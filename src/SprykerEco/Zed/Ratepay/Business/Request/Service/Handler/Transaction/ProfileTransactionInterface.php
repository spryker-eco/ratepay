<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Service\Handler\Transaction;

interface ProfileTransactionInterface
{
    /**
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    public function request();
}
