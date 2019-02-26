<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\SprykerEco\Zed\Ratepay\Business\Request\Payment\Refund;

use Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\RefundAdapterMock;
use Functional\SprykerEco\Zed\Ratepay\Business\Request\Payment\PrepaymentAbstractTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group Refund
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

        $this->setUpSalesOrderTestData();
        $this->setUpPaymentTestData();

        $this->orderTransfer->fromArray($this->orderEntity->toArray(), true);
    }

    /**
     * @return \Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\RefundAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new RefundAdapterMock();
    }

    /**
     * @return \Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\RefundAdapterMock
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
