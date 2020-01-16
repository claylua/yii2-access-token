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

use Yii;

/**
 * This is the model class for table "access_token".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $status
 * @property string $token
 * @property string $updated_at
 * @property string $created_at
 *
 * @property User $user
 */
use common\models\User as User;
use yii\behaviors\TimestampBehavior;

class AccessToken extends \yii\db\ActiveRecord
{
  /**
   * behaviors
   *
   */
  public function behaviors()
  {
    return [
      TimestampBehavior::className(),
    ];
  }


  /**
   * find
   *
   */
  public static function find()
  {
    if(!Yii::$app->user->identity->isAdmin) {
      return parent::find()->where(['user_id' => Yii::$app->user->id]);
    } 
    return parent::find();
  }

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'access_token';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      // [['user_id', 'token'], 'required'],
      // [['user_id', 'status'], 'integer'],
      // [['updated_at', 'created_at'], 'safe'],
      [['created_at', 'updated_at'], 'date', 'format'=>'dd-MM-yyyy', 'message'=>'{attribute} must be DD/MM/YYYY format.'             ],
      [['token'], 'string', 'max' => 255],
      [['token'], 'unique'],
      [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('app', 'ID'),
      'user_id' => Yii::t('app', 'User ID'),
      'status' => Yii::t('app', 'Status'),
      'token' => Yii::t('app', 'Token'),
      'updated_at' => Yii::t('app', 'Updated At'),
      'created_at' => Yii::t('app', 'Created At'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getUser()
  {
    return $this->hasOne(User::className(), ['id' => 'user_id']);
  }
}
