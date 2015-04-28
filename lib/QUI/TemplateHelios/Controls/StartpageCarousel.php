<?php

/**
 * This file contains QUI\TemplateHelios\Controls\StartpageCarousel
 */

namespace QUI\TemplateHelios\Controls;

use QUI;

/**
 * Class Startpage2Box
 *
 * @package quiqqer/template-helios
 */
class StartpageCarousel extends QUI\Control
{
    /**
     * constructor
     *
     * @param Array $attributes
     */
    public function __construct($attributes = array())
    {
        // default options
        $this->setAttributes(array(
            'class'     => 'carousel',
            'limit'     => 10,
            'sitetypes' => false,
            'nodeName'  => 'section'
        ));

        parent::setAttributes($attributes);

        $this->addCSSFile(
            dirname(__FILE__).'/StartpageCarousel.css'
        );
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Control::create()
     */
    public function getBody()
    {
        $Engine = QUI::getTemplateManager()->getEngine();

        $limit = $this->getAttribute('limit');
        $sitetypes = $this->getAttribute('sitetypes');
        $order = $this->getAttribute('order');

        if (!$limit) {
            $limit = 2;
        }

        if (!$order) {
            $order = 'release_from ASC';
        }


        $children = QUI\Projects\Site\Utils::getSitesByInputList(
            $this->_getProject(),
            $sitetypes,
            array(
                'limit' => $limit,
                'order' => $order
            )
        );

        $Engine->assign(array(
            'children' => $children,
            'this'     => $this
        ));


        return $Engine->fetch(dirname(__FILE__).'/StartpageCarousel.html');
    }
}