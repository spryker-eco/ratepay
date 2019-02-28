<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Order;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\Elv as ElvMapper;
use SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\Installment as InstallmentMapper;
use SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\Invoice as InvoiceMapper;
use SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\Prepayment as PrepaymentMapper;
use SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\Transaction\Transaction;

class MethodMapperFactory extends AbstractBusinessFactory implements MethodMapperFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\Transaction\TransactionInterface
     */
    public function createPaymentTransactionHandler()
    {
        $paymentTransactionHandler = new Transaction();
        $paymentTransactionHandler->registerMethodMapper($this->createElvMethodMapper());
        $paymentTransactionHandler->registerMethodMapper($this->createInstallmentMethodMapper());
        $paymentTransactionHandler->registerMethodMapper($this->createInvoiceMethodMapper());
        $paymentTransactionHandler->registerMethodMapper($this->createPrepaymentMethodMapper());

        return $paymentTransactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\PaymentMethodMapperInterface
     */
    protected function createElvMethodMapper()
    {
        return new ElvMapper();
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\PaymentMethodMapperInterface
     */
    protected function createInvoiceMethodMapper()
    {
        return new InvoiceMapper();
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\PaymentMethodMapperInterface
     */
    protected function createPrepaymentMethodMapper()
    {
        return new PrepaymentMapper();
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\PaymentMethodMapperInterface
     */
    protected function createInstallmentMethodMapper()
    {
        return new InstallmentMapper();
    }
}
