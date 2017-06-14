<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\SprykerEco\Zed\Ratepay\Business\Request\Payment\ConfigurationCalculation;

use Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\CalculationByTimeInstallmentAdapterMock;
use Generated\Shared\Transfer\RatepayRequestTransfer;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\Head;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculation;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Response\CalculationResponse;

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
     * @return \Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\CalculationByTimeInstallmentAdapterMock
     */
    protected function getPaymentSuccessResponseAdapterMock()
    {
        return new CalculationByTimeInstallmentAdapterMock();
    }

    /**
     * @return \Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\CalculationByTimeInstallmentAdapterMock
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
     * @param \Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\AbstractAdapterMock $adapterMock
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
            ->getInstallmentCalculationResponseConverter($expectedResponse, $this->getCalculationRequest())
            ->convert();
    }

}
