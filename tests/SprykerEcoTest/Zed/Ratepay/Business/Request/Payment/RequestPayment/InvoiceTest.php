<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\RequestPayment;

use SprykerEco\Shared\Ratepay\RatepayConstants;
use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\RequestPaymentInvoiceAdapterMock;
use SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\InvoiceAbstractTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group RequestPayment
 * @group InvoiceTest
 */
class InvoiceTest extends InvoiceAbstractTest
{
    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->quoteTransfer = $this->getQuoteTransfer();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\RequestPaymentInvoiceAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new RequestPaymentInvoiceAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\RequestPaymentInvoiceAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new RequestPaymentInvoiceAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    protected function runFacadeMethod($facade)
    {
        return $facade->requestPayment($this->mockRatepayPaymentRequestTransfer());
    }

    /**
     * @return void
     */
    public function testPaymentWithSuccessResponse()
    {
        parent::testPaymentWithSuccessResponse();

        $this->assertEquals(RatepayConstants::INVOICE, $this->responseTransfer->getPaymentMethod());
        $this->assertEquals($this->expectedResponseTransfer->getPaymentMethod(), $this->responseTransfer->getPaymentMethod());
    }
}
