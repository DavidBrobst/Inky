<?php

namespace Inky\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Security
use Symfony\app\Config\security;
use FOS\UserBundle\Model\User;

// Entity
use Inky\QuizBundle\Entity\Quiz as Quiz;

// Form

class UserAnswerController extends Controller
{
	
	// AddQuizz
	public function userAnswerAction(Quiz $quiz)
	{
		
	return $this->render('InkyQuizBundle:UserAnswer:takeQuiz.html.twig', array('quiz' => $quiz));
	}
	
}
