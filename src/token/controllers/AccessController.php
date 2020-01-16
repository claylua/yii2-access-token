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

namespace claylua\token\controllers;

use Yii;
use claylua\token\models\AccessToken;
use claylua\token\models\AccessTokenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;


/**
 * AccessController implements the CRUD actions for AccessToken model.
 */
class AccessController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => true,
            'roles' => ['@'],
          ],

          // ...
        ],
      ],
    ];
  }

  /**
   * Lists all AccessToken models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new AccessTokenSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * generateJWT
   *
   * @param mixed $user_id
   */
  private function generateJWT($user_id) {
    $jwt = $this->module->jwt;
    $signer = $jwt->getSigner('HS256');
    $key = $jwt->getKey();
    $time = time();
    $token = $jwt->getBuilder()
                 ->issuedBy($this->module->issuer)// Configures the issuer (iss claim)
                 ->permittedFor($this->module->audience)// Configures the audience (aud claim)
                 ->identifiedBy($this->module->id, true)// Configures the id (jti claim), replicating as a header item
                 ->issuedAt($time)// Configures the time that the token was issue (iat claim)
               //->expiresAt($time + 3600)// Configures the expiration time of the token (exp claim)
                 ->withClaim('uid', $user_id)// Configures a new claim, called "uid"
                 ->getToken($signer, $key); // Retrieves the generated token
    return (string)$token;
  }

  /**
   * Creates a new AccessToken model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new AccessToken();
    if (Yii::$app->request->post()){
      $model->load(Yii::$app->request->post());
      if(!$model->user_id) {
        $model->user_id =  Yii::$app->user->id;
      }
      $model->token = $this->generateJWT($model->user_id);

      if ($model->save()) {
        return $this->redirect(['index']);
      }
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }


  /**
   * Deletes an existing AccessToken model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the AccessToken model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return AccessToken the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = AccessToken::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }
}
