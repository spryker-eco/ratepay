<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Dependency\Facade;

interface RatepayToMoneyInterface
{

    /**
     * @param float $value
     *
     * @return int
     */
    public function convertDecimalToInteger($value);

    /**
     * @param int $value
     *
     * @return float
     */
    public function convertIntegerToDecimal($value);

}
