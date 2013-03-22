<?php

namespace Pwc\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;
use Symfony\Component\Security\Core\Validator\Constraint\UserPassword;

class ChangePasswordFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'translation_domain' => 'PwcUserBundle',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));

        $builder->add('new', 'repeated', array(
            'type' => 'password',
            'options' => array('translation_domain' => 'PwcUserBundle'),
            'first_options' => array('label' => 'form.new_password'),
            'second_options' => array('label' => 'form.new_password_confirmation'),
            'invalid_message' => 'fos_user.password.mismatch',
        ));
    }

    public function getName()
    {
        return 'pwc_user_change_password';
    }
}
