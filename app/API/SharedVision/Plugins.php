<?php

namespace SharedVision\API\SharedVision;

use SharedVision\API\SharedVision\Request as SharedVision_API_Request;

class Plugins {

  /**
   * @throws \Exception
   */
  public static function health() :array {
    return SharedVision_API_Request::get_json( 'plugins/v1/health' );
  }

  /**
   * @throws \Exception
   */
  public static function lists() :?array {
    $response = SharedVision_API_Request::get_json( 'plugins/v1/lists' );

    return ( isset( $response[ 'lists' ] ) && !empty( $response[ 'lists' ] ) ? $response[ 'lists' ] : null );
  }

}