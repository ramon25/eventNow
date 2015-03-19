<?php
/**
 * Created by PhpStorm.
 * User: ramon
 * Date: 18.03.15
 * Time: 19:10
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateEventType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date', 'date', array('attr' => array('class' => 'form-control')))
            ->add('password', 'repeated', array(
                'first_name'  => 'password',
                'second_name' => 'confirm',
                'type'        => 'password',
            ))
            ->add('create', 'submit');
    }

    public function getName()
    {
        return 'create_event';
    }
}