<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\Refund;

use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\RefundAdapterMock;
use SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\ElvAbstractTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group Refund
 * @group ElvTest
 */
class ElvTest extends ElvAbstractTest
{
    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->setUpSalesOrderTestData();
        $this->setUpPaymentTestData();

        $this->orderTransfer->fromArray($this->orderEntity->toArray(), true);
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\RefundAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new RefundAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\RefundAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new RefundAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    protected function runFacadeMethod($facade)
    {
        return $facade->refundPayment($this->orderTransfer, $this->orderPartialTransfer, $this->orderTransfer->getItems()->getArrayCopy());
    }
}
