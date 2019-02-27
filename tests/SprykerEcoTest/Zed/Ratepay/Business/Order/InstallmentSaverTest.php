<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Order;

use Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer;
use SprykerEco\Shared\Ratepay\RatepayConfig;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Order
 * @group InstallmentSaverTest
 */
class InstallmentSaverTest extends AbstractSaverTest
{
    /**
     * @const Payment method code.
     */
    public const PAYMENT_METHOD = RatepayConfig::INSTALLMENT;

    /**
     * @return \Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer
     */
    protected function getRatepayPaymentMethodTransfer()
    {
        return new RatepayPaymentInstallmentTransfer();
    }

    /**
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    protected function getPaymentTransferFromQuote()
    {
        return $this->quoteTransfer->getPayment()->getRatepayInstallment();
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentTransfer $payment
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $paymentTransfer
     *
     * @return void
     */
    protected function setRatepayPaymentDataToPaymentTransfer($payment, $paymentTransfer)
    {
        $payment->setRatepayInstallment($paymentTransfer);
    }
}
