<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Service\Handler\Transaction;

use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEco\Zed\Ratepay\Business\Api\Constants as ApiConstants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ProfileResponse;
use SprykerEco\Zed\Ratepay\Business\Request\TransactionHandlerAbstract;

class ProfileTransaction extends TransactionHandlerAbstract implements ProfileTransactionInterface
{
    const TRANSACTION_TYPE = ApiConstants::REQUEST_MODEL_PROFILE;

    /**
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    public function request()
    {
        $request = $this->getMethodMapper(RatepayConfig::METHOD_SERVICE)
            ->profile();

        $response = $this->sendRequest((string)$request);

        $profileResponseTransfer = $this->converterFactory
            ->createProfileResponseConverter($response)
            ->convert();

        return $profileResponseTransfer;
    }

    /**
     * @param string $request
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\BaseResponse
     */
    protected function sendRequest($request)
    {
        return new ProfileResponse($this->executionAdapter->sendRequest($request));
    }
}
