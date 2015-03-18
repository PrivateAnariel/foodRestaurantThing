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
        $builder->add('courriel', 'email', array(
            'label' => 'label.email'
            ));
        $builder->add('mdp', 'repeated', array(
           'first_name' => 'mdp',
           'second_name' => 'confirm_mdp',
           'type' => 'password'
        ));
        $builder->add('prenom','text',array(
            'max_length'=>20,
            'label' => 'label.firstname'
            ));
        $builder->add('nom','text',array(
            'max_length'=>20,
            'label' => 'label.name'
               ));
        $builder->add('datenaissance','birthday',array( 
            'label' => 'birthday',
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'attr' => array('value' => '2000-01-01'),
        ));
        $builder->add('telephone','text', array('max_length'=>10));
        $builder->add('adresse', 'text',array('max_length'=>30));
        $builder->add('submit', 'submit');
	}

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Client',
        ));
    }

    public function getName()
    {
        return 'confirm_client';
    }
}