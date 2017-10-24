<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentInitTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEco\Zed\Ratepay\Business\Api\Mapper\OrderPaymentInitMapper;
use SprykerEco\Zed\Ratepay\Business\Api\Mapper\OrderPaymentRequestMapper;
use SprykerEco\Zed\Ratepay\Business\Api\Mapper\QuotePaymentInitMapper;
use SprykerEco\Zed\Ratepay\Business\Api\Mapper\QuotePaymentRequestMapper;
use SprykerEco\Zed\Ratepay\Business\Order\PartialOrderCalculator;
use SprykerEco\Zed\Ratepay\Business\Service\PaymentMethodExtractor;
use SprykerEco\Zed\Ratepay\RatepayDependencyProvider;

/**
 * @method \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 */
class RatepayCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Service\PaymentMethodExtractor
     */
    protected $paymentMethodExtractor;

    /**
     * @return \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToSalesInterface
     */
    public function getSalesFacade()
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToCalculationInterface
     */
    public function getCalculationFacade()
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::FACADE_CALCULATION);
    }

    /**
     * @return \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    public function getSalesQueryContainer()
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::SALES_QUERY_CONTAINER);
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Service\PaymentMethodExtractorInterface
     */
    public function getPaymentMethodExtractor()
    {
        if (!$this->paymentMethodExtractor) {
            $this->paymentMethodExtractor = $this->createPaymentMethodExtractor();
        }

        return $this->paymentMethodExtractor;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Service\PaymentMethodExtractorInterface
     */
    protected function createPaymentMethodExtractor()
    {
        return new PaymentMethodExtractor(RatepayConfig::PAYMENT_METHODS_MAP);
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPaymentInitMapperByQuote(
        RatepayPaymentInitTransfer $ratepayPaymentInitTransfer,
        QuoteTransfer $quoteTransfer
    ) {
        return new QuotePaymentInitMapper(
            $ratepayPaymentInitTransfer,
            $quoteTransfer,
            $this->getPaymentMethodExtractor()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPaymentInitMapperByOrder(
        RatepayPaymentInitTransfer $ratepayPaymentInitTransfer,
        SpySalesOrder $orderEntity
    ) {

        return new OrderPaymentInitMapper(
            $ratepayPaymentInitTransfer,
            $orderEntity
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $partialOrderTransfer
     * @param \Generated\Shared\Transfer\RatepayPaymentElvTransfer|\Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer|\Generated\Shared\Transfer\RatepayPaymentInvoiceTransfer|\Generated\Shared\Transfer\RatepayPaymentPrepaymentTransfer $paymentData
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPaymentRequestMapperByQuote(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer,
        RatepayPaymentInitTransfer $ratepayPaymentInitTransfer,
        QuoteTransfer $quoteTransfer,
        OrderTransfer $partialOrderTransfer,
        $paymentData
    ) {

        return new QuotePaymentRequestMapper(
            $ratepayPaymentRequestTransfer,
            $ratepayPaymentInitTransfer,
            $quoteTransfer,
            $partialOrderTransfer,
            $paymentData
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $partialOrderTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPaymentRequestMapperByOrder(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer,
        RatepayPaymentInitTransfer $ratepayPaymentInitTransfer,
        OrderTransfer $orderTransfer,
        OrderTransfer $partialOrderTransfer,
        SpySalesOrder $orderEntity
    ) {

        return new OrderPaymentRequestMapper(
            $ratepayPaymentRequestTransfer,
            $ratepayPaymentInitTransfer,
            $orderTransfer,
            $partialOrderTransfer,
            $orderEntity,
            $this->getQueryContainer()
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Order\PartialOrderCalculatorInterface
     */
    public function createPartialOrderCalculator()
    {
        return new PartialOrderCalculator(
            $this->getProvidedDependency(RatepayDependencyProvider::FACADE_CALCULATION),
            $this->getSalesQueryContainer()
        );
    }
}
