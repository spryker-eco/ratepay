<?php
/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\ConfirmDelivery;

use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfirmDeliveryAdapterMock;
use SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\InvoiceAbstractTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group ConfirmDelivery
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

        $this->setUpSalesOrderTestData();
        $this->setUpPaymentTestData();

        $this->orderTransfer->fromArray($this->orderEntity->toArray(), true);
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfirmDeliveryAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new ConfirmDeliveryAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfirmDeliveryAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new ConfirmDeliveryAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    protected function runFacadeMethod($facade)
    {
        return $facade->confirmDelivery($this->orderTransfer, $this->orderPartialTransfer, $this->orderTransfer->getItems()->getArrayCopy());
    }
}
