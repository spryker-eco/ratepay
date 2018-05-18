<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\SprykerEco\Zed\Ratepay\Business\Api\Adapter\Http;

class TransferAdapterMock extends AbstractAdapterMock
{
    /**
     * @return array
     */
    public function getSuccessResponse()
    {
        return $this->requestData;
    }

    /**
     * @return array
     */
    public function getFailureResponse()
    {
        return $this->requestData;
    }
}
