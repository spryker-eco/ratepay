<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Ratepay\RatepayConfig as SharedRatepayConfig;
use SprykerEco\Shared\Ratepay\RatepayConstants;

class RatepayConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getTransactionGatewayUrl()
    {
        return $this->get(RatepayConstants::RATEPAY_API_URL);
    }

    /**
     * @return string
     */
    public function getProfileId()
    {
        return $this->get(RatepayConstants::PROFILE_ID);
    }

    /**
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->get(RatepayConstants::SECURITY_CODE);
    }

    /**
     * @return string
     */
    public function getSystemId()
    {
        return $this->get(RatepayConstants::SYSTEM_ID);
    }

    /**
     * @return string
     */
    public function getSnippedId()
    {
        return $this->get(RatepayConstants::SNIPPET_ID);
    }

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->get(RatepayConstants::SHOP_ID);
    }

    /**
     * @return string
     */
    public function getTranslationFilePath()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . SharedRatepayConfig::GLOSSARY_FILE_PATH;
    }
}
