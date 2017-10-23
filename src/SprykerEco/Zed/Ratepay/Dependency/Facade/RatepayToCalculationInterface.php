<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Dependency\Facade;

interface RatepayToCalculationInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTrasfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderTotalByOrderTransfer($orderTrasfer);
}
