<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Builder;

class BankAccount extends AbstractBuilder implements BankAccountInterface
{
    const ROOT_TAG = 'bank-account';

    /**
     * @return array
     */
    public function buildData()
    {
        $return = [
            'owner' => $this->requestTransfer->getBankAccount()->getOwner(),
            'iban' => $this->requestTransfer->getBankAccount()->getIban(),
            'bic-swift' => $this->requestTransfer->getBankAccount()->getBicSwift(),
        ];
        return $return;
    }

    /**
     * @return string
     */
    public function getRootTag()
    {
        return static::ROOT_TAG;
    }
}
