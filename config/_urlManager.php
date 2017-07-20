<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        // about-us
        ['pattern'=>'about', 'route'=>'site/about'],

        // contact
        ['pattern'=>'contact', 'route'=>'site/contact'],

        // services
        ['pattern'=>'master', 'route'=>'site/masters'],

        // support-faq
        ['pattern'=>'catalog', 'route'=>'site/catalog'],
        // shop
        ['pattern'=>'shop', 'route'=>'shop/index'],
        //product
        ['pattern'=>'product', 'route'=>'site/product'],





    ]
];
