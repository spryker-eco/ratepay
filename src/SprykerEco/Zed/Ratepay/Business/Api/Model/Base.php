<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model;

use SprykerEco\Shared\Ratepay\RatepayConfig;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface;

abstract class Base extends AbstractRequest
{
    const ROOT_TAG = 'request';
    const CONTENT = 'content';

    const OPERATION = '';

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface
     */
    protected $head;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface $head
     */
    public function __construct(HeadInterface $head)
    {
        $this->head = $head;
    }

    /**
     * @return array
     */
    protected function buildData()
    {
        $this->getHead()->setOperation(static::OPERATION);
        return [
            '@version' => RatepayConfig::RATEPAY_REQUEST_VERSION,
            '@xmlns' => RatepayConfig::RATEPAY_REQUEST_XMLNS_URN,
            $this->getHead()->getRootTag() => $this->getHead(),
        ];
    }

    /**
     * @return string
     */
    public function getRootTag()
    {
        return static::ROOT_TAG;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface
     */
    public function getHead()
    {
        return $this->head;
    }
}
