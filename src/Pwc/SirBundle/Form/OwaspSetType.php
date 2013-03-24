<?php

namespace Pwc\SirBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OwaspSetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'form.label.owaspset.name'))
                ->add('year', null, array('label' => 'form.label.owaspset.year'))
                ->add('owaspItems', 'collection', array(
                    'type'  => new OwaspItemType(),
                    'label' => 'form.label.owaspset.owaspitems'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pwc\SirBundle\Entity\OwaspSet'
        ));
    }

    public function getName()
    {
        return 'pwc_sirbundle_owaspsettype';
    }
}
