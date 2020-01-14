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

	public $controllerNamespace = 'claylua\token\controllers';
  public $issuer = "http://example.com";
  public $audience = "http://example.org";
  public $id="4f1g23a12aa";


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
