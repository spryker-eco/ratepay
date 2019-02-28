<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Dependency\Injector;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Dependency\Injector\AbstractDependencyInjector;
use Spryker\Zed\Payment\Dependency\Plugin\Checkout\CheckoutPluginCollection;
use Spryker\Zed\Payment\PaymentDependencyProvider;
use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEco\Zed\Ratepay\Communication\Plugin\Checkout\RatepayPostCheckPlugin;
use SprykerEco\Zed\Ratepay\Communication\Plugin\Checkout\RatepaySaveOrderPlugin;

class PaymentDependencyInjector extends AbstractDependencyInjector
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function injectBusinessLayerDependencies(Container $container)
    {
        $container = $this->injectPaymentPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function injectPaymentPlugins(Container $container)
    {
        $container->extend(PaymentDependencyProvider::CHECKOUT_PLUGINS, function (CheckoutPluginCollection $pluginCollection) {
            $pluginCollection->add(new RatepaySaveOrderPlugin(), RatepayConfig::PROVIDER_NAME, PaymentDependencyProvider::CHECKOUT_ORDER_SAVER_PLUGINS);
            $pluginCollection->add(new RatepayPostCheckPlugin(), RatepayConfig::PROVIDER_NAME, PaymentDependencyProvider::CHECKOUT_POST_SAVE_PLUGINS);

            return $pluginCollection;
        });

        return $container;
    }
}
