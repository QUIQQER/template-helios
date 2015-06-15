<?php

/**
 * Emotion
 */

QUI\Utils\Site::setRecursivAttribute($Site, 'image_emotion');

/**
 * Background
 */

$Background = false;

if ($Project->getConfig('templateHelios.settings.pageBackground')) {
    try {
        $Background = QUI\Projects\Media\Utils::getImageByUrl(
            $Project->getConfig('templateHelios.settings.pageBackground')
        );

    } catch (QUI\Exception $Exception) {
        \QUI\System\Log::writeRecursive($Exception->getMessage());
    }
}

/**
 * colors
 */

$footerColor = '#2b252c';
$controlColor = '#ef8376';

if ($Project->getConfig('templateHelios.settings.controlColor')) {
    $controlColor = $Project->getConfig('templateHelios.settings.controlColor');
}

if ($Project->getConfig('templateHelios.settings.footerColor')) {
    $footerColor = $Project->getConfig('templateHelios.settings.footerColor');
}

$Engine->assign(array(
    'controlColor' => $controlColor,
    'footerColor'  => $footerColor,
    'Background'   => $Background
));

/**
 * Header
 */

$headerText = $Project->firstChild()->getAttribute('title');
$headerLogo = false;

$confLogoSetting = $Project->getConfig('templateHelios.settings.headerLogo');

if ($Project->getConfig('templateHelios.settings.headerText')) {
    $headerText = $Project->getConfig('templateHelios.settings.headerText');
}

if ($confLogoSetting
    && QUI\Projects\Media\Utils::isMediaUrl($confLogoSetting)
) {
    $headerLogo = $confLogoSetting;
}

$Engine->assign(array(
    'headerText'      => $headerText,
    'headerLogo'      => $headerLogo,
    'headerMenuPos'   => $Project->getConfig('templateHelios.settings.pageMenuPos'),
    'pageHeaderImage' => $Project->getConfig('templateHelios.settings.pageHeaderImage'),
    'headerFile'      => dirname(__FILE__).'/header.html'
));

/**
 * Helios body class
 */

$bodyClass = '';

switch ($Template->getLayoutType()) {
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

$Engine->assign('bodyClass', $bodyClass);