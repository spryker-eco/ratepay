<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\ConfirmPayment;

use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfirmPaymentAdapterMock;
use SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\ElvAbstractTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group ConfirmPayment
 * @group ElvTest
 */
class ElvTest extends ElvAbstractTest
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpSalesOrderTestData();
        $this->setUpPaymentTestData();

        $this->orderTransfer->fromArray($this->orderEntity->toArray(), true);
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfirmPaymentAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new ConfirmPaymentAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfirmPaymentAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new ConfirmPaymentAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    protected function runFacadeMethod($facade)
    {
        return $facade->confirmPayment($this->orderTransfer);
    }
}
