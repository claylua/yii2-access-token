<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\token\models\AccessToken */

$this->title = Yii::t('app', 'Create Access Token');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Access Tokens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-token-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
