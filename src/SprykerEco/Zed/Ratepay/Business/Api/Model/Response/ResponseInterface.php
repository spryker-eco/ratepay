<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model\Response;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function getTransactionId();

    /**
     * @return string
     */
    public function getTransactionShortId();

    /**
     * @return bool
     */
    public function isSuccessful();

    /**
     * @return string
     */
    public function getStatusCode();

    /**
     * @return string
     */
    public function getStatusText();

    /**
     * @return int
     */
    public function getReasonCode();

    /**
     * @return string
     */
    public function getReasonText();

    /**
     * @return int
     */
    public function getResultCode();

    /**
     * @return string
     */
    public function getResultText();

    /**
     * @return string
     */
    public function getResponseType();

    /**
     * @return string
     */
    public function getCustomerMessage();

    /**
     * @return string
     */
    public function getPaymentMethod();
}
