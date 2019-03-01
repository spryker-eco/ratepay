<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use Generated\Shared\Transfer\RatepayResponseTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Payment\Dependency\Plugin\Checkout\CheckoutPreCheckPluginInterface;

/**
 * @method \SprykerEco\Zed\Ratepay\Business\RatepayFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Ratepay\Communication\RatepayCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 * @method \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface getQueryContainer()
 */
class RatepayPreCheckPlugin extends AbstractPlugin implements CheckoutPreCheckPluginInterface
{
    /**
     * @api
     *
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
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function checkCondition(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ) {
        $ratepayPaymentInitTransfer = $this->getFactory()->createPaymentInitTransfer();
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

        $partialOrderTransfer = $this->getPartialOrderTransferByBasketItems($quoteTransfer);

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

        $this->getFacade()->updatePaymentMethodByPaymentResponse(
            $ratepayResponseTransfer,
            $ratepayPaymentRequestTransfer->getOrderId()
        );

        $this->checkForErrors($ratepayResponseTransfer, $checkoutResponseTransfer);
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
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getPartialOrderTransferByBasketItems($quoteTransfer)
    {
        $partialOrderTransfer = $this->getFactory()->createOrderTransfer();
        $items = $this->getFactory()->createOrderTransferItemsByBasketItems($quoteTransfer->getItems());
        $partialOrderTransfer->setItems($items);
        $partialOrderTransfer->setPriceMode($quoteTransfer->getPriceMode());
        $partialOrderTransfer->setTotals($quoteTransfer->getTotals());

        return $this
            ->getFactory()
            ->getCalculationFacade()
            ->getOrderTotalByOrderTransfer($partialOrderTransfer);
    }
}
