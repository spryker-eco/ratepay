<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Api\Model\Payment;

use SprykerEco\Zed\Ratepay\Business\Api\Builder\Head;
use SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket;
use SprykerEco\Zed\Ratepay\Business\Api\Constants;
use SprykerEco\Zed\Ratepay\Business\Api\Model\Base;

class Refund extends Base
{
    /**
     * @const Method operation.
     */
    const OPERATION = Constants::REQUEST_MODEL_PAYMENT_CHANGE;

    /**
     * @const Method operation subtype.
     */
    const OPERATION_SUBTYPE = 'return';

    /**
     * @var \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket
     */
    protected $basket;

    /**
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\Head $head
     * @param \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket $shoppingBasket
     */
    public function __construct(Head $head, ShoppingBasket $shoppingBasket)
    {
        parent::__construct($head);
        $this->basket = $shoppingBasket;
    }

    /**
     * @return array
     */
    protected function buildData()
    {
        $this->getHead()->setOperationSubstring(static::OPERATION_SUBTYPE);
        $paymentRequestData = parent::buildData();
        $paymentRequestData['content'] = [
            $this->getShoppingBasket()->getRootTag() => $this->getShoppingBasket(),
        ];

        return $paymentRequestData;
    }

    /**
     * @return \SprykerEco\Zed\Ratepay\Business\Api\Builder\ShoppingBasket
     */
    public function getShoppingBasket()
    {
        return $this->basket;
    }
}
