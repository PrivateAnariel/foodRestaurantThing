<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\DataTransformer\EntToIdTransformer;

class RestaurantType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $transformer = new EntToIdTransformer($entityManager);
		
        $builder->add('nom','text',array('max_length'=>20, 'label' => 'firstname'));      
		$builder->add('telephone','text', array('max_length'=>10, 'label' => 'telephone'));
        $builder->add('adresse','text',array('max_length'=>100, 'label'=>'address'));
        $builder->add($builder->create('idEntrepreneur','hidden')
                              ->addModelTransformer($transformer));
		$builder->add('submit', 'submit', array('label'=>'submit'));
   
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Restaurant',
        ))
        ->setRequired(array(
            'em',
        ))
        ->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));;
    }

    public function getName()
    {
        return 'restaurant';
    }
}