<?php

namespace App\Repository;

use App\Entity\Appointment;
use App\Entity\DoctorData;
use App\Entity\PatientData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

    public function getPaginatedAppointments(
        PatientData|DoctorData $userData,
        int $min,
        int $max,
    ): Paginator {
        $qb = $this->createQueryBuilder('a');
        $query = $qb
            ->where($qb->expr()->eq('a.patient', ':userData'))
            ->orWhere($qb->expr()->eq('a.doctor', ':userData'))
            ->setParameter('userData', $userData)
            ->setFirstResult($min)
            ->setMaxResults($max)
            ->getQuery();

        return new Paginator($query);
    }
}
