<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Plugin;

use Generated\Shared\Transfer\CartChangeTransfer;
use Spryker\Zed\Cart\Dependency\ItemExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerEco\Zed\Ratepay\Business\RatepayFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Ratepay\Communication\RatepayCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 * @method \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface getQueryContainer()
 */
class RatepayPlugin extends AbstractPlugin implements ItemExpanderPluginInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer)
    {
        return $this->getFacade()->expandItems($cartChangeTransfer);
    }
}
