<?php

namespace App\Repository;

use App\Entity\Task;
use App\Interfaces\TaskRepository as InterfacesTaskRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository implements InterfacesTaskRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function addTask(Task $task): void
    {
        $em = $this->getEntityManager();

        $em->persist($task);
        $em->flush($task);
    }

    public function removeTask(Task $task): void
    {
        $em = $this->getEntityManager();

        $em->flush($task);
    }

    public function findByAndCount(array $criteria): ?int
    {
        return count($this->findBy($criteria));
    }

    /**
     * This method should not be used. It is used only in unit tests
     *
     * @param Task $task
     * @return void
     */
    public function eraseTask(Task $task): void
    {
        $em = $this->getEntityManager();

        $em->remove($task);
        $em->flush($task);
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
