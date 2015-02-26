<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RestaurantType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('nom','text',array('max_length'=>20));
		$builder->add('telephone','text', array('max_length'=>10));
		$builder->add('submit', 'submit');
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Restaurant',
        ));
    }

    public function getName()
    {
        return 'confirm_restaurant';
    }
}