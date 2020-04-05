<?php

/* @var $this yii\web\View */
/* @var array Film $popular_films */

use yii\helpers\Html;
use yii\web\View;

$this->title = 'My Yii Application';

$this->registerJsFile('@web/slick/slick.min.js',
    ['position' =>View::POS_END,'depends' =>[\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/slick/slick-theme.css');
$this->registerCssFile('@web/slick/slick.css');
$this->registerJs(<<<JS
        $('.slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: true,
    focusOnSelect: true,
    autoplay: true
});
JS
, View::POS_READY);

?>
<div class="site-index">


    <h2>Popular movies</h2>
    <div class="slider">
        <?php foreach ($popular_films as $item): ?>
            <div>
                <h3><?= $item->title ?></h3>
                <?= Html::img('@web/uploads/' . $item->img_path, ['style' => 'height : 500px']) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="main-page__news-section">
        <div class="my-container">
            <div class="main-page__block-heading">
                <h2>Top movies</h2>
            </div>
        <?php echo \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'pager' => [
                'hideOnSinglePage' => true,
            ],
            'itemView' => '_items',
            'itemOptions' => [
                'class' => 'single-new'
            ],
            'options' => [
                'class' => 'news-widget'
            ]
        ])?>
        </div>
    </div>
</div>
