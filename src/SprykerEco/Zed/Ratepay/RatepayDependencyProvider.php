<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToGlossaryBridge;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyBridge;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToProductBridge;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToSalesBridge;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToCalculationBridge;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToSalesQueryContainerBridge;

class RatepayDependencyProvider extends AbstractBundleDependencyProvider
{

    const FACADE_SALES = 'FACADE_SALES';
    const FACADE_CALCULATION = 'FACADE_CALCULATION';
    const FACADE_GLOSSARY = 'GLOSSARY_FACADE';
    const FACADE_PRODUCT = 'FACADE_PRODUCT';
    const FACADE_MONEY = 'FACADE_MONEY';
    const SALES_QUERY_CONTAINER = 'SALES_QUERY_CONTAINER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = $this->addSalesFacade($container);
        $container = $this->addCalculationFacade($container);
        $container = $this->addSalesQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addProductFacade($container);
        $container = $this->addGlossaryFacade($container);
        $container = $this->addMoneyFacade($container);
        $container = $this->addSalesQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesFacade(Container $container)
    {
        $container[static::FACADE_SALES] = function (Container $container) {
            return new RatepayToSalesBridge($container->getLocator()->sales()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCalculationFacade(Container $container)
    {
        $container[static::FACADE_CALCULATION] = function (Container $container) {
            return new RatepayToCalculationBridge($container->getLocator()->calculation()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductFacade(Container $container)
    {
        $container[self::FACADE_PRODUCT] = function (Container $container) {
            return new RatepayToProductBridge($container->getLocator()->product()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addGlossaryFacade(Container $container)
    {
        $container[self::FACADE_GLOSSARY] = function (Container $container) {
            return new RatepayToGlossaryBridge($container->getLocator()->glossary()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addMoneyFacade(Container $container)
    {
        $container[self::FACADE_MONEY] = function (Container $container) {
            return new RatepayToMoneyBridge($container->getLocator()->money()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return Container
     */
    protected function addSalesQueryContainer(Container $container)
    {
        $container[self::SALES_QUERY_CONTAINER] = function (Container $container) {
            return new RatepayToSalesQueryContainerBridge($container->getLocator()->sales()->queryContainer());
        };

        return $container;
    }

}
