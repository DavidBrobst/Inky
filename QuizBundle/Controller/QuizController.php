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
use Inky\CourseBundle\Entity\Lesson\Lesson as Lesson;
use Inky\CourseBundle\Entity\InkyChap\InkyChap as InkyChap;
use Inky\QuizBundle\Entity\Question\Question;
use Inky\QuizBundle\Entity\Question\TfQuestion as TfQuestion;
use Inky\QuizBundle\Entity\Question\McQuestion as McQuestion;
use Inky\QuizBundle\Entity\Question\InputQuestion as InputQuestion;
use Inky\QuizBundle\Entity\Question\SubmitQuestion as SubmitQuestion;

use Inky\QuizBundle\Entity\UserAnswer\SubmitUser as SubmitUser;
use Inky\QuizBundle\Entity\UserAnswer\McUser as McUser;
use Inky\QuizBundle\Entity\UserAnswer\TfUser as TfUser;
use Inky\QuizBundle\Entity\UserAnswer\InputUser as InputUser;
use Inky\QuizBundle\Entity\Answer;

// Form
use Inky\QuizBundle\Form\QuizType;
use Inky\QuizBundle\Form\QuizEditType;

use Inky\QuizBundle\Form\Question\QuestionType;

class QuizController extends Controller
{

    public function QuizAction($name)
    {
        return $this->render('InkyQuizBundle:Default:index.html.twig', array('name' => $name));
    }
	
	// AddQuizz
	public function addQuizAction(Lesson $lesson)
	{
		$session = $this->get('session');
		$new_quiz = new Quiz;
		$new_quiz->setLesson($lesson);		
        $form = $this->createForm(new QuizType(), $new_quiz);
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
		     
			$formQu = $this->createForm(new QuizType(),$new_quiz);
			
				
			// Returns the appropriate form
            return $this->render('InkyQuizBundle:Quiz:quizType.html.twig', array(	'form' => $formQu->createView(),
																					'formName'=>'inky_quizbundle_quiztype_question',
																					'lesson' => $lesson	)
								);
		}

		if ($request->getMethod() == 'POST')
		{

			$form->bind($request);
			if ($form->isValid()) 
			{
				$response = $em->getRepository('InkyCourseBundle:InkyChap\InkyChap')->findByLesson($lesson);
				$orderId = (count($response)+1);
				// InkyChap
				$InkyChap = new InkyChap();
				$InkyChap->setTitle($form->get('title')->getData());
				$InkyChap->setType('InkyQuiz');
				$InkyChap->setLesson($lesson);
				$InkyChap->setOrderId($orderId);
				
				$em->persist($new_quiz);
				$em->persist($InkyChap);
				
				$em->flush();
		
				$this->get('session')->getFlashBag()->add('info', 'Quiz bien ajouté');
				return $this->redirect($this->generateUrl('add_question', array('quiz' => $new_quiz->getId())));
			}
		}
	
	return $this->render('InkyQuizBundle:Quiz:addQuiz.html.twig', array('form' => $form->createView(),
																		'formName'=>'inky_quizbundle_quiztype_question',
																		'lesson' => $lesson));
	}
	
	public function editQuizzesAction (Lesson $lesson)
	{
		return $this->render('InkyQuizBundle:Quiz:editQuizzes.html.twig', array('lesson' => $lesson));
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
				$this->get('session')->getFlashBag()->add('success', 'Quiz bien modifiee');
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
	
	public function addQuestionAction (Quiz $quiz)
	{
		$em = $this->getDoctrine()->getManager();
     	$request = $this->getRequest();		
		$QuTypeList = $em -> getRepository('InkyQuizBundle:Question\Question')->findAll();
		
		// If we have an Xml Request, we send the selected rendered form
		if($request->isXmlHttpRequest()) 
		{
            $QuestionType= $request->request->get('QuestionType');  
		    
			$FormClass = 'Inky\QuizBundle\Entity\Question\\'.$QuestionType;
			$Question = new $FormClass();
			$formQu = $this->createForm(new QuestionType($QuestionType),$Question);
			$this->get('session')->set('formType',$QuestionType);
				
			// Returns the appropriate form
            return $this->render('InkyQuizBundle:Quiz:questionType.html.twig', array(	'form' => $formQu->createView(),
																						'QuType'=>$QuestionType,
																						'formName'=>'inky_quizbundle_questiontype',
																						'quiz' => $quiz->getId()	)
								);
		}
		if ($request->getMethod() == 'POST')
		{
			$formType = $this->get('session')->get('formType');
			$formTypePath = 'Inky\QuizBundle\Entity\Question\\'.$formType;
			$new_question = new $formTypePath;
			$form = $this->createForm(new QuestionType($formType),$new_question);
			$form->bind($request);
			if ($form->isValid()) 
			{
				
				$new_question->setQuiz($quiz);
				$em->persist($new_question);
				if($formType!='TfQuestion')
				{
					foreach($form->get('answer')->getData() as $answer)
					{
						$answer->setQuestion($new_question);
					}
					
				}
				
				$em->flush();
			}
		
			
		}
		return $this->render(	'InkyQuizBundle:Question:addQuestion.html.twig',array(	'formName'=>'inky_quizbundle_question',
																						'quiz' => $quiz->getId(),
																						'QuTypeList' => $QuTypeList
																				)
							);

	}
	
	public function viewQuizAction(Lesson $lesson)
	{
		return $this->render(	'InkyQuizBundle:Quiz:viewQuiz.html.twig',array('lesson' => $lesson)
							);
	}
	
	public function adminQuizAction(Lesson $lesson)
	{
		return $this->render(	'InkyQuizBundle:Quiz:adminQuiz.html.twig',array('lesson' => $lesson)
							);
	}
	
	public function takeQuizAction (Quiz $quiz)
	{
		$em = $this->getDoctrine()->getManager();
		$request = $this->getRequest();		
		
		if($request->isXmlHttpRequest()) 
		{
			$QuestionType= $request->request->get('QuestionType');
			$QuestionId= $request->request->get('QuestionId');
				
			// We get the next question from the datababez and do everything in our power to return the corresponding template ;-)
			// To do so we need nothing but the type of question and its ID
			$quEntity = 'InkyQuizBundle:Question\\'.$QuestionType;
			$em = $this->getDoctrine()->getManager();
			$QuDetail = $em -> getRepository($quEntity)->findOneById($QuestionId);
			$option['question'] = $QuDetail;
			// Create user answer Type
			if($QuestionType=='McQuestion')
			{
				$AnsDetail = $em -> getRepository('InkyQuizBundle:Answer\McAnswer')->findByQuestion($QuestionId);
				$option['answer'] = $AnsDetail ;
			}	
			$request = $this->getRequest();
			return $this->render(	'InkyQuizBundle:UserAnswer:'.$QuestionType.'.html.twig',$option
								);
		}
	}
	
	public function renderQuestionAction($type,$id,$option = array())
	{
		$request = $this->getRequest();
		$user = $this->getUser();
		if($request->isXmlHttpRequest()) 
		{
			// We get what was sent byt the user
            $QuestionType= $request->request->get('QuestionType');
            $QuestionId= $request->request->get('QuestionId');
            $Answer= $request->request->get('answer');
			
			// We then transform it into an answer in the datababez
			$em = $this->getDoctrine()->getManager();
			
			if($QuestionType == 'McQuestion')
			{
				$chosenAnswer = $em -> getRepository('InkyQuizBundle:Answer\McAnswer')->findOneById($Answer);
				$chosenQuestion = $em -> getRepository('InkyQuizBundle:Question\McQuestion')->findOneById($QuestionId);
				
				// Determine wheter or not the user has already answered
				$exist = $em -> getRepository('InkyQuizBundle:UserAnswer\McUser')->findOneBy(array('question'=>$QuestionId,'user'=>$user));
				if(count($exist)>0){$Answer = $exist;}
				else { $Answer=new McUser;	$Answer->setUser($user); $Answer->setQuestion($chosenQuestion);}
				
				$Answer -> setAnswer($chosenAnswer);
				$em->persist($Answer);
				$em->flush();
			}
			elseif($QuestionType == 'TfQuestion')
			{
				$chosenAnswer = $Answer;
				$chosenQuestion = $em -> getRepository('InkyQuizBundle:Question\TfQuestion')->findOneById($QuestionId);
				
				// Determines whether or not the user has already answered
				$exist = $em -> getRepository('InkyQuizBundle:UserAnswer\TfUser')->findOneBy(array('question'=>$QuestionId,'user'=>$user));
				if(count($exist)>0){$Answer = $exist;}
				else { $Answer=new TfUser;	$Answer->setUser($user); $Answer->setQuestion($chosenQuestion);}
				
				$Answer -> setAnswer($chosenAnswer);
				$em->persist($Answer);
				$em->flush();
			}
			elseif($QuestionType == 'InputQuestion')
			{
				$chosenAnswer = $Answer;
				$chosenQuestion = $em -> getRepository('InkyQuizBundle:Question\InputQuestion')->findOneById($QuestionId);
				
				// Determines whether or not the user has already answered
				$exist = $em -> getRepository('InkyQuizBundle:UserAnswer\InputUser')->findOneById(array('question'=>$QuestionId,'user'=>$user));
				if(count($exist)>0){$Answer = $exist;}
				else { $Answer=new InputUser;	$Answer->setUser($user); $Answer->setQuestion($chosenQuestion);}
				
				$Answer -> setAnswer($chosenAnswer);
				$em->persist($Answer);
				$em->flush();
			}
			elseif($QuestionType == 'SubmitQuestion')
			{
				$chosenAnswer = $Answer;
				$chosenQuestion = $em -> getRepository('InkyQuizBundle:Question\SubmitQuestion')->findOneById($QuestionId);
				
				// Determines whether or not the user has already answered
				$exist = $em -> getRepository('InkyQuizBundle:UserAnswer\SubmitUser')->findOneById(array('question'=>$QuestionId,'user'=>$user));
				if(count($exist)>0){$Answer = $exist;}
				else { $Answer=new SubmitUser;	$Answer->setUser($user); $Answer->setQuestion($chosenQuestion);}
				
				$Answer -> setAnswer($chosenAnswer);
				$em->persist($Answer);
				$em->flush();
			}
			
			            
		}
		// Here we find the question (and answer options if MultipleChhoice question)
		$quEntity = 'InkyQuizBundle:Question\\'.$type;
		$em = $this->getDoctrine()->getManager();
		$QuDetail = $em -> getRepository($quEntity)->findOneById($id);
		$option['question'] = $QuDetail;
		// Create user answer Type
		if($type=='McQuestion')
		{
			$AnsDetail = $em -> getRepository('InkyQuizBundle:Answer\McAnswer')->findByQuestion($id);
			$option['answer'] = $AnsDetail ;
		}	
		$request = $this->getRequest();
		return $this->render(	'InkyQuizBundle:UserAnswer:'.$type.'.html.twig',$option
							);
	}
}
