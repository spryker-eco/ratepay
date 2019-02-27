<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Ratepay;

interface RatepayConfig
{
    public const PROVIDER_NAME = 'Ratepay';
    public const PAYMENT_METHOD_INVOICE = 'ratepayInvoice';
    public const PAYMENT_METHOD_ELV = 'ratepayElv';
    public const PAYMENT_METHOD_INSTALLMENT = 'ratepayInstallment';
    public const PAYMENT_METHOD_PREPAYMENT = 'ratepayPrepayment';
    public const INVOICE = 'INVOICE';
    public const ELV = 'ELV';
    public const INSTALLMENT = 'INSTALLMENT';
    public const PREPAYMENT = 'PREPAYMENT';

    public const PAYMENT_METHODS_MAP = [
        self::INVOICE => 'ratepayInvoice',
        self::ELV => 'ratepayElv',
        self::INSTALLMENT => 'ratepayInstallment',
        self::PREPAYMENT => 'ratepayPrepayment',
    ];
    public const METHOD_SERVICE = 'SERVICE';
    /**
     * Installment debit pay type.
     */
    public const DEBIT_PAY_TYPE_DIRECT_DEBIT = 'DIRECT-DEBIT';
    public const DEBIT_PAY_TYPE_BANK_TRANSFER = 'BANK-TRANSFER';
    public const DEBIT_PAY_TYPES = [
        self::DEBIT_PAY_TYPE_DIRECT_DEBIT,
        self::DEBIT_PAY_TYPE_BANK_TRANSFER,
    ];
    /**
     * Installment calculator types.
     */
    public const INSTALLMENT_CALCULATION_TIME = 'calculation-by-time';
    public const INSTALLMENT_CALCULATION_RATE = 'calculation-by-rate';
    public const INSTALLMENT_CALCULATION_TYPES = [
        self::INSTALLMENT_CALCULATION_TIME,
        self::INSTALLMENT_CALCULATION_RATE,
    ];

    /**
     * Genders.
     */
    public const GENDER_MALE = 'M';
    public const GENDER_FEMALE = 'F';
    /**
     * Ratepay request configuration.
     */
    public const RATEPAY_REQUEST_VERSION = '1.0';
    public const RATEPAY_REQUEST_XMLNS_URN = 'urn://www.ratepay.com/payment/1_0';

    /**
     * Path to bundle glossary file.
     */
    public const GLOSSARY_FILE_PATH = 'Business/Internal/glossary.yml';
}
