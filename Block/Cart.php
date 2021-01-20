<?php

namespace Wse\OptiMonk\Block;

use Magento\Checkout\Model\Session as Session;
use Magento\Cookie\Helper\Cookie as CookieHelper;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Quote\Model\Quote\Item;
use Wse\OptiMonk\Helper\Data as OptiMonkHelper;

/**
 * Copyright (C) 2016 OptiMonk
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For a copy of the GNU General Public License, see <http://www.gnu.org/licenses/>.
 *
 * @author     Tibor Berna
 * @since 2016.03.31. 13:33
 */
class Cart extends Template
{
    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @var \Wse\OptiMonk\Helper\Data
     */
    protected $omHelper = null;

    /**
     * @var \Magento\Cookie\Helper\Cookie
     */
    protected $cookieHelper = null;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Context $context
     * @param CookieHelper $cookieHelper
     * @param OptiMonkHelper $omHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        OptiMonkHelper $omHelper,
        CookieHelper $cookieHelper,
        Session $session,
        array $data = []
    )
    {
        $this->cookieHelper = $cookieHelper;
        $this->omHelper = $omHelper;
        $this->session = $session;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->cookieHelper->isUserNotAllowSaveCookie() || !$this->omHelper->isEnabled()) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Return Cart Variables
     *
     * @return array
     */
    public function getProducts()
    {
        /** @var Item $item */
        foreach ($this->session->getQuote()->getAllVisibleItems() as $item) {
            $product = $item->getProduct();

            $this->variables[$item->getSku()] = [
                "product_id" => $product->getId(),
                "name" => $product->getName(),
                "price" => $item->getPrice(),
                "row_total" => $item->getRowTotal(),
                "quantity" => $item->getQty(),
                "category_ids" => "|" . implode("|", $product->getCategoryIds()) . "|"
            ];
        }
        return $this->variables;
    }

    /**
     * @param $name
     * @param $value
     */
    public function addVariable($name, $value)
    {
        if (!empty($name) && !empty($value)) {
            $this->variables[$name] = $value;
        }
    }
}
