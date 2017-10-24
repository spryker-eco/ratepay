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
 * @group InstallmentDetailMapperTest
 */
class InstallmentDetailMapperTest extends AbstractMapperTest
{
    /**
     * @return void
     */
    public function testMapper()
    {
        $this->mapperFactory
            ->createInstallmentDetailMapper(
                $this->mockRatepayPaymentRequestTransfer($this->mockRatepayPaymentInstallmentTransfer())
            )
            ->map();

        $this->assertEquals(3, $this->requestTransfer->getInstallmentDetails()->getRatesNumber());
        $this->assertEquals(12, $this->requestTransfer->getInstallmentDetails()->getAmount());
        $this->assertEquals(14.5, $this->requestTransfer->getInstallmentDetails()->getLastAmount());
        $this->assertEquals(0.14, $this->requestTransfer->getInstallmentDetails()->getInterestRate());
        $this->assertEquals(28, $this->requestTransfer->getInstallmentDetails()->getPaymentFirstday());
    }
}
