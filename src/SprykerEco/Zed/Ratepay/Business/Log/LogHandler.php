<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Log;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LogHandler extends AbstractProcessingHandler
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param bool|int $level
     * @param bool $bubble
     */
    public function __construct(LoggerInterface $logger, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->logger = $logger;
    }

    /**
     * @param array $record
     *
     * @return void
     */
    protected function write(array $record)
    {
        $this->logger->info($record['message'], $record['context']);
    }
}
