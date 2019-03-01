<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\Store;
use Spryker\Yves\Messenger\FlashMessenger\FlashMessengerInterface;
use SprykerEco\Client\Ratepay\RatepayClientInterface;
use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEco\Shared\Ratepay\RatepayConstants;
use Symfony\Component\HttpFoundation\Request;

class RatepayHandler implements RatepayHandlerInterface
{
    public const INSTALLMENT_CALCULATOR_ERROR_HASH = 0;
    public const CHECKOUT_PARTIAL_SUMMARY_PATH = 'Ratepay/partial/summary';

    /**
     * @var \SprykerEco\Client\Ratepay\RatepayClientInterface
     */
    protected $ratepayClient;

    /**
     * @var \Spryker\Yves\Messenger\FlashMessenger\FlashMessengerInterface
     */
    protected $flashMessenger;

    /**
     * @var array
     */
    protected static $paymentMethodMapper = [
        RatepayConfig::PAYMENT_METHOD_INVOICE => RatepayConfig::INVOICE,
        RatepayConfig::PAYMENT_METHOD_ELV => RatepayConfig::ELV,
        RatepayConfig::PAYMENT_METHOD_PREPAYMENT => RatepayConfig::PREPAYMENT,
        RatepayConfig::PAYMENT_METHOD_INSTALLMENT => RatepayConfig::INSTALLMENT,
    ];

    /**
     * @var array
     */
    protected static $genderMapper = [
        'Mr' => RatepayConfig::GENDER_MALE,
        'Mrs' => RatepayConfig::GENDER_FEMALE,
    ];

    /**
     * @param \SprykerEco\Client\Ratepay\RatepayClientInterface $ratepayClient
     */
    public function __construct(RatepayClientInterface $ratepayClient)
    {
        $this->ratepayClient = $ratepayClient;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Spryker\Yves\Messenger\FlashMessenger\FlashMessengerInterface $flashMessenger
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(Request $request, QuoteTransfer $quoteTransfer, FlashMessengerInterface $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;

        $paymentSelection = $quoteTransfer->getPayment()->getPaymentSelection();
        $this->setPaymentProviderAndMethod($quoteTransfer, $paymentSelection);
        $this->setRatepayPayment($request, $quoteTransfer, $paymentSelection);
        $this->calculateInstallmentPlan($quoteTransfer);
        $this->setPaymentSuccessPartialPath($quoteTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return void
     */
    protected function setPaymentProviderAndMethod(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $quoteTransfer->getPayment()
            ->setPaymentProvider(RatepayConfig::PROVIDER_NAME)
            ->setPaymentMethod(static::$paymentMethodMapper[$paymentSelection]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return void
     */
    protected function setRatepayPayment(Request $request, QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $ratepayPaymentTransfer = $this->getPaymentTransfer($quoteTransfer, $paymentSelection);
        $ratepayPaymentTransfer->setPaymentType(static::$paymentMethodMapper[$paymentSelection]);

        $billingAddress = $quoteTransfer->getBillingAddress();

        $ratepayPaymentTransfer
            ->setGender(static::$genderMapper[$billingAddress->getSalutation()])
            ->setCurrencyIso3($this->getCurrency())
            ->setIpAddress($request->getClientIp())
            ->setDeviceFingerprint(
                md5(
                    $quoteTransfer->getCustomer()->getIdCustomer()
                    . "_"
                    . microtime()
                )
            )
            ->setDeviceIdentSId(Config::get(RatepayConstants::SNIPPET_ID));
    }

    /**
     * @return string
     */
    protected function getCurrency()
    {
        return Store::getInstance()->getCurrencyIsoCode();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentInvoiceTransfer
     */
    protected function getPaymentTransfer(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $method = 'get' . ucfirst($paymentSelection);
        return $quoteTransfer->getPayment()->$method();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function calculateInstallmentPlan(QuoteTransfer $quoteTransfer)
    {
        if ($quoteTransfer->getPayment()->getPaymentSelection() === RatepayConfig::PAYMENT_METHOD_INSTALLMENT) {
            $calculationResponse = $this->ratepayClient->installmentCalculation($quoteTransfer);
            if ($calculationResponse->getBaseResponse()->getSuccessful()) {
                $this->setInstallmentPlanDetailToQuote($quoteTransfer, $calculationResponse);
            } else {
                $this->setInstallmentCalculatorError($quoteTransfer, $calculationResponse);
            }
        }
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function setPaymentSuccessPartialPath(QuoteTransfer $quoteTransfer)
    {
        $quoteTransfer->requirePayment()
            ->getPayment()->setSummaryPartialPath(self::CHECKOUT_PARTIAL_SUMMARY_PATH);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RatepayInstallmentCalculationResponseTransfer $calculationResponse
     *
     * @return void
     */
    protected function setInstallmentPlanDetailToQuote(QuoteTransfer $quoteTransfer, $calculationResponse)
    {
        $quoteTransfer->getPayment()
            ->getRatepayInstallment()
            ->setInstallmentAnnualPercentageRate($calculationResponse->getAnnualPercentageRate())
            ->setInstallmentInterestRate($calculationResponse->getInterestRate())
            ->setInstallmentLastRate($calculationResponse->getLastRate())
            ->setInstallmentServiceCharge($calculationResponse->getServiceCharge())
            ->setInstallmentNumberRates($calculationResponse->getNumberOfRates())
            ->setInstallmentRate($calculationResponse->getRate())
            ->setInstallmentInterestAmount($calculationResponse->getInterestAmount())
            ->setInstallmentGrandTotalAmount($calculationResponse->getTotalAmount());
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RatepayInstallmentCalculationResponseTransfer $calculationResponse
     *
     * @return void
     */
    protected function setInstallmentCalculatorError(QuoteTransfer $quoteTransfer, $calculationResponse)
    {
        $quoteTransfer->getPayment()->setPaymentProvider(null);

        $this->flashMessenger->addErrorMessage(
            $calculationResponse
                ->requireBaseResponse()
                ->getBaseResponse()
                ->requireReasonText()
                ->getReasonText()
        );
    }
}
