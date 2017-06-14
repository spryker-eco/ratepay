<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace SprykerEco\Zed\Ratepay\Business\Request\Service\Method;

interface MethodInterface
{

    /**
     * @return string
     */
    public function getMethodName();

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\Payment\Init
     */
    public function profile();

}
