<?php

namespace App\Repository;

use App\Entity\DoctorData;
use App\Entity\Document;
use App\Entity\PatientData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function getPaginatedDocuments(
        array $minMax,
        ?DoctorData $doctor = null,
        ?PatientData $patient = null
    ): Paginator {
        $qb = $this->createQueryBuilder('d');
        $query = $qb
            ->orWhere($qb->expr()->eq('d.doctor', ':doctor'))
            ->orWhere($qb->expr()->eq('d.patient', ':patient'))
            ->setParameters([
                'doctor' => $doctor,
                'patient' => $patient,
            ])
            ->setFirstResult($minMax['min'])
            ->setMaxResults($minMax['max'])
            ->getQuery();

        return new Paginator($query);
    }
}
