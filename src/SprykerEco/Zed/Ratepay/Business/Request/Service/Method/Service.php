<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Service\Method;

use SprykerEco\Shared\Ratepay\RatepayConstants;
use SprykerEco\Zed\Ratepay\Business\Api\Constants as ApiConstants;

/**
 * Service.
 */
class Service extends AbstractMethod implements MethodInterface
{

    /**
     * @const Payment method code.
     */
    const METHOD = RatepayConstants::METHOD_SERVICE;

    /**
     * @return string
     */
    public function getMethodName()
    {
        return static::METHOD;
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
