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
