<?php

namespace app\models;

use app\behaviors\DateToTimeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seance".
 *
 * @property int id
 * @property int $film_id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string cinema_places
 * @property int seance_time
 * @property int seance_date
 * @property int $status
 * @property int|null $published_at
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property integer   $created_by
 * @property integer   $updated_by
 *
 * @property Film $film
 */
class Seance extends \yii\db\ActiveRecord
{

    const SEANCE_TIMES = [
        10 => 10,
        12 => 12,
        14 => 14,
        16 => 16,
        18 => 18,
        20 => 20];

    public $published_at_formatted;
    public $cinema_places_ar = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%seance}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status', 'seance_time'], 'required'],
            [['body', 'cinema_places'], 'string'],
            [['status', 'seance_time', 'published_at', 'seance_date', 'created_at', 'updated_at'], 'integer'],
            ['published_at_formatted', 'date', 'format' => 'php:d.m.Y'],
            [['published_at', 'seance_date'], 'default', 'value' => function () {
                return strtotime(date("Y-m-d"));
            }],
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['slug'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['film_id'], 'exist', 'skipOnError' => true, 'targetClass' => Film::className(), 'targetAttribute' => ['film_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'film_id' => 'Film',
            'slug' => 'Slug',
            'title' => 'Title',
            'body' => 'Body',
            'cinema_places' => 'Cinema seats',
            'seance_time' => 'Seance time',
            'seance_date' => 'Seance date',
            'status' => 'Status',
            'published_at' => 'Published At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'created_by' => 'Created By'
        ];
    }

    public function init()
    {
        $CinemaPlaces = new CinemaPlaces();
        $this->cinema_places_ar = $CinemaPlaces->getPlaces();
            parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true,
            ],
            [
                'class' => DateToTimeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'published_at_formatted',
                    ActiveRecord::EVENT_AFTER_FIND => 'published_at_formatted',
                ],
                'timeAttribute' => 'seance_date'
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Film]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\FilmQuery
     */
    public function getFilm()
    {
        return $this->hasOne(Film::className(), ['id' => 'film_id']);
    }

    /**

     * @return array
     */
    public function getCountTicketsSold(){
        return array_count_values($this->cinema_places_ar)[CinemaPlaces::PLACE_SOLD];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\SeanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SeanceQuery(get_called_class());
    }

    public function afterFind()
    {
        $this->cinema_places_ar = json_decode($this->cinema_places);
        parent::afterFind();

    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->cinema_places = json_encode($this->cinema_places_ar);
            return parent::beforeSave($insert);
        } else {
            return false;
        }
    }

    public function beforeValidate()
    {
        $this->cinema_places = json_encode($this->cinema_places_ar);
        $this->seance_time = Seance::SEANCE_TIMES[$this->seance_time];
        return parent::beforeValidate();
    }
}
