<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Mapper;

use Generated\Shared\Transfer\RatepayPaymentInitTransfer;
use Generated\Shared\Transfer\RatepayRequestHeadTransfer;
use Generated\Shared\Transfer\RatepayRequestTransfer;
use SprykerEco\Zed\Ratepay\RatepayConfig;

class PaymentInitHeadMapper extends BaseMapper
{
    /**
     * @var \Generated\Shared\Transfer\RatepayPaymentInitTransfer
     */
    protected $ratepayPaymentInitTransfer;

    /**
     * @var \SprykerEco\Zed\Ratepay\RatepayConfig
     */
    protected $config;

    /**
     * @var \Generated\Shared\Transfer\RatepayRequestTransfer
     */
    protected $requestTransfer;

    /**
     * @param \Generated\Shared\Transfer\RatepayPaymentInitTransfer $ratepayPaymentInitTransfer
     * @param \SprykerEco\Zed\Ratepay\RatepayConfig $config
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     */
    public function __construct(
        RatepayPaymentInitTransfer $ratepayPaymentInitTransfer,
        RatepayConfig $config,
        RatepayRequestTransfer $requestTransfer
    ) {
        $this->ratepayPaymentInitTransfer = $ratepayPaymentInitTransfer;
        $this->config = $config;
        $this->requestTransfer = $requestTransfer;
    }

    /**
     * @return void
     */
    public function map()
    {
        $this->requestTransfer->setHead(new RatepayRequestHeadTransfer())->getHead()
            ->setTransactionId($this->ratepayPaymentInitTransfer->getTransactionId())
            ->setTransactionShortId($this->ratepayPaymentInitTransfer->getTransactionShortId())
            ->setCustomerId($this->ratepayPaymentInitTransfer->getCustomerId())
            ->setDeviceFingerprint($this->ratepayPaymentInitTransfer->getDeviceFingerprint())
            ->setSystemId($this->config->getSystemId())
            ->setProfileId($this->config->getProfileId())
            ->setSecurityCode($this->config->getSecurityCode());
    }
}
