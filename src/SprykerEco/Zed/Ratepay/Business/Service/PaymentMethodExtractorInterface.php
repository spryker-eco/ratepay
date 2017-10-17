<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Service;

use Generated\Shared\Transfer\QuoteTransfer;

interface PaymentMethodExtractorInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @throws \SprykerEco\Zed\Ratepay\Business\Exception\NoPaymentMethodException
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer|null
     */
    public function extractPaymentMethod(QuoteTransfer $quoteTransfer);

}
