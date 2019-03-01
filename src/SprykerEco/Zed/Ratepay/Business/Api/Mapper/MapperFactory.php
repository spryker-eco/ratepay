<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Mapper;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentInitTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use Generated\Shared\Transfer\RatepayRequestTransfer;
use Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Ratepay\RatepayDependencyProvider;

/**
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 */
class MapperFactory extends AbstractBusinessFactory implements MapperFactoryInterface
{
    /**
     * @var \Generated\Shared\Transfer\RatepayRequestTransfer
     */
    protected $requestTransfer;

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     */
    public function __construct(RatepayRequestTransfer $requestTransfer)
    {
        $this->requestTransfer = $requestTransfer;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface
     */
    protected function getMoneyFacade()
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createHeadMapper()
    {
        return new HeadMapper(
            $this->getConfig(),
            $this->requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPaymentInitHeadMapper(
        RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
    ) {
        return new PaymentInitHeadMapper(
            $ratepayPaymentInitTransfer,
            $this->getConfig(),
            $this->requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $paymentData
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createQuoteHeadMapper(
        QuoteTransfer $quoteTransfer,
        TransferInterface $paymentData
    ) {
        return new QuoteHeadMapper(
            $quoteTransfer,
            $paymentData,
            $this->getConfig(),
            $this->requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $paymentData
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createOrderHeadMapper(
        OrderTransfer $orderTransfer,
        SpyPaymentRatepay $paymentData
    ) {
        return new OrderHeadMapper(
            $orderTransfer,
            $paymentData,
            $this->getConfig(),
            $this->requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     * @param string $type
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createAddressMapper(
        AddressTransfer $addressTransfer,
        $type
    ) {
        return new AddressMapper(
            $addressTransfer,
            $type,
            $this->requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createBankAccountMapper(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
    ) {
        return new BankAccountMapper(
            $ratepayPaymentRequestTransfer,
            $this->requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createBasketItemMapper(
        ItemTransfer $itemTransfer
    ) {
        return new BasketItemMapper(
            $itemTransfer,
            $this->requestTransfer,
            $this->getMoneyFacade()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createBasketMapper(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
    ) {
        return new BasketMapper(
            $ratepayPaymentRequestTransfer,
            $this->requestTransfer,
            $this->getMoneyFacade()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $partialOrderTransfer
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $ratepayPaymentTransfer
     * @param bool $needToSendShipping
     * @param float|int $discountTaxRate
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPartialBasketMapper(
        OrderTransfer $orderTransfer,
        OrderTransfer $partialOrderTransfer,
        $ratepayPaymentTransfer,
        $needToSendShipping = false,
        $discountTaxRate = 0
    ) {
        return new PartialBasketMapper(
            $orderTransfer,
            $partialOrderTransfer,
            $ratepayPaymentTransfer,
            $needToSendShipping,
            $discountTaxRate,
            $this->requestTransfer,
            $this->getMoneyFacade()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createCustomerMapper(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
    ) {
        return new CustomerMapper(
            $ratepayPaymentRequestTransfer,
            $this->requestTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPaymentMapper(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
    ) {
        return new PaymentMapper(
            $ratepayPaymentRequestTransfer,
            $this->requestTransfer,
            $this->getMoneyFacade()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RatepayPaymentElvTransfer|\Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer $ratepayPaymentTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createInstallmentCalculationMapper(
        QuoteTransfer $quoteTransfer,
        $ratepayPaymentTransfer
    ) {
        return new InstallmentCalculationMapper(
            $quoteTransfer,
            $ratepayPaymentTransfer,
            $this->requestTransfer,
            $this->getMoneyFacade()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createInstallmentDetailMapper(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
    ) {
        return new InstallmentDetailMapper(
            $ratepayPaymentRequestTransfer,
            $this->requestTransfer,
            $this->getMoneyFacade()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createInstallmentPaymentMapper(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
    ) {
        return new InstallmentPaymentMapper(
            $ratepayPaymentRequestTransfer,
            $this->requestTransfer,
            $this->getMoneyFacade()
        );
    }
}
