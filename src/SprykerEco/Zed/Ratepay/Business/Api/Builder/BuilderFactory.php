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
class BuilderFactory implements BuilderFactoryInterface
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
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\CustomerInterface
     */
    public function createCustomer()
    {
        return new Customer(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\AddressInterface
     */
    public function createCustomerAddress()
    {
        return new Address(
            $this->requestTransfer,
            Constants::REQUEST_MODEL_ADDRESS_TYPE_BILLING
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\BankAccountInterface
     */
    public function createBankAccount()
    {
        return new BankAccount(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface
     */
    public function createHead()
    {
        return new Head(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\PaymentInterface
     */
    public function createPayment()
    {
        return new Payment(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface
     */
    public function createShoppingBasket()
    {
        return new ShoppingBasket(
            $this->requestTransfer
        );
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\InstallmentCalculationInterface
     */
    public function createInstallmentCalculation()
    {
        return new InstallmentCalculation(
            $this->requestTransfer
        );
    }
}
