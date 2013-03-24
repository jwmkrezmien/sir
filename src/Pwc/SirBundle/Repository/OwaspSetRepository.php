<?php

namespace Pwc\SirBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OwaspSetRepository extends EntityRepository
{
    public function findAllSorted($sortField, $sortDirection)
    {
        $query = $this->createQueryBuilder('o')
                      ->select('o')
                      ->orderBy('o.' . $sortField, $sortDirection);

        return $query->getQuery()->getResult();
    }
}