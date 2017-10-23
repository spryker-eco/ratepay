<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model;

interface RequestModelFactoryInterface
{
    /**
     * @param string $modelType
     * @param callable $builder
     *
     * @return $this
     */
    public function registerBuilder($modelType, $builder);

    /**
     * @param string $modelType
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    public function build($modelType);
}
