<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Persistence;

use Orm\Zed\Ratepay\Persistence\SpyPaymentRatepayLogQuery;
use Orm\Zed\Ratepay\Persistence\SpyPaymentRatepayQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 * @method \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainer getQueryContainer()
 */
class RatepayPersistenceFactory extends AbstractPersistenceFactory
{

    /**
     * @return \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepayQuery
     */
    public function createPaymentRatepayQuery()
    {
        return SpyPaymentRatepayQuery::create();
    }

    /**
     * @return \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepayLogQuery
     */
    public function createPaymentRatepayLogQuery()
    {
        return SpyPaymentRatepayLogQuery::create();
    }

}
