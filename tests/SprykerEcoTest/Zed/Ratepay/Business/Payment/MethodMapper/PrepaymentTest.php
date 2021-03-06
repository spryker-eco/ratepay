<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Payment\MethodMapper;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\RatepayPaymentPrepaymentTransfer;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Method\Prepayment;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Payment
 * @group MethodMapper
 * @group PrepaymentTest
 */
class PrepaymentTest extends AbstractMethodMapperTest
{
    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Method\MethodInterface
     */
    public function getPaymentMethod()
    {
        return new Prepayment(
            $this->createApiRequestFactory(),
            $this->createMapperFactory(),
            $this->getQueryContainerMock()
        );
    }

    /**
     * @return \Generated\Shared\Transfer\PaymentTransfer
     */
    protected function getPaymentTransfer()
    {
        $paymentTransfer = new RatepayPaymentPrepaymentTransfer();
        $this->setRatepayPaymentEntityData($paymentTransfer);

        $payment = new PaymentTransfer();
        $payment->setRatepayPrepayment($paymentTransfer);

        return $payment;
    }

    /**
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay|\Generated\Shared\Transfer\RatepayPaymentPrepaymentTransfer $ratepayPaymentEntity
     *
     * @return void
     */
    protected function setRatepayPaymentEntityData($ratepayPaymentEntity)
    {
        $ratepayPaymentEntity
            ->setResultCode(503)
            ->setDateOfBirth('11.11.1991')
            ->setCurrencyIso3('iso3')
            ->setCustomerAllowCreditInquiry(true)
            ->setGender('M')
            ->setPhone('123456789')
            ->setIpAddress('127.0.0.1')
            ->setPaymentType('PREPAYMENT')
            ->setTransactionId('58-201604122719694')
            ->setTransactionShortId('5QTZ.2VWD.OMWW.9D3E')
            ->setDeviceFingerprint('122356');
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request $request
     *
     * @return void
     */
    protected function testPaymentSpecificRequestData($request)
    {
        $this->assertEquals('invoice', $this->requestTransfer->getPayment()->getMethod());

        $this->assertNull($this->requestTransfer->getPayment()->getInstallmentDetails());
        $this->assertNull($this->requestTransfer->getPayment()->getDebitPayType());
    }
}
