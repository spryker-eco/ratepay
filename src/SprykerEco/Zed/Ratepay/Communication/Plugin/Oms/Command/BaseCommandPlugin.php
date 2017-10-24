<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Plugin\Oms\Command;

use ArrayObject;
use Generated\Shared\Transfer\CalculatedDiscountTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

/**
 * @method \SprykerEco\Zed\Ratepay\Business\RatepayFacade getFacade()
 * @method \SprykerEco\Zed\Ratepay\Communication\RatepayCommunicationFactory getFactory()
 */
abstract class BaseCommandPlugin extends AbstractPlugin implements CommandByOrderInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getOrderTransfer(SpySalesOrder $orderEntity)
    {
        return $this
            ->getFactory()
            ->getSalesFacade()
            ->getOrderTotalsByIdSalesOrder($orderEntity->getIdSalesOrder());
    }

    /**
     * @param int $idSalesOrderItem
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function getOrderItemTotalsByIdSalesOrderItem($idSalesOrderItem)
    {
        return $this
            ->getFactory()
            ->createPartialOrderCalculator()
            ->getOrderItemTotalsByIdSalesOrderItem($idSalesOrderItem);
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getPartialOrderTransferByOrderItems($orderItems, SpySalesOrder $orderEntity)
    {
        $partialOrderTransfer = $this->createOrderTransfer();
        $items = $this->createOrderTransferItems($orderItems);
        $partialOrderTransfer->setItems($items);
        $partialOrderTransfer = $this->getFilledOrderTransfer($partialOrderTransfer, $orderEntity);

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
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return \ArrayObject
     */
    protected function createOrderTransferItems(array $orderItems)
    {
        $items = new ArrayObject();
        foreach ($orderItems as $orderItemEntity) {
            $items[] = $this->createItemTransferByItemEntity($orderItemEntity);
        }

        return $items;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItemEntity
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function createItemTransferByItemEntity($orderItemEntity)
    {
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setIdSalesOrderItem($orderItemEntity->getIdSalesOrderItem());
        $itemTransfer->setUnitGrossPrice($orderItemEntity->getGrossPrice());
        $itemTransfer->setQuantity($orderItemEntity->getQuantity());
        $itemTransfer->setCalculatedDiscounts(
            new ArrayObject($this->getCalculatedDiscounts($orderItemEntity))
        );

        return $itemTransfer;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItemEntity
     *
     * @return array
     */
    protected function getCalculatedDiscounts($orderItemEntity)
    {
        $result = [];
        $discounts = $orderItemEntity->getDiscounts();
        foreach ($discounts as $discount) {
            $calculatedDiscountTransfer = new CalculatedDiscountTransfer();
            $calculatedDiscountTransfer
                ->setDescription($discount->getDescription())
                ->setDisplayName($discount->getDisplayName())
                ->setUnitAmount($discount->getAmount())
                ->setIdDiscount($discount->getIdSalesDiscount())
                ->setQuantity($orderItemEntity->getQuantity());
            $result[] = $calculatedDiscountTransfer;
        }

        return $result;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $partialOrderTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getFilledOrderTransfer($partialOrderTransfer, $orderEntity)
    {
        $partialOrderTransfer->setPriceMode($orderEntity->getPriceMode());
        $partialOrderTransfer->setTotals($this->getTotalsTransfer($orderEntity));

        return $partialOrderTransfer;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\TotalsTransfer
     */
    protected function getTotalsTransfer($orderEntity)
    {
        $totalsTransfer = new TotalsTransfer();
        $lastTotals = $orderEntity->getLastOrderTotals();
        $totalsTransfer
            ->setGrandTotal($lastTotals->getGrandTotal())
            ->setSubtotal($lastTotals->getSubtotal())
            ->setDiscountTotal($lastTotals->getDiscountTotal())
            ->setExpenseTotal($lastTotals->getOrderExpenseTotal());

        return $totalsTransfer;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return \Generated\Shared\Transfer\ItemTransfer[]
     */
    protected function getOrderItemsTransfer(array $orderItems)
    {
        $orderTransferItems = [];
        foreach ($orderItems as $orderItem) {
            $orderTransferItems[$orderItem->getIdSalesOrderItem()] = $this
                ->getOrderItemTotalsByIdSalesOrderItem($orderItem->getIdSalesOrderItem());
        }

        return $orderTransferItems;
    }
}
