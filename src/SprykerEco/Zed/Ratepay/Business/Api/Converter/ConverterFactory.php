<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Converter;

use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Configuration;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\CalculationResponse;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ConfigurationResponse;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ResponseInterface;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface;

class ConverterFactory implements ConverterFactoryInterface
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface
     */
    protected $moneyFacade;

    /**
     * @param \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface $moneyFacade
     */
    public function __construct(RatepayToMoneyInterface $moneyFacade)
    {
        $this->moneyFacade = $moneyFacade;
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ResponseInterface $response
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterInterface
     */
    public function createTransferObjectConverter(
        ResponseInterface $response
    ) {
        return new TransferObjectConverter(
            $response,
            $this->moneyFacade
        );
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\CalculationResponse $response
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation $request
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterInterface
     */
    public function createInstallmentCalculationResponseConverter(
        CalculationResponse $response,
        Calculation $request
    ) {
        return new InstallmentCalculationResponseConverter(
            $response,
            $this->moneyFacade,
            $this->createTransferObjectConverter($response),
            $request
        );
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ConfigurationResponse $response
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Configuration $request
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterInterface
     */
    public function createInstallmentConfigurationResponseConverter(
        ConfigurationResponse $response,
        Configuration $request
    ) {
        return new InstallmentConfigurationResponseConverter(
            $response,
            $this->moneyFacade,
            $this->createTransferObjectConverter($response),
            $request
        );
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ResponseInterface $response
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterInterface
     */
    public function createProfileResponseConverter(
        ResponseInterface $response
    ) {
        return new ProfileResponseConverter(
            $response,
            $this->moneyFacade,
            $this->createTransferObjectConverter($response)
        );
    }
}
