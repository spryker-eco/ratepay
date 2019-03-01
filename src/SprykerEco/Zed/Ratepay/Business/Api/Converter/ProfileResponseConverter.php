<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Converter;

use Generated\Shared\Transfer\RatepayProfileResponseTransfer;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ResponseInterface;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface;

class ProfileResponseConverter extends BaseConverter
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Converter\TransferObjectConverter
     */
    protected $responseTransfer;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ResponseInterface $response
     * @param \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface $moneyFacade
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Converter\TransferObjectConverter $responseTransferConverter
     */
    public function __construct(
        ResponseInterface $response,
        RatepayToMoneyInterface $moneyFacade,
        TransferObjectConverter $responseTransferConverter
    ) {
        parent::__construct($response, $moneyFacade);

        $this->responseTransfer = $responseTransferConverter;
    }

    /**
     * @return \Generated\Shared\Transfer\RatepayProfileResponseTransfer
     */
    public function convert()
    {
        $baseResponse = $this->responseTransfer->convert();

        $responseTransfer = new RatepayProfileResponseTransfer();
        $responseTransfer
            ->setBaseResponse($baseResponse);

        $successCode = Constants::REQUEST_CODE_SUCCESS_MATRIX[Constants::REQUEST_MODEL_PROFILE];
        if ($successCode == $baseResponse->getResultCode()) {
            $responseTransfer
                ->setMasterData($this->response->getMasterData())
                ->setInstallmentConfigurationResult($this->response->getInstallmentConfigurationResult());
        }

        return $responseTransfer;
    }
}
