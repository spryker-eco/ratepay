<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http\Guzzle;
use SprykerEco\Zed\Ratepay\Business\Api\ApiFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\BuilderFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\BuilderFactoryInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterFactoryInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperFactoryInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Model\RequestModelBuilderInterface;
use SprykerEco\Zed\Ratepay\Business\Expander\ProductExpander;
use SprykerEco\Zed\Ratepay\Business\Expander\ProductExpanderInterface;
use SprykerEco\Zed\Ratepay\Business\Internal\Install;
use SprykerEco\Zed\Ratepay\Business\Internal\InstallInterface;
use SprykerEco\Zed\Ratepay\Business\Order\MethodMapperFactory;
use SprykerEco\Zed\Ratepay\Business\Order\MethodMapperFactoryInterface;
use SprykerEco\Zed\Ratepay\Business\Order\Saver;
use SprykerEco\Zed\Ratepay\Business\Order\SaverInterface;
use SprykerEco\Zed\Ratepay\Business\Payment\PaymentSaver;
use SprykerEco\Zed\Ratepay\Business\Payment\PaymentSaverInterface;
use SprykerEco\Zed\Ratepay\Business\Payment\PostSaveHook;
use SprykerEco\Zed\Ratepay\Business\Payment\PostSaveHookInterface;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\CancelPaymentTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\ConfirmDeliveryTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\ConfirmPaymentTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\InitPaymentTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\InstallmentCalculationTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\InstallmentConfigurationTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\MethodMapperInterface;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\OrderTransactionInterface;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\PaymentInitTransactionInterface;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\QuoteTransactionInterface;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\RefundPaymentTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\RequestPaymentTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\RequestPaymentTransactionInterface;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Method\Elv;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Method\Installment;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Method\Invoice;
use SprykerEco\Zed\Ratepay\Business\Request\Payment\Method\Prepayment;
use SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface;
use SprykerEco\Zed\Ratepay\Business\Request\Service\Handler\Transaction\ProfileTransaction;
use SprykerEco\Zed\Ratepay\Business\Request\Service\Handler\Transaction\ProfileTransactionInterface;
use SprykerEco\Zed\Ratepay\Business\Request\Service\Method\ServiceMethod;
use SprykerEco\Zed\Ratepay\Business\Status\TransactionStatus;
use SprykerEco\Zed\Ratepay\Business\Status\TransactionStatusInterface;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToCalculationInterface;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToGlossaryInterface;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToProductInterface;
use SprykerEco\Zed\Ratepay\RatepayDependencyProvider;

/**
 * @method \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 */
class RatepayBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @param string $gatewayUrl
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface
     */
    protected function createAdapter($gatewayUrl): AdapterInterface
    {
        return new Guzzle($gatewayUrl);
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Service\Handler\Transaction\ProfileTransactionInterface
     */
    public function createRequestProfileTransactionHandler(): ProfileTransactionInterface
    {
        $transactionHandler = new ProfileTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $transactionHandler->registerMethodMapper($this->createServiceMethod($this->createRequestTransfer()));

        return $transactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\PaymentInitTransactionInterface
     */
    public function createInitPaymentTransactionHandler(): PaymentInitTransactionInterface
    {
        $transactionHandler = new InitPaymentTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $this->registerAllMethodMappers($transactionHandler);

        return $transactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\RequestPaymentTransactionInterface
     */
    public function createRequestPaymentTransactionHandler(): RequestPaymentTransactionInterface
    {
        $transactionHandler = new RequestPaymentTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $this->registerAllMethodMappers($transactionHandler);

        return $transactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Payment\PaymentSaverInterface
     */
    public function createPaymentMethodSaver(): PaymentSaverInterface
    {
        $paymentSaver = new PaymentSaver(
            $this->getQueryContainer()
        );

        return $paymentSaver;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\OrderTransactionInterface
     */
    public function createConfirmPaymentTransactionHandler(): OrderTransactionInterface
    {
        $transactionHandler = new ConfirmPaymentTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $this->registerAllMethodMappers($transactionHandler);

        return $transactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\OrderTransactionInterface
     */
    public function createConfirmDeliveryTransactionHandler(): OrderTransactionInterface
    {
        $transactionHandler = new ConfirmDeliveryTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $this->registerAllMethodMappers($transactionHandler);

        return $transactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\OrderTransactionInterface
     */
    public function createCancelPaymentTransactionHandler(): OrderTransactionInterface
    {
        $transactionHandler = new CancelPaymentTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $this->registerAllMethodMappers($transactionHandler);

        return $transactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\OrderTransactionInterface
     */
    public function createRefundPaymentTransactionHandler(): OrderTransactionInterface
    {
        $transactionHandler = new RefundPaymentTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $this->registerAllMethodMappers($transactionHandler);

        return $transactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\QuoteTransactionInterface
     */
    public function createInstallmentConfigurationTransactionHandler(): QuoteTransactionInterface
    {
        $transactionHandler = new InstallmentConfigurationTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $transactionHandler->registerMethodMapper($this->createInstallment($this->createRequestTransfer()));

        return $transactionHandler;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\QuoteTransactionInterface
     */
    public function createInstallmentCalculationTransactionHandler(): QuoteTransactionInterface
    {
        $transactionHandler = new InstallmentCalculationTransaction(
            $this->createAdapter($this->getConfig()->getTransactionGatewayUrl()),
            $this->createConverterFactory(),
            $this->getQueryContainer()
        );

        $transactionHandler->registerMethodMapper($this->createInstallment($this->createRequestTransfer()));

        return $transactionHandler;
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction\MethodMapperInterface $transactionHandler
     *
     * @return void
     */
    protected function registerAllMethodMappers(MethodMapperInterface $transactionHandler): void
    {
        $requestTransfer = $this->createRequestTransfer();

        $transactionHandler->registerMethodMapper($this->createInvoice($requestTransfer));
        $transactionHandler->registerMethodMapper($this->createElv($requestTransfer));
        $transactionHandler->registerMethodMapper($this->createPrepayment($requestTransfer));
        $transactionHandler->registerMethodMapper($this->createInstallment($requestTransfer));
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Status\TransactionStatusInterface
     */
    public function createStatusTransaction(): TransactionStatusInterface
    {
        return new TransactionStatus(
            $this->getQueryContainer()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestModelBuilderInterface
     */
    public function createApiRequestFactory($requestTransfer): RequestModelBuilderInterface
    {
        $factory = new ApiFactory(
            $this->createBuilderFactory($requestTransfer)
        );

        return $factory->createRequestModelBuilder();
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Order\MethodMapperFactoryInterface
     */
    public function createMethodMapperFactory(): MethodMapperFactoryInterface
    {
        return new MethodMapperFactory();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Order\SaverInterface
     */
    public function createOrderSaver(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ): SaverInterface {
        $paymentMapper = $this
            ->createMethodMapperFactory()
            ->createPaymentTransactionHandler()
            ->prepareMethodMapper($quoteTransfer);

        return new Saver(
            $quoteTransfer,
            $checkoutResponseTransfer,
            $paymentMapper
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Converter\ConverterFactoryInterface
     */
    protected function createConverterFactory(): ConverterFactoryInterface
    {
        return new ConverterFactory(
            $this->getMoneyFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface
     */
    protected function getMoneyFacade(): RatepayToMoneyInterface
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::FACADE_MONEY);
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperFactoryInterface
     */
    protected function createMapperFactory(RatepayRequestTransfer $requestTransfer): MapperFactoryInterface
    {
        return new MapperFactory(
            $requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\BuilderFactoryInterface
     */
    protected function createBuilderFactory(RatepayRequestTransfer $requestTransfer): BuilderFactoryInterface
    {
        return new BuilderFactory(
            $requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface
     */
    public function createInvoice(RatepayRequestTransfer $requestTransfer): RequestMethodInterface
    {
        return new Invoice(
            $this->createApiRequestFactory($requestTransfer),
            $this->createMapperFactory($requestTransfer),
            $this->getQueryContainer()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface
     */
    public function createElv(RatepayRequestTransfer $requestTransfer): RequestMethodInterface
    {
        return new Elv(
            $this->createApiRequestFactory($requestTransfer),
            $this->createMapperFactory($requestTransfer),
            $this->getQueryContainer()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface
     */
    public function createPrepayment(RatepayRequestTransfer $requestTransfer): RequestMethodInterface
    {
        return new Prepayment(
            $this->createApiRequestFactory($requestTransfer),
            $this->createMapperFactory($requestTransfer),
            $this->getQueryContainer()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface
     */
    public function createInstallment(RatepayRequestTransfer $requestTransfer): RequestMethodInterface
    {
        return new Installment(
            $this->createApiRequestFactory($requestTransfer),
            $this->createMapperFactory($requestTransfer),
            $this->getQueryContainer()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface
     */
    public function createServiceMethod(RatepayRequestTransfer $requestTransfer): RequestMethodInterface
    {
        return new ServiceMethod(
            $this->createApiRequestFactory($requestTransfer),
            $this->createMapperFactory($requestTransfer),
            $this->getQueryContainer()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Expander\ProductExpanderInterface
     */
    public function createProductExpander(): ProductExpanderInterface
    {
        return new ProductExpander(
            $this->getProductFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToProductInterface
     */
    protected function getProductFacade(): RatepayToProductInterface
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Internal\InstallInterface
     */
    public function createInstaller(): InstallInterface
    {
        return new Install(
            $this->getGlossaryFacade(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Payment\PostSaveHookInterface
     */
    public function createPostSaveHook(): PostSaveHookInterface
    {
        return new PostSaveHook(
            $this->getQueryContainer()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToCalculationInterface
     */
    public function getCalculation(): RatepayToCalculationInterface
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::FACADE_CALCULATION);
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToGlossaryInterface
     */
    protected function getGlossaryFacade(): RatepayToGlossaryInterface
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::FACADE_GLOSSARY);
    }

    /**
     * @return \Generated\Shared\Transfer\RatepayRequestTransfer
     */
    protected function createRequestTransfer(): RatepayRequestTransfer
    {
        return new RatepayRequestTransfer();
    }
}
