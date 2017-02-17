<?php
namespace Wse\OptiMonk\Helper;

use Magento\Store\Model\Store;

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
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Config
     */
    const XML_PATH_ACTIVE = 'wse_optimonk/optimonk/active';
    const XML_PATH_ACCOUNT = 'wse_optimonk/optimonk/account';

    /**
     * @return bool
     */
    public function isEnabled()
    {
        $accountId = $this->scopeConfig->getValue(
            self::XML_PATH_ACCOUNT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return $accountId && $this->scopeConfig->isSetFlag(
            self::XML_PATH_ACTIVE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     *
     * @return bool | null | string
     */
    public function getAccountId()
    {
        return trim($this->scopeConfig->getValue(self::XML_PATH_ACCOUNT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
}
