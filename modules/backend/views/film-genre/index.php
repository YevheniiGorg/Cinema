<?php

use app\grid\EnumColumn;
use app\models\FilmGenre;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\search\FilmGenreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Film Genres';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-genre-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Film Genre', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'slug',
            'title',
            'body:ntext',
            [
                'class' => EnumColumn::class,
                'attribute' => 'status',
                'options' => ['style' => 'width: 10%'],
                'enum' => FilmGenre::statuses(),
                'filter' => FilmGenre::statuses(),
            ],
            [
                'attribute' => 'created_by',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->author->username;
                },
            ],
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
