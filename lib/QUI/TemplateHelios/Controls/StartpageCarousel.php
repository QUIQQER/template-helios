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

        if (!empty($sitetypes)) {
            $children = $this->_getSitesByList();

        } else {
            $children = $this->_getProject()->getSites(array(
                'limit' => $limit,
                'order' => $order
            ));
        }

        $Engine->assign(array(
            'children' => $children,
            'this'     => $this
        ));


        return $Engine->fetch(dirname(__FILE__).'/StartpageCarousel.html');
    }

    /**
     * Return the sites via the site types option
     *
     * @return array
     */
    protected function _getSitesByList()
    {
        $Project = $this->_getProject();
        $limit = $this->getAttribute('limit');
        $sitetypes = $this->getAttribute('sitetypes');
        $order = $this->getAttribute('order');

        if (!$limit) {
            $limit = 2;
        }

        if (!$order) {
            $order = 'release_from DESC';
        }

        $sitetypes = explode(';', $sitetypes);

        $ids = array();
        $types = array();
        $where = array();

        foreach ($sitetypes as $sitetypeEntry) {
            if (is_numeric($sitetypeEntry)) {
                $ids[] = $sitetypeEntry;
                continue;
            }

            $types[] = $sitetypeEntry;
        }

        if (!empty($ids)) {
            $where['id'] = array(
                'type'  => 'IN',
                'value' => $ids
            );
        }

        if (!empty($types)) {
            $where['type'] = array(
                'type'  => 'IN',
                'value' => $types
            );
        }

        return $Project->getSites(array(
            'where_or' => $where,
            'limit'    => $limit,
            'order'    => $order
        ));
    }
}