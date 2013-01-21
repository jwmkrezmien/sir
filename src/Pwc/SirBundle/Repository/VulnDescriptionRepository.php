<?php

namespace Pwc\SirBundle\Repository;

use Doctrine\ORM\EntityRepository;

class VulnDescriptionRepository extends EntityRepository
{
/*
    private $result = array();

    public function findDescription(\Pwc\SirBundle\Entity\Vulnerability $vulnerability, \Pwc\SirBundle\Entity\Language $language)
    {
        $query =  $this->createQueryBuilder('vd')
                        ->select('vd, l')
                        ->innerJoin('vd.language', 'l')
                        ->where('vd.vulnerability = :vulnerability')
                        ->andWhere('vd.language = :language')
                        ->setParameters(array(
                            'vulnerability' => $vulnerability->getId(),
                            'language'      => $language->getId()
                        ));

        return $query->getQuery()->getOneOrNullResult(); //Result(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function getHydratedDescriptions(\Pwc\SirBundle\Entity\Vulnerability $vulnerability)
    {
        foreach($this->findAllForVulnerability($vulnerability) as $description)
        {
            $this->result[$description['language']['name']] = $description;
        }

        return json_encode($this->result);
    }
*/
}