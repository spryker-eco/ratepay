<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Ratepay;

use Spryker\Client\Kernel\AbstractFactory;
use SprykerEco\Client\Ratepay\Zed\RatepayStub;

class RatepayFactory extends AbstractFactory
{

    /**
     * @return \SprykerEco\Client\Ratepay\Zed\RatepayStubInterface
     */
    public function createRatepayStub()
    {
        return new RatepayStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient()
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::CLIENT_ZED_REQUEST);
    }

}
