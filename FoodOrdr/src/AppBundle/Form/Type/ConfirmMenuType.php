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
      
		$entityManager = $options['em'];
        $builder->add('nom','text',array('max_length'=>20, 'label' => 'lastname'));
        $builder->add('items', 'collection', array('type' => new ItemType(), 
                                                    'allow_add' => true,
                                                    'by_reference' => false,
                                                    'options'  => array(
                                                        'em' => $entityManager,
                                                    )));      
		$builder->add('Envoyer le menu ', 'submit',array('label' => 'confirm'));
   
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
         $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Menu',
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
        return 'menu';
    }

}