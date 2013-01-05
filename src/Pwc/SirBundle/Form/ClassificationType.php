<?php

namespace Pwc\SirBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityRepository;

class ClassificationType extends AbstractType
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

/*
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $type = $this->type;

        $builder->add('test', 'entity', array(
            'class' => 'PwcSirBundle:Classification',
            'query_builder' => function (EntityRepository $er) use ($type)
            {
                var_dump($type);

                return $er->createQueryBuilder('c')
                    ->where('c.type = :type')
                    ->addOrderBy('c.rank', 'DESC')
                    ->setParameters(array('type' => $type));
            }
        ));

//        $resolver->setDefaults();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'type' => ''
        ));
    }
*/
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $type = $this->type;

        $resolver->setDefaults(array(
            'class' => 'PwcSirBundle:Classification',
            'query_builder' => function (EntityRepository $er) use ($type)
            {
                var_dump($type);

                return $er->findAllForType($type);
            }
////            'choices' => array(
////                'L' => 'form.type.classification.low',
////                'M' => 'form.type.classification.medium',
////                'H' => 'form.type.classification.high'
////            )
        ));
    }

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'classification';
    }
}