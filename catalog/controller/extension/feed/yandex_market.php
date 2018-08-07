<?php
/**
 * Класс YML экспорта
 * YML (Yandex Market Language) - стандарт, разработанный "Яндексом"
 * для принятия и публикации информации в базе данных Яндекс.Маркет
 * YML основан на стандарте XML (Extensible Markup Language)
 * описание формата YML http://partner.market.yandex.ru/legal/tt/
 */
class ControllerExtensionFeedYandexMarket extends Controller {
	private $shop = array();
	private $currencies = array();
	private $categories = array();
    private $delivery_options = array();
	private $offers = array();
//	private $from_charset = 'utf-8';
	private $eol = "\n";

	public function index() {
		if ($this->config->get('yandex_market_status')) {

			$allowed_categories = $this->config->get('yandex_market_categories');
			
			$this->load->model('export/yandex_market');
            $this->load->model('catalog/product');
			$this->load->model('localisation/currency');
			$this->load->model('tool/image');

			// Магазин
			$this->setShop('name', $this->config->get('yandex_market_shopname'));
			$this->setShop('company', $this->config->get('yandex_market_company'));			
			$this->setShop('url', HTTPS_SERVER);
			$this->setShop('phone', $this->config->get('config_telephone'));
			$this->setShop('platform', 'ocStore');
			$this->setShop('version', VERSION);

			// Валюты
			$offers_currency = $this->config->get('yandex_market_currency');
			if (!$this->currency->has($offers_currency)) exit();

			$decimal_place = $this->currency->getDecimalPlace($offers_currency);

			$shop_currency = $this->config->get('config_currency');

			$this->setCurrency($offers_currency, 1);

            if ( $this->config->get('yandex_market_allcurrencies')) {
                $currencies = $this->model_localisation_currency->getCurrencies();
            } else {
                $currencies = $this->model_localisation_currency->getCurrencyByCode($offers_currency);
            }
                
			$supported_currencies = array('RUR', 'RUB', 'USD', 'BYR', 'KZT', 'EUR', 'UAH');

			$currencies = array_intersect_key($currencies, array_flip($supported_currencies));

			foreach ($currencies as $currency) {
				if ($currency['code'] != $offers_currency && $currency['status'] == 1) {
					$this->setCurrency($currency['code'], number_format(1/$this->currency->convert($currency['value'], $offers_currency, $shop_currency), 4, '.', ''));
				}
			}

			// Категории
			$categories = $this->model_export_yandex_market->getCategory();
			
			$types = $categories;

			foreach ($categories as $category) {
				$this->setCategory($category['name'], $category['category_id'], $category['parent_id']);
			}
            
            // Общие условия доставки для всех товаров
            if ($this->config->get('yandex_market_delivery_common')) {
				$delivery_options = $this->config->get('yandex_market_delivery_option');
				foreach ($delivery_options as $delivery_option) {
					$delivery_options[] = $this->setDeliveryOptions($delivery_option['cost'], $delivery_option['days'], $delivery_option['order_before']);
				}
			}
            
			// Товарные предложения
			$in_stock_id = $this->config->get('yandex_market_in_stock'); // id статуса товара "В наличии"
			$out_of_stock_id = $this->config->get('yandex_market_out_of_stock'); // id статуса товара "Нет на складе"
			$vendor_required = false; // true - только товары у которых задан производитель, необходимо для 'vendor.model' 
			$products = $this->model_export_yandex_market->getProduct($allowed_categories, $out_of_stock_id, $vendor_required);

			 // Категория предложения в дереве категорий Яндекс.Маркета
            if ($this->config->get('yandex_market_category')) {
				$yandex_market_category_options = $this->config->get('yandex_market_category');               
				foreach($yandex_market_category_options as $yandex_market_category) {
					$yandex_market_categories[] = array (
						'category_id' => $yandex_market_category['category_id'],
						'category_name' => $yandex_market_category['category_name'],
					);
				}  
			}

            // Индивидуальные условия доставки
            if ($this->config->get('yandex_market_delivery_individual')) {
				 if ($this->config->get('yandex_market_delivery_product')) {
					$delivery_options = $this->config->get('yandex_market_delivery_product');               
					foreach($delivery_options as $delivery_option) {
						$delivery_product_options[] = array (
							'category' => $delivery_option['category'],
							'price' => $delivery_option['price_from'],
							'cost' =>  $delivery_option['cost'],
							'days' => $delivery_option['days'],
							'order_before' => $delivery_option['order_before'],
							'priority' => $delivery_option['priority']
						);
						$sort_priority[] = $delivery_option['priority'];
						$sort_price[] = $delivery_option['price_from'];
					}  
					array_multisort($sort_priority, SORT_DESC, $sort_price, SORT_DESC, $delivery_product_options);
				 }
			}
  
			foreach ($products as $product) {
				$data = array();
				// Атрибуты товарного предложения
				$data['id'] = $product['product_id'];
				if (!$this->config->get('yandex_market_simple')) {
					$data['type'] = 'vendor.model';
				}
				$data['available'] = ($product['quantity'] > 0 || $product['stock_status_id'] == $in_stock_id);

				// Параметры товарного предложения
				$data['url'] = $this->url->link('product/product', 'path=' . $this->getPath($product['category_id']) . '&product_id=' . $product['product_id'], 'SSL') . '?utm_source=market&utm_term=' . $product['product_id'];
					
				$data['price'] = number_format($this->currency->convert($this->tax->calculate($product['price'], $product['tax_class_id']), $shop_currency, $offers_currency), $decimal_place, '.', '');
			
				if ($product['price'] < $product['old_price']) {
					$data['oldprice'] = number_format($this->currency->convert($this->tax->calculate($product['old_price'], $product['tax_class_id']), $shop_currency, $offers_currency), $decimal_place, '.', '');
				}
				
				$data['currencyId'] = $offers_currency;
				$data['categoryId'] = $product['category_id'];
								
				foreach ($types as $typePrefix) {
					if ($typePrefix['category_id'] == $product['category_id']) { $data['typePrefix'] = $typePrefix['name']; break; }
				}
				
                $data['store'] = ($this->config->get('yandex_market_store') ? 'true' : 'false');
                $data['pickup'] = ($this->config->get('yandex_market_pickup') ? 'true' : 'false');
                $data['delivery'] = ($this->config->get('yandex_market_delivery') ? 'true' : 'false');   
                $data['manufacturer_warranty'] = ($this->config->get('yandex_market_manufacturer_warranty') ? 'true' : 'false');           
				$data['name'] = $product['name'];
				$model = preg_replace('/\s/', '', $product['model']);
				$data['vendor'] =  ($product['manufacturer'] ?  $product['manufacturer'] : $this->config->get('yandex_market_vendor'));
				$data['description'] = $product['description'];
				
				if ($product['weight'] > 0) {
					$data['weight'] = number_format($product['weight'], 1, '.', '');
                }
				
				if ($this->config->get('yandex_market_dimensions') && $product['length'] > 0 && $product['width'] > 0 && $product['height'] > 0) {
					$data['dimensions'] = number_format($product['length'], 1, '.', '').'/'.number_format($product['width'], 1, '.', '').'/'.number_format($product['height'], 1, '.', '');
                }       
					
				if ($this->config->get('yandex_market_model')) {
					$model = str_replace(array('{NAME}', '{CATEGORY}', '{VENDOR}', '{DIMENSIONS}'), array($product['name'], (isset($data['typePrefix']) ? $data['typePrefix'] : ''), (isset($data['vendor']) ? $data['vendor'] : ''), 				(($product['length'] > 0 && $product['width'] > 0 && $product['height'] > 0) ? $this->length->format($product['length'], $product['length_class_id']).' x '.$this->length->format($product['width'], $product['length_class_id']).' x '.$this->length->format($product['height'], $product['length_class_id']) : '')), $this->config->get('yandex_market_model'));														
				
					$attributes = $this->model_catalog_product->getProductAttributes($product['product_id']);
					if (count($attributes)) {
						foreach ($attributes as $attr) {
							foreach ($attr['attribute'] as $val) {
								$model = str_replace('{ATTR_'.$val['attribute_id'].'}', $val['text'], $model);
							}
						}
					}
					
					$model = preg_replace('/{ATTR_[0-9]{1,}}/', '' , $model);
					$data['model'] = preg_replace("/\s{2,}/"," ",$model); 
					
				} else {
					$data['model'] = ($model ?  $model : $product['name']);
				}
				
				if ($this->config->get('yandex_market_sales_notes')) {
					$data['sales_notes'] = $this->config->get('yandex_market_sales_notes');
				}
				
				if (!$this->config->get('yandex_market_additional_images')) {
					if ($product['image']) {
						$data['picture'] = $this->model_tool_image->resize($product['image'], 600, 600);
					}
				} else {
					if ($product['image']) {
						$data['picture'] = array($this->model_tool_image->resize($product['image'], 600, 600));
					}
					$product_images = $this->model_export_yandex_market->getProductImages($product['product_id']);
					if ($product_images) {
						foreach($product_images as $product_image) {
							$data['picture'][] = $this->model_tool_image->resize($product_image['image'], 600, 600);
						}
					}
				}
                
                if ($this->config->get('yandex_market_category_default')) {
					$data['market_category'] = $this->config->get('yandex_market_category_default');
				}
                
                if ($this->config->get('yandex_market_category')) {
					foreach($yandex_market_categories as $key => $yandex_market_category) {
						if($data['categoryId'] == $yandex_market_category['category_id']) {
							$data['market_category'] = $yandex_market_category['category_name'];
							break;
						}
					}
				}
                
                // Индивидуальные условия доставки
                if ($this->config->get('yandex_market_delivery_individual')) {
					if ($this->config->get('yandex_market_delivery_product')) {	   
						foreach($delivery_product_options as $key => $delivery_option) {
							if($delivery_option['category'] !="") {
								$categories = explode(",", $delivery_option['category']);
								if (in_array($data['categoryId'], $categories)) {
									if($data['price'] >= $delivery_option['price']) {
										$data['delivery_options'][0] = array (
											'cost' =>  $delivery_option['cost'],
											'days' => $delivery_option['days'],
											'order_before' => $delivery_option['order_before']
										);
										break;
									}
								}
							} else {             
								if($data['price'] >= $delivery_option['price']) {
									$data['delivery_options'][0] = array (
										'cost' =>  $delivery_option['cost'],
										'days' => $delivery_option['days'],
										'order_before' => $delivery_option['order_before']
									);
									break;    
								}
							}
						}
						$data['delivery_options'] = serialize($data['delivery_options']);
					}
				}
				
				$yandex_market_country_of_origin = $this->config->get('yandex_market_country_of_origin');

                // Массив для вывода параметров
				if ($this->config->get('yandex_market_features')) {
					$attributes = $this->model_catalog_product->getProductAttributes($data['id']);
					if (count($attributes)) {
						foreach ($attributes as $attr) {
							foreach ($attr['attribute'] as $val) {
								if ($val['attribute_id'] == $yandex_market_country_of_origin) {
									$data['country_of_origin'] =  $val['text'];
								} else {
									$data['param'][] = array('name' => $val['name'], 'value' => $val['text']);
								}
                            }
                        }
                    }
				}

				$this->setOffer($data);
			}

			$this->categories = array_filter($this->categories, array($this, "filterCategory"));
			
			$catalog = $this->getYml();
			
			$yml = new DOMDocument('1.0', 'UTF-8');
			$yml->formatOutput = true;
			$yml->loadXML($catalog);
			$yml->save("yandex.xml");

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($this->getYml());
		}
	}

	/**
	 * Методы формирования YML
	 */

	/**
	 * Формирование массива для элемента shop описывающего магазин
	 *
	 * @param string $name - Название элемента
	 * @param string $value - Значение элемента
	 */
	private function setShop($name, $value) {
		$allowed = array('name', 'company', 'url', 'phone', 'platform', 'version', 'agency', 'email');
		if (in_array($name, $allowed)) {
			$this->shop[$name] = $this->prepareField($value);
		}
	}
    
	/**
	 * Валюты
	 *
	 * @param string $id - код валюты (RUR, RUB, USD, BYR, KZT, EUR, UAH)
	 * @param float|string $rate - курс этой валюты к валюте, взятой за единицу.
	 *	Параметр rate может иметь так же следующие значения:
	 *		CBRF - курс по Центральному банку РФ.
	 *		NBU - курс по Национальному банку Украины.
	 *		NBK - курс по Национальному банку Казахстана.
	 *		СВ - курс по банку той страны, к которой относится интернет-магазин
	 * 		по Своему региону, указанному в Партнерском интерфейсе Яндекс.Маркета.
	 * @param float $plus - используется только в случае rate = CBRF, NBU, NBK или СВ
	 *		и означает на сколько увеличить курс в процентах от курса выбранного банка
	 * @return bool
	 */
	private function setCurrency($id, $rate = 'CBRF', $plus = 0) {
		$allow_id = array('RUR', 'RUB', 'USD', 'BYR', 'KZT', 'EUR', 'UAH');
		if (!in_array($id, $allow_id)) {
			return false;
		}
		$allow_rate = array('CBRF', 'NBU', 'NBK', 'CB');
		if (in_array($rate, $allow_rate)) {
			$plus = str_replace(',', '.', $plus);
			if (is_numeric($plus) && $plus > 0) {
				$this->currencies[] = array(
					'id'=>$this->prepareField(strtoupper($id)),
					'rate'=>$rate,
					'plus'=>(float)$plus
				);
			} else {
				$this->currencies[] = array(
					'id'=>$this->prepareField(strtoupper($id)),
					'rate'=>$rate
				);
			}
		} else {
			$rate = str_replace(',', '.', $rate);
			if (!(is_numeric($rate) && $rate > 0)) {
				return false;
			}
			$this->currencies[] = array(
				'id'=>$this->prepareField(strtoupper($id)),
				'rate'=>(float)$rate
			);
		}

		return true;
	}

	/**
	 * Категории товаров
	 *
	 * @param string $name - название рубрики
	 * @param int $id - id рубрики
	 * @param int $parent_id - id родительской рубрики
	 * @return bool
	 */
	private function setCategory($name, $id, $parent_id = 0) {
		$id = (int)$id;
		if ($id < 1 || trim($name) == '') {
			return false;
		}
		if ((int)$parent_id > 0) {
			$this->categories[$id] = array(
				'id'=>$id,
				'parentId'=>(int)$parent_id,
				'name'=>$this->prepareField($name)
			);
		} else {
			$this->categories[$id] = array(
				'id'=>$id,
				'name'=>$this->prepareField($name)
			);
		}

		return true;
	}
    
    /**
	 * Общие условия доставки для всех товаров
	 *
	 * @param string $cost — стоимость доставки в рублях
	 * @param string $days — срок доставки в рабочих днях
	 * @param string $order_before (необязательный) — время оформления заказа, до наступления которого действуют указанные сроки и условия доставки.
	 * @return bool
	 */
	private function setDeliveryOptions($cost, $days, $order_before) {
        if ($order_before != '') {
            $this->delivery_options[] = array(
                    'cost'=>$cost,
                    'days'=>$days,
                    'order-before'=>$order_before
            );
        } else {
            $this->delivery_options[] = array(
                    'cost'=>$cost,
                    'days'=>$days
            );
        }
		return true;
	}

	/**
	 * Товарные предложения
	 *
	 * @param array $data - массив параметров товарного предложения
	 */
	private function setOffer($data) {
		$offer = array();

		$attributes = array('id', 'type', 'available', 'bid', 'cbid', 'param', 'delivery_options');
		$attributes = array_intersect_key($data, array_flip($attributes));

		foreach ($attributes as $key => $value) {
			switch ($key)
			{
				case 'id':
				case 'bid':
				case 'cbid':
					$value = (int)$value;
					if ($value > 0) {
						$offer[$key] = $value;
					}
					break;

				case 'type':
					if (in_array($value, array('vendor.model', 'book', 'audiobook', 'artist.title', 'tour', 'ticket', 'event-ticket'))) {
						$offer['type'] = $value;
					}
					break;

				case 'available':
					$offer['available'] = ($value ? 'true' : 'false');
					break;

				case 'param':
					if (is_array($value)) {
						$offer['param'] = $value;
					}
					break;

                case 'delivery_options':
					if (is_array($value)) {
						$offer['delivery_options'] = $value;
					}
					break;    
                    
				default:
					break;
			}
		}

		$type = isset($offer['type']) ? $offer['type'] : '';

		$allowed_tags = array('url'=>0, 'buyurl'=>0, 'price'=>1, 'oldprice'=>0, 'wprice'=>0, 'currencyId'=>1, 'xCategory'=>0, 'categoryId'=>1, 'picture'=>0, 'store'=>0, 'pickup'=>0, 'delivery'=>0, 'delivery_options' =>0, 'deliveryIncluded'=>0, 'local_delivery_cost'=>0, 'orderingTime'=>0);

		switch ($type) {
			case 'vendor.model':
				$allowed_tags = array_merge($allowed_tags, array('typePrefix'=>0, 'vendor'=>1, 'vendorCode'=>0, 'model'=>1, 'provider'=>0, 'tarifplan'=>0));
				break;

			case 'book':
				$allowed_tags = array_merge($allowed_tags, array('author'=>0, 'name'=>1, 'publisher'=>0, 'series'=>0, 'year'=>0, 'ISBN'=>0, 'volume'=>0, 'part'=>0, 'language'=>0, 'binding'=>0, 'page_extent'=>0, 'table_of_contents'=>0));
				break;

			case 'audiobook':
				$allowed_tags = array_merge($allowed_tags, array('author'=>0, 'name'=>1, 'publisher'=>0, 'series'=>0, 'year'=>0, 'ISBN'=>0, 'volume'=>0, 'part'=>0, 'language'=>0, 'table_of_contents'=>0, 'performed_by'=>0, 'performance_type'=>0, 'storage'=>0, 'format'=>0, 'recording_length'=>0));
				break;

			case 'artist.title':
				$allowed_tags = array_merge($allowed_tags, array('artist'=>0, 'title'=>1, 'year'=>0, 'media'=>0, 'starring'=>0, 'director'=>0, 'originalName'=>0, 'country'=>0));
				break;

			case 'tour':
				$allowed_tags = array_merge($allowed_tags, array('worldRegion'=>0, 'country'=>0, 'region'=>0, 'days'=>1, 'dataTour'=>0, 'name'=>1, 'hotel_stars'=>0, 'room'=>0, 'meal'=>0, 'included'=>1, 'transport'=>1, 'price_min'=>0, 'price_max'=>0, 'options'=>0));
				break;

			case 'event-ticket':
				$allowed_tags = array_merge($allowed_tags, array('name'=>1, 'place'=>1, 'hall'=>0, 'hall_part'=>0, 'date'=>1, 'is_premiere'=>0, 'is_kids'=>0));
				break;

			default:
				$allowed_tags = array_merge($allowed_tags, array('name'=>1, 'vendor'=>0, 'vendorCode'=>0));
				break;
		}

		$allowed_tags = array_merge($allowed_tags, array('aliases'=>0, 'additional'=>0, 'description'=>0, 'market_category'=>1, 'sales_notes'=>0, 'weight'=>0, 'dimensions'=>0, 'promo'=>0, 'manufacturer_warranty'=>0, 'country_of_origin'=>0, 'downloadable'=>0, 'adult'=>0, 'barcode'=>0));

		$required_tags = array_filter($allowed_tags);

		if (sizeof(array_intersect_key($data, $required_tags)) != sizeof($required_tags)) {
			return;
		}

		$data = array_intersect_key($data, $allowed_tags);
//		if (isset($data['tarifplan']) && !isset($data['provider'])) {
//			unset($data['tarifplan']);
//		}

		$allowed_tags = array_intersect_key($allowed_tags, $data);

		// Стандарт XML учитывает порядок следования элементов,
		// поэтому важно соблюдать его в соответствии с порядком описанным в DTD
		$offer['data'] = array();
		foreach ($allowed_tags as $key => $value) {
			$offer['data'][$key] = $data[$key];
		}

		$this->offers[] = $offer;
	}

	/**
	 * Формирование YML файла
	 *
	 * @return string
	 */
	private function getYml() {
		$yml  = '<?xml version="1.0" encoding="utf-8"?>' . $this->eol;
		$yml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . $this->eol;
		$yml .= '<yml_catalog date="' . date('Y-m-d H:i') . '">' . $this->eol;
		$yml .= '<shop>' . $this->eol;
        
		// информация о магазине
		$yml .= $this->array2Tag($this->shop);

		// валюты
		$yml .= '<currencies>' . $this->eol;
		foreach ($this->currencies as $currency) {
			$yml .= $this->getElement($currency, 'currency');
		}
		$yml .= '</currencies>' . $this->eol;

		// категории
		$yml .= '<categories>' . $this->eol;
		foreach ($this->categories as $category) {
			$category_name = $category['name'];
			unset($category['name'], $category['export']);
			$yml .= $this->getElement($category, 'category', $category_name);
		}
		$yml .= '</categories>' . $this->eol;
        
        // общие условия доставки для всех товаров
        if ($this->config->get('yandex_market_delivery_common')) {
			$yml .= '<delivery-options>' . $this->eol;
			foreach ($this->delivery_options as $delivery_option) {
				$category_name = $delivery_option['cost'];
				//unset($category['name'], $category['export']);
				$yml .= $this->getElement($delivery_option, 'option');
			}
			$yml .= '</delivery-options>' . $this->eol;
		}

		// товарные предложения
		$yml .= '<offers>' . $this->eol;
		foreach ($this->offers as $offer) {
			$tags = $this->array2Tag($offer['data']);
			unset($offer['data']);
            if (isset($offer['delivery_options'])) {
				$tags .= $this->array2DeliveryOptions($offer['delivery_options']);
				unset($offer['delivery_options']);
			}            
			if (isset($offer['param'])) {
				$tags .= $this->array2Param($offer['param']);
				unset($offer['param']);
			}
			$yml .= $this->getElement($offer, 'offer', $tags);
		}
		$yml .= '</offers>' . $this->eol;

		$yml .= '</shop>';
		$yml .= '</yml_catalog>';

		return $yml;
	}

	/**
	 * Фрмирование элемента
	 *
	 * @param array $attributes
	 * @param string $element_name
	 * @param string $element_value
	 * @return string
	 */
	private function getElement($attributes, $element_name, $element_value = '') {
		$retval = '<' . $element_name . ' ';
		foreach ($attributes as $key => $value) {
			$retval .= $key . '="' . $value . '" ';
		}
		$retval .= $element_value ? '>' . $this->eol . $element_value . '</' . $element_name . '>' : '/>';
		$retval .= $this->eol;

		return $retval;
	}

	/**
	 * Преобразование массива в теги
	 *
	 * @param array $tags
	 * @return string
	 */
	private function array2Tag($tags) {
		$retval = '';
		foreach ($tags as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $i => $val) {	
					$retval .= '<' . $key . '>' . $this->prepareField($val) . '</' . $key . '>' . $this->eol;
				}
			} else {
				if ($key == 'delivery_options') {
						$offer['delivery_options'] = unserialize($value);
						$retval .= $this->array2DeliveryOptions($offer['delivery_options']);
						unset($offer['delivery_options']);
				} else {
					$retval .= '<' . $key . '>' . $this->prepareField($value) . '</' . $key . '>' . $this->eol;
				}
			}
		}

		return $retval;
	}

    /**
	 * Преобразование массива в теги доставки
	 *
	 * @param array $delivery_options
	 * @return string
	 */
	private function array2DeliveryOptions($delivery_options) {
		$retval = '<delivery-options>';
		foreach ($delivery_options as $delivery_option) {
			$retval .= '<option cost="' . $this->prepareField($delivery_option['cost']) . '"  days="' . $this->prepareField($delivery_option['days']) . '"';
			if ($delivery_option['order_before'] != '') {
				$retval .= ' order_before="' . $this->prepareField($delivery_option['order_before']) . '"';
			}
			$retval .= ' />' . $this->eol;
		}
        $retval .= '</delivery-options>';
        
		return $retval;
	}
    
	/**
	 * Преобразование массива в теги параметров
	 *
	 * @param array $params
	 * @return string
	 */
	private function array2Param($params) {
		$retval = '';
		foreach ($params as $param) {
			$retval .= '<param name="' . $this->prepareField($param['name']);
			if (isset($param['unit'])) {
				$retval .= '" unit="' . $this->prepareField($param['unit']);
			}
			$retval .= '">' . $this->prepareField($param['value']) . '</param>' . $this->eol;
		}

		return $retval;
	}

	/**
	 * Подготовка текстового поля в соответствии с требованиями Яндекса
	 * Запрещаем любые html-тэги, стандарт XML не допускает использования в текстовых данных
	 * непечатаемых символов с ASCII-кодами в диапазоне значений от 0 до 31 (за исключением
	 * символов с кодами 9, 10, 13 - табуляция, перевод строки, возврат каретки). Также этот
	 * стандарт требует обязательной замены некоторых символов на их символьные примитивы.
	 * @param string $text
	 * @return string
	 */
	private function prepareField($field) {
		$field = htmlspecialchars_decode($field);
		$field = strip_tags($field);
        $from = array('"', '&', '>', '<', '\'');
        $to = array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
        $field = str_replace($from, $to, $field);
	/*	if ($this->from_charset != 'windows-1251') {
			$field = @iconv($this->from_charset, 'windows-1251//TRANSLIT//IGNORE', $field);
		}
		$field = preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $field);
    */
		return trim($field);
	}

	protected function getPath($category_id, $current_path = '') {
		if (isset($this->categories[$category_id])) {
			$this->categories[$category_id]['export'] = 1;

			if (!$current_path) {
				$new_path = $this->categories[$category_id]['id'];
			} else {
				$new_path = $this->categories[$category_id]['id'] . '_' . $current_path;
			}	

			if (isset($this->categories[$category_id]['parentId'])) {
				return $this->getPath($this->categories[$category_id]['parentId'], $new_path);
			} else {
				return $new_path;
			}

		}
	}

	function filterCategory($category) {
		return isset($category['export']);
	}
}
?>
