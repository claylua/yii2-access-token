<?php

namespace claylua\token;

/**
 * token module definition class
 */
class Module extends \yii\base\Module
{
	/**
	 * {@inheritdoc}
	 */
	public $controllerNamespace = 'common\modules\token\controllers';

	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		parent::init();
		\Yii::configure($this, require __DIR__ . '/config/main.php');

		// custom initialization code goes here
	}
}
