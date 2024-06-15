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

class NpwzField extends AbstractFormField
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }


    protected function getFieldName(): string
    {
        return 'npwz';
    }

    protected function getFieldType(): string
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

    public function getCallbackConstraint(): Callback
    {
        $callback = function (mixed $object, ExecutionContextInterface $context) {
            // TODO: check what is the type of $object
            $npwz = $object->getNpwz();
            $doctorProfile = $this->entityManager
                ->getRepository(DoctorProfile::class)
                ->findOneBy(['npwz' => $npwz]);

            if ($doctorProfile) {
                $context->buildViolation('Doctor with this npwz already exists')
                    ->atPath('npwz')
                    ->addViolation();
            }
        };

        return new Callback();
    }
}
