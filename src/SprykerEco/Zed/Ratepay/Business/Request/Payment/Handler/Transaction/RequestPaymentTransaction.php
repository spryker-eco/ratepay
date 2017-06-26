<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction;

use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use SprykerEco\Zed\Ratepay\Business\Api\Constants as ApiConstants;

class RequestPaymentTransaction extends BaseTransaction
{

    const TRANSACTION_TYPE = ApiConstants::REQUEST_MODEL_PAYMENT_REQUEST;

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    public function request(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer)
    {
        $paymentMethodName = $ratepayPaymentRequestTransfer
            ->getRatepayPaymentInit()
            ->getPaymentMethodName();

        $request = $this->getMethodMapper($paymentMethodName)
            ->paymentRequest($ratepayPaymentRequestTransfer);
        $response = $this->sendRequest((string)$request);
        $this->logInfo($request, $response, $paymentMethodName, $ratepayPaymentRequestTransfer->getOrderId());

        $responseTransfer = $this->converterFactory
            ->getTransferObjectConverter($response)
            ->convert();
        $this->fixResponseTransferTransactionId($responseTransfer, $responseTransfer->getTransactionId(), $responseTransfer->getTransactionShortId());

        return $responseTransfer;
    }

}
