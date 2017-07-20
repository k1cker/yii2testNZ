<?php
namespace app\components\interfaces;


interface IProduct
{
    public function product_list($sort);
    public function product_list_price($left,$right);
    public function product_list_cat($cat_id);


}