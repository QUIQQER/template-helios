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
     * @param array $attributes
     */
    public function __construct($attributes = array())
    {
        // default options
        $this->setAttributes(array(
            'class' => 'carousel',
            'limit' => 10,
            'sitetypes' => false,
            'nodeName' => 'section'
        ));

        parent::__construct($attributes);

        $this->addCSSFile(
            dirname(__FILE__) . '/StartpageCarousel.css'
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

        $limit     = $this->getAttribute('limit');
        $sitetypes = $this->getAttribute('sitetypes');

        if (!$limit) {
            $limit = 2;
        }

        // order
        switch ($this->getAttribute('order')) {
            case 'name ASC':
            case 'name DESC':
            case 'title ASC':
            case 'title DESC':
            case 'c_date ASC':
            case 'c_date DESC':
            case 'd_date ASC':
            case 'd_date DESC':
            case 'release_from ASC':
            case 'release_from DESC':
                $order = $this->getAttribute('order');
                break;

            default:
                $order = 'release_from DESC';
                break;
        }


        $children = QUI\Projects\Site\Utils::getSitesByInputList(
            $this->getProject(),
            $sitetypes,
            array(
                'limit' => $limit,
                'order' => $order
            )
        );

        $Engine->assign(array(
            'children' => $children,
            'this' => $this
        ));


        return $Engine->fetch(dirname(__FILE__) . '/StartpageCarousel.html');
    }
}
