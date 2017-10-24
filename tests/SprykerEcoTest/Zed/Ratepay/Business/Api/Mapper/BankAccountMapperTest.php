<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Api\Mapper;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Api
 * @group Mapper
 * @group BankAccountMapperTest
 */
class BankAccountMapperTest extends AbstractMapperTest
{
    /**
     * @return void
     */
    public function testMapper()
    {
        $this->mapperFactory
            ->createBankAccountMapper(
                $this->mockRatepayPaymentRequestTransfer()
            )
            ->map();

        $this->assertEquals('iban', $this->requestTransfer->getBankAccount()->getIban());
        $this->assertEquals('bic', $this->requestTransfer->getBankAccount()->getBicSwift());
        $this->assertEquals('fn ln', $this->requestTransfer->getBankAccount()->getOwner());
    }
}
