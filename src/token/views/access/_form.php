<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\token\models\AccessToken */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-token-form">

    <?php $form = ActiveForm::begin(); ?>


<?php 
echo $form->field($model, 'status')->dropDownList([
	'' => 'Select an option',
	'0' => 'Inactive', 
	'1' => 'Active', 
],[]);
?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
