<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfirmRestaurateurType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('courriel', 'email', array('read_only' => true, 'label' => 'email'));
		$builder->add('prenom','text',array('read_only' => true, 'label' => 'firstname'));
		$builder->add('nom','text',array('read_only' => true, 'label' => 'lastname'));
		$builder->add('telephone','text', array('read_only' => true, 'label' => 'telephone'));
		$builder->add('mdp','hidden', array('label' => 'password'));
        $builder->add('restaurants','entity', array(
    'class' => 'AppBundle:Restaurant',
    'property' => 'nom',
    'empty_value' => 'Aucun',
    'empty_data'=> null ,
    'required' => false,
    'multiple'  => true
));
		$builder->add('Confirmer', 'submit', array('label' => 'confirm'));
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Restaurateur',
        ));
    }

    public function getName()
    {
        return 'restaurateur';
    }
}