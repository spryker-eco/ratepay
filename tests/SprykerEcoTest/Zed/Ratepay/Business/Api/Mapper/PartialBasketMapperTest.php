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
 * @group PartialBasketMapperTest
 */
class PartialBasketMapperTest extends AbstractMapperTest
{
    /**
     * @return void
     */
    public function testMapper()
    {
        $this->mapperFactory
            ->createPartialBasketMapper(
                $this->mockOrderTransfer(),
                $this->mockPartialOrderTransfer(),
                $this->mockPaymentElvTransfer()
            )
            ->map();

        $this->assertEquals(18, $this->requestTransfer->getShoppingBasket()->getAmount());
        $this->assertEquals('iso3', $this->requestTransfer->getShoppingBasket()->getCurrency());
    }
}
