<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use claylua\token\assets\AdminAsset;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\token\models\AccessTokenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = Yii::t('app', 'Access Tokens');
$this->params['breadcrumbs'][] = $this->title;
AdminAsset::register($this);
?>

<div class="access-token-index">


    <p>
        <?= Html::a(Yii::t('app', 'Generate Access Token'), ['create'], ['class' => 'btn btn-success', 'data-method'=>'post']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'summary' => '',
  'columns' => [
    [
      'attribute' => 'token',
      'contentOptions' => ['class' => 'truncate'],
    ],
    // 'updated_at:datetime',
    'created_at:datetime',

    [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{delete}',
      'buttons' => [
        'delete' => function ($url, $model) {
          return Html::a('revoke', $url, [
            'title' => Yii::t('app', 'revoke'),
            'class' => 'btn btn-xs btn-danger btn-block',
            'data-method'=>'post',
            'data-confirm'=>'Are you sure you want to revoke this token?',
            'data-pjax'=>1
          ]);
        }

],
  'visibleButtons' =>
  [
    'update' => false,
    'view' => false,
    'delete' => true
  ]
],
        ],
      ]); ?>

    <?php Pjax::end(); ?>

</div>
