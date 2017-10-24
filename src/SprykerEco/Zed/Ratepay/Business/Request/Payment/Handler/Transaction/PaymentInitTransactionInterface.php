<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction;

use Generated\Shared\Transfer\RatepayPaymentInitTransfer;

interface PaymentInitTransactionInterface extends MethodMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function request(RatepayPaymentInitTransfer $ratepayPaymentInitTransfer);
}
