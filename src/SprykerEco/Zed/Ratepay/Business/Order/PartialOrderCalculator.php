<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Order;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface;
use SprykerEco\Zed\Ratepay\Business\Exception\OrderTotalHydrationException;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToCalculationInterface;

class PartialOrderCalculator implements PartialOrderCalculatorInterface
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToCalculationInterface
     */
    protected $ratepayToCalculationBridge;

    /**
     * @var \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    protected $salesQueryContainer;

    /**
     * @param \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToCalculationInterface $ratepayToCalculationBridge
     * @param \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface $salesQueryContainer
     */
    public function __construct(
        RatepayToCalculationInterface $ratepayToCalculationBridge,
        SalesQueryContainerInterface $salesQueryContainer
    ) {

        $this->ratepayToCalculationBridge = $ratepayToCalculationBridge;
        $this->salesQueryContainer = $salesQueryContainer;
    }

    /**
     * @param int $idSalesOrderItem
     *
     * @throws \SprykerEco\Zed\Ratepay\Business\Exception\OrderTotalHydrationException
     *
     * @return \Generated\Shared\Transfer\ItemTransfer|null
     */
    public function getOrderItemTotalsByIdSalesOrderItem($idSalesOrderItem)
    {
        $salesOrderItemEntity = $this->salesQueryContainer
            ->querySalesOrderItem()
            ->findOneByIdSalesOrderItem($idSalesOrderItem);

        if ($salesOrderItemEntity === null) {
            throw new OrderTotalHydrationException(
                sprintf('Order item with id "%d" not found!', $idSalesOrderItem)
            );
        }

        $orderTransfer = $this->createOrderTransfer($salesOrderItemEntity);

        $orderTransfer = $this->ratepayToCalculationBridge->getOrderTotalByOrderTransfer($orderTransfer);

        $items = $orderTransfer->getItems();
        return $items->count() > 0 ? $items[0] : null;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $salesOrderItemEntity
     *
     * @throws \SprykerEco\Zed\Ratepay\Business\Exception\OrderTotalHydrationException
     *
     * @return \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     */
    protected function createOrderTransfer($salesOrderItemEntity)
    {
        $salesOrderEntity = $this->salesQueryContainer
            ->querySalesOrder()
            ->findOneByIdSalesOrder(
                $salesOrderItemEntity->getFkSalesOrder()
            );

        if ($salesOrderEntity !== null) {
            throw new OrderTotalHydrationException(
                sprintf('Order with id "%d" not found!', $salesOrderItemEntity->getFkSalesOrder())
            );
        }

        $itemTransfer = $this->getHydratedSaleOrderItemTransfer($salesOrderItemEntity);

        $orderTransfer = new OrderTransfer();
        $orderTransfer->addItem($itemTransfer);
        $orderTransfer->setPriceMode($salesOrderEntity->getPriceMode());
        $orderTransfer->setTotals(new TotalsTransfer());

        return $orderTransfer;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $salesOrderItemEntity
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function getHydratedSaleOrderItemTransfer($salesOrderItemEntity)
    {
        $itemTransfer = new ItemTransfer();
        $itemTransfer->fromArray($salesOrderItemEntity->toArray(), true);
        $itemTransfer->setUnitGrossPrice($salesOrderItemEntity->getGrossPrice());

        return $itemTransfer;
    }
}
