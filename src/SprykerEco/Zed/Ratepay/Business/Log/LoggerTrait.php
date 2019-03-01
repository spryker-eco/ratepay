<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Log;

use Spryker\Shared\Log\LoggerFactory;

trait LoggerTrait
{
    /**
     * @return \Psr\Log\LoggerInterface|null
     */
    protected function getLogger()
    {
        $loggerConfig = new LoggerConfig();

        return LoggerFactory::getInstance($loggerConfig);
    }
}
