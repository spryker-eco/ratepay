<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Order;

use Generated\Shared\Transfer\RatepayPaymentElvTransfer;
use SprykerEco\Shared\Ratepay\RatepayConfig;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Order
 * @group ElvSaverTest
 */
class ElvSaverTest extends AbstractSaverTest
{
    /**
     * @const Payment method code.
     */
    public const PAYMENT_METHOD = RatepayConfig::ELV;

    /**
     * @return \Generated\Shared\Transfer\RatepayPaymentElvTransfer
     */
    protected function getRatepayPaymentMethodTransfer()
    {
        return (new RatepayPaymentElvTransfer())
            ->setBankAccountBic('XXXXXXXXXXX')
            ->setBankAccountIban('XXXX XXXX XXXX XXXX XXXX XX')
            ->setBankAccountHolder('TestHolder');
    }

    /**
     * @return \Generated\Shared\Transfer\RatepayPaymentElvTransfer
     */
    protected function getPaymentTransferFromQuote()
    {
        return $this->quoteTransfer->getPayment()->getRatepayElv();
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentTransfer $payment
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $paymentTransfer
     *
     * @return void
     */
    protected function setRatepayPaymentDataToPaymentTransfer($payment, $paymentTransfer)
    {
        $payment->setRatepayElv($paymentTransfer);
    }

    /**
     * @return void
     */
    public function testSaveOrderPaymentData()
    {
        parent::testSaveOrderPaymentData();

        $paymentMethodTransfer = $this->getPaymentTransferFromQuote();
        $this->assertEquals($paymentMethodTransfer->getBankAccountBic(), $this->paymentEntity->getBankAccountBic());
        $this->assertEquals($paymentMethodTransfer->getBankAccountIban(), $this->paymentEntity->getBankAccountIban());
    }
}
