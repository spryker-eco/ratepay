<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\Order;

use Orm\Zed\Ratepay\Persistence\SpyPaymentRatepay;
use SprykerEcoTest\Zed\Ratepay\Business\AbstractBusinessTest;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Ratepay
 * @group Business
 * @group Order
 * @group AbstractSaverTest
 */
abstract class AbstractSaverTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function testSaveOrderPaymentCreatesPersistentPaymentData()
    {
        $this->assertInstanceOf(SpyPaymentRatepay::class, $this->paymentEntity);
    }

    /**
     * @return void
     */
    public function testSaveOrderPaymentData()
    {
        $paymentMethodTransfer = $this->getPaymentTransferFromQuote();

        $this->assertEquals($paymentMethodTransfer->getTransactionId(), $this->paymentEntity->getTransactionId());
        $this->assertEquals($paymentMethodTransfer->getTransactionShortId(), $this->paymentEntity->getTransactionShortId());
        $this->assertEquals($paymentMethodTransfer->getResultCode(), $this->paymentEntity->getResultCode());
        $this->assertEquals($paymentMethodTransfer->getGender(), $this->paymentEntity->getGender());
        $this->assertEquals($paymentMethodTransfer->getDateOfBirth(), $this->paymentEntity->getDateOfBirth()->format('d.m.Y'));
        $this->assertEquals($paymentMethodTransfer->getCurrencyIso3(), $this->paymentEntity->getCurrencyIso3());
        $this->assertEquals($paymentMethodTransfer->getDeviceFingerprint(), $this->paymentEntity->getDeviceFingerprint());
        $this->assertEquals($paymentMethodTransfer->getPaymentType(), $this->paymentEntity->getPaymentType());
        $this->assertEquals($paymentMethodTransfer->getIpAddress(), $this->paymentEntity->getIpAddress());
    }
}
