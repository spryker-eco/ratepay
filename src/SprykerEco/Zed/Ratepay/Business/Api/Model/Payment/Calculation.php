<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model\Payment;

use SprykerEco\Zed\Ratepay\Business\Api\Builder\Head;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculation;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Base;

class Calculation extends Base
{

    const OPERATION = Constants::REQUEST_MODEL_CALCULATION_REQUEST;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculation
     */
    protected $installmentCalculation;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Head $head
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculation $installmentCalculation
     */
    public function __construct(Head $head, InstallmentCalculation $installmentCalculation)
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
        $result['content'] = [
            $this->getInstallmentCalculation()->getRootTag() => $this->getInstallmentCalculation(),
        ];

        return $result;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculation
     */
    public function getInstallmentCalculation()
    {
        return $this->installmentCalculation;
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculation $installmentCalculation
     *
     * @return $this
     */
    public function setInstallmentCalculation($installmentCalculation)
    {
        $this->installmentCalculation = $installmentCalculation;

        return $this;
    }

}
