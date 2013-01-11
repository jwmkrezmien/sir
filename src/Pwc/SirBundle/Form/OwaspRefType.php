<?php

namespace Pwc\SirBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class OwaspRefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vulnerability')
            ->add('owaspitem', 'entity', array(
                    'class'         => 'PwcSirBundle:OwaspItem',
                    'group_by'      => 'owaspset.name',
                    'multiple'      => true,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->findAllRanked();
                    }
        ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pwc\SirBundle\Entity\OwaspRef'
        ));
    }

    public function getName()
    {
        return 'pwc_sirbundle_owaspreftype';
    }
}
