<?php

use app\models\CinemaPlaces;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $film app\models\Film */
/* @var $seance app\models\Seance */

$this->title = $film->title;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content">
    <film class="film-item">
        <h1><?= $this->title ?></h1>
        <div class="post-img">
            <?= Html::img('@web/uploads/' . $film->img_path,['style' => 'height : 220px; width: 400px;']) ?>
        </div>
        <div class="desc-line">
            <p class="post-category">
                <?=  $film->genre->title ?>
            </p>
            <h3>Seance start:</h3>
            <p class="post-date">
                Dade: <?=  date('d.m.Y',$seance->seance_date); ?>
            </p>
            <p>
                Time: <?= $seance->seance_time?>
            </p>
        </div>

        <div class="row cinema_hall">
            <h2>Choose a place:</h2>
            <?php $n=0; for($i = 1; $i <= CinemaPlaces::COUNT_ROWS;  $i++): ?>
                <div class="row_cinema "><p>Row# <?= $i ?></p>
                <?php for($j = 1; $j <= CinemaPlaces::COUNT_PLACES; $j++): ?>
                    <div class="place_cinema <?= $seance->cinema_places_ar[$n]? 'sales': 'free'?> " data-num="<?= $n ?>"><?= $j ?></div>
                <?php $n++; endfor ?>
                </div>
            <?php endfor ?>
        </div>
        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'buy-form']); ?>

                <?= $form->field($buy_form, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($buy_form, 'email') ?>

                <?= $form->field($buy_form, 'array_tickets')->hiddenInput()->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </film>
</div>
