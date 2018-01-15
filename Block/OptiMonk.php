<?php
namespace Wse\OptiMonk\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cookie\Helper\Cookie as CookieHelper;
use Wse\OptiMonk\Helper\Data as OptiMonkHelper;

/**
 * OptiMonk - Magento 2 Module
 *
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
 * @author Tibor Berna
 * @since 2016.07.28.
 */
class OptiMonk extends Template
{
    /**
     * @var \Wse\OptiMonk\Helper\Data
     */
    protected $optiMonkHelper = null;

    /**
     * @var \Magento\Cookie\Helper\Cookie
     */
    protected $cookieHelper = null;

    /**
     * @param Context $context
     * @param CookieHelper $cookieHelper
     * @param OptiMonkHelper $optiMonkHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        CookieHelper $cookieHelper,
        OptiMonkHelper $optiMonkHelper,
        array $data = []
    ) {
        $this->cookieHelper = $cookieHelper;
        $this->optiMonkHelper = $optiMonkHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get OM Account Id
     *
     * @return mixed
     */
    public function getAccountId()
    {
        return trim($this->optiMonkHelper->getAccountId());
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (
            $this->cookieHelper->isUserNotAllowSaveCookie()
            || !$this->optiMonkHelper->isEnabled()
        ) {
            return '';
        }

        return parent::_toHtml();
    }
}
