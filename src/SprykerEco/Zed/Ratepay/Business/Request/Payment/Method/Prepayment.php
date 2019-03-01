<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Method;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentPrepaymentTransfer;
use SprykerEco\Shared\Ratepay\RatepayConfig;

/**
 * Ratepay Prepayment payment method.
 */
class Prepayment extends AbstractMethod
{
    /**
     * @return string
     */
    public function getMethodName()
    {
        return RatepayConfig::PREPAYMENT;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentPrepaymentTransfer
     */
    public function getPaymentData(QuoteTransfer $quoteTransfer)
    {
        return $quoteTransfer->requirePayment()
            ->getPayment()
            ->requireRatepayPrepayment()
            ->getRatepayPrepayment();
    }

    /**
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $payment
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentPrepaymentTransfer
     */
    protected function getPaymentTransferObject($payment)
    {
        return new RatepayPaymentPrepaymentTransfer();
    }
}
