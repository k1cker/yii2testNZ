<?php
namespace app\components\concreate;


use app\components\interfaces\IProduct;
use app\models\Product;

class ProductConcreate implements IProduct {


//    public function product_list($sort = null)
//    {
//        if (isset($sort)){
//
//            switch ($sort){
//                case 'new':
//                    $result = Product::find()->orderBy('id desc')->all();
//                    break;
//                case "price+":
//                    $result = Product::find()->orderBy('price desc')->all();
//                    break;
//                case "price-":
//                    $result = Product::find()->orderBy('price asc')->all();
//                    break;
//                case "az":
//                    $result = Product::find()->orderBy('name desc')->all();
//
//                    break;
//                case "za":
//                    $result = Product::find()->orderBy('name asc')->all();
//                    break;
//                default:
//                    $result = Product::find()->all();
//            }
//
//            return $result;
//        }
//        $result = Product::find()->all();
//        return $result;
//
//    }

    public function product_list($sort = null)
    {
        if (isset($sort)){

            switch ($sort){
                case 'new':
                    $result = 'id desc';
                    break;
                case "price+":
                    $result = 'price desc';
                    break;
                case "price-":
                    $result = 'price asc';
                    break;
                case "az":
                    $result ='name desc';

                    break;
                case "za":
                    $result = 'name asc';
                    break;
                default:
                    $result = 'id desc';
            }

            return $result;
        }
        $result = Product::find()->all();
        return $result;

    }
    public function product_list_price($left=null,$right=null)
    {
        if (isset($left)&&isset($right)){

            $result = Product::find()->where(['between', 'price',$left, $left+$right])
//                ->where(['>=', 'price', $left ])->andWhere(['<=', 'price', $right ])
                ->all();

            return $result;
        }
        $result = Product::find()->all();
        return $result;

    }
    public function product_list_cat($ids1=null,$ids2=null,$ids3=null,$left=null,$right=null,$sort = null)
    {
        $sort_order = $this->product_list($sort);
       if (isset($left)&&isset($right) && ($ids1 =='')&& ($ids2 =='')&& ($ids3 =='')&& ($left =='')&& ($right =='')){
            $result = Product::find()->orderBy($sort_order)
                ->all();
        }elseif(isset($left)&&isset($right) && ($ids1 =='')&& ($ids2 =='')&& ($ids3 =='')){

        $result = Product::find()->where(['between', 'price',$left, $left+$right])->orderBy($sort_order)

            ->all();

    }
        else{
            $result = Product::find()->where(['in', 'master_id', $ids1 ])
                ->orWhere(['in', 'category_id', $ids2 ])
                ->orWhere(['in', 'technique_id', $ids3 ])
                ->andWhere(['between', 'price',$left, $left+$right])->orderBy($sort_order)
                ->all();
        }

        return $result;

    }
}