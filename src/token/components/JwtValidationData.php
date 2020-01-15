<?php

namespace claylua\token\components;

class JwtValidationData extends \sizeg\jwt\JwtValidationData
{

  /**
   * @inheritdoc
   */
  public function init()
  {
    $this->validationData->setIssuer($this->module->issuer);
    $this->validationData->setAudience($this->module->audience);
    $this->validationData->setId($this->module->id);

    parent::init();
  }
}    
