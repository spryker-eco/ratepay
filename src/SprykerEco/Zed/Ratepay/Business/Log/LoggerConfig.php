<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Log;

use Spryker\Shared\Log\Config\LoggerConfigInterface;

class LoggerConfig implements LoggerConfigInterface
{
    /**
     * @return string
     */
    public function getChannelName()
    {
        return "ratepayLogger";
    }

    /**
     * @return \Monolog\Handler\HandlerInterface[]
     */
    public function getHandlers()
    {
        return [
            new LogHandler(new PaymentLogger()),
        ];
    }

    /**
     * @return \callable[]
     */
    public function getProcessors()
    {
        return [];
    }
}
