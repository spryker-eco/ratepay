<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \SprykerEco\Zed\Ratepay\Business\RatepayFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Ratepay\Communication\RatepayCommunicationFactory getFactory()
 */
class ProfileController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $profileResponse = $this->getFacade()->requestProfile();

        return $this->viewResponse([
            'masterData' => $profileResponse->getMasterData(),
            'installmentConfigurationResult' => $profileResponse->getInstallmentConfigurationResult(),
        ]);
    }
}
