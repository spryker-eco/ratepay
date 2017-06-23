<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
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
