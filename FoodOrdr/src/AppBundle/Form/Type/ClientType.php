<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $options['em'];
        $builder->add('courriel', 'email', array(
            'label' => 'email'
            ));
        $builder->add('mdp', 'repeated', array(
           'first_name' => 'mdp',
           'second_name' => 'confirm_mdp',
           'type' => 'password'
        ));
        $builder->add('prenom','text',array(
            'max_length'=>20,
            'label' => 'firstname'
            ));
        $builder->add('nom','text',array(
            'max_length'=>20,
            'label' => 'lastname'
               ));
        $builder->add('datenaissance','birthday',array( 
            'label' => 'birthday',
            'widget' => 'choice',
        ));
        $builder->add('telephone','text', array('max_length'=>10,'label' => 'telephone'));
        $builder->add('adresses', 'collection', array('type' => new AdresseType(), 
                                                        'allow_add' => true,
                                                        'by_reference' => false,
                                                        'options'  => array(
                                                            'em' => $entityManager,
                                                        )));
        $builder->add('submit', 'submit', array('label' => 'submit'));
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
        return 'client';
    }
}