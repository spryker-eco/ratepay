<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Method;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayPaymentInitTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;

interface MethodInterface
{
    /**
     * @return string
     */
    public function getMethodName();

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function getPaymentData(QuoteTransfer $quoteTransfer);

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Init
     */
    public function paymentInit(RatepayPaymentInitTransfer $ratepayPaymentInitTransfer);

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request
     */
    public function paymentRequest(RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request
     */
    public function paymentConfirm(OrderTransfer $orderTransfer);

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $partialOrderTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request
     */
    public function deliveryConfirm(
        OrderTransfer $orderTransfer,
        OrderTransfer $partialOrderTransfer,
        array $orderItems
    );

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $partialOrderTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request
     */
    public function paymentCancel(
        OrderTransfer $orderTransfer,
        OrderTransfer $partialOrderTransfer,
        array $orderItems
    );

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $partialOrderTransfer
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Request
     */
    public function paymentRefund(
        OrderTransfer $orderTransfer,
        OrderTransfer $partialOrderTransfer,
        array $orderItems
    );
}
