<?php

namespace app\modules\token\controllers;

use yii\web\Controller;

/**
 * Default controller for the `token` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}