<?php

namespace App\Form\Register;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

abstract class AbstractUserFormType extends AbstractType
{
    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Callback([
                        'callback' => function ($email, ExecutionContextInterface $context) {
                            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
                            if ($user) {
                                $context->addViolation('Istnieje już użytkownik o podanym adresie e-mail');
                            }
                        }
                    ])
                ],
            ])
            ->add('password', RepeatedType::class, [
                'required' => true,
                'type' => PasswordType::class,
                'constraints' => [new NotBlank()],
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('secondName', TextType::class, [
                'required' => true,
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'constraints' => [new NotBlank()],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'required' => true,
                'constraints' => [
                    new IsTrue(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
