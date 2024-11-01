<?php

namespace SharedVision\Helper;

use SharedVision\API\SharedVision\Plugins as SharedVision_API_Plugins;
use SharedVision\Settings as SharedVision_Settings;

class Health {

  public static function is_okay() {
    if( empty( SharedVision_Settings::instance()->get( 'bearer_token' ) ) )
      return false;

    $transient = get_transient( 'shared_vision_is_valid_bearer_token' );

    // Checking for empty will not be a reliable return when comment count is 0
    if( $transient !== false )
      return $transient;

    try {
      $health_status = SharedVision_API_Plugins::health();

      $transient = ( isset( $health_status[ 'success' ] ) && !empty( $health_status[ 'success' ] ) );

      set_transient( 'shared_vision_is_valid_bearer_token', $transient, DAY_IN_SECONDS );
    } catch ( \Exception $e ) {
      $transient = false;

      // Throttle to max 1 request every minute in case it's invalid, to avoid pinging the server too much.
      set_transient( 'shared_vision_is_valid_bearer_token', $transient, MINUTE_IN_SECONDS );
    }

    return $transient;
  }

}