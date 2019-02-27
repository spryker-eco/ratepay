<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model\Deliver;

use SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Base;

class Confirm extends Base
{
    /**
     * Deliver confirmation operation.
     */
    public const OPERATION = Constants::REQUEST_MODEL_DELIVER_CONFIRM;

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface
     */
    protected $basket;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\HeadInterface $head
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface $shoppingBasket
     */
    public function __construct(HeadInterface $head, ShoppingBasketInterface $shoppingBasket)
    {
        parent::__construct($head);
        $this->basket = $shoppingBasket;
    }

    /**
     * @return array
     */
    protected function buildData()
    {
        $this->getHead()->setOperation(static::OPERATION);
        $paymentRequestData = parent::buildData();
        $paymentRequestData['content'] = [
            $this->getShoppingBasket()->getRootTag() => $this->getShoppingBasket(),
        ];

        return $paymentRequestData;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasketInterface
     */
    public function getShoppingBasket()
    {
        return $this->basket;
    }
}
