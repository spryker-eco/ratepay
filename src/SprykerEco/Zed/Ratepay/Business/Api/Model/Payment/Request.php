<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model\Payment;

use SprykerEco\Zed\Ratepay\Business\Api\Builder\Customer;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\Head;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\Payment;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Base;

class Request extends Base
{

    const OPERATION = Constants::REQUEST_MODEL_PAYMENT_REQUEST;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\Customer
     */
    protected $customer;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket
     */
    protected $basket;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\Payment
     */
    protected $payment;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Head $head
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Customer $customer
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket $basket
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Payment $payment
     */
    public function __construct(
        Head $head,
        Customer $customer,
        ShoppingBasket $basket,
        Payment $payment
    ) {

        parent::__construct($head);
        $this->customer = $customer;
        $this->basket = $basket;
        $this->payment = $payment;
    }

    /**
     * @return array
     */
    protected function buildData()
    {
        $result = parent::buildData();
        $result['content'] = [
            $this->getCustomer()->getRootTag() => $this->getCustomer(),
            $this->getShoppingBasket()->getRootTag() => $this->getShoppingBasket(),
            $this->getPayment()->getRootTag() => $this->getPayment(),
        ];

        return $result;
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Customer $customer
     *
     * @return $this
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket $basket
     *
     * @return $this
     */
    public function setShoppingBasket(ShoppingBasket $basket)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket
     */
    public function getShoppingBasket()
    {
        return $this->basket;
    }

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Payment $payment
     *
     * @return $this
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

}
