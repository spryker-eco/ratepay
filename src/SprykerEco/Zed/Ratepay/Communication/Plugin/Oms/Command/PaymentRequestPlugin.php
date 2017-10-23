<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Plugin\Oms\Command;

use Generated\Shared\Transfer\RatepayPaymentInitTransfer;
use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

/**
 * @method \SprykerEco\Zed\Ratepay\Business\RatepayFacade getFacade()
 * @method \SprykerEco\Zed\Ratepay\Communication\RatepayCommunicationFactory getFactory()
 */
class PaymentRequestPlugin extends BaseCommandPlugin implements CommandByOrderInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        $ratepayPaymentInitTransfer = new RatepayPaymentInitTransfer();
        $quotePaymentInitMapper = $this->getFactory()->createPaymentInitMapperByOrder(
            $ratepayPaymentInitTransfer,
            $orderEntity
        );
        $quotePaymentInitMapper->map();

        $this->getFacade()->initPayment($ratepayPaymentInitTransfer);

        $partialOrderTransfer = $this->getPartialOrderTransferByOrderItems($orderItems, $orderEntity);

        $ratepayPaymentRequestTransfer = new RatepayPaymentRequestTransfer();
        $quotePaymentRequestMapper = $this->getFactory()->createPaymentRequestMapperByOrder(
            $ratepayPaymentRequestTransfer,
            $ratepayPaymentInitTransfer,
            $this->getOrderTransfer($orderEntity),
            $partialOrderTransfer,
            $orderEntity
        );
        $quotePaymentRequestMapper->map();

        $ratepayResponseTransfer = $this->getFacade()->requestPayment($ratepayPaymentRequestTransfer);
        $this->getFacade()->updatePaymentMethodByPaymentResponse($ratepayResponseTransfer, $ratepayPaymentRequestTransfer->getOrderId());

        return [];
    }
}
