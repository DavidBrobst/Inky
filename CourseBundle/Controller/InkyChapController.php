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
	public function viewInkyChapAction(Lesson $lesson, InkyChap $inkychap)
	{
		
		$em = $this->getDoctrine()->getManager();
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
		// If First visit, advancmeent updated
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

		return $this->forward('InkyQuizBundle:Quiz:takeQuiz', array('quiz' => $inkyQuiz->getQuiz() ));
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
				// InkyText
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
