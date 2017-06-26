<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Builder;

use Generated\Shared\Transfer\RatepayRequestTransfer;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;

/**
 * @method \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface getQueryContainer()
 */
class BuilderFactory
{

    /**
     * @var \Generated\Shared\Transfer\RatepayRequestTransfer
     */
    protected $requestTransfer;

    /**
     * @param \Generated\Shared\Transfer\RatepayRequestTransfer $requestTransfer
     */
    public function __construct(RatepayRequestTransfer $requestTransfer)
    {
        $this->requestTransfer = $requestTransfer;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\Customer
     */
    public function createCustomer()
    {
        return new Customer(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\Address
     */
    public function createCustomerAddress()
    {
        return new Address(
            $this->requestTransfer,
            Constants::REQUEST_MODEL_ADDRESS_TYPE_BILLING
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\BankAccount
     */
    public function createBankAccount()
    {
        return new BankAccount(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\Head
     */
    public function createHead()
    {
        return new Head(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\Payment
     */
    public function createPayment()
    {
        return new Payment(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket
     */
    public function createShoppingBasket()
    {
        return new ShoppingBasket(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketItem
     */
    public function createShoppingBasketItem()
    {
        return new ShoppingBasketItem(
            $this->requestTransfer,
            0
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculation
     */
    public function createInstallmentCalculation()
    {
        return new InstallmentCalculation(
            $this->requestTransfer
        );
    }

}
