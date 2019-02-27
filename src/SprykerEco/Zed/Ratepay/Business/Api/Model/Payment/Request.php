<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model\Payment;

use SprykerEco\Zed\Ratepay\Business\Api\Builder\Customer;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\CustomerInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\Payment;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\PaymentInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Base;

class Request extends Base
{
    public const OPERATION = Constants::REQUEST_MODEL_PAYMENT_REQUEST;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\CustomerInterface
     */
    protected $customer;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface
     */
    protected $basket;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\PaymentInterface
     */
    protected $payment;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface $head
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\CustomerInterface $customer
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface $basket
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\PaymentInterface $payment
     */
    public function __construct(
        HeadInterface $head,
        CustomerInterface $customer,
        ShoppingBasketInterface $basket,
        PaymentInterface $payment
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
        $result[self::CONTENT] = [
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
