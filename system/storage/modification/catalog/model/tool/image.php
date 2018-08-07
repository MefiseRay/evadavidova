<?php
class ModelToolImage extends Model {

                public function cdn_rewrite($host_url, $new_image) {
                    require_once(DIR_SYSTEM . 'nitro/core/core.php');
                    require_once(DIR_SYSTEM . 'nitro/core/cdn.php');
                    
                    $nitro_result = nitroCDNResolve($new_image, $host_url);

                    return $nitro_result;
                }
            
	public function resize($filename, $width, $height) {
              if (function_exists("getMobilePrefix") && function_exists("getCurrentRoute") && isNitroEnabled() && !isset($_COOKIE["save_image_dimensions"])) {
                $route = getCurrentRoute();

                switch ($route) {
                case "common/home":
                    $page_type = "home";
                    break;
                case "product/category":
                    $page_type = "category";
                    break;
                case "product/product":
                    $page_type = "product";
                    break;
                default:
                    $page_type = "";
                    break;
                }

                if ($page_type) {
                    $device_type = ucfirst(trim(getMobilePrefix(true), "-"));
                    if (!$device_type) {
                        $device_type = "Desktop";
                    }

                    $overrides = getNitroPersistence('DimensionOverride.' . $page_type . '.' . $device_type);
                    if ($overrides) {
                        foreach ($overrides as $override) {
                            if ((int)$override["old"]["width"] == (int)$width && (int)$override["old"]["height"] == (int)$height) {
                                $width = (int)$override["new"]["width"];
                                $height = (int)$override["new"]["height"];
                            }
                        }
                    }
                }
              }
		if (!is_file(DIR_IMAGE . $filename)) {
			if (is_file(DIR_IMAGE . 'no_image.jpg')) {
				$filename = 'no_image.jpg';
			} elseif (is_file(DIR_IMAGE . 'no_image.png')) {
				$filename = 'no_image.png';
			} else {
				return;
			}
		}


                if (isset($_COOKIE["save_image_dimensions"])) {
                    if (empty($GLOBALS["reset_session_dimensions"])) {
                        $GLOBALS["reset_session_dimensions"] = true;
                        $this->session->data["nitro_image_dimensions"] = array();
                    }

                    $dimension_string = $width . "x" . $height;
                    if (!in_array($dimension_string, $this->session->data["nitro_image_dimensions"])) {
                        $this->session->data["nitro_image_dimensions"][] = $dimension_string;
                    }
                }
            
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$image_old = $filename;
		$image_new = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;

		
                $nitro_refresh_file = getQuickImageCacheRefreshFilename();
                $nitro_recache = (getNitroPersistence('Enabled') && getNitroPersistence('ImageCache.OverrideCompression') && is_file(DIR_IMAGE . $image_new) && is_file($nitro_refresh_file)) ? filemtime($nitro_refresh_file) > filectime(DIR_IMAGE . $image_new) : false;
                if (!is_file(DIR_IMAGE . $image_new) || (filectime(DIR_IMAGE . $image_old) > filectime(DIR_IMAGE . $image_new)) || $nitro_recache) {
            
			list($width_orig, $height_orig, $image_type) = getimagesize(DIR_IMAGE . $image_old);

			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) {
				return DIR_IMAGE . $image_old;
			}

			$path = '';

			$directories = explode('/', dirname($image_new));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}


                $isNitroImageOverrideEnabled = getNitroPersistence('Enabled') && getNitroPersistence('ImageCache.OverrideCompression');
            
			
                if ($width_orig != $width || $height_orig != $height || $isNitroImageOverrideEnabled) {
            
				$image = new Image(DIR_IMAGE . $image_old);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $image_new);

                require_once DIR_SYSTEM . 'nitro/core/core.php';
                include NITRO_INCLUDE_FOLDER . 'smush_on_demand.php';
            
			} else {
				copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);

                require_once DIR_SYSTEM . 'nitro/core/core.php';
                include NITRO_INCLUDE_FOLDER . 'smush_on_demand.php';
            
			}
		}

		$imagepath_parts = explode('/', $image_new);
		$new_image = implode('/', array_map('rawurlencode', $imagepath_parts));

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {

                $default_link = $this->config->get('config_ssl').'image/'.$new_image;
                $cdn_link = $this->cdn_rewrite($this->config->get('config_ssl'), 'image/'.$new_image);
                if ($default_link == $cdn_link) {
                    return $this->config->get('config_ssl') . (isset($seoUrlImage) ? $seoUrlImage : 'image/' . $new_image);
                } else {
                    return $cdn_link;
                }
            
			return $this->config->get('config_ssl') . 'image/' . $new_image;
		} else {

                $default_link = $this->config->get('config_url').'image/'.$new_image;
                $cdn_link = $this->cdn_rewrite($this->config->get('config_url'), 'image/'.$new_image);
                if ($default_link == $cdn_link) {
                    return $this->config->get('config_url') . (isset($seoUrlImage) ? $seoUrlImage : 'image/' . $new_image);
                } else {
                    return $cdn_link;
                }
            
			return $this->config->get('config_url') . 'image/' . $new_image;
		}
	}
}
