<?php

namespace AppBundle\Repository;

/**
 * VideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideoRepository extends \Doctrine\ORM\EntityRepository
{

    public function search(string $search): array {
        $qb = $this->createQueryBuilder('v');
        $query = $qb
            ->where("v.title LIKE :search")
            ->orderBy('v.datetime', 'DESC')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery();

        return $query->getResult();
    }
}
