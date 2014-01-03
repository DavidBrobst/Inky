<?php

namespace Inky\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Inky\QuizBundle\Form\AnswerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qContent')
            ->add('qType')
			->add('answer', 'collection', array('type' => new AnswerType(),
												'allow_add' => true,
												'allow_delete' => true,
												'prototype' => true,
												'prototype_name' => '__char_prot__'))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inky\QuizBundle\Entity\Question'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inky_quizbundle_question';
    }
}
