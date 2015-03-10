<?php

/**
 * Emotion
 */

\QUI\Utils\Site::setRecursivAttribute( $Site, 'image_emotion' );


/**
 * Helios body class
 */

$bodyClass = '';

switch ( $Template->getLayoutType() )
{
    case 'layout/startpage':
        $bodyClass = 'homepage';
    break;

    case 'layout/leftSidebar':
        $bodyClass = 'left-sidebar';
    break;

    case 'layout/rightSidebar':
        $bodyClass = 'right-sidebar';
    break;

    default:
        $bodyClass = 'no-sidebar';
}

$Engine->assign( 'bodyClass', $bodyClass );