<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\ConfigurationCalculation;

use Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer;
use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEcoTest\Zed\Ratepay\Business\Request\AbstractFacadeTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group ConfigurationCalculation
 * @group InstallmentAbstractTest
 */
abstract class InstallmentAbstractTest extends AbstractFacadeTest
{
    /**
     * @const Payment method code.
     */
    public const PAYMENT_METHOD = RatepayConfig::INSTALLMENT;

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

    /**
     * @return \Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer
     */
    protected function getRatepayPaymentMethodTransfer()
    {
        return (new RatepayPaymentInstallmentTransfer())
            ->setBankAccountBic('XXXXXXXXXXX')
            ->setBankAccountIban('XXXX XXXX XXXX XXXX XXXX XX')
            ->setBankAccountHolder('TestHolder');
    }

    /**
     * @return \Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer
     */
    protected function getPaymentTransferFromQuote()
    {
        return $this->quoteTransfer->getPayment()->getRatepayInstallment();
    }

    /**
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay|\Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer$ratepayPaymentEntity
     *
     * @return void
     */
    protected function setRatepayPaymentEntityData($ratepayPaymentEntity)
    {
        $ratepayPaymentEntity
            ->setResultCode(503)
            ->setDateOfBirth('11.11.1991')
            ->setCurrencyIso3('EUR')
            ->setCustomerAllowCreditInquiry(true)
            ->setGender('M')
            ->setPhone('123456789')
            ->setIpAddress('127.0.0.1')
            ->setPaymentType('INSTALLMENT')
            ->setTransactionId('58-201604122719694')
            ->setTransactionShortId('5QTZ.2VWD.OMWW.9D3E')
            ->setDeviceFingerprint('122356');
    }

    /**
     * @return void
     */
    public function testPaymentWithSuccessResponse()
    {
        $adapterMock = $this->getPaymentSuccessResponseAdapterMock();
        $facade = $this->getFacadeMock($adapterMock);
        $this->responseTransfer = $this->runFacadeMethod($facade);

        $this->testResponseInstance();

        $expectedResponse = $this->sendRequest($adapterMock, $adapterMock->getSuccessResponse());
        $this->convertResponseToTransfer($expectedResponse);

        $this->assertEquals($this->expectedResponseTransfer, $this->responseTransfer);

        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getResultCode(), $this->responseTransfer->getBaseResponse()->getResultCode());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getResultText(), $this->responseTransfer->getBaseResponse()->getResultText());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getReasonCode(), $this->responseTransfer->getBaseResponse()->getReasonCode());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getReasonText(), $this->responseTransfer->getBaseResponse()->getReasonText());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getTransactionShortId(), $this->responseTransfer->getBaseResponse()->getTransactionShortId());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getTransactionId(), $this->responseTransfer->getBaseResponse()->getTransactionId());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getCustomerMessage(), $this->responseTransfer->getBaseResponse()->getCustomerMessage());

        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getSuccessful(), $this->responseTransfer->getBaseResponse()->getSuccessful());
        $this->assertTrue($this->expectedResponseTransfer->getBaseResponse()->getSuccessful());
    }

    /**
     * @return void
     */
    public function testPaymentWithFailureResponse()
    {
        $adapterMock = $this->getPaymentFailureResponseAdapterMock();
        $facade = $this->getFacadeMock($adapterMock);
        $this->responseTransfer = $this->runFacadeMethod($facade);

        $this->testResponseInstance();

        $expectedResponse = $this->sendRequest($adapterMock, $adapterMock->getFailureResponse());
        $this->convertResponseToTransfer($expectedResponse);

        $this->assertEquals($this->expectedResponseTransfer, $this->responseTransfer);

        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getResultCode(), $this->responseTransfer->getBaseResponse()->getResultCode());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getResultText(), $this->responseTransfer->getBaseResponse()->getResultText());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getReasonCode(), $this->responseTransfer->getBaseResponse()->getReasonCode());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getReasonText(), $this->responseTransfer->getBaseResponse()->getReasonText());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getTransactionShortId(), $this->responseTransfer->getBaseResponse()->getTransactionShortId());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getTransactionId(), $this->responseTransfer->getBaseResponse()->getTransactionId());
        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getCustomerMessage(), $this->responseTransfer->getBaseResponse()->getCustomerMessage());

        $this->assertSame($this->expectedResponseTransfer->getBaseResponse()->getSuccessful(), $this->responseTransfer->getBaseResponse()->getSuccessful());
        $this->assertFalse($this->expectedResponseTransfer->getBaseResponse()->getSuccessful());
    }
}
