<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay\Widget;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;
use SprykerEco\Shared\Ratepay\RatepayConfig;

/**
 * @method \SprykerEco\Yves\Ratepay\RatepayFactory getFactory()
 */
class RatepaySummaryWidget extends AbstractWidget
{
    protected const PARAMETER_RATEPAY_PAYMENT_TRANSFER = 'ratepayPaymentTransfer';
    protected const PARAMETER_QUOTE_TRANSFER = 'quoteTransfer';
    protected const PARAMETER_VIEW_NAME = 'view';

    protected const PAYMENT_TRANSFER_MAP = [
        RatepayConfig::INVOICE => 'getRatepayInvoice',
        RatepayConfig::ELV => 'getRatepayElv',
        RatepayConfig::INSTALLMENT => 'getRatepayInstallment',
        RatepayConfig::PREPAYMENT => 'getRatepayPrepayment'
    ];

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     */
    public function __construct(QuoteTransfer $quoteTransfer)
    {
        $this->addParameter(static::PARAMETER_RATEPAY_PAYMENT_TRANSFER, $this->getRatepayPaymentTransfer($quoteTransfer));
        $this->addParameter(static::PARAMETER_VIEW_NAME, $this->getViewName($quoteTransfer));
        $this->addParameter(static::PARAMETER_QUOTE_TRANSFER, $quoteTransfer);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'RatepaySummaryWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@Ratepay/partial/ratepay-summary-widget.twig';
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return AbstractTransfer|null
     */
    protected function getRatepayPaymentTransfer(QuoteTransfer $quoteTransfer): ?AbstractTransfer
    {
        $paymentTransfer = $quoteTransfer->getPayment();

        if (!isset(static::PAYMENT_TRANSFER_MAP[$paymentTransfer->getPaymentMethod()])) {
            return null;
        }

        $getterName = static::PAYMENT_TRANSFER_MAP[$paymentTransfer->getPaymentMethod()];

        if (!method_exists($paymentTransfer, $getterName)) {
            return null;
        }

        return $quoteTransfer->getPayment()->$getterName();
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    protected function getViewName(QuoteTransfer $quoteTransfer): string
    {
        return strtolower($quoteTransfer->getPayment()->getPaymentMethod());
    }
}
