<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Film */


$this->title = $model->title;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <film class="film-item">
        <h1><?= $this->title ?></h1>
        <div class="desc-line">
            <p class="post-category">
                <?=  $model->genre->title ?>
            </p>
            <p class="post-date">
                <?= date('d.m.Y', $model->created_at); ?>
            </p>
        </div>
        <div class="post-img">
       <?= Html::img('@web/uploads/' . $model->img_path,['style' => 'height : 220px; width: 400px;']) ?>
        </div>
        <div class="short-description">
            <?= $model->body?>
        </div>
        <div class="row">
            <h3>All movie sessions: </h3>
            <?php if(!empty($model->seance)): ?>
            <?php foreach ($model->seance as $item): ?>
                <div class="seance col-md-6">
                    <p>Seance date: <?= date('d.m.Y', $item->seance_date); ?></p>
                    <p>Seance time: <?= $item->seance_time ?></p>
                    <?= Html::a('Buy tickets',['/seance', 'slug' => $item->slug, 'film' => $model->id]) ?>

                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <p>Sorry but there are no sessions on this movie!</p>
            <? endif; ?>
        </div>
    </film>
</div>