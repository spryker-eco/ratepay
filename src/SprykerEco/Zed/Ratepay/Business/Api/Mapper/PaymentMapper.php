<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Mapper;

use Generated\Shared\Transfer\RatepayPaymentRequestTransfer;
use Generated\Shared\Transfer\RatepayRequestPaymentTransfer;
use Generated\Shared\Transfer\RatepayRequestTransfer;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface;

class PaymentMapper extends BaseMapper
{
    /**
     * @var \Generated\Shared\Transfer\RatepayPaymentRequestTransfer
     */
    protected $ratepayPaymentRequestTransfer;

    /**
     * @var \Generated\Shared\Transfer\RatepayRequestTransfer
     */
    protected $requestTransfer;

    /**
     * @var \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface
     */
    protected $moneyFacade;

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     * @param \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToMoneyInterface $moneyFacade
     */
    public function __construct(
        RatepayPaymentRequestTransfer $ratepayPaymentRequestTransfer,
        RatepayRequestTransfer $requestTransfer,
        RatepayToMoneyInterface $moneyFacade
    ) {

        $this->ratepayPaymentRequestTransfer = $ratepayPaymentRequestTransfer;
        $this->requestTransfer = $requestTransfer;
        $this->moneyFacade = $moneyFacade;
    }

    /**
     * @return void
     */
    public function map()
    {
        $grandTotal = $this->moneyFacade->convertIntegerToDecimal((int)$this->ratepayPaymentRequestTransfer->getGrandTotal());

        $this->requestTransfer->setPayment(new RatepayRequestPaymentTransfer())->getPayment()
            ->setCurrency($this->ratepayPaymentRequestTransfer->getCurrencyIso3())
            ->setMethod($this->ratepayPaymentRequestTransfer->getPaymentType())
            ->setAmount($grandTotal);
    }
}
