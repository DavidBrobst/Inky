<?php

namespace Inky\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use Inky\QuizBundle\Form\Question\QuestionType;

use Inky\QuizBundle\Form\Question\TfQuestionType as TfQuestion;
use Inky\QuizBundle\Form\Question\McQuestionType as McQuestion;
use Inky\QuizBundle\Form\Question\InputQuestionType as InputQuestion;
use Inky\QuizBundle\Form\Question\SubmitQuestionType as SubmitQuestion;

use Inky\QuizBundle\Form\EventListener\QuestionSubscriber as QuestionSubscriber;

class QuizType extends AbstractType
{
	public function __construct($QuType)
    {
        $this->QuType = $QuType;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($this->QuType == false)
		{
			$builder
				->add('title', 'text')
				->add('description', 'textarea')
				->add('isPublic', 'checkbox', array('required'=>false))
				
				->add('question', 'collection', array('type' => new QuestionType(),
													'allow_add' => true,
													'allow_delete' => true));
		}
		else
		{
			$builder->addEventListener(
				FormEvents::PRE_SET_DATA,
				function(FormEvent $event) {
                $form = $event->getForm();
				
				$QestionForm = 'Inky\QuizBundle\Form\Question\\'.$this->QuType.'Type';
			$form
				->add($this->QuType, 'collection', array('type' => new $QestionForm (),
														'allow_add' => true,
														'allow_delete' => true));
				}
			);
		}
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inky\QuizBundle\Entity\Quiz',
			'csrf_protection' => true,
            'csrf_field_name' => '_token',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inky_quizbundle_quiztype';
    }
}
