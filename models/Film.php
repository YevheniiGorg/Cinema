<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "film".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property int|null $genre_id
 * @property int|null $popularity_rating
 * @property string $body
 * @property string|null $img_path
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property integer   $created_by
 * @property integer   $updated_by
 *
 * @property FilmGenre $genre
 * @property Seance $seance
 */
class Film extends \yii\db\ActiveRecord
{

    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%film}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body', 'status'], 'required'],
            [['genre_id', 'status', 'created_at', 'updated_at', 'popularity_rating'], 'integer'],
            [['body'], 'string'],
            [['slug','img_path'], 'string', 'max' => 1024],
            [['slug'], 'unique'],
            [['title'], 'string', 'max' => 512],
            [['imageFile'] ,'file'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => FilmGenre::className(), 'targetAttribute' => ['genre_id' => 'id']],
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
            'genre_id' => 'Genre ID',
            'body' => 'Body',
            'img_path' => 'Img',
            'imageFile' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\FilmGenreQuery
     */
    public function getGenre()
    {
        return $this->hasOne(FilmGenre::className(), ['id' => 'genre_id']);
    }

    /**
     * Gets query for [[Seance]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\SeanceQuery
     */
    public function getSeance()
    {
        return $this->hasMany(Seance::className(), ['film_id' => 'id'])->
        orderBy(['seance_date' => SORT_DESC]);;
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\FilmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FilmQuery(get_called_class());
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::getAlias('@webroot') .'/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function getImage(){
        return Yii::getAlias('@web')  .'/uploads/'. $this->img_path;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->imageFile = Yii::getAlias('@webroot')  .'/uploads/' .$this->img_path;
    }
}
