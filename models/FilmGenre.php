<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "film_genre".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property integer   $created_by
 * @property integer   $updated_by
 *
 * @property Film[] $films
 */
class FilmGenre extends \yii\db\ActiveRecord
{

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT     = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'film_genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['body'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['slug'], 'string', 'max' => 1024],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['title'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'body' => 'Body',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'created_by' => 'Created By'
        ];
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
            ]
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
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DRAFT =>  'Draft',
            self::STATUS_PUBLISHED => 'Published',
        ];
    }

    /**
     * Gets query for [[Films]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\FilmQuery
     */
    public function getFilms()
    {
        return $this->hasMany(Film::className(), ['genre_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\FilmGenreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FilmGenreQuery(get_called_class());
    }
}
