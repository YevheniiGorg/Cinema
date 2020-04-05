<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmGenre */

$this->title = 'Create Film Genre';
$this->params['breadcrumbs'][] = ['label' => 'Film Genres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-genre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
