<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction;

use SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface;

interface MethodMapperInterface
{
    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface $mapper
     *
     * @return void
     */
    public function registerMethodMapper(RequestMethodInterface $mapper);
}
