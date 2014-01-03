<?php

namespace Inky\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class QuestionController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('InkyQuizBundle:Default:index.html.twig', array('name' => $name));
    }
}
