<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Ratepay\Form;

use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormProviderNameInterface;
use SprykerEco\Shared\Ratepay\RatepayConfig;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

abstract class SubFormAbstract extends AbstractSubFormType implements SubFormInterface, SubFormProviderNameInterface
{
    public const FIELD_DATE_OF_BIRTH = 'date_of_birth';
    public const FIELD_PHONE = 'phone';
    public const FIELD_ALLOW_CREDIT_INQUIRY = 'customer_allow_credit_inquiry';

    public const MIN_BIRTHDAY_DATE_STRING = '-18 years';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addDateOfBirth($builder)
            ->addPhone($builder);
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return RatepayConfig::PROVIDER_NAME;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDateOfBirth(FormBuilderInterface $builder)
    {
        $builder->add(
            self::FIELD_DATE_OF_BIRTH,
            BirthdayType::class,
            [
                'label' => false,
                'required' => true,
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'input' => 'string',
                'constraints' => [
                    $this->createNotBlankConstraint(),
                    $this->createBirthdayConstraint(),
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
    protected function addPhone(FormBuilderInterface $builder)
    {
        $builder->add(
            self::FIELD_PHONE,
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
     * @param string|null $groups
     *
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function createNotBlankConstraint($groups = null)
    {
        $groups = ($groups === null) ? $this->getPropertyPath() : $groups;
        return new NotBlank(['groups' => $groups]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function createBirthdayConstraint()
    {
        return new Callback([
            'callback' => function ($date, ExecutionContextInterface $context) {
                if (strtotime($date) > strtotime(self::MIN_BIRTHDAY_DATE_STRING)) {
                    $context->addViolation('checkout.step.payment.must_be_older_than_18_years');
                }
            },
            'groups' => $this->getPropertyPath(),
        ]);
    }
}
