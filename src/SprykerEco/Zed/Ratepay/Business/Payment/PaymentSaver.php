<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Payment;

use Generated\Shared\Transfer\RatepayResponseTransfer;
use SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface;

class PaymentSaver implements PaymentSaverInterface
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface $queryContainer
     */
    public function __construct(
        RatepayQueryContainerInterface $queryContainer
    ) {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\RatepayResponseTransfer $ratepayPaymentResponseTransfer
     * @param int $orderId
     *
     * @return void
     */
    public function updatePaymentMethodByPaymentResponse(RatepayResponseTransfer $ratepayPaymentResponseTransfer, $orderId)
    {
        $paymentMethod = $this->getPaymentMethodByOrderId($orderId);
        if ($paymentMethod) {
            $paymentMethod->setTransactionId($ratepayPaymentResponseTransfer->getTransactionId());
            $paymentMethod->setTransactionShortId($ratepayPaymentResponseTransfer->getTransactionShortId());
            $paymentMethod->setResultCode($ratepayPaymentResponseTransfer->getResultCode());
            $paymentMethod->setDescriptor($ratepayPaymentResponseTransfer->getDescriptor());
            $paymentMethod->save();
        }
    }

    /**
     * @param int $orderId
     *
     * @return \Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay
     */
    protected function getPaymentMethodByOrderId($orderId)
    {
        return $this->queryContainer
            ->queryPayments()
            ->findByFkSalesOrder($orderId)->getFirst();
    }
}
