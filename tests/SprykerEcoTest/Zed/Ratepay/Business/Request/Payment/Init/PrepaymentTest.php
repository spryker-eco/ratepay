<?php
/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\Init;

use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\InitAdapterMock;
use SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\PrepaymentAbstractTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group Init
 * @group PrepaymentTest
 */
class PrepaymentTest extends PrepaymentAbstractTest
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
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\InitAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new InitAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\InitAdapterMock
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
