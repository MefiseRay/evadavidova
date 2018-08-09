<?php

class ControllerProductCustomized extends Controller
{

    public function index()
    {

        $this->language->load('product/customized');

        if ((int)$this->config->get('coc_customized_status') == 1) {

            $this->load->model('coc/product');

            $this->load->model('tool/image');

            if (isset($this->request->get['sort'])) {

                $sort = $this->request->get['sort'];

            } else {

                $sort = 'p.sort_order';

            }

            if (isset($this->request->get['order'])) {

                $order = $this->request->get['order'];

            } else {

                $order = 'ASC';

            }

            if (isset($this->request->get['page'])) {

                $page = $this->request->get['page'];

            } else {

                $page = 1;

            }

            if (isset($this->request->get['limit'])) {

                $limit = $this->request->get['limit'];

            } else {

                $limit = $this->config->get('config_product_limit');

            }

            $coc_customized_description = $this->config->get('coc_customized_description');

            $this->document->setTitle($coc_customized_description[(int)$this->config->get('config_language_id')]['meta_title']);

            $this->document->setDescription($coc_customized_description[(int)$this->config->get('config_language_id')]['meta_description']);

            $this->document->setKeywords($coc_customized_description[(int)$this->config->get('config_language_id')]['meta_keyword']);

            $this->document->addLink($this->url->link('product/customized', ''), 'canonical');

            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(

                'text' => $this->language->get('text_home'),

                'href' => $this->url->link('common/home')

            );

            $url = '';

            if (isset($this->request->get['sort'])) {

                $url .= '&sort=' . $this->request->get['sort'];

            }

            if (isset($this->request->get['order'])) {

                $url .= '&order=' . $this->request->get['order'];

            }

            if (isset($this->request->get['page'])) {

                $url .= '&page=' . $this->request->get['page'];

            }

            if (isset($this->request->get['limit'])) {

                $url .= '&limit=' . $this->request->get['limit'];

            }

            $data['breadcrumbs'][] = array(

                'text' => $coc_customized_description[(int)$this->config->get('config_language_id')]['heading_title'],

                'href' => $this->url->link('product/customized', $url)

            );

            $data['heading_title'] = $coc_customized_description[(int)$this->config->get('config_language_id')]['heading_title'];

            $data['text_empty'] = $this->language->get('text_empty');

            $data['text_quantity'] = $this->language->get('text_quantity');

            $data['text_manufacturer'] = $this->language->get('text_manufacturer');

            $data['text_model'] = $this->language->get('text_model');

            $data['text_price'] = $this->language->get('text_price');

            $data['text_tax'] = $this->language->get('text_tax');

            $data['text_points'] = $this->language->get('text_points');

            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

            $data['text_display'] = $this->language->get('text_display');

            $data['text_list'] = $this->language->get('text_list');

            $data['text_grid'] = $this->language->get('text_grid');

            $data['text_sort'] = $this->language->get('text_sort');

            $data['text_limit'] = $this->language->get('text_limit');

            $data['button_cart'] = $this->language->get('button_cart');

            $data['button_wishlist'] = $this->language->get('button_wishlist');

            $data['button_compare'] = $this->language->get('button_compare');

            $data['compare'] = $this->url->link('product/compare');

            $data['products'] = array();

            $pre_products = array();

            //$total_limit = $limit * 10; //define the total number to get

            $filter_data = array(

                'sort' => $sort,

                'order' => $order,

                'start' => ($page - 1) * $limit,

                'limit' => $limit,

                'page' => $page

            );

            $results = $this->config->get('coc_customized_product');

            //$product_total = (count($results) < $total_limit) ? count($results) : $total_limit;

            $product_total = count($results);

            $products = array_slice($results, 0, $product_total); //get total products ids

            if ($product_total) {


                //get product info into an array

                foreach ($products as $product_id) {

                    $product_info = $this->model_coc_product->getProduct($product_id);

                    if ($product_info && $product_info['status'] == 1) {

                        $pre_products[] = $product_info;

                    } else {

                        $product_total = $product_total - 1;

                    }

                }

                //start to sort data

                $name = array();

                $price = array();

                $rating = array();

                $model = array();

                $sort_order = array();

                foreach ($pre_products as $key => $value) {

                    $name[$key] = strtolower($value['name']);

                    $price[$key] = $value['special'] ? $value['special'] : $value['price'];

                    $rating[$key] = $value['rating'];

                    $model[$key] = $value['model'];

                    $viewed[$key] = $value['viewed'];

                    $sort_order[$key] = $value['sort_order'];

                }

                if ($filter_data['sort'] != 'p.sort_order') {

                    if ($filter_data['sort'] == 'pd.name') {

                        $coc_sort = $name;

                    }

                    if ($filter_data['sort'] == 'p.price') {

                        $coc_sort = $price;

                    }

                    if ($filter_data['sort'] == 'rating') {

                        $coc_sort = $rating;

                    }

                    if ($filter_data['sort'] == 'p.model') {

                        $coc_sort = $model;

                    }

                    if ($filter_data['order'] == 'ASC') {

                        array_multisort($coc_sort, SORT_ASC, $pre_products);

                    } else {

                        array_multisort($coc_sort, SORT_DESC, $pre_products);

                    }

                } else {

                    array_multisort($sort_order, SORT_DESC, $pre_products);

                }

                //end sort data

                //get the products of specific page

                $pre_products = array_slice($pre_products, ($filter_data['page'] - 1) * $filter_data['limit'], $filter_data['limit']);

                foreach ($pre_products as $result) {

                    if ($result['image']) {

                        $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));

                    } else {

                        $image = false;

                    }

                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {

                        $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));

                    } else {

                        $price = false;

                    }

                    if ((float)$result['special']) {

                        $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));

                    } else {

                        $special = false;

                    }

                    if ($this->config->get('config_tax')) {

                        $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);

                    } else {

                        $tax = false;

                    }

                    if ($this->config->get('config_review_status')) {

                        $rating = (int)$result['rating'];

                    } else {

                        $rating = false;

                    }

                    $product['special'] = ((float)$result['special']) ? $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'))) : false;

                    $data['products'][] = array(

                        'product_id' => $result['product_id'],

                        'thumb' => $image,

                        'name' => $result['name'],

                        'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',

                        'price' => $price,

                        'special' => $special,

                        'tax' => $tax,

                        'rating' => $result['rating'],

                        'reviews' => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),

                        'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)

                    );

                }

            }

            $url = '';

            if (isset($this->request->get['limit'])) {

                $url .= '&limit=' . $this->request->get['limit'];

            }

            $data['sorts'] = array();

            $data['sorts'][] = array(

                'text' => $this->language->get('text_default'),

                'value' => 'p.sort_order-ASC',

                'href' => $this->url->link('product/customized', 'sort=p.sort_order&order=ASC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_name_asc'),

                'value' => 'pd.name-ASC',

                'href' => $this->url->link('product/customized', 'sort=pd.name&order=ASC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_name_desc'),

                'value' => 'pd.name-DESC',

                'href' => $this->url->link('product/customized', 'sort=pd.name&order=DESC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_price_asc'),

                'value' => 'p.price-ASC',

                'href' => $this->url->link('product/customized', 'sort=p.price&order=ASC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_price_desc'),

                'value' => 'p.price-DESC',

                'href' => $this->url->link('product/customized', 'sort=p.price&order=DESC' . $url)

            );

            if ($this->config->get('config_review_status')) {

                $data['sorts'][] = array(

                    'text' => $this->language->get('text_rating_desc'),

                    'value' => 'rating-DESC',

                    'href' => $this->url->link('product/customized', 'sort=rating&order=DESC' . $url)

                );

                $data['sorts'][] = array(

                    'text' => $this->language->get('text_rating_asc'),

                    'value' => 'rating-ASC',

                    'href' => $this->url->link('product/customized', 'sort=rating&order=ASC' . $url)

                );

            }

            $data['sorts'][] = array(

                'text' => $this->language->get('text_model_asc'),

                'value' => 'p.model-ASC',

                'href' => $this->url->link('product/customized', 'sort=p.model&order=ASC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_model_desc'),

                'value' => 'p.model-DESC',

                'href' => $this->url->link('product/customized', 'sort=p.model&order=DESC' . $url)

            );

            $url = '';

            if (isset($this->request->get['sort'])) {

                $url .= '&sort=' . $this->request->get['sort'];

            }

            if (isset($this->request->get['order'])) {

                $url .= '&order=' . $this->request->get['order'];

            }

            $data['limits'] = array();

            $limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {

                $data['limits'][] = array(

                    'text' => $value,

                    'value' => $value,

                    'href' => $this->url->link('product/customized', $url . '&limit=' . $value)

                );

            }

            $url = '';

            if (isset($this->request->get['sort'])) {

                $url .= '&sort=' . $this->request->get['sort'];

            }

            if (isset($this->request->get['order'])) {

                $url .= '&order=' . $this->request->get['order'];

            }

            if (isset($this->request->get['limit'])) {

                $url .= '&limit=' . $this->request->get['limit'];

            }

            $pagination = new Pagination();

            $pagination->total = $product_total;

            $pagination->page = $page;

            $pagination->limit = $limit;

            $pagination->url = $this->url->link('product/customized', $url . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            $data['sort'] = $sort;

            $data['order'] = $order;

            $data['limit'] = $limit;

            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');

            $data['column_right'] = $this->load->controller('common/column_right');

            $data['content_top'] = $this->load->controller('common/content_top');

            $data['content_bottom'] = $this->load->controller('common/content_bottom');

            $data['footer'] = $this->load->controller('common/footer');

            $data['header'] = $this->load->controller('common/header');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/customized.tpl')) {

                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/customized.tpl', $data));

            } else {

                $this->response->setOutput($this->load->view('default/template/product/customized.tpl', $data));

            }

        } else {

            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/category', $url)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
            } else {
                $this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
            }


        }

    }

}
