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

class CreateTicketType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameOnTicket', 'text', array(
                'attr' => array(
                    'placeholder' => 'Ticket holders name (can be empty)',
                ),
            ))
            ->add('Create Ticket', 'submit');
    }

    public function getName()
    {
        return 'create_ticket';
    }
}