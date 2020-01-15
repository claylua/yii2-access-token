<?php

namespace claylua\token\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use claylua\token\models\AccessToken;

/**
 * AccessTokenSearch represents the model behind the search form of `common\modules\token\models\AccessToken`.
 */
class AccessTokenSearch extends AccessToken
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['user_id', 'token', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
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
        $query = AccessToken::find();

        $query->joinWith(['user']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

				// Important: here is how we set up the sorting
				// The key is the attribute name on our "AccessTokenSearch" instance
				$dataProvider->sort->attributes['email'] = [
					// The tables are the ones our relation are configured to
					// in my case they are prefixed with "tbl_"
					'asc' => ['user.email' => SORT_ASC],
					'desc' => ['user.email' => SORT_DESC],
				];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
          'access_token.id' => $this->id,
          'status' => $this->status,
        ])
              ->andFilterWhere([
                '>=',
                'access_token.created_at',
                strtotime($this->created_at)
              ])
              ->andFilterWhere([
                '>=',
                'access_token.updated_at',
                strtotime($this->updated_at)
              ])
              ->andFilterWhere(['like', 'user.email', $this->user_id]);


        $query->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
