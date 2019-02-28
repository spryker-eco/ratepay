<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Method;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentInvoiceTransfer;
use SprykerEco\Shared\Ratepay\RatepayConfig;

class Invoice extends AbstractMethod
{
    /**
     * @return string
     */
    public function getMethodName()
    {
        return RatepayConfig::INVOICE;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentInvoiceTransfer
     */
    public function getPaymentData(QuoteTransfer $quoteTransfer)
    {
        return $quoteTransfer->requirePayment()
            ->getPayment()
            ->requireRatepayInvoice()
            ->getRatepayInvoice();
    }

    /**
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $payment
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentInvoiceTransfer
     */
    protected function getPaymentTransferObject($payment)
    {
        return new RatepayPaymentInvoiceTransfer();
    }
}
