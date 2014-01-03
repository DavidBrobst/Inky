<?php

namespace Inky\QuizBundle\Form\Answer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Inky\QuizBundle\Form\Answer\SubmitAnswerType;

class SubmitAnswerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inky\QuizBundle\Entity\Answer\SubmitAnswer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inky_quizbundle_answer_submitanswertype';
    }
}
