<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\Cancel;

use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\CancelAdapterMock;
use SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\PrepaymentAbstractTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group Cancel
 * @group PrepaymentTest
 */
class PrepaymentTest extends PrepaymentAbstractTest
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
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\CancelAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new CancelAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\CancelAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new CancelAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    protected function runFacadeMethod($facade)
    {
        return $facade->cancelPayment($this->orderTransfer, $this->orderPartialTransfer, $this->orderTransfer->getItems()->getArrayCopy());
    }
}
