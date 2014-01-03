<?php

namespace Inky\CourseBundle\Form\InkyChap;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InkyVideoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inky\CourseBundle\Entity\InkyChap\InkyVideo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inky_coursebundle_inkychap_inkyvideo';
    }
}
