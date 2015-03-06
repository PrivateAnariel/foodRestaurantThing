<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfirmRestaurantType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('nom','text',array('read_only' => true));
		$builder->add('telephone','text', array('read_only' => true));
        $builder->add('adresse','text',array('read_only' => true));
        $builder->add('idEntrepreneur','hidden');
		$builder->add('Confirmer', 'submit');
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Restaurant',
        ));
    }

    public function getName()
    {
        return 'restaurant';
    }
}