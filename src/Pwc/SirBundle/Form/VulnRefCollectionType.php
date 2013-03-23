<?php

namespace Pwc\SirBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VulnRefCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vulnRefs', 'collection', array(
                'type'         => new VulnRefType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'required'     => false,
                'by_reference' => false
              ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pwc\SirBundle\Entity\Vulnerability'
        ));
    }

    public function getName()
    {
        return 'pwc_sirbundle_vulnrefcollectiontype';
    }
}
