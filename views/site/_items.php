<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

?>

<div class="post-img">
<?= Html::a(
    Html::img('@web/uploads/' . $model->img_path,['style' => 'height : 220px; width: 400px;'])
    , ['/view', 'slug' => $model->slug]) ?>
</div>
<div class="main-page__post-description">
    <div class="desc-line">
        <p class="post-category">
            <?=  $model->genre->title ?>
        </p>
        <p class="post-date">
            <?= date('d.m.Y', $model->created_at); ?>
        </p>
    </div>

    <p class="post-title">
        <?= Html::a($model->title, ['/view', 'slug' => $model->slug]) ?>
    </p>

    <div class="short-description">
        <p>
            <?= \yii\helpers\StringHelper::truncate($model->body,150,'...'); ?>
        </p>

    </div>

</div>

