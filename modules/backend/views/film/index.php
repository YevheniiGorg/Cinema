<?php

use app\grid\EnumColumn;
use app\models\FilmGenre;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\search\FilmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Films';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Film', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'genre_id',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return $model->genre ? $model->genre->title : null;
                },
                'filter' => ArrayHelper::map(\app\models\FilmGenre::find()->active()->all(), 'id', 'title'),
            ],
            'image:image',
//            'body:ntext',
            'popularity_rating',
            [
                'class' => EnumColumn::class,
                'attribute' => 'status',
                'options' => ['style' => 'width: 10%'],
                'enum' => FilmGenre::statuses(),
                'filter' => FilmGenre::statuses(),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
