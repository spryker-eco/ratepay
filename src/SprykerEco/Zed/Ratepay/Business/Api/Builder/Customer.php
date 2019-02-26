<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Builder;

use SprykerEco\Zed\Ratepay\Business\Api\Constants;

/**
 * Class Customer
 * @package SprykerEco\Zed\Ratepay\Business\Api\Builder
 */
class Customer extends AbstractBuilder implements BuilderInterface
{
    const ROOT_TAG = 'customer';

    /**
     * @return array
     */
    public function buildData()
    {
        $customerData = [
            'first-name' => $this->requestTransfer->getCustomer()->getFirstName(),
            'last-name' => $this->requestTransfer->getCustomer()->getLastName(),
            'gender' => $this->requestTransfer->getCustomer()->getGender(),
            'date-of-birth' => $this->requestTransfer->getCustomer()->getDob(),
            'ip-address' => $this->requestTransfer->getCustomer()->getIpAddress(),
            'contacts' => [
                'email' => $this->requestTransfer->getCustomer()->getEmail(),
                'phone' => [
                    'direct-dial' => $this->requestTransfer->getCustomer()->getPhone(),
                ],
            ],
            'addresses' => [
                (new Address($this->requestTransfer, Constants::REQUEST_MODEL_ADDRESS_TYPE_BILLING)),
                (new Address($this->requestTransfer, Constants::REQUEST_MODEL_ADDRESS_TYPE_DELIVERY)),
            ],
            'customer-allow-credit-inquiry' => $this->requestTransfer->getCustomer()->getAllowCreditInquiry(),
        ];
        if (strlen($this->requestTransfer->getCustomer()->getCompany())) {
            $customerData['company-name'] = $this->requestTransfer->getCustomer()->getCompany();
        }

        if ($this->requestTransfer->getBankAccount() !== null) {
            $bankAccountBuilder = new BankAccount($this->requestTransfer);
            $customerData[$bankAccountBuilder->getRootTag()] = $bankAccountBuilder;
        }

        return $customerData;
    }

    /**
     * @return string
     */
    public function getRootTag()
    {
        return static::ROOT_TAG;
    }
}
