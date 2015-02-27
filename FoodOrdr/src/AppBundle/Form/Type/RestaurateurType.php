<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RestaurateurType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('courriel', 'email');
        $builder->add('mdp', 'repeated', array(
           'first_name' => 'mdp',
           'second_name' => 'confirm_mdp',
           'type' => 'password'
        ));
		$builder->add('prenom','text',array('max_length'=>20));
		$builder->add('nom','text',array('max_length'=>20));
		$builder->add('telephone','text', array('max_length'=>10));
        $builder->add('idRestaurant', 'entity', array( 'class' => 'AppBundle:Restaurant', 'empty_value' => ' '));
		$builder->add('submit', 'submit');
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Restaurateur',
        ));
    }

    public function getName()
    {
        return 'confirm_restaurateur';
    }
}