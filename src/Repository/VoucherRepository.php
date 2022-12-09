<?php

namespace App\Repository;

use App\Entity\Voucher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<Voucher>
 *
 * @method Voucher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voucher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voucher[]    findAll()
 * @method Voucher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoucherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voucher::class);
    }

    public function save(Voucher $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Voucher $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findVoucherByCode(string $code): Voucher|null
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function findVoucherById(string $id): Voucher|null
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findVoucherByStatusId(int $id = 0 , array $status= [])
    {
        $query =  $this->createQueryBuilder('v');
        if($id != 0) {
            $query->andWhere('v.id = :id')->setParameter('id', $id);
        }
        if(!empty($status)) {
            $query->andWhere('v.status in (:status)')->setParameter('status', $status);
        }
        return $query->getQuery()->getResult();
    }

    public function findVoucherListByStatus(int $status, string $greaterOrLessSign = '')
    {
        $query =  $this->createQueryBuilder('v');
        if($greaterOrLessSign != '') {
            if($greaterOrLessSign == '<') {
                $query->andWhere('v.expired_at < :currentDate ');
            } else {
                $query->andWhere('v.expired_at >= :currentDate ');
            }
           $query->setParameter('currentDate', date("Y-m-d", time()));
        }
        if(!empty($status)) {
            $query->andWhere('v.status = :status')->setParameter('status', $status);
        }
        return $query->getQuery()->getResult();
    }

    public function updateVoucherStatus(string $id, int $status): ?int
    {
        $currentTime = new \DateTime();
        return $this->createQueryBuilder('v')
            ->update()
            ->set('v.status', ':status')
            ->setParameter('status', $status)
            ->set('v.updated_at', ':updatedAt')
            ->setParameter('updatedAt', $currentTime)
            ->where('v.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult();
    }
//    /**
//     * @return Voucher[] Returns an array of Voucher objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Voucher
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
