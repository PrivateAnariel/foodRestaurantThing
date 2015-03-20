<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\DataTransformer\EntToIdTransformer;

class ConfirmItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		
        $builder->add('nom','text',array('max_length'=>20, 'label' => 'lasttname'));      
		$builder->add('prix','text', array('max_length'=>10, 'label' => 'price'));
        $builder->add('description','text',array('max_length'=>200,'required' => false));
		$builder->add('Confirmer', 'submit', array('label' => 'confirm'));
   
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Item',
        ));
    }

     public function getName()
    {
        return 'item';
    }

}