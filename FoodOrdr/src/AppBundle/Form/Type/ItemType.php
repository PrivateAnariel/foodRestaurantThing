<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\DataTransformer\EntToIdTransformer;

class ItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		
        $builder->add('nom','text',array('max_length'=>20,'label' => 'lastname'));      
		$builder->add('prix','text', array('max_length'=>10, 'label' => 'price'));
        $builder->add('description','text',array('max_length'=>200, 'required' => false));
        $builder->add('confirmer_item','button', array('label' => "Confirmer l'item"));   
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Item',
        ))
        ->setRequired(array(
            'em',
        ))
        ->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

     public function getName()
    {
        return 'item';
    }

}