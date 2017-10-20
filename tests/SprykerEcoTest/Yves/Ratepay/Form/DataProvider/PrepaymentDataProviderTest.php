<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Yves\Ratepay\Form\DataProvider;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\RatepayPaymentPrepaymentTransfer;
use SprykerEco\Yves\Ratepay\Form\DataProvider\PrepaymentDataProvider;

/**
 * @group Unit
 * @group Spryker
 * @group Yves
 * @group Ratepay
 * @group Form
 * @group DataProvider
 * @group PrepaymentDataProviderTest
 */
class PrepaymentDataProviderTest extends AbstractDataProviderTest
{

    /**
     * @return void
     */
    public function testGetDataShouldAddTransferIfNotSet()
    {
        $prepaymentDataProvider = $this->getInvoiceDataProvider();
        $quoteTransfer = $this->getQuoteTransfer();

        $prepaymentDataProvider->getData($quoteTransfer);

        $paymentTransfer = $quoteTransfer->getPayment();
        $this->assertInstanceOf(PaymentTransfer::class, $paymentTransfer);
        $this->assertInstanceOf(RatepayPaymentPrepaymentTransfer::class, $paymentTransfer->getRatepayPrepayment());
    }

    /**
     * @return void
     */
    public function testGetDataShouldAddPhoneNumber()
    {
        $prepaymentDataProvider = $this->getInvoiceDataProvider();

        $quoteTransfer = $this->getQuoteTransfer();

        $prepaymentDataProvider->getData($quoteTransfer);

        $paymentTransfer = $quoteTransfer->getPayment();
        $this->assertInstanceOf(PaymentTransfer::class, $paymentTransfer);

        $paymentMethodTransfer = $paymentTransfer->getRatepayPrepayment();
        $this->assertInstanceOf(RatepayPaymentPrepaymentTransfer::class, $paymentMethodTransfer);
        $this->assertSame(static::PHONE_NUMBER, $paymentMethodTransfer->getPhone());
    }

    /**
     * @return \SprykerEco\Yves\Ratepay\Form\DataProvider\InstallmentDataProvider
     */
    protected function getInvoiceDataProvider()
    {
        $prepaymentDataProvider = new PrepaymentDataProvider();

        return $prepaymentDataProvider;
    }

}
