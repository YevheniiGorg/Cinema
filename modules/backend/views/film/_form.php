<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Film */
/* @var $form yii\widgets\ActiveForm */
/* @var $genre app\models\FilmGenre[] */
?>

<div class="film-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'genre_id')->dropDownList(\yii\helpers\ArrayHelper::map($genre, 'id', 'title')) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <div><label for="film-imagefile">Image</label></div>
    <?= $model->Image ? Html::img($model->Image) : 'Файл не выбран'?>

    <?= $form->field($model, 'imageFile')->fileInput()->label(false) ?>

    <?= $form->field($model, 'status')->checkbox(['value' => '1', 'checked ' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
