<?php

namespace claylua\token\controllers;

use Yii;
use claylua\token\models\AccessToken;
use claylua\token\models\AccessTokenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AdminController implements the CRUD actions for AccessToken model.
 */
class AdminController extends Controller
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
     * Displays a single AccessToken model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    private function generateJWT($uid) 
		{
			$jwt = Yii::$app->jwt;
			$signer = $jwt->getSigner('HS256');
			$key = $jwt->getKey();
			$time = time();
			$token = $jwt->getBuilder()
								->issuedBy($this->module->issuer)// Configures the issuer (iss claim)
								->permittedFor($this->module->audience)// Configures the audience (aud claim)
								->identifiedBy($this->module->id, true)// Configures the id (jti claim), replicating as a header item
								->issuedAt($time)// Configures the time that the token was issue (iat claim)
								// ->expiresAt($time + 3600)// Configures the expiration time of the token (exp claim)
								->withClaim('uid', $uid)// Configures a new claim, called "uid"
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
			$model->load(Yii::$app->request->post());
			$model->token = $this0>generateJWT($model->user_id);
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}

			return $this->render('create', [
				'model' => $model,
			]);
		}

    /**
     * Updates an existing AccessToken model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
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
