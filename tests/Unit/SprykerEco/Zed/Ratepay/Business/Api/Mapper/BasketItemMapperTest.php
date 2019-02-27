<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\Ratepay\Business\Api\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Api
 * @group Mapper
 * @group BasketItemMapperTest
 */
class BasketItemMapperTest extends AbstractMapperTest
{
    /**
     * @return void
     */
    public function testMapper()
    {
        $this->mapperFactory
            ->getBasketMapper(
                $this->mockRatepayPaymentRequestTransfer()
            )
            ->map();

        $itemTransfer = new ItemTransfer();
        $itemTransfer->setName('q1')
            ->setSku('q2')
            ->setGroupKey('q3')
            ->setQuantity('q4')
            ->setTaxRate('q5')
            ->setUnitGrossPrice(1200)
            ->setUnitPriceToPayAggregation(1200)
            ->setUnitGrossPriceWithProductOptionAndDiscountAmounts(1200)
            ->setProductOptions(new ArrayObject());

        $this->mapperFactory
            ->getBasketItemMapper(
                $itemTransfer
            )
            ->map();

        $this->assertEquals('q1', $this->requestTransfer->getShoppingBasket()->getItems()[0]->getItemName());
        $this->assertEquals('q2', $this->requestTransfer->getShoppingBasket()->getItems()[0]->getArticleNumber());
        $this->assertEquals('q3', $this->requestTransfer->getShoppingBasket()->getItems()[0]->getUniqueArticleNumber());
        $this->assertEquals('q4', $this->requestTransfer->getShoppingBasket()->getItems()[0]->getQuantity());
        $this->assertEquals('q5', $this->requestTransfer->getShoppingBasket()->getItems()[0]->getTaxRate());
        $this->assertEquals(12, $this->requestTransfer->getShoppingBasket()->getItems()[0]->getUnitPriceGross());
    }
}
