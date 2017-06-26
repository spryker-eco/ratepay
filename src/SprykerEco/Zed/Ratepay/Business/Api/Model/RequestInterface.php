<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model;

interface RequestInterface
{

    /**
     * @return string
     */
    public function toXml();

    /**
     * @return string
     */
    public function __toString();

}
