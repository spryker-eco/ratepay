<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Plugin;

use Spryker\Zed\Installer\Dependency\Plugin\InstallerPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerEco\Zed\Ratepay\Communication\RatepayCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Ratepay\Business\RatepayFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 * @method \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface getQueryContainer()
 */
class RatepayInstallerPlugin extends AbstractPlugin implements InstallerPluginInterface
{
    /**
     * @api
     *
     * @return void
     */
    public function install()
    {
        $this->getFacade()->install();
    }
}
