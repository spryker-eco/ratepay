<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Builder;

interface HeadInterface extends BuilderInterface
{
    /**
     * @param string $operation
     *
     * @return void
     */
    public function setOperation($operation);

    /**
     * @param string $subOperation
     *
     * @return void
     */
    public function setOperationSubstring($subOperation);
}
