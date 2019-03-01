<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Method;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentElvTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use SprykerEco\Shared\Ratepay\RatepayConfig;

/**
 * Ratepay Elv payment method.
 */
class Elv extends AbstractMethod
{
    /**
     * @return string
     */
    public function getMethodName()
    {
        return RatepayConfig::ELV;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentElvTransfer
     */
    public function getPaymentData(QuoteTransfer $quoteTransfer)
    {
        return $quoteTransfer
            ->requirePayment()
            ->getPayment()
            ->requireRatepayElv()
            ->getRatepayElv();
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return void
     */
    protected function mapPaymentData(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer)
    {
        parent::mapPaymentData($ratepayPaymentRequestTransfer);
        $this->mapBankAccountData($ratepayPaymentRequestTransfer);
    }

    /**
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $payment
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentElvTransfer
     */
    protected function getPaymentTransferObject($payment)
    {
        return new RatepayPaymentElvTransfer();
    }
}
