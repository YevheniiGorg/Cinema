<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seance */
/* @var $film app\models\Film[] */

$this->title = 'Create Seance';
$this->params['breadcrumbs'][] = ['label' => 'Seances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'film' => $film
    ]) ?>

</div>
