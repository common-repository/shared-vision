<?php

namespace SharedVision\Builders;

class DiviBuilder {

  public $modules = [];

  public function setup() {
    if( did_action( 'et_builder_ready' ) ) {
      $this->_register_modules();
    } else {
      add_action( 'et_builder_ready', [ $this, '_register_modules' ] );
    }
  }

  public function _register_modules() {
    $this->modules[] = new DiviBuilder\Embed();
  }

}