<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction;

use Generated\Shared\Transfer\RatepayPaymentInitTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;

interface RequestPaymentTransactionInterface extends MethodMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    public function request(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer);
}
