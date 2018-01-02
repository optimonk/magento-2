<?php

namespace Wse\OptiMonk\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

/**
 * Class Index
 * @package Wse\OptiMonk\Controller\Cart
 */
class Index extends Action
{
    /**
     * @return Raw
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        /** @var string $block */
        $block = $resultPage->getLayout()
            ->createBlock('Wse\OptiMonk\Block\Cart')
            ->setTemplate("Wse_OptiMonk::cart.phtml")
            ->toHtml();

        /** @var Raw $response */
        $response = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $response->setContents($block);
        $response->setHeader("Content-Type", "application/javascript");

        return $response;
    }
}