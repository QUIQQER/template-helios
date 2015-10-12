
document.addEvent('domready', function()
{
    "use strict";

    new Element('div', {
        id : '___body_loader',
        styles : {
            background : '#f0f4f4',
            height : '100%',
            left : 0,
            opacity: 1,
            position : 'fixed',
            top : 0,
            width : '100%',
            zIndex: 100
        }
    }).inject( document.body );

    window.addEvent('load', function() {
        window._loaded = true;
    });
});

require.config({

    paths: {
        'helios-init' : URL_TEMPLATE_DIR +'bin/js/init',
        'skel'        : URL_TEMPLATE_DIR +'bin/js/skel.min',
        'skel-layers' : URL_TEMPLATE_DIR +'bin/js/skel-layers.min',

        'jquery'           : URL_TEMPLATE_DIR +'bin/js/jquery.min',
        'jquery.dropotron' : URL_TEMPLATE_DIR +'bin/js/jquery.dropotron.min',
        'jquery.scrolly'   : URL_TEMPLATE_DIR +'bin/js/jquery.scrolly.min',
        'jquery.onvisible' : URL_TEMPLATE_DIR +'bin/js/jquery.onvisible.min'
    },

    shim: {
        'skel' : {
            deps: [
                'jquery.dropotron',
                'jquery.scrolly',
                'jquery.onvisible'
            ]
        },

        'skel-layers' : {
            deps: ['skel']
        },

        'helios-init' : {
            deps: ['skel-layers']
        }
    }
});


require(['qui/QUI', 'helios-init' ], function(QUI)
{
    "use strict";

    var Header = document.getElement( '#header'),
        Next   = Header.getNext();

    if ( !Next.get( 'id' ) ) {
        Next.set( 'id', String.uniqueID () );
    }

    Header.getElements( '.scrolly' ).addEvent('click', function(event)
    {
        event.stop();
        new Fx.Scroll( window ).toElement( Next );
    });

    //
    //QUI.setAttribute( 'control-loader-type', 'ball-clip-rotate' );
    ////QUI.setAttribute( 'control-loader-color', 'red' );
    //
    //require(['qui/controls/loader/Loader'], function(QUILoader)
    //{
    //    var Load = new QUILoader({
    //        styles : {
    //            zIndex    : 1000,
    //            position  : 'fixed'
    //        }
    //    }).inject( document.body );
    //
    //    Load.show();
    //
    //    (function() {
    //        Load.hide();
    //    }).delay( 4000 );
    //});

});