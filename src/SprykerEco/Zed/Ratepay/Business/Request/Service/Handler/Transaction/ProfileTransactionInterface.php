<?php

namespace SprykerEco\Zed\Ratepay\Business\Request\Service\Handler\Transaction;

interface ProfileTransactionInterface
{
    /**
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    public function request();
}
