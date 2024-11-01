( function( sharedvision_data, blocks, i18n, element, components ) {
  let el = element.createElement,
    __ = i18n.__;

  blocks.registerBlockType( 'sharedvision/embed', {
    title: __( 'Shared Vision : Embed', 'sharedvision' ),
    icon: 'embed-generic',
    example: {},
    attributes: {
      list_hash: {
        type    : 'string',
        default : ""
      },
    },
    edit: function( props ) {
      if( typeof sharedvision_data.lists === "undefined" || sharedvision_data.lists.length === 0 ) {
        return el(
          'p',
          {
            style: {
              backgroundColor: 'rgb(254, 96, 84)',
              color: '#fff',
              padding: '20px',
              textAlign : 'center',
              borderRadius : '5px'
            }
          },
          __( "Shared Vision, cannot retrieve lists, please ensure API credentials are set.", 'sharedvision' )
        );
      }

      let options = [];

      sharedvision_data.lists.forEach(element => {
        options.push( { value: element.hash, label: element.name } );
      });

      return el(
        components.SelectControl,
        {
          label: __( 'Shared Vision : Embed', 'sharedvision' ),
          value: props.attributes.list_hash,
          options: options,
          onChange: function( value ) {
            props.setAttributes( { list_hash: value } );
          }
        }
      );
    },
    save: function() {
      return null;
    },
  } );
} )( window.sharedvision_data, window.wp.blocks, window.wp.i18n, window.wp.element, window.wp.components );

// sharedvision_data.lists