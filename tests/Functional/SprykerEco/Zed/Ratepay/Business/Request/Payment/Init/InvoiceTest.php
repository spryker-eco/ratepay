<?php
/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\SprykerEco\Zed\Ratepay\Business\Request\Payment\Init;

use Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\InitAdapterMock;
use Functional\SprykerEco\Zed\Ratepay\Business\Request\Payment\InvoiceAbstractTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group Init
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
     * @return \Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\InitAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new InitAdapterMock();
    }

    /**
     * @return \Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\InitAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new InitAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    protected function runFacadeMethod($facade)
    {
        return $facade->initPayment($this->mockRatepayPaymentInitTransfer());
    }

}
