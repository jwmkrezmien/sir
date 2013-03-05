<?php

namespace Pwc\SirBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ToolRepository extends EntityRepository
{
    public function findAllSorted($sortField, $sortDirection)
    {
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->orderBy('t.' . $sortField, $sortDirection);

        return $query->getQuery()->getResult();
    }
}