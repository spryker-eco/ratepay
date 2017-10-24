<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\BuilderFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Constants as ApiConstants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Deliver\Confirm as DeliverConfirm;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Calculation as PaymentCalculation;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Cancel as PaymentCancel;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Configuration as PaymentConfiguration;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Confirm as PaymentConfirm;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Init as PaymentInit;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Refund as PaymentRefund;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request as PaymentRequest;
use SprykerEco\Zed\Ratepay\Business\Api\Model\RequestModelBuilder;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Service\Profile as ProfileRequest;

class ApiFactory extends AbstractBusinessFactory
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\BuilderFactory
     */
    protected $builderFactory;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\BuilderFactory $builderFactory
     */
    public function __construct(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestModelBuilderInterface
     */
    public function createRequestModelBuilder()
    {
        $builder = (new RequestModelBuilder())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_PAYMENT_INIT, $this->createInitModel())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_PAYMENT_REQUEST, $this->createPaymentRequestModel())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_PAYMENT_CONFIRM, $this->createPaymentConfirmModel())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_DELIVER_CONFIRM, $this->createDeliverConfirmModel())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_PAYMENT_CANCEL, $this->createCancelPayment())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_PAYMENT_REFUND, $this->createRefundPayment())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_CONFIGURATION_REQUEST, $this->createConfigurationRequest())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_CALCULATION_REQUEST, $this->createCalculationRequest())
            ->registerBuilder(ApiConstants::REQUEST_MODEL_PROFILE, $this->createProfileRequest());

        return $builder;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createInitModel()
    {
        return new PaymentInit(
            $this->builderFactory->createHead()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createPaymentRequestModel()
    {
        return new PaymentRequest(
            $this->builderFactory->createHead(),
            $this->builderFactory->createCustomer(),
            $this->builderFactory->createShoppingBasket(),
            $this->builderFactory->createPayment()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createPaymentConfirmModel()
    {
        return new PaymentConfirm(
            $this->builderFactory->createHead()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createDeliverConfirmModel()
    {
        return new DeliverConfirm(
            $this->builderFactory->createHead(),
            $this->builderFactory->createShoppingBasket()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createCancelPayment()
    {
        return new PaymentCancel(
            $this->builderFactory->createHead(),
            $this->builderFactory->createShoppingBasket()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createRefundPayment()
    {
        return new PaymentRefund(
            $this->builderFactory->createHead(),
            $this->builderFactory->createShoppingBasket()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createConfigurationRequest()
    {
        return new PaymentConfiguration(
            $this->builderFactory->createHead()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createCalculationRequest()
    {
        return new PaymentCalculation(
            $this->builderFactory->createHead(),
            $this->builderFactory->createInstallmentCalculation()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    protected function createProfileRequest()
    {
        return new ProfileRequest(
            $this->builderFactory->createHead()
        );
    }
}
