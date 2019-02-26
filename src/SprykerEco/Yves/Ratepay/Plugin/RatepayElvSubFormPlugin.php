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
class RatepayElvSubFormPlugin extends AbstractPlugin implements SubFormPluginInterface
{
    /**
     * @return \SprykerEco\Yves\Ratepay\Form\ElvSubForm
     */
    public function createSubForm()
    {
        return $this->getFactory()->createElvForm();
    }

    /**
     * @return \SprykerEco\Yves\Ratepay\Form\DataProvider\ElvDataProvider
     */
    public function createSubFormDataProvider()
    {
        return $this->getFactory()->createElvFormDataProvider();
    }
}
