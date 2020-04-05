<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Seance */
/* @var $form yii\widgets\ActiveForm */
/* @var $film app\models\Film[] */
?>

<div class="seance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'film_id')->dropDownList(ArrayHelper::map($film, 'id', 'title')) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'seance_time')->dropDownList(\app\models\Seance::SEANCE_TIMES) ?>

    <?= $form->field($model, 'status')->checkbox(['value' => '1', 'checked ' => true]) ?>

    <?= $form->field($model, 'published_at_formatted')->widget(DatePicker::class, ['dateFormat' => 'dd.MM.yyyy',])->label('Premiere date'); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
