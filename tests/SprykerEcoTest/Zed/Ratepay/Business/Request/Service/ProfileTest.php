<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Service;

use Generated\Shared\Transfer\RatepayProfileResponseTransfer;
use Spryker\Zed\Money\Business\MoneyFacade;
use SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ProfileResponse;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyBridge;
use SprykerEcoTest\Zed\Ratepay\Business\AbstractWithConfigTest;
use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ProfileAdapterMock;
use SprykerEcoTest\Zed\Ratepay\Business\Request\AbstractFacadeTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Service
 * @group ProfileTest
 */
class ProfileTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        AbstractWithConfigTest::setUp();

        $ratepayToMoneyBridge = new RatepayToMoneyBridge(new MoneyFacade());
        $this->converterFactory = new ConverterFactory($ratepayToMoneyBridge);
    }

    /**
     * @return void
     */
    public function testPaymentWithSuccessResponse(): void
    {
        $adapterMock = $this->getPaymentSuccessResponseAdapterMock();

        $facade = $this->getFacadeMock($adapterMock);
        $this->responseTransfer = $this->runFacadeMethod($facade);

        $this->testResponseInstance();

        $expectedResponse = $this->sendRequest($adapterMock, $adapterMock->getSuccessResponse());
        $this->convertResponseToTransfer($expectedResponse);

        $this->assertEquals($this->expectedResponseTransfer, $this->responseTransfer);
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getResultCode(),
            $this->responseTransfer->getBaseResponse()->getResultCode()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getResultText(),
            $this->responseTransfer->getBaseResponse()->getResultText()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getReasonCode(),
            $this->responseTransfer->getBaseResponse()->getReasonCode()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getReasonText(),
            $this->responseTransfer->getBaseResponse()->getReasonText()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getTransactionShortId(),
            $this->responseTransfer->getBaseResponse()->getTransactionShortId()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getTransactionId(),
            $this->responseTransfer->getBaseResponse()->getTransactionId()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getCustomerMessage(),
            $this->responseTransfer->getBaseResponse()->getCustomerMessage()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getSuccessful(),
            $this->responseTransfer->getBaseResponse()->getSuccessful()
        );
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

        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getResultCode(),
            $this->responseTransfer->getBaseResponse()->getResultCode()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getResultText(),
            $this->responseTransfer->getBaseResponse()->getResultText()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getReasonCode(),
            $this->responseTransfer->getBaseResponse()->getReasonCode()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getReasonText(),
            $this->responseTransfer->getBaseResponse()->getReasonText()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getTransactionShortId(),
            $this->responseTransfer->getBaseResponse()->getTransactionShortId()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getTransactionId(),
            $this->responseTransfer->getBaseResponse()->getTransactionId()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getCustomerMessage(),
            $this->responseTransfer->getBaseResponse()->getCustomerMessage()
        );
        $this->assertSame(
            $this->expectedResponseTransfer->getBaseResponse()->getSuccessful(),
            $this->responseTransfer->getBaseResponse()->getSuccessful()
        );
        $this->assertFalse($this->expectedResponseTransfer->getBaseResponse()->getSuccessful());
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\BaseResponse $expectedResponse
     *
     * @return void
     */
    protected function convertResponseToTransfer($expectedResponse)
    {
        $this->expectedResponseTransfer = $this->converterFactory
            ->createProfileResponseConverter($expectedResponse)
            ->convert();
    }

    /**
     * @param \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\AbstractAdapterMock $adapterMock
     * @param string $request
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ProfileResponse
     */
    protected function sendRequest($adapterMock, $request)
    {
        return new ProfileResponse($adapterMock->sendRequest($request));
    }

    /**
     * @return void
     */
    protected function testResponseInstance(): void
    {
        $this->assertInstanceOf(
            'Generated\Shared\Transfer\RatepayProfileResponseTransfer',
            $this->responseTransfer
        );
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ProfileAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new ProfileAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ProfileAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new ProfileAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayProfileResponseTransfer
     */
    protected function runFacadeMethod($facade): RatepayProfileResponseTransfer
    {
        return $facade->requestProfile();
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentTransfer $payment
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $paymentTransfer
     *
     * @return void
     */
    protected function setRatepayPaymentDataToPaymentTransfer($payment, $paymentTransfer)
    {
    }

    /**
     * @return void
     */
    protected function getRatepayPaymentMethodTransfer()
    {
    }

    /**
     * @return void
     */
    protected function getPaymentTransferFromQuote()
    {
    }

    /**
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $ratepayPaymentEntity
     *
     * @return void
     */
    protected function setRatepayPaymentEntityData($ratepayPaymentEntity)
    {
    }
}
