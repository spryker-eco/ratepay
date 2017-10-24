<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model\Payment;

use SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculationInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Base;

class Calculation extends Base
{
    const OPERATION = Constants::REQUEST_MODEL_CALCULATION_REQUEST;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculationInterface
     */
    protected $installmentCalculation;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface $head
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculationInterface $installmentCalculation
     */
    public function __construct(HeadInterface $head, InstallmentCalculationInterface $installmentCalculation)
    {
        parent::__construct($head);
        $this->installmentCalculation = $installmentCalculation;
    }

    /**
     * @return array
     */
    protected function buildData()
    {
        $result = parent::buildData();
        $result[self::CONTENT] = [
            $this->getInstallmentCalculation()->getRootTag() => $this->getInstallmentCalculation(),
        ];

        return $result;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculationInterface
     */
    public function getInstallmentCalculation()
    {
        return $this->installmentCalculation;
    }
}
