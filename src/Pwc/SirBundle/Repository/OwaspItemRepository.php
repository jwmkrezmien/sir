<?php

namespace Pwc\SirBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OwaspItemRepository extends EntityRepository
{
    public function findAllRanked()
    {
        $query =  $this->createQueryBuilder('o')
                       ->orderBy('o.rank', 'ASC');

        return $query;
    }
}