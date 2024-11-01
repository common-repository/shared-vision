<?php

namespace SharedVision\Helper;

use SharedVision\API\SharedVision\Plugins as SharedVision_API_Plugins;

class Lists {

  public static function assoc_list( $key = 'hash', $value = 'name', $no_empty_response = false ) :array {
    $lists = static::entries();
    $options = [];

    foreach( $lists as $list )
      $options[ $list[ $key ] ] = $list[ $value ];

    if( empty( $options ) && $no_empty_response ) {
      if( $key === 'hash' )
        return [ '' => __( "Cannot retrieve lists, please ensure API credentials are set", 'sharedvision' ) ];

      return [ __( "Cannot retrieve lists, please ensure API credentials are set", 'sharedvision' ) => '' ];
    }

    return $options;
  }

  public static function entries() :array {
    if( !Health::is_okay() )
      return [];

    $transient = get_transient( 'shared_vision_lists' );

    // Checking for empty will not be a reliable return when comment count is 0
    if( $transient !== false && is_array( $transient ) )
      return $transient;

    try {
      $transient = SharedVision_API_Plugins::lists();
    } catch ( \Exception $e ) {
      return [];
    }

    if( empty( $transient ) )
      return [];

    set_transient( 'shared_vision_lists', $transient, MINUTE_IN_SECONDS );

    return $transient;
  }

}