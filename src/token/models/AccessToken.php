<?php

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
  public function behaviors()
  {
    return [
      TimestampBehavior::className(),
    ];
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
