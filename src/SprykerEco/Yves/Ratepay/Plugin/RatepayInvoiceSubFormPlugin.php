<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay\Plugin;

use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginInterface;

/**
 * @method \SprykerEco\Yves\Ratepay\RatepayFactory getFactory()
 */
class RatepayInvoiceSubFormPlugin extends AbstractPlugin implements SubFormPluginInterface
{
    /**
     * @return \SprykerEco\Yves\Ratepay\Form\InvoiceSubForm
     */
    public function createSubForm()
    {
        return $this->getFactory()->createInvoiceForm();
    }

    /**
     * @return \SprykerEco\Yves\Ratepay\Form\DataProvider\InvoiceDataProvider
     */
    public function createSubFormDataProvider()
    {
        return $this->getFactory()->createInvoiceFormDataProvider();
    }
}
