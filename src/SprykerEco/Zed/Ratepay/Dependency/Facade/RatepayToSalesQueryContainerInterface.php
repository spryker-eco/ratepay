<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Dependency\Facade;

interface RatepayToSalesQueryContainerInterface
{
    /**
     * @return \Spryker\Zed\Sales\Persistence\SalesQueryContainer
     */
    public function getSalesQueryContainer();
}
