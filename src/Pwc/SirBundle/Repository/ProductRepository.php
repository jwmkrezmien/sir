<?php

namespace Pwc\SirBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function findAllSorted($sortField, $sortDirection)
    {
        $query = $this->createQueryBuilder('p')
                      ->select('p')
                      ->orderBy('p.' . $sortField, $sortDirection);

        return $query->getQuery()->getResult();
    }
}