<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\ConfigurationCalculation;

use Generated\Shared\Transfer\RatepayRequestTransfer;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\Head;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Configuration;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ConfigurationResponse;
use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfigurationInstallmentAdapterMock;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group ConfigurationCalculation
 * @group InstallmentConfigurationTest
 */
class InstallmentConfigurationTest extends InstallmentAbstractTest
{
    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfigurationInstallmentAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new ConfigurationInstallmentAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\ConfigurationInstallmentAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new ConfigurationInstallmentAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    protected function runFacadeMethod($facade)
    {
        return $facade->installmentConfiguration($this->quoteTransfer);
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Configuration
     */
    protected function getConfigurationRequest()
    {
        return new Configuration(
            new Head(new RatepayRequestTransfer())
        );
    }

    /**
     * @param \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\AbstractAdapterMock $adapterMock
     * @param string $request
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ConfigurationResponse
     */
    protected function sendRequest($adapterMock, $request)
    {
        return new ConfigurationResponse($adapterMock->sendRequest($request));
    }

    /**
     * @return void
     */
    protected function testResponseInstance()
    {
        $this->assertInstanceOf('\Generated\Shared\Transfer\RatepayInstallmentConfigurationResponseTransfer', $this->responseTransfer);
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\ConfigurationResponse $expectedResponse
     *
     * @return void
     */
    protected function convertResponseToTransfer($expectedResponse)
    {
        $this->expectedResponseTransfer = $this->converterFactory
            ->createInstallmentConfigurationResponseConverter($expectedResponse, $this->getConfigurationRequest())
            ->convert();
    }
}
