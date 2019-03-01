<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerEco\Yves\Ratepay\Form\DataProvider\ElvDataProvider;
use SprykerEco\Yves\Ratepay\Form\DataProvider\InstallmentDataProvider;
use SprykerEco\Yves\Ratepay\Form\DataProvider\InvoiceDataProvider;
use SprykerEco\Yves\Ratepay\Form\DataProvider\PrepaymentDataProvider;
use SprykerEco\Yves\Ratepay\Form\ElvSubForm;
use SprykerEco\Yves\Ratepay\Form\InstallmentSubForm;
use SprykerEco\Yves\Ratepay\Form\InvoiceSubForm;
use SprykerEco\Yves\Ratepay\Form\PrepaymentSubForm;
use SprykerEco\Yves\Ratepay\Handler\RatepayHandler;

/**
 * @method \SprykerEco\Zed\Ratepay\RatepayConfig getConfig()
 */
class RatepayFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Yves\Ratepay\Handler\RatepayHandlerInterface
     */
    public function createRatepayHandler()
    {
        return new RatepayHandler(
            $this->getRatepayClient()
        );
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createInvoiceForm()
    {
        return new InvoiceSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createInvoiceFormDataProvider()
    {
        return new InvoiceDataProvider();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createElvForm()
    {
        return new ElvSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createElvFormDataProvider()
    {
        return new ElvDataProvider();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createPrepaymentForm()
    {
        return new PrepaymentSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createPrepaymentFormDataProvider()
    {
        return new PrepaymentDataProvider();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createInstallmentForm()
    {
        return new InstallmentSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createInstallmentFormDataProvider()
    {
        return new InstallmentDataProvider(
            $this->getRatepayClient(),
            $this->getSessionClient()
        );
    }

    /**
     * @return \SprykerEco\Client\Ratepay\RatepayClientInterface
     */
    public function getRatepayClient()
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::CLIENT_RATEPAY);
    }

    /**
     * @return \Spryker\Client\Session\SessionClientInterface
     */
    protected function getSessionClient()
    {
        return $this->getProvidedDependency(RatepayDependencyProvider::CLIENT_SESSION);
    }
}
