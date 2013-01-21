<?php

namespace Pwc\SirBundle\Repository;

use Doctrine\ORM\EntityRepository;

class VulnDescriptionRepository extends EntityRepository
{
    private $result = array();

    public function findAllForVulnerability(\Pwc\SirBundle\Entity\Vulnerability $vulnerability)
    {
        $query =  $this->createQueryBuilder('vd')
                        ->select('vd, l')
                        ->innerJoin('vd.language', 'l')
                        ->where('vd.vulnerability = :vulnerability')
                        ->setParameters(array(
                            'vulnerability' => $vulnerability->getId()
                        ));

        return $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function getHydratedDescriptions(\Pwc\SirBundle\Entity\Vulnerability $vulnerability)
    {
        foreach($this->findAllForVulnerability($vulnerability) as $description)
        {
            $this->result[$description['language']['name']] = $description;
        }

        return json_encode($this->result);
    }
}