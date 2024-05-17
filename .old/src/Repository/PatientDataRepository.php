<?php

namespace App\Repository;

use App\Entity\DoctorData;
use App\Entity\PatientData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method PatientData|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatientData|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatientData[]    findAll()
 * @method PatientData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientData::class);
    }

    public function findPatientsDataByDoctorDataInAppointment(DoctorData $doctor)
    {
        $qb = $this->createQueryBuilder('pd');

        return $qb->join('pd.appointments', 'a')
            ->where($qb->expr()->eq('a.doctor', ':doctor'))
            ->setParameter('doctor', $doctor)
            ->getQuery()
            ->getResult();
    }
}
