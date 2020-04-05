<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seance */
/* @var $film app\models\Film[] */

$this->title = 'Update Seance: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Seances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->film_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'film' => $film
    ]) ?>

</div>
