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

$footerColorBackground = '#2b252c';
$footerColorFont       = '#ffffff';
$footerColorLink       = '#ffffff';
$headerColorFont       = '#ffffff';
$controlColor          = '#ef8376';

if ($Project->getConfig('templateHelios.settings.controlColor')) {
    $controlColor = $Project->getConfig('templateHelios.settings.controlColor');
}

if ($Project->getConfig('templateHelios.settings.footerColorBackground')) {
    $footerColorBackground = $Project->getConfig('templateHelios.settings.footerColorBackground');
}

if ($Project->getConfig('templateHelios.settings.footerColorFont')) {
    $footerColorFont = $Project->getConfig('templateHelios.settings.footerColorFont');
}

if ($Project->getConfig('templateHelios.settings.footerColorLink')) {
    $footerColorLink = $Project->getConfig('templateHelios.settings.footerColorLink');
}

if ($Project->getConfig('templateHelios.settings.headerColorFont')) {
    $headerColorFont = $Project->getConfig('templateHelios.settings.headerColorFont');
}

$Engine->assign(array(
    'controlColor'          => $controlColor,
    'footerColorBackground' => $footerColorBackground,
    'footerColorFont'       => $footerColorFont,
    'footerColorLink'       => $footerColorLink,
    'headerColorFont'       => $headerColorFont,
    'Background'            => $Background
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
    'headerFile'      => dirname(__FILE__) . '/header.html',
    'BricksManager'   => \QUI\Bricks\Manager::init()
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

$Engine->assign(
    'typeClass',
    'type-' . str_replace(array('/', ':'), '-', $Site->getAttribute('type'))
);