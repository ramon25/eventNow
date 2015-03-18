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

class CheckinType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('submit', 'submit', array('label' => 'Delete', 'attr'=>array('type'=>'danger')));
            ->add('CheckIn', 'submit', array('label' => 'Check In', 'button_class' => 'success', 'attr' => array('class' => 'btn-block btn-lg')));

    }

    public function getName()
    {
        return 'checkin';
    }
}