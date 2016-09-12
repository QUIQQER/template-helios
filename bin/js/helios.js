document.addEvent('domready', function () {
    "use strict";

    new Element('div', {
        id    : '___body_loader',
        styles: {
            background: '#f0f4f4',
            height    : '100%',
            left      : 0,
            opacity   : 1,
            position  : 'fixed',
            top       : 0,
            width     : '100%',
            zIndex    : 100
        }
    }).inject(document.body);

    window.addEvent('load', function () {
        window._loaded = true;
    });
});

require.config({

    paths: {
        'helios-init': URL_TEMPLATE_DIR + 'bin/js/init',
        'skel'       : URL_TEMPLATE_DIR + 'bin/js/skel.min',
        'skel-layers': URL_TEMPLATE_DIR + 'bin/js/skel-layers.min',

        'jquery'          : URL_TEMPLATE_DIR + 'bin/js/jquery.min',
        'jquery.dropotron': URL_TEMPLATE_DIR + 'bin/js/jquery.dropotron.min',
        'jquery.scrolly'  : URL_TEMPLATE_DIR + 'bin/js/jquery.scrolly.min',
        'jquery.onvisible': URL_TEMPLATE_DIR + 'bin/js/jquery.onvisible.min'
    },

    shim: {
        'skel': {
            deps: [
                'jquery.dropotron',
                'jquery.scrolly',
                'jquery.onvisible'
            ]
        },

        'skel-layers': {
            deps: ['skel']
        },

        'helios-init': {
            deps: ['skel-layers']
        }
    }
});


require([
    'qui/QUI',
    'Locale',
    'helios-init'
].append(QUIQQER_LOCALE), function (QUI, QUILocale) {
    "use strict";

    QUILocale.setCurrent(QUIQQER_PROJECT.lang);

    var Header = document.getElement('#header'),
        Next   = Header.getNext();

    if (!Next.get('id')) {
        Next.set('id', String.uniqueID());
    }

    Header.getElements('.scrolly').addEvent('click', function (event) {
        event.stop();
        new Fx.Scroll(window).toElement(Next);
    });


    // scroll fix
    var Nav = document.id('nav');

    var scrollOffset       = Nav.getSize().y;
    var scrollOffsetHelper = function (Event) {

        var href = '';

        if (typeOf(Event) === 'string') {
            href = Event;
        } else {
            Event.stop();
            href = Event.target.get('href');
        }

        href = href.replace('#', '');

        var Anchor = document.getElement('[name="' + href + '"]');

        if (!Anchor) {
            Anchor = document.id(href);
        }

        if (!Anchor) {
            return;
        }

        var scrollTo = Anchor.getPosition().y - scrollOffset;

        new Fx.Scroll(window).start(0, scrollTo);

        if (history && "pushState" in history) {
            history.pushState(
                {},
                document.title,
                window.location.pathname + '#' + href
            );
            return false;
        }
    };


    if (window.location.hash) {
        scrollOffsetHelper(window.location.hash);
    }

    window.addEvent('load', function () {
        document.getElements('a[href^=\'#\']').each(function (Link) {
            Link.addEvent('click', scrollOffsetHelper);
        });
    });

    if ("onhashchange" in window) {
        window.addEventListener("hashchange", function () {
            (function () {
                scrollOffsetHelper(window.location.hash);
            }).delay(100);
        });
    }
});
