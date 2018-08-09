<?php

class ControllerProductAll extends Controller
{

    public function index()
    {

        $this->load->language('product/all');

        if ((int)$this->config->get('coc_all_status') == 1) {

            $this->load->model('coc/product001');

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


            $coc_all_description = $this->config->get('coc_all_description');

            $this->document->setTitle($coc_all_description[(int)$this->config->get('config_language_id')]['meta_title']);

            $this->document->setDescription($coc_all_description[(int)$this->config->get('config_language_id')]['meta_description']);

            $this->document->setKeywords($coc_all_description[(int)$this->config->get('config_language_id')]['meta_keyword']);

            $this->document->addLink($this->url->link('product/all', ''), 'canonical');

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

                'text' => $coc_all_description[(int)$this->config->get('config_language_id')]['heading_title'],

                'href' => $this->url->link('product/all', $url)

            );

            $data['heading_title'] = $coc_all_description[(int)$this->config->get('config_language_id')]['heading_title'];

            $data['text_empty'] = $this->language->get('text_empty');

            $data['text_quantity'] = $this->language->get('text_quantity');

            $data['text_manufacturer'] = $this->language->get('text_manufacturer');

            $data['text_model'] = $this->language->get('text_model');

            $data['text_price'] = $this->language->get('text_price');

            $data['text_tax'] = $this->language->get('text_tax');

            $data['text_points'] = $this->language->get('text_points');

            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

            $data['text_sort'] = $this->language->get('text_sort');

            $data['text_limit'] = $this->language->get('text_limit');

            $data['button_cart'] = $this->language->get('button_cart');

            $data['button_wishlist'] = $this->language->get('button_wishlist');

            $data['button_compare'] = $this->language->get('button_compare');

            $data['button_list'] = $this->language->get('button_list');

            $data['button_grid'] = $this->language->get('button_grid');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['compare'] = $this->url->link('product/compare');

            $data['products'] = array();

            $filter_data = array(

                'filter_category_id' => 0,

                'filter_filter' => 0,

                'sort' => $sort,

                'order' => $order,

                'start' => ($page - 1) * $limit,

                'limit' => $limit

            );

            $product_total = $this->model_coc_product001->getTotalProducts($filter_data);

            $results = $this->model_coc_product001->getProducts($filter_data);

            foreach ($results as $result) {

                if ($result['image']) {

                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));

                } else {

                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));

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

                $data['products'][] = array(

                    'product_id' => $result['product_id'],

                    'thumb' => $image,

                    'name' => $result['name'],

                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',

                    'price' => $price,

                    'special' => $special,

                    'tax' => $tax,

                    'rating' => $result['rating'],

                    'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)

                );

            }

            $url = '';

            if (isset($this->request->get['limit'])) {

                $url .= '&limit=' . $this->request->get['limit'];

            }

            $data['sorts'] = array();

            $data['sorts'][] = array(

                'text' => $this->language->get('text_default'),

                'value' => 'p.sort_order-ASC',

                'href' => $this->url->link('product/all', 'sort=p.sort_order&order=ASC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_name_asc'),

                'value' => 'pd.name-ASC',

                'href' => $this->url->link('product/all', 'sort=pd.name&order=ASC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_name_desc'),

                'value' => 'pd.name-DESC',

                'href' => $this->url->link('product/all', 'sort=pd.name&order=DESC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_price_asc'),

                'value' => 'p.price-ASC',

                'href' => $this->url->link('product/all', 'sort=p.price&order=ASC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_price_desc'),

                'value' => 'p.price-DESC',

                'href' => $this->url->link('product/all', 'sort=p.price&order=DESC' . $url)

            );

            if ($this->config->get('config_review_status')) {

                $data['sorts'][] = array(

                    'text' => $this->language->get('text_rating_desc'),

                    'value' => 'rating-DESC',

                    'href' => $this->url->link('product/all', 'sort=rating&order=DESC' . $url)

                );

                $data['sorts'][] = array(

                    'text' => $this->language->get('text_rating_asc'),

                    'value' => 'rating-ASC',

                    'href' => $this->url->link('product/all', 'sort=rating&order=ASC' . $url)

                );
            }

            $data['sorts'][] = array(

                'text' => $this->language->get('text_model_asc'),

                'value' => 'p.model-ASC',

                'href' => $this->url->link('product/all', 'sort=p.model&order=ASC' . $url)

            );

            $data['sorts'][] = array(

                'text' => $this->language->get('text_model_desc'),

                'value' => 'p.model-DESC',

                'href' => $this->url->link('product/all', 'sort=p.model&order=DESC' . $url)

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

                    'href' => $this->url->link('product/all', $url . '&limit=' . $value)

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

            $pagination->url = $this->url->link('product/all', $url . '&page={page}');

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

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/all.tpl')) {

                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/all.tpl', $data));

            } else {

                $this->response->setOutput($this->load->view('default/template/product/all.tpl', $data));

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