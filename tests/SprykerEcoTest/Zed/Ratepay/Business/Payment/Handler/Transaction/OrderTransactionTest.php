<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Payment\Handler\Transaction;

use Generated\Shared\Transfer\RatepayResponseTransfer;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\CancelPaymentTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\ConfirmDeliveryTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\ConfirmPaymentTransaction;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Payment
 * @group Handler
 * @group Transaction
 * @group OrderTransactionTest
 */
class OrderTransactionTest extends BaseTransactionTest
{

    const SUCCESS_MESSAGE = 'Die Prüfung war erfolgreich. Vielen Dank, dass Sie die Zahlart Rechnung gewählt haben.';

    /**
     * @return void
     */
    public function testConfirmPayment()
    {
        $transactionHandler = $this->getTransactionHandlerObject(ConfirmPaymentTransaction::class);
        $transactionHandler->registerMethodMapper($this->mockMethodInvoice());

        $responseTransfer = $transactionHandler->request($this->mockOrderTransfer());

        $this->assertInstanceOf(RatepayResponseTransfer::class, $responseTransfer);

        $this->assertEquals(
            self::SUCCESS_MESSAGE,
            $responseTransfer->getCustomerMessage()
        );
    }

    /**
     * @return void
     */
    public function testCancelPayment()
    {
        $transactionHandler = $this->getTransactionHandlerObject(CancelPaymentTransaction::class);
        $transactionHandler->registerMethodMapper($this->mockMethodInvoice());

        $responseTransfer = $transactionHandler->request(
            $this->mockOrderTransfer(),
            $this->mockPartialOrderTransfer()
        );

        $this->assertInstanceOf(RatepayResponseTransfer::class, $responseTransfer);

        $this->assertEquals(
            self::SUCCESS_MESSAGE,
            $responseTransfer->getCustomerMessage()
        );
    }

    /**
     * @return void
     */
    public function testDeliveryConfirmation()
    {
        $transactionHandler = $this->getTransactionHandlerObject(ConfirmDeliveryTransaction::class);
        $transactionHandler->registerMethodMapper($this->mockMethodInvoice());

        $responseTransfer = $transactionHandler->request(
            $this->mockOrderTransfer(),
            $this->mockPartialOrderTransfer()
        );

        $this->assertInstanceOf(RatepayResponseTransfer::class, $responseTransfer);

        $this->assertEquals(
            self::SUCCESS_MESSAGE,
            $responseTransfer->getCustomerMessage()
        );
    }

    /**
     * @return void
     */
    public function testRefundPayment()
    {
        $transactionHandler = $this->getTransactionHandlerObject('\SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\RefundPaymentTransaction');
        $transactionHandler->registerMethodMapper($this->mockMethodInvoice());

        $responseTransfer = $transactionHandler->request(
            $this->mockOrderTransfer(),
            $this->mockPartialOrderTransfer()
        );

        $this->assertInstanceOf('\Generated\Shared\Transfer\RatepayResponseTransfer', $responseTransfer);

        $this->assertEquals(
            self::SUCCESS_MESSAGE,
            $responseTransfer->getCustomerMessage()
        );
    }

}
