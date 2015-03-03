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
        $builder->add('courriel', 'email', array('read_only' => true));
		$builder->add('prenom','text',array('read_only' => true));
		$builder->add('nom','text',array('read_only' => true));
		$builder->add('telephone','text', array('read_only' => true));
		$builder->add('mdp','hidden');
        $builder->add('idRestaurant','entity', array(
    'class' => 'AppBundle:Restaurant',
    'property' => 'nom',
));
		$builder->add('Confirmer', 'submit');
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