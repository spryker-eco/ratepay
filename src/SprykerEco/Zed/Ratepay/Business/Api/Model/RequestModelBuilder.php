<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model;

class RequestModelBuilder implements RequestModelBuilderInterface
{
    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface[]
     */
    protected $builders;

    /**
     * @param string $modelType
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestInterface $builder
     *
     * @return $this
     */
    public function registerBuilder($modelType, RequestInterface $builder)
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
        return $this->builders[$modelType];
    }
}
