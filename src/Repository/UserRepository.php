<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Gets User by name from repository
     *
     * @param string $name
     * @return User|null
     */
    public function getUserByName(string $name): ?User
    {
        return $this->createQueryBuilder('user')
            ->where('user.username = :username')
            ->setParameter(':username', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Persisting user to databse
     *
     * @param User $user
     * @return void
     */
    public function create(User $user): void
    {
        $em = $this->getEntityManager();

        $em->persist($user);
        $em->flush();
    }
}
