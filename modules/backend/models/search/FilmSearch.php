<?php

namespace app\modules\backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Film;

/**
 * FilmSearch represents the model behind the search form of `app\models\Film`.
 */
class FilmSearch extends Film
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'genre_id', 'status', 'created_at', 'updated_at','popularity_rating'], 'integer'],
            [['slug', 'title', 'body', 'img_path'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Film::find()->active();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'genre_id' => $this->genre_id,
            'status' => $this->status,
            'popularity_rating' => $this->popularity_rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->img_path])
            ->andFilterWhere(['like', 'body', $this->body]);


        return $dataProvider;
    }
}
