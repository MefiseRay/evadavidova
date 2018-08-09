<?php

class ControllerExtensionModuleImport1C extends Controller
{
    private $manufacturer_property_id = 0;
    private $color_property_id = 0;
    private $size_property_id = 0;
    private $minimum_property_id = 0;
    private $exists_attribute_presets = array();
    //private $dir = DIRECTORY_SEPARATOR.'Exchange1C'.DIRECTORY_SEPARATOR.'webdata'.DIRECTORY_SEPARATOR.'000000001'.DIRECTORY_SEPARATOR;
    private $dir = '/Exchange1C/webdata/000000001/';

    public function clearDatabase()
    {
        $this->load->model('extension/module/Import1C');

        $this->model_extension_module_Import1C->clearDatabase();
    }

    public function addCategoriesToProduct()
    {
        $this->load->model('extension/module/Import1C');

        $this->model_extension_module_Import1C->addCategoriesToProduct();

    }

    public function import()
    {
        header('Content-Type: text/html; charset=utf-8');
        $this->load->model('extension/module/Import1C');

        // Directory
        $dir = $this->request->server['DOCUMENT_ROOT'] . $this->dir;

        $files = scandir($dir);

        $catalog = '';

        // Как бы не называлась папка в webdata - получаем путь
        foreach ($files as $file) {
            if (!is_dir($dir . $file)) {
                $catalog = $dir . $file;
            }
        }

        // Categories
        $exist_categories = $this->model_extension_module_Import1C->getAllCategories();

        if ($catalog) {
            $xml = simplexml_load_file($catalog);

            $categories = array();
            foreach ($xml->Классификатор->Группы->children() as $category) {
                $category_id = $category->Ид->__toString();
                $categories[$category_id]['id'] = $category_id;
                $categories[$category_id]['name'] = $this->clear($category->Наименование->__toString());
                $categories[$category_id]['keyword'] = $this->translit($categories[$category_id]['name']);
                $categories[$category_id]['parent_id'] = '';
                $subcategories = $this->getAllCategories($category->Группы, $category_id);
            }

            $categories = array_merge($categories, $subcategories);

            foreach ($categories as $category_data) {
                if (array_key_exists($category_data['id'], $exist_categories)) {
                    $this->model_extension_module_Import1C->updateCategory($category_data, $exist_categories[$category_data['id']]);
                } else {
                    $exist_categories[$category_data['id']] = $this->model_extension_module_Import1C->addCategory($category_data);
                }
            }

            // var_dump($categories);
        }

        // Attributes		

        $dir = $this->request->server['DOCUMENT_ROOT'] . $this->dir . 'properties' . DIRECTORY_SEPARATOR;

        $files = scandir($dir);

        $catalog = '';

        // Как бы не называлась папка в webdata - получаем путь
        foreach ($files as $file) {
            if (!is_dir($dir . $file)) {
                $catalog = $dir . $file;
            }
        }


        if ($catalog) {
            $xml = simplexml_load_file($catalog);

            $attributes = $option_values = $manufacturers = array();
            $i = 0;
            foreach ($xml->Классификатор->Свойства->children() as $attribute) {
                $property_id = trim($attribute->Ид->__toString());

                switch ($property_id) {
                    case '9f8cae83-92f3-11e7-89f1-14dae9e311d7':
                    case 'ba28c6ce-946a-11e7-89f1-14dae9e311d7':
                        $this->color_property_id = $attribute->Ид->__toString();
                        $j = 0;
                        $colors['id'] = $attribute->Ид->__toString();
                        $colors['name'] = $attribute->Наименование->__toString();
                        if (isset($attribute->ВариантыЗначений)) {
                            foreach ($attribute->ВариантыЗначений->children() as $value) {
                                if ($value->Значение->__toString() && $value->Значение->__toString() != '') {
                                    $colors['option_values'][$j]['id'] = $value->ИдЗначения->__toString();
                                    $colors['option_values'][$j]['name'] = $this->clear($value->Значение->__toString());
                                    $j++;
                                }
                            }
                        }
                        break;
                    case '9f8cae86-92f3-11e7-89f1-14dae9e311d7':
                        $this->size_property_id = $attribute->Ид->__toString();
                        $j = 0;
                        $sizes['id'] = $attribute->Ид->__toString();
                        $sizes['name'] = $attribute->Наименование->__toString();
                        foreach ($attribute->ВариантыЗначений->children() as $value) {
                            if ($value->Значение->__toString() && $value->Значение->__toString() != '') {
                                $sizes['option_values'][$j]['id'] = $value->ИдЗначения->__toString();
                                $sizes['option_values'][$j]['name'] = $this->clear($value->Значение->__toString());
                                $j++;
                            }
                        }
                        break;
                    case '7ed585c2-fa78-11e7-852d-38d547aa20ca':
                        $group[$i] = $value->ИдЗначения->__toString();
                        $group[$i] = $this->clear($value->Значение->__toString());
                        break;
                    default:
                        $attributes[$i]['id'] = $attribute->Ид->__toString();
                        $attributes[$i]['name'] = $attribute->Наименование->__toString();
                        if (trim($attribute->ТипЗначений->__toString()) == 'Справочник') {
                            if (isset($attribute->ВариантыЗначений)) {
                                $j = 0;
                                foreach ($attribute->ВариантыЗначений->children() as $value) {
                                    if ($value->Значение->__toString() && $value->Значение->__toString() != '') {
                                        $attributes[$i]['attribute_presets'][$j]['id'] = $value->ИдЗначения->__toString();
                                        $attributes[$i]['attribute_presets'][$j]['text'] = $this->clear($value->Значение->__toString());
                                        $j++;
                                    }
                                }
                            }
                        }
                }

                $i++;
            }

            $exist_attributes = $this->model_extension_module_Import1C->getAllAttributes();

            foreach ($attributes as $attribute_data) {
                if (array_key_exists($attribute_data['id'], $exist_attributes)) {
                    $attribute_id = $exist_attributes[$attribute_data['id']];
                    $this->model_extension_module_Import1C->updateAttribute($attribute_data, $attribute_id);
                    if (isset($attribute_data['attribute_presets'])) {
                        $this->addPresets($attribute_data['attribute_presets'], $attribute_id);
                    }
                } else {
                    $exist_attributes[$attribute_data['id']] = $this->model_extension_module_Import1C->addAttribute($attribute_data);
                    if (isset($attribute_data['attribute_presets'])) {
                        $this->addPresets($attribute_data['attribute_presets'], $exist_attributes[$attribute_data['id']]);
                    }
                }
            }

            //var_dump($attributes);

            // Colors
            $color_option_id = $this->model_extension_module_Import1C->getColorOptionId();

            $exist_colors = $this->model_extension_module_Import1C->getOptionValues($color_option_id);

            $colors['option_values'] = $this->multiSort($colors['option_values'], 'name');

            $sort_order = 0;
            foreach ($colors['option_values'] as $color_value_data) {
                if (array_key_exists($color_value_data['id'], $exist_colors)) {
                    $option_value_id = $exist_colors[$color_value_data['id']];
                    $this->model_extension_module_Import1C->updateOptionValue($color_value_data, $option_value_id, $sort_order++);
                } else {
                    $exist_colors[$color_value_data['id']] = $this->model_extension_module_Import1C->addOptionValue($color_value_data, $color_option_id, $sort_order++);
                }
            }

            // Sizes
            $size_option_id = $this->model_extension_module_Import1C->getSizeOptionId();

            $exist_sizes = $this->model_extension_module_Import1C->getOptionValues($size_option_id);

            $sizes['option_values'] = $this->multiSort($sizes['option_values'], 'name');

            $sort_order = 0;
            foreach ($sizes['option_values'] as $size_value_data) {
                if (array_key_exists($size_value_data['id'], $exist_sizes)) {
                    $option_value_id = $exist_sizes[$size_value_data['id']];
                    $this->model_extension_module_Import1C->updateOptionValue($size_value_data, $option_value_id, $sort_order++);
                } else {
                    $exist_sizes[$size_value_data['id']] = $this->model_extension_module_Import1C->addOptionValue($size_value_data, $size_option_id, $sort_order++);
                }
            }

            //var_dump($colors);
            //var_dump($sizes);
        }


        // Products
        $dir = $this->request->server['DOCUMENT_ROOT'] . $this->dir . 'goods' . DIRECTORY_SEPARATOR;

        $files = scandir($dir);

        $products = $unavailable_products = array();

        $catalog = '';

        // Как бы не называлась папка в webdata - получаем путь
        foreach ($files as $file) {
            if (!is_dir($dir . $file)) {
                $catalog = $dir . $file;
            }
        }

        if ($catalog) {
            $xml = simplexml_load_file($catalog);

            $exist_products = $this->model_extension_module_Import1C->getAllProducts();

            $products = array();
            foreach ($xml->Каталог->Товары->children() as $product) {
                $product_id = $product->Ид->__toString();
                if ($product->ПометкаУдаления->__toString() != 'true') {
                    $products[$product_id]['id'] = $product_id;
                    $products[$product_id]['price'] = 0;
                    $products[$product_id]['quantity'] = 0;
                    $products[$product_id]['status'] = ($product->ПометкаУдаления->__toString() === 'true' ? false : true);
                    $products[$product_id]['model'] = $product->Артикул->__toString();
                    $products[$product_id]['sku'] = $product->Штрихкод->__toString();
                    $products[$product_id]['name'] = $this->clear($product->Наименование->__toString());
                    $products[$product_id]['keyword'] = $this->translit($products[$product_id]['name']);
                    $products[$product_id]['description'] = $this->clear($product->Описание->__toString());

                    $products[$product_id]['product_category'] = array();
                    foreach ($product->Группы->children() as $id) {
                        $products[$product_id]['product_category'][] = $exist_categories[trim($id->__toString())];
                    }
                    $products[$product_id]['product_color_image'] = false;
                    foreach ($product->ЗначенияРеквизитов as $props) {
                        foreach ($props->ЗначениеРеквизита as $value) {
                            $pics = $value->Значение->__toString();
                            $pieces = explode("#", $pics);
                            if (isset($pieces[1]) && $pieces[1] == 'КартинкаЦвета') {
                                $products[$product_id]['product_color_image'] = str_replace('/public_html/image/', '', $this->clear($pieces[0]));
                            }
                        }
                    }
                    $products[$product_id]['product_image'] = array();
                    foreach ($product->Картинка as $image) {
                        $thumb = str_replace('/public_html/image/', '', $this->clear($image->__toString()));
                        if ($products[$product_id]['product_color_image'] == false || $products[$product_id]['product_color_image'] != $thumb) {
                            $products[$product_id]['product_image'][] = $thumb;
                        }
                    }
                    if (count($products[$product_id]['product_image'])) {
                        $products[$product_id]['status'] = 1; // Если есть фото
                    } else {
                        $products[$product_id]['status'] = 0; // Если нет фото
                    }
                    $i = 0;
                    foreach ($product->ЗначенияСвойств->children() as $attribute) {
                        $property_id = trim($attribute->Ид->__toString());
                        $property_value = trim($attribute->Значение->__toString());
                        if (isset($exist_attributes[$property_id]) && $property_value) {
                            if (isset($this->exists_attribute_presets[$property_value])) {
                                $products[$product_id]['product_attribute'][$i]['attribute_id'] = $exist_attributes[$property_id];
                                $products[$product_id]['product_attribute'][$i]['preset_id'] = $this->exists_attribute_presets[$property_value];
                            } else {
                                $products[$product_id]['product_attribute'][$i]['attribute_id'] = $exist_attributes[$property_id];
                                $products[$product_id]['product_attribute'][$i]['text'] = $this->clear($attribute->Значение->__toString());
                            }
                        } else {
                            if ($property_id == '9f8cae83-92f3-11e7-89f1-14dae9e311d7' || $property_id == 'ba28c6ce-946a-11e7-89f1-14dae9e311d7') {
                                if (isset($exist_colors[$property_value])) {
                                    $products[$product_id]['product_color_option_value'] = $exist_colors[$property_value];
                                }
                            }
                        }
                        $i++;
                    }
                } else {
                    $unavailable_products[] = $product_id;
                }
            }

            //var_dump($exist_colors);
            //var_dump($exist_sizes);

            $i = 0;

            $unavailable_offers = array();

            foreach ($xml->ПакетПредложений->Предложения->children() as $offer) {
                $option_status = ($offer->ПометкаУдаления->__toString() === 'true' ? false : true);
                if ($option_status) {
                    $product_id = current(explode('#', $offer->Ид->__toString()));
                    if (isset($offer->ЗначенияСвойств)) {
                        foreach ($offer->ЗначенияСвойств->children() as $option) {
                            if (!isset($exist_sizes[$option->Значение->__toString()])) {
                                //var_dump($offer->Ид->__toString());
                            }
                            $products[$product_id]['product_option'][$i]['product_option_value'][$size_option_id] = $exist_sizes[$option->Значение->__toString()];
                        }
                    }
                    if (isset($offer->Цены)) {
                        foreach ($offer->Цены->children() as $price) {
                            $products[$product_id]['product_option'][$i]['price'] = str_replace(',', '.', $price->ЦенаЗаЕдиницу->__toString());
                        }
                    } else {
                        $products[$product_id]['product_option'][$i]['price'] = 0;
                    }
                    $sku = explode('#', $offer->Ид->__toString());
                    $products[$product_id]['product_option'][$i]['1C_product_id'] = $sku[0];
                    $products[$product_id]['product_option'][$i]['sku'] = $offer->Ид->__toString();
                    $products[$product_id]['product_option'][$i]['model'] = $products[$product_id]['model'];
                    $products[$product_id]['product_option'][$i]['product_option_value'][$color_option_id] = $products[$product_id] ['product_color_option_value'];
                    $products[$product_id]['product_option'][$i]['quantity'] = abs((int)$offer->Остатки->Остаток->Количество->__toString());
                    $products[$product_id]['product_option'][$i]['status'] = $option_status;
                    $products[$product_id]['price'] = ($products[$product_id]['price'] < $products[$product_id]['product_option'][$i]['price'] ? $products[$product_id]['product_option'][$i]['price'] : $products[$product_id]['price']);
                    $products[$product_id]['quantity'] = $products[$product_id]['quantity'] + $products[$product_id]['product_option'][$i]['quantity'];

                    $i++;
                } else {
                    $unavailable_offers[] = $offer->Ид->__toString();
                }
            }
        }

        // Directory
        $dir = $this->request->server['DOCUMENT_ROOT'] . $this->dir;

        $files = scandir($dir);

        $catalog = '';

        // Как бы не называлась папка в webdata - получаем путь
        foreach ($files as $file) {
            if (!is_dir($dir . $file)) {
                $catalog = $dir . $file;
            }
        }

        $specials = $expired_specials = array();


        if (count($products)) {
            foreach ($products as $product_data) {
                if (array_key_exists($product_data['id'], $exist_products)) {
                    $this->model_extension_module_Import1C->updateProduct($product_data, $product_data['id'], $color_option_id);
                } else {
                    $product_id = $this->model_extension_module_Import1C->addProduct($product_data);

                    $exist_products[$product_data['id']] = $product_data['model'];
                }
            }
        }

        $exist_products = $this->model_extension_module_Import1C->getAllProducts();

        foreach ($exist_products as $id => $model) {

            $product_id = $this->model_extension_module_Import1C->getProduct($model, $id);

            $offers[$product_id] = $this->model_extension_module_Import1C->getProductsByModel($model, $product_id, $id);

        }

        //var_dump($offers);

        foreach ($offers as $product_id => $offer) {
            if (isset($offer['product_option'])) {
                $this->model_extension_module_Import1C->addProductOptions($product_id, $offer['product_option']);
            }

            if (isset($offer['product_related_option'])) {
                $this->model_extension_module_Import1C->addProductRelatedOptions($product_id, $offer['product_related_option']);
            }
        }

        if ($catalog) {
            $xml = simplexml_load_file($catalog);

            if (isset($xml->Скидки) && $xml->Скидки) {
                foreach ($xml->Скидки->children() as $sale) {
                    $special_id = $sale->Ид->__toString();
                    $name = $sale->Наименование->__toString();
                    $start_date = explode("T", $sale->ДатаНачала->__toString());
                    $start_date = $start_date[0];
                    $end_date = explode("T", $sale->ДатаЗавершения->__toString());
                    $end_date = $end_date[0];
                    $activity = $sale->Активность->__toString();;
                    $priority = $sale->Приоритет->__toString();;

                    if (isset($sale->Предложения) && $activity == 'true') {
                        foreach ($sale->Предложения->children() as $offer) {
                            $id = $offer->__toString();
                            $specials[$id]['1C_special_id'] = $special_id;
                            $specials[$id]['name'] = $name;
                            $specials[$id]['priority'] = $priority;
                            $specials[$id]['date_start'] = $start_date;
                            $specials[$id]['date_end'] = ($end_date != '0001-01-01' ? $end_date : '');
                            $specials[$id]['value'] = (int)$sale->Значение->__toString();
                        }
                    } else {
                        $expired_specials[] = $special_id;
                    }
                }
            }

            //var_dump($products);

            // Update Specials
            foreach ($specials as $sku => $special) {
                $this->model_extension_module_Import1C->setSpecialPrice($special, $sku);
            }

            foreach ($expired_specials as $special_id) {
                $this->model_extension_module_Import1C->deleteSpecial($special_id);
            }

            if (count($unavailable_products)) {
                foreach ($unavailable_products as $id) {
                    $this->model_extension_module_Import1C->deleteProduct($id);
                }
            }

            if (count($unavailable_offers)) {
                foreach ($unavailable_offers as $id) {
                    $this->model_extension_module_Import1C->deleteOffer($id);
                }
            }
        }

        /*
                $catalog = $dir.'offers.xml';
                $xml = simplexml_load_file($catalog);
                foreach ($xml->ПакетПредложений->Предложения->children() as $offer) {
                    $product_id = $offer->Ид->__toString();
                    foreach ($offer->Цены->children() as $price) {
                        $products[$product_id]['price'] = str_replace(',', '.', $price->ЦенаЗаЕдиницу->__toString());
                    }
                    $products[$product_id]['quantity'] = str_replace(',00', '', $offer->Количество->__toString());
                }

                // Выставляем всем товарам в графе кол-во 0 (для опций)
                $this->model_module_Import1C->deactivateAllProducts();

                foreach ($products as $product_data) {
                    if (in_array($product_data['model'], $exist_products)) {
                        $this->model_module_Import1C->updateProduct($product_data, $product_data['model'], $color_option_id);
                    } else {
                        $product_id = $this->model_module_Import1C->addProduct($product_data);

                        if (isset($product_data['product_option_value_id'])) {
                            $this->model_module_Import1C->addProductColorValue($product_data, $color_option_id, $product_id);
                        }

                        $exist_products[$product_data['id']] = $product_data['model'];
                    }
                }
            */


        $this->cleanDir($this->request->server['DOCUMENT_ROOT'] . $this->dir);
        $this->cleanDir($this->request->server['DOCUMENT_ROOT'] . $this->dir . 'properties/');
        $this->cleanDir($this->request->server['DOCUMENT_ROOT'] . $this->dir . 'goods/');

    }

    private function getAllCategories($categories, $parent_id = 0)
    {

        $output = array();

        if ($categories) {
            foreach ($categories->children() as $category) {
                $category_id = $category->Ид->__toString();
                $category_name = $this->clear($category->Наименование->__toString());
                $output[$category_id] = array(
                    'id' => $category_id,
                    'name' => $category_name,
                    'keyword' => $this->translit($category_name),
                    'parent_id' => $parent_id,
                );
                $output += $this->getAllCategories($category->Группы, $category_id);
            }
        }

        return $output;
    }

    public function addPresets($data = array(), $attribute_id = 0)
    {
        $this->load->model('extension/module/Import1C');

        $this->exists_attribute_presets = $this->model_extension_module_Import1C->getAllAttributePresets();

        foreach ($data as $attribute_preset_data) {
            if (array_key_exists($attribute_preset_data['id'], $this->exists_attribute_presets)) {
                $this->model_extension_module_Import1C->updateAttributePreset($attribute_preset_data, $this->exists_attribute_presets[$attribute_preset_data['id']]);
            } else {
                $this->exists_attribute_presets[$attribute_preset_data['id']] = $this->model_extension_module_Import1C->addAttributePreset($attribute_preset_data, $attribute_id);
            }
        }
    }

    public function multiSort($array, $field)
    {
        $sortArr = array();
        foreach ($array as $key => $val) {
            $sortArr[$key] = $val[$field];
        }

        array_multisort($sortArr, $array);

        return $array;
    }

    public function translit($str)
    {
        // replace always
        $str = str_replace(array(
            '`', '~', '!', '@', '#', '$', '%', '^', '*', '(', ')', '+', '=', '[', '{', ']', '}', '\\', '|', ';', ':', "'", '"', ',', '<', '.', '>', '/', '?'
        ), ' ', str_replace(array(
            '&'
        ), array(
            'and'
        ), htmlspecialchars_decode($str)));

        $unPretty = array(
            'À', 'à', 'Á', 'á', 'Â', 'â', 'Ã', 'ã', 'Ä', 'ä', 'Å', 'å', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ǟ', 'ǟ', 'Ǻ', 'ǻ', 'Α', 'α', 'ъ', 'ạ', 'ả', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ', 'Ạ', 'Ả', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ',
            'Ḃ', 'ḃ', 'Б', 'б',
            'Ć', 'ć', 'Ç', 'ç', 'Č', 'č', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Ч', 'ч', 'Χ', 'χ',
            'Ḑ', 'ḑ', 'Ď', 'ď', 'Ḋ', 'ḋ', 'Đ', 'đ', 'Ð', 'ð', 'Д', 'д', 'Δ', 'δ',
            'Ǳ', 'ǲ', 'ǳ', 'Ǆ', 'ǅ', 'ǆ',
            'È', 'è', 'É', 'é', 'Ě', 'ě', 'Ê', 'ê', 'Ë', 'ë', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ę', 'ę', 'Ė', 'ė', 'Ʒ', 'ʒ', 'Ǯ', 'ǯ', 'Е', 'е', 'Э', 'э', 'Ε', 'ε', 'ẹ', 'ẻ', 'ẽ', 'ề', 'ế', 'ệ', 'ể', 'ễ', 'Ẹ', 'Ẻ', 'Ẽ', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
            'Ḟ', 'ḟ', 'ƒ', 'Ф', 'ф', 'Φ', 'φ',
            'ﬁ', 'ﬂ',
            'Ǵ', 'ǵ', 'Ģ', 'ģ', 'Ǧ', 'ǧ', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ǥ', 'ǥ', 'Г', 'г', 'Γ', 'γ',
            'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ж', 'ж', 'Х', 'х',
            'Ì', 'ì', 'Í', 'í', 'Î', 'î', 'Ĩ', 'ĩ', 'Ï', 'ï', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'И', 'и', 'Η', 'η', 'Ι', 'ι', 'ị', 'ỉ', 'Ị', 'Ỉ',
            'Ĳ', 'ĳ',
            'Ĵ', 'ĵ',
            'Ḱ', 'ḱ', 'Ķ', 'ķ', 'Ǩ', 'ǩ', 'К', 'к', 'Κ', 'κ',
            'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Л', 'л', 'Λ', 'λ',
            'Ǉ', 'ǈ', 'ǉ',
            'Ṁ', 'ṁ', 'М', 'м', 'Μ', 'μ',
            'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'Ñ', 'ñ', 'ŉ', 'Ŋ', 'ŋ', 'Н', 'н', 'Ν', 'ν',
            'Ǌ', 'ǋ', 'ǌ',
            'Ò', 'ò', 'Ó', 'ó', 'Ô', 'ô', 'Õ', 'õ', 'Ö', 'ö', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ø', 'ø', 'Ő', 'ő', 'Ǿ', 'ǿ', 'О', 'о', 'Ο', 'ο', 'Ω', 'ω', 'ọ', 'ỏ', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ', 'Ọ', 'Ỏ', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
            'Œ', 'œ',
            'Ṗ', 'ṗ', 'П', 'п', 'Π', 'π',
            'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Р', 'р', 'Ρ', 'ρ', 'Ψ', 'ψ',
            'Ś', 'ś', 'Ş', 'ş', 'Š', 'š', 'Ŝ', 'ŝ', 'Ṡ', 'ṡ', 'ſ', 'ß', 'С', 'с', 'Ш', 'ш', 'Щ', 'щ', 'Σ', 'σ', 'ς',
            'Ţ', 'ţ', 'Ť', 'ť', 'Ṫ', 'ṫ', 'Ŧ', 'ŧ', 'Þ', 'þ', 'Т', 'т', 'Ц', 'ц', 'Θ', 'θ', 'Τ', 'τ',
            'Ù', 'ù', 'Ú', 'ú', 'Û', 'û', 'Ũ', 'ũ', 'Ü', 'ü', 'Ů', 'ů', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ų', 'ų', 'Ű', 'ű', 'У', 'у', 'ụ', 'ủ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ', 'Ụ', 'Ủ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
            'В', 'в', 'Β', 'β',
            'Ẁ', 'ẁ', 'Ẃ', 'ẃ', 'Ŵ', 'ŵ', 'Ẅ', 'ẅ',
            'Ξ', 'ξ',
            'Ỳ', 'ỳ', 'Ý', 'ý', 'Ŷ', 'ŷ', 'Ÿ', 'ÿ', 'Й', 'й', 'Ы', 'ы', 'Ю', 'ю', 'Я', 'я', 'Υ', 'υ', 'ỵ', 'ỷ', 'ỹ', 'Ỵ', 'Ỷ', 'Ỹ',
            'Ź', 'ź', 'Ž', 'ž', 'Ż', 'ż', 'З', 'з', 'Ζ', 'ζ',
            'Æ', 'æ', 'Ǽ', 'ǽ', 'а', 'А',
            'ь'
        );
        $pretty = array(
            'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
            'B', 'b', 'B', 'b',
            'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'CH', 'ch', 'CH', 'ch',
            'D', 'd', 'D', 'd', 'D', 'd', 'D', 'd', 'D', 'd', 'D', 'd', 'D', 'd',
            'DZ', 'Dz', 'dz', 'DZ', 'Dz', 'dz',
            'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
            'F', 'f', 'f', 'F', 'f', 'F', 'f',
            'fi', 'fl',
            'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g',
            'H', 'h', 'H', 'h', 'ZH', 'zh', 'H', 'h',
            'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'i', 'i', 'I', 'I',
            'IJ', 'ij',
            'J', 'j',
            'K', 'k', 'K', 'k', 'K', 'k', 'K', 'k', 'K', 'k',
            'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l',
            'LJ', 'Lj', 'lj',
            'M', 'm', 'M', 'm', 'M', 'm',
            'N', 'n', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'N', 'n', 'N', 'n', 'N', 'n',
            'NJ', 'Nj', 'nj',
            'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
            'OE', 'oe',
            'P', 'p', 'P', 'p', 'P', 'p', 'PS', 'ps',
            'R', 'r', 'R', 'r', 'R', 'r', 'R', 'r', 'R', 'r',
            'S', 's', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 's', 'ss', 'S', 's', 'SH', 'sh', 'SHCH', 'shch', 'S', 's', 's',
            'T', 't', 'T', 't', 'T', 't', 'T', 't', 'T', 't', 'T', 't', 'TS', 'ts', 'TH', 'th', 'T', 't',
            'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
            'V', 'v', 'V', 'v',
            'W', 'w', 'W', 'w', 'W', 'w', 'W', 'w',
            'X', 'x',
            'Y', 'y', 'Y', 'y', 'Y', 'y', 'Y', 'y', 'Y', 'y', 'Y', 'y', 'YU', 'yu', 'YA', 'ya', 'Y', 'y', 'y', 'y', 'y', 'Y', 'Y', 'Y',
            'Z', 'z', 'Z', 'z', 'Z', 'z', 'Z', 'z', 'Z', 'z',
            'AE', 'ae', 'AE', 'ae', 'a', 'A',
            ''
        );

        $str = mb_strtolower(str_replace($unPretty, $pretty, $str), 'utf-8');
        $str = trim(preg_replace('/[^A-Z^a-z^0-9]+/', '-', $str), '-');
        return preg_replace('/-+/', '-', $str);
    }

    public function clear($str)
    {
        return trim(preg_replace('/\s{2,}/', ' ', $str));
    }

    public function cleanDir($dir)
    {
        $files = glob($dir . "*");
        if (count($files) > 0) {
            foreach ($files as $file) {
                if (!is_dir($dir . $file)) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
        }
    }

}
