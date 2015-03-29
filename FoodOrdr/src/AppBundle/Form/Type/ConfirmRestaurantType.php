<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\DataTransformer\EntToIdTransformer;

class ConfirmRestaurantType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $transformer = new EntToIdTransformer($entityManager);
        
		$builder->add('nom','text',array('read_only' => true));
		$builder->add('telephone','text', array('read_only' => true, 'label' => 'telephone'));
        $builder->add('adresse','text',array('read_only' => true, 'label' => 'address'));
        $builder->add($builder->create('idEntrepreneur','hidden')
                              ->addModelTransformer($transformer));
        $builder->add('idRestaurateur', 'entity', array( 'class' => 'AppBundle:Restaurateur', 'empty_value' => ' ','required' => false));
		$builder->add('Confirmer', 'submit', array('label' => 'confirm'));
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
        return 'confirm_restaurant';
    }
}