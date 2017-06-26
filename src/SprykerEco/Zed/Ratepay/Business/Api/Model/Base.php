<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model;

use SprykerEco\Shared\Ratepay\RatepayConstants;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\Head;

abstract class Base extends AbstractRequest
{

    const ROOT_TAG = 'request';

    const OPERATION = '';

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\Head
     */
    protected $head;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Head $head
     */
    public function __construct(Head $head)
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
            '@version' => RatepayConstants::RATEPAY_REQUEST_VERSION,
            '@xmlns' => RatepayConstants::RATEPAY_REQUEST_XMLNS_URN,
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
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Head $head
     *
     * @return $this
     */
    public function setHead(Head $head)
    {
        $this->head = $head;
        return $this;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\Head
     */
    public function getHead()
    {
        return $this->head;
    }

}
