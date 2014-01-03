<?php

namespace Inky\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Security
use Symfony\app\Config\security;
use FOS\UserBundle\Model\User;
// ACL
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

// Entity
use Inky\QuizBundle\Entity\Quiz as Quiz;
use Inky\CourseBundle\Entity\Lesson;
use Inky\QuizBundle\Entity\Question;
use Inky\QuizBundle\Entity\Question\TfQuestion as TfQuestion;
use Inky\QuizBundle\Entity\Answer;

// Form
use Inky\QuizBundle\Form\QuizType;
use Inky\QuizBundle\Form\QuizEditType;

class QuizController extends Controller
{
    public function QuizAction($name)
    {
        return $this->render('InkyQuizBundle:Default:index.html.twig', array('name' => $name));
    }
	
	// AddQuizz
	public function addQuizAction(Lesson $lesson)
	{

		$new_quiz = new Quiz;
		$new_quiz->setLesson($lesson);		
        $form = $this->createForm(new QuizType(false), $new_quiz);
     	$request = $this->getRequest();
		$em = $this->getDoctrine()->getEntityManager();
		
		if($request->isXmlHttpRequest()) 
		{
			    
            $QuestionType= $request->request->get('QuestionType');  

			// On choppe l'id demande, on lui attribu son nom 
			// $repository = $em->getRepository('InkyQuizBundle:Question\Question');			
            // $QuestionTypeSelected = $em->getRepository('InkyQuizBundle:Question\Question')->findOneById($QuestionTypeID);      
			// Si on a un truc qui n'existe pas
			// if(count($QuestionTypeSelected)<1)
				// throw $this->createNotFoundException('This type of question doesnt exist');
			// Sinon on cree la reponse
		     
			$formQu = $this->createForm(new QuizType($QuestionType),$new_quiz);
			
				
		// Returns the appropriate form
            return $this->render('InkyQuizBundle:Quiz:quizType.html.twig', array(	'form' => $formQu->createView(),
																					'formName'=>'inky_quizbundle_quiztype_question',
																					'lesson' => $lesson->getId()	)
								);
		}

		if ($request->getMethod() == 'POST')
		{

			$form->bind($request);
			if ($form->isValid()) 
			{
				$em->persist($new_quiz);
				foreach ($form->get('question')->getData() as $question) 
				{
					$question->setQuiz($new_quiz);
					foreach($question->getAnswer() as $answer)
					{
						$answer->setQuestion($question);
					}
				}
				$em->flush();
		
				$this->get('session')->getFlashBag()->add('info', 'Quiz bien ajouté');
				return $this->redirect($this->generateUrl('edit_quiz', array('quiz' => $new_quiz->getId())));
			}
		}
	
	return $this->render('InkyQuizBundle:Quiz:addQuiz.html.twig', array('form' => $form->createView(),
																		'formName'=>'inky_quizbundle_quiztype_question',
																		'lesson' => $lesson->getId()));
	}
	
	public function editQuizAction (Quiz $quiz)
	{				
		$em = $this->getDoctrine()->getManager();
		
		
		// We create our form and treat the data if smt is submitted
		$form = $this->createForm(new QuizEditType(), $quiz);
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			
			$form->bind($request);
			if ($form->isValid()) 
			{
				$em->persist($quiz);
				foreach ($form->get('question')->getData() as $question) 
				{
					$question->setQuiz($quiz);
					foreach($question->getAnswer() as $answer)
					{
						$answer->setQuestion($question);
					}
				}
				$em->flush();
				$this->get('session')->getFlashBag()->add('EditQuiz', 'Quiz bien modifiee');
				return $this->redirect($this->generateUrl('edit_quiz', array('quiz' => $quiz->getId())));
			}
		}
		return $this->render(	'InkyQuizBundle:Quiz:editQuiz.html.twig', 
								array(	'form' => $form->createView(), 
										'formName'=>'inky_quizbundle_quizedittype_question',
										'quiz' => $quiz->getId()
								)
							);
	}

}
