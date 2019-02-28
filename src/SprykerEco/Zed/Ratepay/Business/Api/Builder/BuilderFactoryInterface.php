<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Builder;

/**
 * @method \SprykerEco\Zed\Ratepay\Persistence\RatepayQueryContainerInterface getQueryContainer()
 */
interface BuilderFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\CustomerInterface
     */
    public function createCustomer();

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\AddressInterface
     */
    public function createCustomerAddress();

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\BankAccountInterface
     */
    public function createBankAccount();

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface
     */
    public function createHead();

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\PaymentInterface
     */
    public function createPayment();

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface
     */
    public function createShoppingBasket();

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculationInterface
     */
    public function createInstallmentCalculation();
}
