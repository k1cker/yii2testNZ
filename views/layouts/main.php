<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $menuItems = [
        [
            'label' => 'Section',
            'items' => [
                [
                    'label' => 'Subsection One',
                    'url' => ['/sub-section-one/index']],
                'visible' => Yii::$app->user->can('sub-section-one.manage'),
            ],
            [
                'label' => 'Subsection One',
                'url' => ['/sub-section-one/index']
            ],
            [
                'label' => 'SEO',
                'icon' => 'fa fa-bar-chart',
                'url' => '#',
                'items' => [
                    [
                        'label' => 'SEO-записи',
                        'icon' => 'fa fa-circle-o',
                        'url' => ['/seo-posts'],
                    ],
                    [
                        'label' => 'Произвольные meta и title',
                        'icon' => 'fa fa-circle-o',
                        'url' => ['/seo-meta'],
                    ],
                    [
                        'label' => 'Кол-во входов и регионы',
                        'icon' => 'fa fa-circle-o',
                        'url' => ['/seo-regions'],
                    ],
                    [
                        'label' => 'Динамика',
                        'icon' => 'fa fa-circle-o',
                        'url' => ['/seo-dynamic'],
                    ],
                    [
                        'label' => '24online',
                        'icon' => 'fa fa-circle-o',
                        'url' => ['/seo-online'],
                    ]
                ]
            ],

        ],
    ];

    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' =>
            \app\models\Menu::getMenu()
//            [
//            ['label' => 'Home', 'url' => ['/site/index']],
//            ['label' => 'About', 'url' => ['/site/about']],
//            ['label' => 'Contact', 'url' => ['/site/contact']],
//            ['label' => 'Menu', 'url' => ['/menu/index']],
//                [
//                    'label' => 'SEO',
//                    'icon' => 'fa fa-bar-chart',
//                    'url' => '#',
//                    'items' => [
//                        [
//                            'label' => 'SEO-записи',
//                            'icon' => 'fa fa-circle-o',
//                            'url' => ['/seo-posts'],
//                        ],
//                        [
//                            'label' => 'Произвольные meta и title',
//                            'icon' => 'fa fa-circle-o',
//                            'url' => ['/seo-meta'],
//                        ],
//                        [
//                            'label' => 'Кол-во входов и регионы',
//                            'icon' => 'fa fa-circle-o',
//                            'url' => ['/seo-regions'],
//                        ],
//                        [
//                            'label' => 'Динамика',
//                            'icon' => 'fa fa-circle-o',
//                            'url' => ['/seo-dynamic'],
//                        ],
//                        [
//                            'label' => '24online',
//                            'icon' => 'fa fa-circle-o',
//                            'url' => ['/seo-online'],
//                        ]
//                    ]
//                ],
//
//
//
//
//            Yii::$app->user->isGuest ? (
//                ['label' => 'Login', 'url' => ['/site/login']]
//            ) : (
//                '<li>'
//                . Html::beginForm(['/site/logout'], 'post')
//                . Html::submitButton(
//                    'Logout (' . Yii::$app->user->identity->username . ')',
//                    ['class' => 'btn btn-link logout']
//                )
//                . Html::endForm()
//                . '</li>'
//            )
//        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
