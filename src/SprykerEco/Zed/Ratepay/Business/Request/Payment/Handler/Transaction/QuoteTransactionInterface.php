<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Request\Payment\Handler\Transaction;

use Generated\Shared\Transfer\QuoteTransfer;

interface QuoteTransactionInterface extends MethodMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function request(QuoteTransfer $quoteTransfer);
}
