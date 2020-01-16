<?php

/*
 * Copyright (c) 2020, Clay Lua <czeeyong@gmail.com>
 * Author: Clay Lua <czeeyong@gmail.com>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the <organization> nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

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
