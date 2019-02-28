<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay\Form\DataProvider;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer;
use Spryker\Client\Session\SessionClientInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Client\Ratepay\RatepayClientInterface;
use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEco\Yves\Ratepay\Form\InstallmentSubForm;

class InstallmentDataProvider extends DataProviderAbstract
{
    public const INSTALLMENT_CONFIGURATION = 'installment_configuration';

    /**
     * @var \SprykerEco\Client\Ratepay\RatepayClientInterface $ratepayClient
     */
    protected $ratepayClient;

    /**
     * @var \Spryker\Client\Session\SessionClientInterface
     */
    protected $sessionClient;

    /**
     * @param \SprykerEco\Client\Ratepay\RatepayClientInterface $ratepayClient
     * @param \Spryker\Client\Session\SessionClientInterface $sessionClient
     */
    public function __construct(RatepayClientInterface $ratepayClient, SessionClientInterface $sessionClient)
    {
        $this->ratepayClient = $ratepayClient;
        $this->sessionClient = $sessionClient;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer
     */
    public function getData(AbstractTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getPayment() === null) {
            $paymentTransfer = new PaymentTransfer();
            $paymentMethodTransfer = new RatepayPaymentInstallmentTransfer();
            $paymentMethodTransfer->setPhone($this->getPhoneNumber($quoteTransfer));
            $paymentTransfer->setRatepayInstallment($paymentMethodTransfer);

            $quoteTransfer->setPayment($paymentTransfer);
        }

        return $quoteTransfer;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    public function getOptions(AbstractTransfer $quoteTransfer)
    {
        $this->getData($quoteTransfer);
        $configurationResponseTransfer = $this->getInstallmentConfiguration($quoteTransfer);
        $this->setInstallmentDefaultAmount($quoteTransfer, $configurationResponseTransfer);
        $options = [
            InstallmentSubForm::OPTION_DEBIT_PAY_TYPE => array_combine(RatepayConfig::DEBIT_PAY_TYPES, RatepayConfig::DEBIT_PAY_TYPES),
            InstallmentSubForm::OPTION_CALCULATION_TYPE => array_combine(RatepayConfig::INSTALLMENT_CALCULATION_TYPES, RatepayConfig::INSTALLMENT_CALCULATION_TYPES),
            InstallmentSubForm::OPTION_MONTH_ALLOWED => $configurationResponseTransfer->getMonthAllowed(),
        ];

        return $options;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RatepayInstallmentConfigurationResponseTransfer
     */
    protected function getInstallmentConfiguration(QuoteTransfer $quoteTransfer)
    {
        $configurationResponseTransfer = $this->sessionClient->get(self::INSTALLMENT_CONFIGURATION);
        if (!$configurationResponseTransfer) {
            $quoteTransfer->getPayment()->setPaymentMethod(RatepayConfig::INSTALLMENT);
            $configurationResponseTransfer = $this->ratepayClient->installmentConfiguration($quoteTransfer);
            $this->sessionClient->set(self::INSTALLMENT_CONFIGURATION, $configurationResponseTransfer);
        }

        return $configurationResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RatepayInstallmentConfigurationResponseTransfer $configurationResponseTransfer
     *
     * @return void
     */
    protected function setInstallmentDefaultAmount(QuoteTransfer $quoteTransfer, $configurationResponseTransfer)
    {
        $installmentTransfer = $quoteTransfer->getPayment()->getRatepayInstallment();
        $installmentTransfer->setInterestRateDefault($configurationResponseTransfer->getInterestrateDefault());
    }
}
