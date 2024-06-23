<?php

namespace App\Form\DoctorProfileType;

use App\Entity\DoctorProfile;
use App\Form\AbstractFormField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CustomerIdField extends AbstractFormField
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator
    ) {
    }

    protected function getFieldName(): string
    {
        return 'customerId';
    }

    protected function getFieldType(): ?string
    {
        return NumberType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'constraints' => $this->getConstraints(),
        ];
    }

    private function getConstraints(): array
    {
        return [
            new NotBlank(),
            new Callback([$this, 'getCallback'])
        ];
    }

    public function getCallback(mixed $customerId, ExecutionContextInterface $context): void
    {
        $doctorProfile = $this->entityManager
            ->getRepository(DoctorProfile::class)
            ->findOneBy(['customerId' => $customerId]);

        if (!$doctorProfile) {
            return;
        }

        $message = $this->translator->trans('doctor.profile.create.409');
        $context->buildViolation($message)
            ->atPath('customerId')
            ->addViolation();
    }
}
