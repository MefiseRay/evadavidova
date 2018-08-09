<?php

class ControllerExtensionFeedYandexSitemap extends Controller
{

    public function index()
    {
        $map = $this->generateXml();

        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        $xml->loadXML($map);
        $xml->save("sitemap.xml");

        $this->response->addHeader('Content-Type: application/xml');
        $this->response->setOutput($this->generateXml());

    }

    public function generateXml()
    {
        if ($this->config->get('yandex_sitemap_status')) {
            $output = '<?xml version="1.0" encoding="UTF-8"?>';
            $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            $this->load->model('catalog/product');

            if ($this->config->get('yandex_sitemap_homepage')) {
                $output .= '<url>';
                $output .= '<loc>' . HTTPS_SERVER . '</loc>';
                $output .= '<changefreq>weekly</changefreq>';
                $output .= '<priority>1.0</priority>';
                $output .= '</url>';
            }

            $products = $this->model_catalog_product->getProducts();

            $p_priority = $this->config->get('yandex_sitemap_product_priority');

            if ($p_priority != 0) {
                foreach ($products as $product) {
                    $output .= '<url>';
                    $output .= '<loc>' . $this->url->link('product/product', 'product_id=' . $product['product_id'], 'SSL') . '</loc>';
                    $output .= '<changefreq>weekly</changefreq>';
                    $output .= '<priority>' . $p_priority . '</priority>';
                    $output .= '</url>';
                }
            }

            $this->load->model('catalog/category');

            $c_priority = $this->config->get('yandex_sitemap_category_priority');

            if ($c_priority != 0) {
                $output .= $this->getCategories(0);
            }

            $this->load->model('catalog/manufacturer');

            $manufacturers = $this->model_catalog_manufacturer->getManufacturers();

            $m_priority = $this->config->get('yandex_sitemap_manufacturer_priority');

            if ($m_priority != 0) {
                foreach ($manufacturers as $manufacturer) {
                    $output .= '<url>';
                    $output .= '<loc>' . $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id'], 'SSL') . '</loc>';
                    $output .= '<changefreq>weekly</changefreq>';
                    $output .= '<priority>' . $m_priority . '</priority>';
                    $output .= '</url>';
                }
            }

            $this->load->model('catalog/information');

            $informations = $this->model_catalog_information->getInformations();

            $i_priority = $this->config->get('yandex_sitemap_information_priority');

            if ($i_priority != 0) {
                foreach ($informations as $information) {
                    $output .= '<url>';
                    $output .= '<loc>' . $this->url->link('information/information', 'information_id=' . $information['information_id'], 'SSL') . '</loc>';
                    $output .= '<changefreq>weekly</changefreq>';
                    $output .= '<priority>' . $i_priority . '</priority>';
                    $output .= '</url>';
                }
            }

            if ($this->config->get('yandex_sitemap_contacts')) {
                $output .= '<url>';
                $output .= '<loc>' . $this->url->link('information/contact', '', 'SSL') . '</loc>';
                $output .= '<changefreq>weekly</changefreq>';
                $output .= '<priority>0.7</priority>';
                $output .= '</url>';
            }

            $output .= '</urlset>';

            //$this->response->addHeader('Content-Type: application/xml');
            //$this->response->setOutput($output);
            return $output;
        }
    }

    protected function getCategories($parent_id, $current_path = '')
    {
        $output = '';
        $c_priority = $this->config->get('yandex_sitemap_category_priority');

        $results = $this->model_catalog_category->getCategories($parent_id);

        foreach ($results as $result) {
            if (!$current_path) {
                $new_path = $result['category_id'];
            } else {
                $new_path = $current_path . '_' . $result['category_id'];
            }

            $output .= '<url>';
            $output .= '<loc>' . $this->url->link('product/category', 'path=' . $new_path, 'SSL') . '</loc>';
            $output .= '<changefreq>weekly</changefreq>';
            $output .= '<priority>' . $c_priority . '</priority>';
            $output .= '</url>';

            $output .= $this->getCategories($result['category_id'], $new_path);
        }

        return $output;
    }
}
