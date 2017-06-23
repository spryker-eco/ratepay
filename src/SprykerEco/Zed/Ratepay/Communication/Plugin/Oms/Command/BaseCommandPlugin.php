<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Plugin\Oms\Command;

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
            ->getSales()
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
        $partialOrderTransfer = $this->getFactory()->createOrderTransfer();
        $items = $this->getFactory()->createOrderTransferItems($orderItems);
        $partialOrderTransfer->setItems($items);
        $partialOrderTransfer = $this->getFilledOrderTransfer($partialOrderTransfer, $orderEntity);

        return $this
            ->getFactory()
            ->getCalculation()
            ->getOrderTotalByOrderTransfer($partialOrderTransfer);
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
