<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Order;

interface SaverInterface
{
    /**
     * @return void
     */
    public function saveOrderPayment();
}
