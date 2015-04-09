<?php
namespace Alborq\DataTokenBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DataTokenEntityRepository extends EntityRepository {

    public function findOutdatedToken()
    {
        $now = new \DateTime();
        $qb = $this->createQueryBuilder('d');

        return $qb->where($qb->expr()->lte('d.dateEnd','CURRENT_TIMESTAMP()'))
            ->getQuery()
            ->getResult();
    }

    public function countToken()
    {
        return $this->createQueryBuilder('d')
            ->select('count(d)')
            ->getQuery()
            ->getSingleScalarResult();
    }
} 