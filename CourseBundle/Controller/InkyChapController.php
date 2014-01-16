<?php

namespace Inky\CourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\User;

use Inky\CourseBundle\Entity\Lesson\Lesson as Lesson;
use Inky\CourseBundle\Entity\InkyChap\InkyChap;
use Inky\CourseBundle\Entity\InkyChap\InkyText;
use Inky\CourseBundle\Entity\InkyChap\InkyVideo;
use Inky\CourseBundle\Entity\InkyChap\InkyChapAdvancement;

use Inky\CourseBundle\Form\InkyChap\InkyTextType;
use Inky\CourseBundle\Form\InkyChap\InkyVideoType;

class InkyChapController extends Controller
{
	public function renderInkyChapAction(InkyChap $inkychap)
	{
		// Return the course page and InkyChap loaded
		return $inkychap->getTitle();
	}
	public function viewInkyChapAction(InkyChap $inkychap)
	{
		
		$em = $this->getDoctrine()->getManager();
		$lesson = $inkychap->getLesson();
		
		// InkyUser's Advancemnt
		$repository = $em->getRepository('InkyCourseBundle:InkyChap\InkyChapAdvancement');
		$advancement = $repository->getLessonAdvancement($lesson,$this->getUser());
		$currentAdv = $repository->findBy(array('inkychap'=>$inkychap, 'user'=>$this->getUser()));
		
		// Lesson's InkyChapters
		$repository = $em->getRepository('InkyCourseBundle:InkyChap\InkyChap');
		$InkyChapList = $repository->findByLesson($lesson);
		
		// We bind the chapter and advancements to see what the InkyUser has and hasn't studied
		$InkyChapMapOut = array();
		foreach ($InkyChapList as $InkyCL)
		{
			$completed = false;
			foreach($advancement as $adv)
			{
				if ($inkychap == $InkyCL) {$completed = 'current';}
				elseif ($adv->getInkyChap() == $InkyCL) {$completed = 'completed';}
			}
			$InkyChapMapOut[] = array(	'InkyChapTitle'=>$InkyCL->getTitle(),
										'InkyChapId'=>$InkyCL->getId(),
										'status' => $completed,
										'inkychap'=> $inkychap
									);
		}
		
		// If First visit, advancement updated
		// The advancement here describes where the user GOT not what he completed
		if(!$currentAdv)
		{
			$currentAdv = new InkyChapAdvancement;
			$currentAdv->setCompleted(true);
			$currentAdv->setUser($this->getUser());
			$currentAdv->setInkychap($inkychap);
			$em->persist($currentAdv);
			$em->flush();	
		}
		// Chapter
		return $this->render(	'InkyCourseBundle:InkyChap:viewInkyChap.html.twig', 
								array(	'lesson' => $lesson,
										'inkychap'=> $inkychap,
										'mapout' => $InkyChapMapOut,
										'nbinkychap' => count($InkyChapList)
								)
							);
	}
	
	// Render  InkyText
	public function renderInkyTextAction(InkyChap $inkyChap)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('InkyCourseBundle:InkyChap\InkyText');
		$inkyText = $repository->findOneByInkyChap($inkyChap);
		return $this->render(	'InkyCourseBundle:InkyChap:InkyText.html.twig', 
								array(	'inkytext' => $inkyText)
							);
	}
	// Render  InkyQuiz
	public function renderInkyQuizAction(InkyChap $inkyChap)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('InkyCourseBundle:InkyChap\InkyQuiz');
		$inkyQuiz = $repository->findOneByInkyChap($inkyChap);
		
		function getQuRef($quiz,$em)
		{
					
			// We display question refference in an array with the type of question, its Id (what we need to get it) AND an OrderId to know how to diplay them
			// ToDo: Add the order thingy in each array created
			$QuRef = array ();
			//McQuestion
			$McQuestionList = $em -> getRepository('InkyQuizBundle:Question\McQuestion')->findByQuiz($quiz);
			foreach ($McQuestionList as $McQu)
			{
				$QuRef[] = array('McQuestion',$McQu->getId());
			}
			$InputQuestionList = $em -> getRepository('InkyQuizBundle:Question\InputQuestion')->findByQuiz($quiz);
			foreach ($InputQuestionList as $InputQu)
			{
				$QuRef[] = array('InputQuestion',$InputQu->getId());
			}
			$TfQuestionList = $em -> getRepository('InkyQuizBundle:Question\TfQuestion')->findByQuiz($quiz);
			foreach ($TfQuestionList as $TfQu)
			{
				$QuRef[] = array('TfQuestion',$TfQu->getId());
			}
			$SubmitQuestionList = $em -> getRepository('InkyQuizBundle:Question\SubmitQuestion')->findByQuiz($quiz);
			foreach ($SubmitQuestionList as $SubmitQu)
			{
				$QuRef[] = array('SubmitQuestion',$McQu->getId());
			}
			
			return $QuRef;
		}
		// Once ou Question Refenrence has been populated, all that is left to do is to fetch the question and send the answer to the datababez
		return $this->render(	'InkyQuizBundle:UserAnswer:takeQuiz.html.twig',array(	'quiz' => $inkyQuiz,
																						'QuRef' => getQuRef($inkyQuiz,$em)
																				)
							);
	}

	// Render  InkyVideo
	public function renderInkyVideoAction(InkyChap $inkyChap)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('InkyCourseBundle:InkyChap\InkyVideo');
		$inkyVideo = $repository->findOneByInkyChap($inkyChap);

		// If the video URL is 11 characters long, we have the youtube video code
		if(strlen($inkyVideo->getUrl()) == 11)
			$url = '//www.youtube.com/v/'.$inkyVideo->getUrl();
		else
			$url = $inkyVideo->getUrl();
			
		return $this->render(	'InkyCourseBundle:InkyChap:InkyVideo.html.twig', 
						array(	'inkyvideo' => $inkyVideo->getId(),
								'url' => $url)
					);
	}
	
	// Add InkyChap
	public function addInkyChapAction(Lesson $lesson)
	{
	// Chapter	
	return $this->render(	'InkyCourseBundle:InkyChap:newInkyChap.html.twig', 
								array(	'lesson' => $lesson	)
							);
	}
	
	// InkyChap Stats
	public function statsAction(InkyChap $inkychap)
	{
	// Chapter	
	return $this->render(	'InkyCourseBundle:InkyChap:stats.html.twig', 
								array(	'inkychap' => $inkychap	)
							);
	}
	// Text
	public function addInkyTextAction(Lesson $lesson)
	{
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new InkyTextType());
		
		$request = $this->getRequest();
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
				$InkyChap->setType('InkyText');
				$InkyChap->setLesson($lesson);
				$InkyChap->setOrderId($orderId);
				// InkyText
				$InkyText = new InkyText();
				$InkyText->setInkyChap($InkyChap);
				$InkyText->setTitle($form->get('title')->getData());
				$InkyText->setContent ($form->get('content')->getData());
				// And send to Datababez
				$em->persist($InkyChap);
				$em->persist($InkyText);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('InkyText', 'Creation effectuee');
				return $this->redirect($this->generateUrl('inkychap_add', array('lesson' => $lesson->getId())));
			}
		}
	return $this->render(	'InkyCourseBundle:InkyChap:newInkyText.html.twig', 
								array(	'lesson' => $lesson,
										'form' => $form->createView())
							);
	}
	// Video
	public function addInkyVideoAction(Lesson $lesson)
	{
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new InkyVideoType());
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			
			$form->bind($request);
			if ($form->isValid()) 
			{
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $form->get('url')->getData(), $match)) {
					$video_code = $match[1];
				}
				else
					$video_code = $form->get('url')->getData();
				$response = $em->getRepository('InkyCourseBundle:InkyChap\InkyChap')->findByLesson($lesson);
				$orderId = (count($response)+1);
				// InkyChap
				$InkyChap = new InkyChap();
				$InkyChap->setTitle($form->get('title')->getData());
				$InkyChap->setType('InkyVideo');
				$InkyChap->setLesson($lesson);
				$InkyChap->setOrderId($orderId);
				
				// InkyVideo
				$InkyVideo = new InkyVideo();
				$InkyVideo->setInkyChap($InkyChap);
				$InkyVideo->setTitle($form->get('title')->getData());
				$InkyVideo->setUrl ($video_code);
				
				// And send to Datababez
				$em->persist($InkyChap);
				$em->persist($InkyVideo);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('success', 'Creation effectuee');
				return $this->redirect($this->generateUrl('inkychap_add', array('lesson' => $lesson->getId())));
			}
		}
		return $this->render(	'InkyCourseBundle:InkyChap:newInkyVideo.html.twig', 
									array(	'lesson' => $lesson,
										'form' => $form->createView())
								);
	}
	// Quiz is in the quiz Bundle
}
