<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business;

use Codeception\TestCase\Test;
use SprykerEco\Shared\Ratepay\RatepayConstants;
use SprykerTest\Shared\Testify\Helper\ConfigHelper;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group AbstractBusinessTest
 */
abstract class AbstractWithConfigTest extends Test
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $config[RatepayConstants::PROFILE_ID] = '';
        $config[RatepayConstants::SECURITY_CODE] = '';
        $config[RatepayConstants::SNIPPET_ID] = 'ratepay';
        $config[RatepayConstants::SHOP_ID] = '';
        $config[RatepayConstants::SYSTEM_ID] = '';
        $config[RatepayConstants::RATEPAY_API_URL] = '';

        foreach ($config as $key => $value) {
            $this->getConfigHelper()->setConfig($key, $value);
        }
    }

    /**
     * @return \Codeception\Module
     */
    protected function getConfigHelper()
    {
        return $this->getModule('\\' . ConfigHelper::class);
    }
}
