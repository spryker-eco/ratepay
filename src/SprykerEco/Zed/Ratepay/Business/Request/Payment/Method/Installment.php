<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Method;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEco\Zed\Ratepay\Business\Api\Constants as ApiConstants;

/**
 * Ratepay Elv payment method.
 */
class Installment extends AbstractMethod
{
    /**
     * @return string
     */
    public function getMethodName()
    {
        return RatepayConfig::INSTALLMENT;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer
     */
    public function getPaymentData(QuoteTransfer $quoteTransfer)
    {
        return $quoteTransfer
            ->requirePayment()
            ->getPayment()
            ->requireRatepayInstallment()
            ->getRatepayInstallment();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request
     */
    public function configurationRequest(QuoteTransfer $quoteTransfer)
    {
        $paymentData = $this->getPaymentData($quoteTransfer);

        /*
         * @var \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request $request
         */
        $request = $this->modelFactory->build(ApiConstants::REQUEST_MODEL_CONFIGURATION_REQUEST);
        $this->mapConfigurationData($quoteTransfer, $paymentData);

        return $request;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation
     */
    public function calculationRequest(QuoteTransfer $quoteTransfer)
    {
        $paymentData = $this->getPaymentData($quoteTransfer);

        /*
         * @var \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation $request
         */
        $request = $this->modelFactory->build(ApiConstants::REQUEST_MODEL_CALCULATION_REQUEST);
        $this->mapCalculationData($quoteTransfer, $paymentData);

        return $request;
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return void
     */
    protected function mapPaymentData(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer)
    {
        parent::mapPaymentData($ratepayPaymentRequestTransfer);

        $this->mapperFactory
            ->createInstallmentPaymentMapper($ratepayPaymentRequestTransfer)
            ->map();
        $this->mapperFactory
            ->createInstallmentDetailMapper($ratepayPaymentRequestTransfer)
            ->map();
        if ($ratepayPaymentRequestTransfer->getDebitPayType() == RatepayConfig::DEBIT_PAY_TYPE_DIRECT_DEBIT) {
            $this->mapBankAccountData($ratepayPaymentRequestTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer $paymentData
     *
     * @return void
     */
    protected function mapConfigurationData($quoteTransfer, $paymentData)
    {
        $this->mapperFactory->createQuoteHeadMapper($quoteTransfer, $paymentData)->map();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer $paymentData
     *
     * @return void
     */
    protected function mapCalculationData($quoteTransfer, $paymentData)
    {
        $this->mapperFactory->createQuoteHeadMapper($quoteTransfer, $paymentData)->map();

        $this->mapperFactory
            ->createInstallmentCalculationMapper($quoteTransfer, $paymentData)
            ->map();
    }

    /**
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $payment
     *
     * @return \Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer
     */
    protected function getPaymentTransferObject($payment)
    {
        return new RatepayPaymentInstallmentTransfer();
    }
}
