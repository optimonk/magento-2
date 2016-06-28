<?php
namespace Wse\OptiMonk\Block;

use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Cart as MagentoCart;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cookie\Helper\Cookie as CookieHelper;
use Magento\Quote\Model\Quote\Item;
use Magento\TestFramework\Event\Magento;
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
    protected $_variables = array();

    /**
     * @var \Wse\OptiMonk\Helper\Data
     */
    protected $_omHelper = null;

    /**
     * @var \Magento\Cookie\Helper\Cookie
     */
    protected $_cookieHelper = null;

    /**
     * @var MagentoCart
     */
    protected $cart;

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
        MagentoCart $cart,
        array $data = []
    ) {
        $this->_cookieHelper= $cookieHelper;
        $this->_omHelper   = $omHelper;
        $this->cart = $cart;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->_cookieHelper->isUserNotAllowSaveCookie() || !$this->_omHelper->isEnabled()) {
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
        foreach ($this->cart->getQuote()->getAllVisibleItems() as $item) {

            $product = $item->getProduct();

            $this->_variables[$item->getSku()] = array(
                "product_id" => $product->getId(),
                "name" => $product->getName(),
                "price" => $item->getPrice(),
                "row_total" => $item->getRowTotal(),
                "quantity" => $item->getQty(),
                "category_ids" => "|" . implode("|", $product->getCategoryIds()) . "|"
            );
        }
        return $this->_variables;
    }

    public function addVariable($name, $value)
    {
        if (!empty($name) && !empty($value)) {
            $this->_variables[$name] = $value;
        }
    }
}
