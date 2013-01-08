<?php

namespace Pwc\SirBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClassificationRepository extends EntityRepository
{
    public function findAllForType($type)
    {
        $query =  $this->createQueryBuilder('c')
                        ->where('c.type = :type')
                        ->orderBy('c.rank', 'ASC')
                        ->setParameter('type', $type);
                        //->getQuery();

        return $query;//->getResult();
    }
/*
    public function findAllForImpact()
    {

        $query =  $this->createQueryBuilder('c')
            ->where('c.type = :type')
            ->orderBy('c.rank', 'ASC')
            ->setParameter('type', 'impact');
        //->getQuery();

        return $query;//->getResult();
    }

    public function findAllForLikelihood()
    {

        $query =  $this->createQueryBuilder('c')
            ->where('c.type = :type')
            ->orderBy('c.rank', 'ASC')
            ->setParameter('type', 'likelihood');
        //->getQuery();

        return $query;//->getResult();
    }
*/
}