<?php

class ModelCocFeatured extends Model
{

    public function getFeaturedProducts()
    {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE code = 'featured'");

        if ($query->rows) {

            $i = 0;

            $two = array();

            $three = array();
            foreach ($query->rows as $one) {

                $two[$i] = unserialize($one['setting']);

                $three = array_merge($three, $two[$i]['product']);

                $i++;


            }

            return array_unique($three);

        } else {

            return array();

        }

    }


}

?>