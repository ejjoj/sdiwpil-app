<?php

namespace App\Service\Vuex\Module;

use App\Entity\Appointment;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class DoctorAppointmentsModule extends AbstractModule
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function insertIntoState(ArrayCollection $state): void
    {
        $state->set('doctor_appointments', ['appointments' => $this->getFrontEndAppointments()]);

        parent::insertIntoState($state);
    }

    private function getFrontEndAppointments(): array
    {
        foreach ($this->getAppointments() as $appointment) {
            $appointments[] = $appointment->toFrontEndDoctorArray();
        }

        return $appointments ?? [];
    }

    private function getAppointments(): Paginator
    {
        return $this->entityManager
            ->getRepository(Appointment::class)
            ->getPaginatedAppointments($this->getUser()?->getDoctorData(), 0, 25);
    }

    private function getUser(): User|UserInterface|null
    {
        return $this->security->getUser();
    }
}
