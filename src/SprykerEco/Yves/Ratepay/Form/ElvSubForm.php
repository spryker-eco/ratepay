<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay\Form;

use Generated\Shared\Transfer\RatepayPaymentElvTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Shared\Ratepay\RatepayConfig;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ElvSubForm extends SubFormAbstract
{
    public const PAYMENT_METHOD = 'elv';

    public const FIELD_BUNK_ACCOUNT_HOLDER = 'bank_account_holder';
    public const FIELD_BUNK_ACCOUNT_BIC = 'bank_account_bic';
    public const FIELD_BUNK_ACCOUNT_IBAN = 'bank_account_iban';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RatepayPaymentElvTransfer::class,
            SubFormInterface::OPTIONS_FIELD_NAME => [],
        ]);
    }

    /**
     * @deprecated Use `configureOptions()` instead.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return RatepayConfig::PAYMENT_METHOD_ELV;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return RatepayConfig::PAYMENT_METHOD_ELV;
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return RatepayConfig::PROVIDER_NAME . '/' . static::PAYMENT_METHOD;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $this
            ->addBankAccountBic($builder)
            ->addBankAccountIban($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addBankAccountHolder($builder)
    {
        $builder->add(
            self::FIELD_BUNK_ACCOUNT_HOLDER,
            TextType::class,
            [
                'label' => false,
                'required' => true,
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addBankAccountBic($builder)
    {
        $builder->add(
            self::FIELD_BUNK_ACCOUNT_BIC,
            TextType::class,
            [
                'label' => false,
                'required' => true,
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addBankAccountIban($builder)
    {
        $builder->add(
            self::FIELD_BUNK_ACCOUNT_IBAN,
            TextType::class,
            [
                'label' => false,
                'required' => true,
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }
}
