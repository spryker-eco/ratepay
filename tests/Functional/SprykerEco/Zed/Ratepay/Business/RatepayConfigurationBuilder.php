<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Functional\SprykerEco\Zed\Ratepay\Business;

use SprykerEco\Shared\Ratepay\RatepayConstants;

class RatepayConfigurationBuilder
{
    /**
     * @return array
     */
    public function getRatepayConfigurationOptions(): array
    {
        $config[RatepayConstants::API_URL] = 'http://api.url';
        $config[RatepayConstants::SYSTEM_ID] = 'system-id';
        $config[RatepayConstants::PROFILE_ID] = 'profile-id';
        $config[RatepayConstants::SECURITY_CODE] = 'security-code';

        return $config;
    }
}
