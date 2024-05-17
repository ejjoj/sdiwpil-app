<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return User[]
     */
    public function findDoctorByAppointmentParams(array $params): array
    {
        $qb = $this->createQueryBuilder('u')
            ->join('u.doctorData', 'dd')
            ->orderBy('u.firstName', 'ASC');

        $this
            ->applyMedicalSpecialtyFilter($qb, $params)
            ->applyCityFilter($qb, $params)
            ->applyLastNameFilter($qb, $params);

        return $qb->getQuery()->getResult();
    }

    private function applyMedicalSpecialtyFilter(QueryBuilder $qb, array $params): self
    {
        $medicalSpecialty = $params['medicalSpecialty'] ?? 0;
        if ($medicalSpecialty) {
            $qb
                ->andWhere($qb->expr()->eq('dd.medicalSpecialty', ':medicalSpecialty'))
                ->setParameter('medicalSpecialty', $medicalSpecialty);
        }

        return $this;
    }

    private function applyCityFilter(QueryBuilder $qb, array $params): self
    {
        $city = $params['city'] ?? '';
        if ($city) {
            $qb
                ->join('dd.clinic', 'ddc')
                ->andWhere($qb->expr()->eq('ddc.city', ':city'))
                ->setParameter('city', $city);
        }

        return $this;
    }

    private function applyLastNameFilter(QueryBuilder $qb, array $params): self
    {
        $lastName = $params['lastName'] ?? '';
        if ($lastName) {
            $qb
                ->andWhere($qb->expr()->eq('u.lastName', ':lastName'))
                ->andWhere($qb->expr()->isNotNull('dd'))
                ->setParameter('lastName', $lastName);
        }

        return $this;
    }
}
