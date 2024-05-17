<?php

namespace App\Repository;

use App\Entity\Conversation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversation::class);
    }

    public function getPaginatedConversations(User $user, int $min, int $max): Paginator
    {
        $qb = $this->createQueryBuilder('c');
        $query = $qb
            ->where($qb->expr()->eq('c.patient', ':patient'))
            ->orWhere($qb->expr()->eq('c.doctor', ':doctor'))
            ->setParameters([
                'patient' => $user->getPatientData(),
                'doctor' => $user->getDoctorData(),
            ])
            ->setFirstResult($min)
            ->setMaxResults($max)
            ->getQuery();

        return new Paginator($query);
    }
}
