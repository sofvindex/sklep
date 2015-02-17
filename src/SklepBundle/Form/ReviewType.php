<?php

namespace SklepBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReviewType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('autor')
            ->add('comment')
            ->add('rating','choice', array(
                            'choices'   => array('1' => 'Beznadziejny', '2' => 'Słaby', '3' => 'Ujdzie', '4'=> 'Dobry', '5'=>'Świetny'),
                            'required'  => true,
                            'multiple'  => false,                          
                            'label' => 'Ocena',

                  ))
            ->add('movie',null,array( 'attr'=>array('style'=>'display:none;'), 'label_attr'=>array('style'=>'display:none;') ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SklepBundle\Entity\Review'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sklepbundle_review';
    }
}
