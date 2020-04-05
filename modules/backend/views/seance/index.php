<?php

use app\grid\EnumColumn;
use app\models\FilmGenre;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\backend\models\search\SeanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Seance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'Film name',
                'value' => function ($model) {
                    return $model->film ? $model->film->title : null;
                },

            ],
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
                'attribute' => 'Number of tickets sold', 'value' => function ($model) {
                return empty($model->getCountTicketsSold())? "Nothing sold!" : $model->getCountTicketsSold();
                },
            ],
            'seance_date:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
