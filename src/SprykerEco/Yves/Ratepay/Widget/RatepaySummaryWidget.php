<?php

/**
 * MIT License
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
    protected const PARAMETER_MOLECULE = 'molecule';
    protected const PARAMETER_MODULE = 'module';

    protected const NAME = 'RatepaySummaryWidget';
    protected const TEMPLATE = '@Ratepay/views/ratepay-summary-widget/ratepay-summary-widget.twig';
    protected const MODULE = 'Ratepay';

    protected const PAYMENT_TRANSFER_MAP = [
        RatepayConfig::INVOICE => 'getRatepayInvoice',
        RatepayConfig::ELV => 'getRatepayElv',
        RatepayConfig::INSTALLMENT => 'getRatepayInstallment',
        RatepayConfig::PREPAYMENT => 'getRatepayPrepayment',
    ];

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     */
    public function __construct(QuoteTransfer $quoteTransfer)
    {
        $this->addParameter(static::PARAMETER_RATEPAY_PAYMENT_TRANSFER, $this->getRatepayPaymentTransfer($quoteTransfer));
        $this->addParameter(static::PARAMETER_MOLECULE, $this->getMoleculeName($quoteTransfer));
        $this->addParameter(static::PARAMETER_QUOTE_TRANSFER, $quoteTransfer);
        $this->addParameter(static::PARAMETER_MODULE, static::MODULE);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return static::TEMPLATE;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer|null
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
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    protected function getMoleculeName(QuoteTransfer $quoteTransfer): string
    {
        return strtolower($quoteTransfer->getPayment()->getPaymentMethod());
    }
}
