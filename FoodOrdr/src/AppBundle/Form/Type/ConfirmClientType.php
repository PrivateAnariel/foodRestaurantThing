<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfirmClientType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$entityManager = $options['em'];
        $builder->add('courriel', 'email', array('read_only' => true, 'label' => 'email'));
		$builder->add('prenom','text',array('read_only' => true, 'label' => 'firstname'));
		$builder->add('nom','text',array('read_only' => true,'label' => 'lastname'));
		$builder->add('datenaissance','birthday',array( 
            'label' => 'birthday',
            'widget' => 'choice',
            'read_only' => true,
        ));
		$builder->add('telephone','text', array('read_only' => true, 'label' => 'telephone'));
		$builder->add('adresses', 'collection', array('type' => new AdresseType(), 
                                                    	'read_only' => true, 
                                                        'allow_add' => true,
                                                        'by_reference' => false,
                                                        'options'  => array(
                                                            'em' => $entityManager,
                                                        )));
		$builder->add('mdp','hidden', array('label' => 'password'));
		$builder->add('Confirmer', 'submit', array('label' => 'confirm'));
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Client',
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
        return 'confirm_client';
    }
}