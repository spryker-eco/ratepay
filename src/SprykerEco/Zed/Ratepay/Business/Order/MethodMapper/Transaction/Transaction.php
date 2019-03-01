<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\Transaction;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Ratepay\Business\Exception\NoPaymentMapperException;
use SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\PaymentMethodMapperInterface;

class Transaction implements TransactionInterface
{
    /**
     * @var array
     */
    protected $methodMappers = [];

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\PaymentMethodMapperInterface
     */
    public function prepareMethodMapper(QuoteTransfer $quoteTransfer)
    {
        $paymentMethod = $quoteTransfer
            ->requirePayment()
            ->getPayment()
            ->requirePaymentMethod()
            ->getPaymentMethod();

        return $this->getMethodMapper($paymentMethod);
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\PaymentMethodMapperInterface $mapper
     *
     * @return void
     */
    public function registerMethodMapper(PaymentMethodMapperInterface $mapper)
    {
        $this->methodMappers[$mapper->getMethodName()] = $mapper;
    }

    /**
     * @param string $paymentMethod
     *
     * @throws \SprykerEco\Zed\Ratepay\Business\Exception\NoPaymentMapperException
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\PaymentMethodMapperInterface
     */
    protected function getMethodMapper($paymentMethod)
    {
        if (isset($this->methodMappers[$paymentMethod]) === false) {
            throw new NoPaymentMapperException(sprintf("The payment method %s mapper is not defined.", $paymentMethod));
        }

        return $this->methodMappers[$paymentMethod];
    }
}
