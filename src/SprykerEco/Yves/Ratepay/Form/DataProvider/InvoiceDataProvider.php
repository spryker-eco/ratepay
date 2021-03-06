<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay\Form\DataProvider;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\RatepayPaymentInvoiceTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class InvoiceDataProvider extends DataProviderAbstract
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getPayment() === null) {
            $paymentTransfer = new PaymentTransfer();
            $paymentMethodTransfer = new RatepayPaymentInvoiceTransfer();
            $paymentMethodTransfer->setPhone($this->getPhoneNumber($quoteTransfer));
            $paymentTransfer->setRatepayInvoice($paymentMethodTransfer);

            $quoteTransfer->setPayment($paymentTransfer);
        }

        return $quoteTransfer;
    }
}
