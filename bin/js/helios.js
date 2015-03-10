
document.addEvent('domready', function()
{
    "use strict";

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

require(['qui/QUI', 'helios-init' ], function()
{
    "use strict";

    var Header = document.getElement( '#header'),
        Next   = Header.getNext();

    if ( !Next.get( 'id' ) ) {
        Next.set( 'id', String.uniqueID () );
    }

    Header.getElement( '.scrolly' ).addEvent('click', function(event)
    {
        event.stop();
        new Fx.Scroll( window).toElement( Next );
    });
});