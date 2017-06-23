<?php
/**
 * Created by PhpStorm.
 * User: sikachev
 * Date: 6/23/17
 * Time: 11:22 AM
 */

namespace SprykerEco\Zed\Ratepay\Business\Order;

interface PartialOrderCalculatorInterface
{

    /**
     * @param int $idSalesOrderItem
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function getOrderItemTotalsByIdSalesOrderItem($idSalesOrderItem);

}