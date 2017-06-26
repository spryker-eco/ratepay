<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay\Dependency\Injector;

use Spryker\Shared\Kernel\ContainerInterface;
use Spryker\Shared\Kernel\Dependency\Injector\DependencyInjectorInterface;
use SprykerEco\Shared\Ratepay\RatepayConstants;
use Spryker\Yves\Checkout\CheckoutDependencyProvider;
use SprykerEco\Yves\Ratepay\Plugin\RatepayElvSubFormPlugin;
use SprykerEco\Yves\Ratepay\Plugin\RatepayHandlerPlugin;
use SprykerEco\Yves\Ratepay\Plugin\RatepayInstallmentSubFormPlugin;
use SprykerEco\Yves\Ratepay\Plugin\RatepayInvoiceSubFormPlugin;
use SprykerEco\Yves\Ratepay\Plugin\RatepayPrepaymentSubFormPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;

class CheckoutDependencyInjector implements DependencyInjectorInterface
{

    /**
     * @param \Spryker\Shared\Kernel\ContainerInterface|\Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Shared\Kernel\ContainerInterface|\Spryker\Yves\Kernel\Container
     */
    public function inject(ContainerInterface $container)
    {
        $container = $this->injectPaymentSubForms($container);
        $container = $this->injectPaymentMethodHandler($container);

        return $container;
    }

    /**
     * @param \Spryker\Shared\Kernel\ContainerInterface $container
     *
     * @return \Spryker\Shared\Kernel\ContainerInterface
     */
    protected function injectPaymentSubForms(ContainerInterface $container)
    {
        $container->extend(CheckoutDependencyProvider::PAYMENT_SUB_FORMS, function (SubFormPluginCollection $paymentSubForms) {
            $paymentSubForms->add(new RatepayElvSubFormPlugin());
            $paymentSubForms->add(new RatepayInstallmentSubFormPlugin());
            $paymentSubForms->add(new RatepayInvoiceSubFormPlugin());
            $paymentSubForms->add(new RatepayPrepaymentSubFormPlugin());

            return $paymentSubForms;
        });

        return $container;
    }

    /**
     * @param \Spryker\Shared\Kernel\ContainerInterface $container
     *
     * @return \Spryker\Shared\Kernel\ContainerInterface
     */
    protected function injectPaymentMethodHandler(ContainerInterface $container)
    {
        $container->extend(CheckoutDependencyProvider::PAYMENT_METHOD_HANDLER, function (StepHandlerPluginCollection $paymentMethodHandler) {
            $ratepayHandlerPlugin = new RatepayHandlerPlugin();

            $paymentMethodHandler->add($ratepayHandlerPlugin, RatepayConstants::PAYMENT_METHOD_ELV);
            $paymentMethodHandler->add($ratepayHandlerPlugin, RatepayConstants::PAYMENT_METHOD_INSTALLMENT);
            $paymentMethodHandler->add($ratepayHandlerPlugin, RatepayConstants::PAYMENT_METHOD_INVOICE);
            $paymentMethodHandler->add($ratepayHandlerPlugin, RatepayConstants::PAYMENT_METHOD_PREPAYMENT);

            return $paymentMethodHandler;
        });

        return $container;
    }

}
