<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfirmUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'email', array('read_only' => true));
        $builder->add('password', 'hidden');
		$builder->add('firstName','text', array('read_only' => true));
		$builder->add('lastName','text', array('read_only' => true));
		$builder->add('birthday','date', array(
														'read_only' => true,
														'widget' => 'single_text',
														'format' => 'yyyy-MM-dd',
														'placeholder' => 'Choose an option',
													));
		$builder->add('telephone','integer', array('max_length'=>10, 'read_only' => true));
		$builder->add('address', 'text', array('read_only' => true));
		$builder->add('confirm', 'submit');
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Document\User',
        ));
    }

    public function getName()
    {
        return 'confirm_user';
    }
}