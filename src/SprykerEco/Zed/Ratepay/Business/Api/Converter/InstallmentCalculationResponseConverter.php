<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Converter;

use Generated\Shared\Transfer\RatepayInstallmentCalculationResponseTransfer;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\CalculationResponse;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface;

class InstallmentCalculationResponseConverter extends BaseConverter
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation
     */
    protected $request;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterInterface
     */
    protected $responseTransferConverter;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\CalculationResponse $response
     * @param \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface $moneyFacade
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterInterface $responseTransferConverter
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation $request
     */
    public function __construct(
        CalculationResponse $response,
        RatepayToMoneyInterface $moneyFacade,
        ConverterInterface $responseTransferConverter,
        Calculation $request
    ) {
        parent::__construct($response, $moneyFacade);

        $this->responseTransferConverter = $responseTransferConverter;
        $this->request = $request;
    }

    /**
     * @return \Generated\Shared\Transfer\RatepayInstallmentCalculationResponseTransfer
     */
    public function convert()
    {
        $baseResponse = $this->responseTransferConverter->convert();

        $responseTransfer = new RatepayInstallmentCalculationResponseTransfer();
        $responseTransfer
            ->setBaseResponse($baseResponse);

        $successCode = Constants::REQUEST_CODE_SUCCESS_MATRIX[Constants::REQUEST_MODEL_CALCULATION_REQUEST];
        if ($successCode == $baseResponse->getResultCode()) {
            $responseTransfer
                ->setTotalAmount($this->decimalToCents($this->response->getTotalAmount()))
                ->setAmount($this->decimalToCents($this->response->getAmount()))
                ->setInterestAmount($this->decimalToCents($this->response->getInterestAmount()))
                ->setServiceCharge($this->decimalToCents($this->response->getServiceCharge()))
                ->setInterestRate($this->decimalToCents($this->response->getInterestRate()))
                ->setAnnualPercentageRate($this->response->getAnnualPercentageRate())
                ->setMonthlyDebitInterest($this->decimalToCents($this->response->getMonthlyDebitInterest()))
                ->setRate($this->decimalToCents($this->response->getRate()))
                ->setNumberOfRates($this->response->getNumberOfRates())
                ->setLastRate($this->decimalToCents($this->response->getLastRate()))
                ->setPaymentFirstDay($this->response->getPaymentFirstday());
        }

        return $responseTransfer;
    }
}
