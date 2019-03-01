<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Converter;

use Generated\Shared\Transfer\RatepayInstallmentConfigurationResponseTransfer;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Configuration;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ResponseInterface;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface;

class InstallmentConfigurationResponseConverter extends BaseConverter
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation
     */
    protected $request;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Converter\TransferObjectConverter
     */
    protected $responseTransfer;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ResponseInterface $response
     * @param \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface $moneyFacade
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Converter\TransferObjectConverter $responseTransferConverter
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Configuration $request
     */
    public function __construct(
        ResponseInterface $response,
        RatepayToMoneyInterface $moneyFacade,
        TransferObjectConverter $responseTransferConverter,
        Configuration $request
    ) {
        parent::__construct($response, $moneyFacade);

        $this->responseTransfer = $responseTransferConverter;
        $this->request = $request;
    }

    /**
     * @return \Generated\Shared\Transfer\RatepayInstallmentConfigurationResponseTransfer
     */
    public function convert()
    {
        $baseResponse = $this->responseTransfer->convert();

        $responseTransfer = new RatepayInstallmentConfigurationResponseTransfer();
        $responseTransfer
            ->setBaseResponse($baseResponse);

        $successCode = Constants::REQUEST_CODE_SUCCESS_MATRIX[Constants::REQUEST_MODEL_CONFIGURATION_REQUEST];
        if ($successCode == $baseResponse->getResultCode()) {
            $responseTransfer
                ->setInterestrateMin($this->response->getInterestrateMin())
                ->setInterestrateDefault($this->response->getInterestrateDefault())
                ->setInterestrateMax($this->response->getInterestrateMax())
                ->setInterestRateMerchantTowardsBank($this->response->getInterestRateMerchantTowardsBank())
                ->setMonthNumberMin($this->response->getMonthNumberMin())
                ->setMonthNumberMax($this->response->getMonthNumberMax())
                ->setMonthLongrun($this->response->getMonthLongrun())
                ->setAmountMinLongrun($this->response->getAmountMinLongrun())
                ->setMonthAllowed($this->response->getMonthAllowed())
                ->setValidPaymentFirstdays($this->response->getValidPaymentFirstdays())
                ->setPaymentFirstday($this->response->getPaymentFirstday())
                ->setPaymentAmount($this->response->getPaymentAmount())
                ->setPaymentLastrate($this->response->getPaymentLastrate())
                ->setRateMinNormal($this->response->getRateMinNormal())
                ->setRateMinLongrun($this->response->getRateMinLongrun())
                ->setServiceCharge($this->response->getServiceCharge())
                ->setMinDifferenceDueday($this->response->getMinDifferenceDueday());
        }

        return $responseTransfer;
    }
}
