<?php

namespace Inky\QuizBundle\Form\Question;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

// Question Forms
use Inky\QuizBundle\Form\Question\TfQuestionType as TfQuestion;
use Inky\QuizBundle\Form\Question\McQuestionType as McQuestion;
use Inky\QuizBundle\Form\Question\InputQuestionType as InputQuestion;
use Inky\QuizBundle\Form\Question\SubmitQuestionType as SubmitQuestion;
// Answer Forms
use Inky\QuizBundle\Form\Answer\McAnswerType as McAnswerType;
use Inky\QuizBundle\Form\Answer\InputAnswerType as InputAnswerType;
use Inky\QuizBundle\Form\Answer\SubmitAnswerType as SumbmitAnswerType;

class QuestionType extends AbstractType
{
	public function __construct($QuType)
    {
        $this->QuType = $QuType;
		$this->QestionForm = 'Inky\QuizBundle\Form\Question\\'.$this->QuType.'Type';
		$this->QestionClass = 'Inky\QuizBundle\Entity\Question\\'.$this->QuType;
    }
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		
        if($this->QuType =='TfQuestion')
		{
			$builder	->add('TfContent', 'text')
						->add('isTrue','checkbox', array('required'=>false));

		}	
		if($this->QuType =='McQuestion')
		{
			$builder
            ->add('content')
            ->add('answer', 'collection', array('type' => new McAnswerType(),
												'allow_add' => true,
												'allow_delete' => true,
												'prototype' => true,
												'prototype_name' => '__char_prot__'))
			;

		}	
		if($this->QuType =='SubmitQuestion')
		{
			$builder
            ->add('content')
            ->add('answer', 'collection', array('type' => new SubmitAnswerType(),
												'allow_add' => true,
												'allow_delete' => true,
												'prototype' => true,
												'prototype_name' => '__char_prot__'))
        ;

		}	
		if($this->QuType =='InputQuestion')
		{
			$builder
            ->add('content')
            ->add('answer', 'collection', array('type' => new InputAnswerType(),
												'allow_add' => true,
												'allow_delete' => true,
												'prototype' => true,
												'prototype_name' => '__char_prot__'))
			;
		}	
	}
	
	/**
    * @param OptionsResolverInterface $resolver
    */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->QestionClass
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inky_quizbundle_questiontype';
    }
}
