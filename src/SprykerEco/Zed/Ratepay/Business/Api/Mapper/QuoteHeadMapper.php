<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RatepayRequestHeadTransfer;
use Generated\Shared\Transfer\RatepayRequestTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use SprykerEco\Zed\Ratepay\RatepayConfig;

class QuoteHeadMapper extends BaseMapper
{

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransfer;

    /**
     * @var \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    protected $paymentData;

    /**
     * @var \SprykerEco\Zed\Ratepay\RatepayConfig
     */
    protected $config;

    /**
     * @var \Generated\Shared\Transfer\RatepayRequestTransfer
     */
    protected $requestTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $paymentData
     * @param \SprykerEco\Zed\Ratepay\RatepayConfig $config
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     */
    public function __construct(
        QuoteTransfer $quoteTransfer,
        TransferInterface $paymentData,
        RatepayConfig $config,
        RatepayRequestTransfer $requestTransfer
    ) {
        $this->quoteTransfer = $quoteTransfer;
        $this->paymentData = $paymentData;
        $this->config = $config;
        $this->requestTransfer = $requestTransfer;
    }

    /**
     * @return void
     */
    public function map()
    {
        $this->requestTransfer->setHead(new RatepayRequestHeadTransfer())->getHead()
            ->setTransactionId($this->paymentData->getTransactionId())
            ->setTransactionShortId($this->paymentData->getTransactionShortId())
            ->setCustomerId($this->quoteTransfer->getCustomer()->getIdCustomer())
            ->setDeviceFingerprint($this->paymentData->getDeviceFingerprint())
            ->setSystemId($this->config->getSystemId())
            ->setProfileId($this->config->getProfileId())
            ->setSecurityCode($this->config->getSecurityCode());
    }

}
