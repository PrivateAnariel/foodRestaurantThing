<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use AppBundle\Form\DataTransformer\EntToIdTransformer;

class ConfirmMenuType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		
        $builder->add('nom','text',array('max_length'=>20));      
		$builder->add('Confirmer', 'submit');
   
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Menu',
        ));
    }

     public function getName()
    {
        return 'menu';
    }

}