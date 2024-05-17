<?php

namespace App\Service\User;

use App\Entity\Clinic;
use App\Entity\DoctorData;
use App\Entity\PatientData;
use App\Entity\User;
use App\Service\Patient\PeselDataHelper;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly PeselDataHelper $peselDataHelper
    ) {
    }

    public function registerUser(array $userData, string $role): User
    {
        $user = (new User())
            ->setEmail($userData['email'])
            ->setRoles([$role])
            ->setFirstName($userData['firstName'])
            ->setSecondName($userData['secondName'] ?? '')
            ->setLastName($userData['lastName']);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
        $user->setPassword($hashedPassword);
        $this->handleRoleDataCreation($user, $userData, $role);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function handlePatientData(User $user, array $userData): void
    {
        $pesel = $userData['pesel'];
        $data = (new PatientData())
            ->setPatient($user)
            ->setPesel($pesel)
            ->setGender($this->peselDataHelper->getGender($pesel))
            ->setBornAt($this->peselDataHelper->getBornDate($pesel));
        $user->setPatientData($data);
        $this->entityManager->persist($data);
    }

    private function getPwzId(): string
    {
        try {
            $pwzId = random_int(1000000, 9999999);
            while ($this->entityManager->getRepository(DoctorData::class)->findOneBy(['pwzId' => $pwzId])) {
                $pwzId = random_int(1000000, 9999999);
            }
        } catch (Exception $exception) {
            $this->getPwzId();
        }

        return $pwzId;
    }

    private function handleDoctorData(User $user, array $userData): void
    {
        /** @var Clinic $clinic */
        $clinic = $userData['clinic'];
        $data = (new DoctorData())
            ->setDoctor($user)
            ->setClinic($clinic)
            ->setMedicalSpecialty($userData['medicalSpecialty'])
            ->setPwzId($this->getPwzId());
        $clinic->addDoctor($data);
        $user->setDoctorData($data);
        $this->entityManager->persist($data);
        $this->entityManager->persist($clinic);
    }

    private function handleReceptionistData(User $user, array $userData): void
    {
        // TODO: implement method
    }

    private function handleManagerData(User $user, array $userData): void
    {
        // TODO: implement method
    }

    private function handleRoleDataCreation(User $user, array $userData, string $role): void
    {
        switch ($role) {
            case User::ROLE_PATIENT:
                $this->handlePatientData($user, $userData);
                break;
            case User::ROLE_DOCTOR:
                $this->handleDoctorData($user, $userData);
                break;
            case User::ROLE_RECEPTIONIST:
                $this->handleReceptionistData($user, $userData);
                break;
            case User::ROLE_MANAGER:
                $this->handleManagerData($user, $userData);
                break;
            default:
                break;
        }
    }
}
