<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use claylua\token\assets\AdminAsset;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\token\models\AccessTokenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Access Tokens');
$this->params['breadcrumbs'][] = $this->title;
AdminAsset::register($this);
?>

<div class="access-token-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Generate Access Token'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
						['attribute' => 'user_id',
						'label'=>'Email',
						'enableSorting'=> true,
						'value' => function( $data ) {
							return $data->user->email;  
							// here user is your relation name in base model.
						},
					],
						['attribute' => 'status',
						'label'=>'Status',
						'enableSorting'=> true,
						'value' => function( $data ) {
							return $data->status?'Active':'Inactive';  
							// here user is your relation name in base model.
						},
					],
          [
            'attribute' => 'token',
            'contentOptions' => ['class' => 'truncate'],
          ],
            // 'updated_at:datetime',
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
