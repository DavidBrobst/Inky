<?php
namespace Inky\QuizBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class QuestionSubscriber implements EventSubscriberInterface
{
	public function __construct($QuType)
    {
        $this->QuType = $QuType;
    }
    public static function getQuestionTypeEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if($this->QuType == false)
		{
			$form
				
				->add('question', 'collection', array('type' => new QuestionType(),
													'allow_add' => true,
													'allow_delete' => true));
		}
		else
		{
			$QestionForm = 'Inky\QuizBundle\Form\Question\\'.$this->QuType.'Type';
			$form
				->add('question', 'collection', array('type' => new QuestionType(),
													'allow_add' => true,
													'allow_delete' => true))
				->add($this->QuType, 'collection', array('type' => new $QestionForm (),
														'allow_add' => true,
														'allow_delete' => true));
		}
    }
}