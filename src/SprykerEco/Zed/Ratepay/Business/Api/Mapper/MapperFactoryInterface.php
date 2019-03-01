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
use Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

/**
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 */
interface MapperFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createHeadMapper();

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPaymentInitHeadMapper(RatepayPaymentInitTransfer $ratepayPaymentInitTransfer);

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $paymentData
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createQuoteHeadMapper(QuoteTransfer $quoteTransfer, TransferInterface $paymentData);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay $paymentData
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createOrderHeadMapper(OrderTransfer $orderTransfer, SpyPaymentRatepay $paymentData);

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     * @param string $type
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createAddressMapper(AddressTransfer $addressTransfer, $type);

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createBankAccountMapper(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer);

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createBasketItemMapper(ItemTransfer $itemTransfer);

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createBasketMapper(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $partialOrderTransfer
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $ratepayPaymentTransfer
     * @param bool $needToSendShipping
     * @param float|int $discountTaxRate
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPartialBasketMapper(OrderTransfer $orderTransfer, OrderTransfer $partialOrderTransfer, $ratepayPaymentTransfer, $needToSendShipping = false, $discountTaxRate = 0);

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createCustomerMapper(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer);

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createPaymentMapper(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer);

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RatepayPaymentElvTransfer|\Generated\Shared\Transfer\RatepayPaymentInstallmentTransfer $ratepayPaymentTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createInstallmentCalculationMapper(QuoteTransfer $quoteTransfer, $ratepayPaymentTransfer);

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createInstallmentDetailMapper(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer);

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperInterface
     */
    public function createInstallmentPaymentMapper(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer);
}
