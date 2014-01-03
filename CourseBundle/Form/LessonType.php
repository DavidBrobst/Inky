<?php

namespace Inky\CourseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LessonType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('isPublic', 'checkbox', array('required'=>false))
            ->add('tags', 'collection', array('type' => new TagType(),
												'allow_add' => true,
												'allow_delete' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inky\CourseBundle\Entity\Lesson\Lesson'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inky_coursebundle_lessontype';
    }
}
