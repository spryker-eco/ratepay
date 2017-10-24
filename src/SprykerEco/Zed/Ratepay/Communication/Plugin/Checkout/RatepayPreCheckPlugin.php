<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Plugin\Checkout;

use ArrayObject;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentInitTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use Generated\Shared\Transfer\RatepayResponseTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Payment\Dependency\Plugin\Checkout\CheckoutPreCheckPluginInterface;

/**
 * @method \SprykerEco\Zed\Ratepay\Business\RatepayFacade getFacade()
 * @method \SprykerEco\Zed\Ratepay\Communication\RatepayCommunicationFactory getFactory()
 */
class RatepayPreCheckPlugin extends AbstractPlugin implements CheckoutPreCheckPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function execute(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse)
    {
        return $this->checkCondition($quoteTransfer, $checkoutResponse);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function checkCondition(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ) {
        $ratepayPaymentInitTransfer = $this->createPaymentInitTransfer();
        $quotePaymentInitMapper = $this->getFactory()->createPaymentInitMapperByQuote(
            $ratepayPaymentInitTransfer,
            $quoteTransfer
        );
        $quotePaymentInitMapper->map();

        $ratepayResponseTransfer = $this->getFacade()->initPayment($ratepayPaymentInitTransfer);
        $paymentData = $this->getFactory()
            ->getPaymentMethodExtractor()
            ->extractPaymentMethod($quoteTransfer);
        if ($paymentData) {
            $paymentData
                ->setTransactionId($ratepayResponseTransfer->getTransactionId())
                ->setTransactionShortId($ratepayResponseTransfer->getTransactionShortId())
                ->setResultCode($ratepayResponseTransfer->getStatusCode());
        }

        $partialOrderTransfer = $this->getPartialOrderTransferByBasketItems($quoteTransfer->getItems());

        $ratepayPaymentRequestTransfer = new RatepayPaymentRequestTransfer();
        $quotePaymentInitMapper = $this->getFactory()->createPaymentRequestMapperByQuote(
            $ratepayPaymentRequestTransfer,
            $ratepayPaymentInitTransfer,
            $quoteTransfer,
            $partialOrderTransfer,
            $paymentData
        );
        $quotePaymentInitMapper->map();

        $ratepayResponseTransfer = $this->getFacade()->requestPayment($ratepayPaymentRequestTransfer);

        if ($paymentData) {
            $paymentData->setDescriptor($ratepayResponseTransfer->getDescriptor());
        }

        $this->getFacade()->updatePaymentMethodByPaymentResponse(
            $ratepayResponseTransfer,
            $ratepayPaymentRequestTransfer->getOrderId()
        );
        $this->checkForErrors($ratepayResponseTransfer, $checkoutResponseTransfer);

        return $checkoutResponseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RatepayPaymentInitTransfer
     */
    public function createPaymentInitTransfer()
    {
        return new RatepayPaymentInitTransfer();
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayResponseTransfer $ratepayResponseTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    protected function checkForErrors(RatepayResponseTransfer $ratepayResponseTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        if (!$ratepayResponseTransfer->getSuccessful()) {
            $errorMessage = $ratepayResponseTransfer->getCustomerMessage() != '' ? $ratepayResponseTransfer->getCustomerMessage() :
                $ratepayResponseTransfer->getResultText();

            $error = new CheckoutErrorTransfer();
            $error
                ->setErrorCode($ratepayResponseTransfer->getResultCode())
                ->setMessage($errorMessage);
            $checkoutResponseTransfer->addError($error);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer[] $basketItems
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getPartialOrderTransferByBasketItems($basketItems)
    {
        $partialOrderTransfer = $this->createOrderTransfer();
        $items = $this->createOrderTransferItemsByBasketItems($basketItems);
        $partialOrderTransfer->setItems($items);

        return $this
            ->getFactory()
            ->getCalculationFacade()
            ->getOrderTotalByOrderTransfer($partialOrderTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function createOrderTransfer()
    {
        return new OrderTransfer();
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer[] $basketItems
     *
     * @return \ArrayObject
     */
    public function createOrderTransferItemsByBasketItems($basketItems)
    {
        $items = new ArrayObject();
        foreach ($basketItems as $basketItem) {
            $items[] = $this->createItemTransferByBasketItem($basketItem);
        }

        return $items;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $basketItem
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function createItemTransferByBasketItem($basketItem)
    {
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setIdSalesOrderItem($basketItem->getIdSalesOrderItem());
        $itemTransfer->setUnitGrossPrice($basketItem->getUnitGrossPrice());
        $itemTransfer->setQuantity($basketItem->getQuantity());

        return $itemTransfer;
    }
}
