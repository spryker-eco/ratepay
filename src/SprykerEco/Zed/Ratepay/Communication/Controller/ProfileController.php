<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \SprykerEco\Zed\Ratepay\Business\RatepayFacade getFacade()
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
