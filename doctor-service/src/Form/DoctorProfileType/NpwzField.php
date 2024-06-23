<?php

namespace App\Form\DoctorProfileType;

use App\Entity\DoctorProfile;
use App\Form\AbstractFormField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class NpwzField extends AbstractFormField
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
    ) {
    }


    protected function getFieldName(): string
    {
        return 'npwz';
    }

    protected function getFieldType(): ?string
    {
        return TextType::class;
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
            new Length(['min' => 10, 'max' => 10]),
            $this->getCallbackConstraint(),
        ];
    }

    private function getCallbackConstraint(): Callback
    {
        return new Callback([$this, 'getCallback']);
    }

    public function getCallback(mixed $npwz, ExecutionContextInterface $context): void
    {
        $doctorProfile = $this->entityManager
            ->getRepository(DoctorProfile::class)
            ->findOneBy(['npwz' => $npwz]);

        if (!$doctorProfile) {
            return;
        }

        $message = $this->translator->trans('doctor.profile.create.409');
        $context->buildViolation($message)
            ->atPath('npwz')
            ->addViolation();
    }
}
