<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Request\Payment\ConfigurationCalculation;

use Generated\Shared\Transfer\RatepayRequestTransfer;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\Head;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculation;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\CalculationResponse;
use SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\CalculationByTimeInstallmentAdapterMock;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Request
 * @group Payment
 * @group ConfigurationCalculation
 * @group InstallmentCalculationByTimeTest
 */
class InstallmentCalculationByTimeTest extends InstallmentAbstractTest
{
    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\CalculationByTimeInstallmentAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new CalculationByTimeInstallmentAdapterMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\CalculationByTimeInstallmentAdapterMock
     */
    protected function getPaymentFailureResponseAdapterMock()
    {
        return (new CalculationByTimeInstallmentAdapterMock())->expectFailure();
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\RatepayFacade $facade
     *
     * @return \Generated\Shared\Transfer\RatepayResponseTransfer
     */
    protected function runFacadeMethod($facade)
    {
        return $facade->installmentCalculation($this->quoteTransfer);
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation
     */
    protected function getCalculationRequest()
    {
        $requestTransfer = new RatepayRequestTransfer();

        return new Calculation(
            new Head($requestTransfer),
            new InstallmentCalculation($requestTransfer)
        );
    }

    /**
     * @param \SprykerEcoTest\Zed\Ratepay\Business\Api\Adapter\Http\AbstractAdapterMock $adapterMock
     * @param string $request
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\CalculationResponse
     */
    protected function sendRequest($adapterMock, $request)
    {
        return new CalculationResponse($adapterMock->sendRequest($request));
    }

    /**
     * @return void
     */
    protected function testResponseInstance()
    {
        $this->assertInstanceOf('\Generated\Shared\Transfer\RatepayInstallmentCalculationResponseTransfer', $this->responseTransfer);
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\Response\CalculationResponse $expectedResponse
     *
     * @return void
     */
    protected function convertResponseToTransfer($expectedResponse)
    {
        $this->expectedResponseTransfer = $this->converterFactory
            ->createInstallmentCalculationResponseConverter($expectedResponse, $this->getCalculationRequest())
            ->convert();
    }
}
