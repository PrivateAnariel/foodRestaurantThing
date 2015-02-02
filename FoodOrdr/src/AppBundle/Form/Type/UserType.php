<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'email');
        $builder->add('password', 'repeated', array(
           'first_name' => 'password',
           'second_name' => 'confirm',
           'type' => 'password'
        ));
		$builder->add('firstName','text');
		$builder->add('lastName','text');
		$builder->add('birthday','date');
		$builder->add('telephone','integer', array('max_length'=>10));
		$builder->add('address', 'text');
		$builder->add('submit', 'submit');
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\User',
        ));
    }

    public function getName()
    {
        return 'user';
    }
}