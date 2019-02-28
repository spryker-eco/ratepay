<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Api\Mapper;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Api
 * @group Mapper
 * @group InstallmentPaymentMapperTest
 */
class InstallmentPaymentMapperTest extends AbstractMapperTest
{
    /**
     * @return void
     */
    public function testMapper()
    {
        $installment = $this->mockRatepayPaymentInstallmentTransfer();
        $quote = $this->mockQuoteTransfer();
        $quote->getPayment()
            ->setRatepayInstallment($installment);

        $ratepayPaymentRequestTransfer = $this->mockRatepayPaymentRequestTransfer($installment, $quote);

        $this->mapperFactory
            ->createBasketMapper(
                $ratepayPaymentRequestTransfer
            )
            ->map();

        $this->mapperFactory
            ->createInstallmentPaymentMapper(
                $ratepayPaymentRequestTransfer
            )
            ->map();

        $this->assertEquals('invoice', $this->requestTransfer->getInstallmentPayment()->getDebitPayType());
        $this->assertEquals('125.7', $this->requestTransfer->getInstallmentPayment()->getAmount());
    }
}
