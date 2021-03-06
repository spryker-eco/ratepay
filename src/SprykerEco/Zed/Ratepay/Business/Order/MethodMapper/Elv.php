<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Order\MethodMapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay;
use SprykerEco\Shared\Ratepay\RatepayConfig;

class Elv extends AbstractMapper
{
    /**
     * @return string
     */
    public function getMethodName()
    {
        return RatepayConfig::ELV;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentElvTransfer
     */
    protected function getPaymentTransfer(QuoteTransfer $quoteTransfer)
    {
        return $quoteTransfer->getPayment()->getRatepayElv();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $payment
     *
     * @return void
     */
    public function mapMethodDataToPayment(QuoteTransfer $quoteTransfer, SpyPaymentRatepay $payment)
    {
        parent::mapMethodDataToPayment($quoteTransfer, $payment);

        $paymentTransfer = $this->getPaymentTransfer($quoteTransfer);
        $payment
            ->setBankAccountBic($paymentTransfer->requireBankAccountBic()->getBankAccountBic())
            ->setBankAccountIban($paymentTransfer->requireBankAccountIban()->getBankAccountIban());
    }
}
