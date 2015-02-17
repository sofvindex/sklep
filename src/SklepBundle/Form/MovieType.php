<?php

namespace SklepBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('rating','choice', array(
                            'choices'   => array('1' => 'Beznadziejny', '2' => 'Słaby', '3' => 'Ujdzie', '4'=> 'Dobry', '5'=>'Świetny'),
                            'required'  => true,
                            'multiple'  => false,                          
                            'label' => 'Ocena',

                  ))
            ->add('price', 'money', array(
                    'attr'=>array(
                        'stepby'=>'0.01',
                        'type'=>'number'
                        ),
                    'data' => '20.99',

                ))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SklepBundle\Entity\Movie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sklepbundle_movie';
    }
}
