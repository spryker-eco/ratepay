<?php
/**
 * Copy over the following configs to your config
 */

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Oms\OmsConstants;
use SprykerEco\Shared\Ratepay\RatepayConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Zed\Oms\OmsConfig;

$config[RatepayConstants::PROFILE_ID] = '';
$config[RatepayConstants::SECURITY_CODE] = '';
$config[RatepayConstants::SNIPPET_ID] = 'ratepay';
$config[RatepayConstants::SHOP_ID] = '';
$config[RatepayConstants::SYSTEM_ID] = 'Spryker ' . $config[ApplicationConstants::HOST_YVES];
$config[TaxConstants::DEFAULT_TAX_RATE] = 19;

$config[OmsConstants::PROCESS_LOCATION] = [
    OmsConfig::DEFAULT_PROCESS_LOCATION,
    APPLICATION_VENDOR_DIR . '/spryker-eco/ratepay/config/Zed/Oms',
];

$config[OmsConstants::ACTIVE_PROCESSES] = [
  'RatepayElv01',
  'RatepayInstallment01',
  'RatepayInvoice01',
  'RatepayPrepayment01',
];

$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
  RatepayConstants::PAYMENT_METHOD_ELV => 'RatepayElv01',
  RatepayConstants::PAYMENT_METHOD_INSTALLMENT => 'RatepayInstallment01',
  RatepayConstants::PAYMENT_METHOD_INVOICE => 'RatepayInvoice01',
  RatepayConstants::PAYMENT_METHOD_PREPAYMENT => 'RatepayPrepayment01',
];

