<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Service\Method;

use SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperFactory;
use SprykerEco\Zed\Ratepay\Business\Api\Model\RequestModelFactoryInterface;
use SprykerEco\Zed\Ratepay\Business\Request\RequestMethodInterface;
use SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface;

abstract class AbstractMethod implements RequestMethodInterface
{

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestModelFactoryInterface
     */
    protected $modelFactory;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperFactory
     */
    protected $mapperFactory;

    /**
     * @var \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface $queryContainer
     */
    protected $queryContainer;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Model\RequestModelFactoryInterface $modelFactory
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Mapper\MapperFactory $mapperFactory
     * @param \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface $queryContainer
     */
    public function __construct(
        RequestModelFactoryInterface $modelFactory,
        MapperFactory $mapperFactory,
        RatepayQueryContainerInterface $queryContainer
    ) {

        $this->modelFactory = $modelFactory;
        $this->mapperFactory = $mapperFactory;
        $this->queryContainer = $queryContainer;
    }

    /**
     * @return void
     */
    protected function mapHeadData()
    {
        $this->mapperFactory
            ->getHeadMapper()
            ->map();
    }

}
