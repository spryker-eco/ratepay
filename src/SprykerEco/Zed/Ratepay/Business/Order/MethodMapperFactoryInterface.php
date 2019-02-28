<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Order;

interface MethodMapperFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapper\Transaction\TransactionInterface
     */
    public function createPaymentTransactionHandler();
}
