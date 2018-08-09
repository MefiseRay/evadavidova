<?php

/**
 * Класс YML экспорта
 * YML (Yandex Market Language) - стандарт, разработанный "Яндексом"
 * для принятия и публикации информации в базе данных Яндекс.Маркет
 * YML основан на стандарте XML (Extensible Markup Language)
 * описание формата YML http://partner.market.yandex.ru/legal/tt/
 */
class ControllerExtensionFeedGoogleMerchant extends Controller
{
    private $shop = array();
    private $currencies = array();
    private $delivery_options = array();
    private $offers = array();
    private $eol = "\n";
    private $tab = "\t";

    public function index()
    {
        if ($this->config->get('google_merchant_status')) {

            $allowed_categories = $this->config->get('yandex_market_categories');

            $this->load->model('export/google_merchant');
            $this->load->model('catalog/product');
            $this->load->model('localisation/currency');
            $this->load->model('tool/image');

            // Магазин
            $this->setShop('title', $this->config->get('google_merchant_title'));
            $this->setShop('link', HTTPS_SERVER);
            $this->setShop('description', $this->config->get('google_merchant_description'));

            // Валюты
            $offers_currency = $this->config->get('google_merchant_currency');
            $decimal_place = $this->currency->getDecimalPlace($offers_currency);
            $shop_currency = $this->config->get('config_currency');

            // Категории

            // Товарные предложения
            $in_stock_id = $this->config->get('google_merchant_in_stock'); // id статуса товара "В наличии"
            $out_of_stock_id = $this->config->get('google_merchant_out_of_stock'); // id статуса товара "Нет на складе"
            $vendor_required = false; // true - только товары у которых задан производитель, необходимо для 'vendor.model'
            $products = $this->model_export_google_merchant->getProduct($allowed_categories, $out_of_stock_id, $vendor_required);

            // Индивидуальные условия доставки
            if ($this->config->get('google_merchant_delivery_product')) {
                $delivery_options = $this->config->get('google_merchant_delivery_product');
                foreach ($delivery_options as $delivery_option) {
                    $delivery_product_options[] = array(
                        'category' => $delivery_option['category'],
                        'price_from' => $delivery_option['price_from'],
                        'price' => $delivery_option['price'],
                        'service' => $delivery_option['service'],
                        'priority' => $delivery_option['priority']
                    );
                    $sort_priority[] = $delivery_option['priority'];
                    $sort_price[] = $delivery_option['price_from'];
                }
                array_multisort($sort_priority, SORT_DESC, $sort_price, SORT_DESC, $delivery_product_options);
            }

            foreach ($products as $product) {
                $data = array();

                // GET CATEGORIES
                $categories = $this->model_export_google_merchant->getCategories($product['product_id']);

                // SET VARS
                $category_name = NULL;
                $highest_lvl = NULL;

                if ($categories) {
                    // LOOP CATEGORIES
                    foreach ($categories as $category) {
                        // GET CATEGORY INFO
                        $category_info = $this->model_export_google_merchant->getCategory($category['category_id']);
                        // CHECK IF LEVEL IS HIGEST SO FAR
                        if ($category_info['lvl'] > $highest_lvl) {
                            // ADD TO HIGHEST VALUE VAR
                            $highest_lvl = $category_info['lvl'];
                            // SET CATEGORY NAME
                            $data['product_type'] = $category_info['name'];
                        }
                    }
                }

                // Атрибуты товарного предложения
                $data['id'] = $product['product_id'];
//				$data['type'] = 'vendor.model';
                $available = ($product['quantity'] > 0 || $product['stock_status_id'] == $in_stock_id);
                $data['availability'] = ($available ? 'in stock' : 'out of stock');

                // Параметры товарного предложения
                $data['link'] = $this->url->link('product/product', 'product_id=' . $product['product_id'], 'SSL');
                $data['price'] = number_format($this->currency->convert($this->tax->calculate($product['price'], $product['tax_class_id']), $shop_currency, $offers_currency), $decimal_place, '.', '') . ' ' . $offers_currency;
                if ($product['sale_price']) {
                    $data['sale_price'] = number_format($this->currency->convert($this->tax->calculate($product['sale_price'], $product['tax_class_id']), $shop_currency, $offers_currency), $decimal_place, '.', '') . ' ' . $offers_currency;
                }
                $data['id'] = $product['product_id'];
                $data['delivery'] = ($this->config->get('google_merchant_delivery') ? 'true' : 'false');
                $data['name'] = $product['name'];
                $data['title'] = $product['name'];
                $data['brand'] = ($product['manufacturer'] ? $product['manufacturer'] : $this->config->get('google_merchant_brand'));
                /*				if ($product['model']) {
                                    $data['mpn'] = preg_replace('/\s/', '', $product['model']);
                                }
                */
                $data['identifier_exists'] = 'FALSE';
                $data['description'] = $product['description'];

                if ($product['image']) {
                    $data['image_link'] = $this->model_tool_image->resize($product['image'], 600, 600);
                }
                if ($this->config->get('google_merchant_additional_images')) {
                    $product_images = $this->model_export_google_merchant->getProductImages($product['product_id']);
                    if ($product_images) {
                        foreach ($product_images as $product_image) {
                            $data['additional_image_link'][] = $this->model_tool_image->resize($product_image['image'], 600, 600);
                        }
                    }
                }
                if ($product['weight'] > 0) {
                    $data['weight'] = number_format($product['weight'], 1, '.', '');
                }
                if ($this->config->get('google_merchant_dimensions') && $product['length'] > 0 && $product['width'] > 0 && $product['height'] > 0) {
                    $data['dimensions'] = number_format($product['length'], 1, '.', '') . '/' . number_format($product['width'], 1, '.', '') . '/' . number_format($product['height'], 1, '.', '');
                }
                if ($this->config->get('google_merchant_condition')) {
                    $data['condition'] = $this->config->get('google_merchant_condition');
                }
                if ($this->config->get('google_merchant_product_category_id')) {
                    $data['google_product_category'] = $this->config->get('google_merchant_product_category_id');
                }
                $data['adwords_redirect'] = $this->url->link('product/product', 'product_id=' . $product['product_id'], 'SSL');

                // Индивидуальные условия доставки
                if ($data['delivery']) {

                    if ($this->config->get('google_merchant_delivery_product')) {

                        foreach ($delivery_product_options as $key => $delivery_option) {
                            if ($delivery_option['category'] != "") {
                                $categories = explode(",", $delivery_option['category']);
                                if (in_array($data['categoryId'], $categories)) {
                                    if ($data['price'] >= $delivery_option['price_from']) {
                                        $data['delivery_options'][0] = array(
                                            'price' => $delivery_option['price'],
                                            'service' => $delivery_option['service']
                                        );
                                        break;
                                    }
                                }
                            } else {
                                if ($data['price'] >= $delivery_option['price']) {
                                    $data['delivery_options'][0] = array(
                                        'price' => $delivery_option['price'],
                                        'service' => $delivery_option['service']
                                    );
                                    break;
                                }
                            }
                        }
                        $data['delivery_options'] = serialize($data['delivery_options']);
                    }

                }

                $color = $this->config->get('google_merchant_color');
                $material = $this->config->get('google_merchant_material');

                // Массив для вывода параметров
                $attributes = $this->model_catalog_product->getProductAttributes($data['id']);
                if (count($attributes)) {
                    foreach ($attributes as $attr) {
                        foreach ($attr['attribute'] as $val) {
                            switch ($val['attribute_id']) {
                                case $color:
                                    $data['color'] = $val['text'];
                                    break;
                                case $material:
                                    $data['material'] = $val['text'];
                                    break;
                            }
                        }
                    }
                }

                $this->setOffer($data);
            }

            $catalog = $this->getYml();

            $yml = new DOMDocument('1.0', 'UTF-8');
            $yml->formatOutput = true;
            $yml->loadXML($catalog);
            $yml->save("google.xml");

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
    private function setShop($name, $value)
    {
        $allowed = array('title', 'link', 'description');
        if (in_array($name, $allowed)) {
            $this->shop[$name] = $this->prepareField($value);
        }
    }

    /**
     * Товарные предложения
     *
     * @param array $data - массив параметров товарного предложения
     */
    private function setOffer($data)
    {
        $offer = array();

        $attributes = array('param', 'delivery_options');
        $attributes = array_intersect_key($data, array_flip($attributes));

        foreach ($attributes as $key => $value) {
            switch ($key) {
                case 'id':
                    $value = (int)$value;
                    if ($value > 0) {
                        $offer[$key] = $value;
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

        $allowed_tags = array('id' => 1, 'title' => 1, 'description' => 0, 'link' => 0, 'image_link' => 0, 'additional_image_link' => 0, 'condition' => 1, 'availability' => 1, 'price' => 1, 'sale_price' => 0, 'delivery_options' => 0, 'brand' => 0, 'mpn' => 0, 'identifier_exists' => 1, 'google_product_category' => 1, 'product_type' => 1, 'color' => 0, 'material' => 0, 'adwords_redirect' => 1);

        $required_tags = array_filter($allowed_tags);

        if (sizeof(array_intersect_key($data, $required_tags)) != sizeof($required_tags)) {
            return;
        }

        $data = array_intersect_key($data, $allowed_tags);

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
    private function getYml()
    {
        $yml = '<?xml version="1.0" encoding="utf-8"?>' . $this->eol;
        $yml .= '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">' . $this->eol;
        $yml .= '<channel>' . $this->eol;

        // информация о магазине
        $yml .= $this->array2TagShop($this->shop);

        // товарные предложения
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
            $yml .= $this->getElement($offer, 'item', $tags);
        }

        $yml .= '</channel>' . $this->eol;
        $yml .= '</rss>';

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
    private function getElement($attributes, $element_name, $element_value = '')
    {
        $retval = '<' . $element_name;
        foreach ($attributes as $key => $value) {
            $retval .= ' ' . $key . '="' . $value . '"';
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
    private function array2Tag($tags)
    {
        $retval = '';
        foreach ($tags as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $i => $val) {
                    $retval .= $this->tab . '<g:' . $key . '>' . $this->prepareField($val) . '</g:' . $key . '>' . $this->eol;
                }
            } else {
                if ($key == 'delivery_options') {
                    $offer['delivery_options'] = unserialize($value);
                    $retval .= $this->array2DeliveryOptions($offer['delivery_options']);
                    unset($offer['delivery_options']);
                } else {
                    if ($key == 'title' || $key == 'link' || $key == 'description') {
                        $retval .= $this->tab . '<' . $key . '>' . $this->prepareField($value) . '</' . $key . '>' . $this->eol;
                    } else {
                        $retval .= $this->tab . '<g:' . $key . '>' . $this->prepareField($value) . '</g:' . $key . '>' . $this->eol;
                    }
                }
            }
        }

        return $retval;
    }

    private function array2TagShop($tags)
    {
        $retval = '';
        foreach ($tags as $key => $value) {
            $retval .= '<' . $key . '>' . $this->prepareField($value) . '</' . $key . '>' . $this->eol;
        }

        return $retval;
    }

    /**
     * Преобразование массива в теги доставки
     *
     * @param array $delivery_options
     * @return string
     */
    private function array2DeliveryOptions($delivery_options)
    {
        $retval = $this->tab . '<g:shipping>' . $this->eol;
        foreach ($delivery_options as $delivery_option) {
            $retval .= $this->tab . $this->tab . '<g:country>RU</g:country>' . $this->eol;
            $retval .= $this->tab . $this->tab . '<g:service>' . $this->prepareField($delivery_option['service']) . '</g:service>' . $this->eol;
            $retval .= $this->tab . $this->tab . '<g:price>' . $this->prepareField($delivery_option['price']) . '</g:price>' . $this->eol;
        }
        $retval .= $this->tab . '</g:shipping>' . $this->eol;;

        return $retval;
    }

    /**
     * Преобразование массива в теги параметров
     *
     * @param array $params
     * @return string
     */
    private function array2Param($params)
    {
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
    private function prepareField($field)
    {
        $field = htmlspecialchars_decode($field);
        $field = strip_tags($field);
        $from = array('"', '&', '>', '<', '\'');
        $to = array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
        $field = str_replace($from, $to, $field);
        return trim($field);
    }
}

?>
