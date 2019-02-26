<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model;

class RequestModelFactory implements RequestModelFactoryInterface
{
    /**
     * @var callable[]
     */
    protected $builders;

    /**
     * @param string $modelType
     * @param object $builder
     *
     * @return $this
     */
    public function registerBuilder($modelType, $builder)
    {
        $this->builders[$modelType] = $builder;
        return $this;
    }

    /**
     * @param string $modelType
     *
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface
     */
    public function build($modelType)
    {
        $builder = $this->builders[$modelType];

        return $builder;
    }
}
