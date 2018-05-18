<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Builder;

class Payment extends AbstractBuilder implements BuilderInterface
{
    const ROOT_TAG = 'payment';

    /**
     * @return array
     */
    public function buildData()
    {
        $return = [
            '@method' => $this->requestTransfer->getPayment()->getMethod(),
            '@currency' => $this->requestTransfer->getPayment()->getCurrency(),
            'amount' => $this->requestTransfer->getPayment()->getAmount(),
            'debit-pay-type' => $this->requestTransfer->getPayment()->getDebitPayType(),
        ];

        if ($this->requestTransfer->getInstallmentPayment()) {
            $return['amount'] = $this->requestTransfer->getInstallmentPayment()->getAmount();
            $return['debit-pay-type'] = $this->requestTransfer->getInstallmentPayment()->getDebitPayType();
            $return['installment-details'] = (new InstallmentDetail($this->requestTransfer));
        }

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
