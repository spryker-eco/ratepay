<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Service\Method;

use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEco\Zed\Ratepay\Business\Api\Constants as ApiConstants;

/**
 * Service.
 */
class ServiceMethod extends AbstractMethod implements MethodInterface
{
    /**
     * @return string
     */
    public function getMethodName()
    {
        return RatepayConfig::METHOD_SERVICE;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Init
     */
    public function profile()
    {
        $request = $this->modelFactory->build(ApiConstants::REQUEST_MODEL_PROFILE);
        $this->mapHeadData();

        return $request;
    }
}
