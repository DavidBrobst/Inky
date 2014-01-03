<?php

namespace Inky\CourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\User;

use Inky\CourseBundle\Entity\Comment\Thread;

use Inky\CourseBundle\Entity\Lesson\Lesson as Lesson;
use Inky\CourseBundle\Entity\Course\Course as Course;
use Inky\CourseBundle\Form\LessonType;
use Inky\CourseBundle\Form\LessonEditType;
use Inky\CourseBundle\Form\ImageType;


class LessonController extends Controller
{
    public function indexAction()
    {
        return $this->render('InkyCourseBundle:Lesson:index.html.twig');
    }

	//Lesson
	public function viewLessonAction(Lesson $lesson)
	{

		return $this->render('InkyCourseBundle:Lesson:viewLesson.html.twig', array('lesson' => $lesson));
	}
	
	public function newLessonAction(Course $course)
	{
		$em = $this->getDoctrine()->getManager();

		$new_lesson = new Lesson;
		$new_thread = new Thread;

		$form = $this->createForm(new LessonType(), $new_lesson);
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
			 
				$em->persist($new_lesson);
				$em->flush();
				$em->persist($new_thread);
				
				$new_lesson->setUser($this->getUser());
				$new_lesson->setAskThread($new_thread);
				$new_lesson->setCourse($course);
				$new_lesson->setCourse($course);
				
				$new_thread->setPermalink($this->generateUrl('lesson_ask', array('lesson'=>$new_lesson->getId()), true));

				$em->flush();
		
				$this->get('session')->getFlashBag()->add('success', 'Lesson bien ajouté');
				return $this->redirect($this->generateUrl('inkychap_add', array('lesson' => $new_lesson->getId())));
			}
		}
	
		return $this->render('InkyCourseBundle:Lesson:newLesson.html.twig', array(	'form' => $form->createView(),
																					'formName'=>'inky_coursebundle_lessontype_tags',
																					'course'=>$course));
	}
	
	public function editLessonAction(Lesson $lesson)
	{				
		$em = $this->getDoctrine()->getManager();
		
		// We start by storing the existant tags and cleaning the db
		$listTags = array();
		foreach ($lesson->getTags() as $gT)
		{
			$listTags[] = $gT;
			$em->remove($gT);
		}
		
		// We create our form and treat the data if smt is submitted
		$form = $this->createForm(new LessonEditType(), $lesson);
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			// We make sure nothing was persisted
			$lesson->getTags()->clear();
			
			$form->bind($request);
			if ($form->isValid()) 
			{
				
				// We add the new tags since the old ones got deleted
				foreach ($form->get('tags')->getData() as $tag) {
				  $tag->setLesson($lesson);
				  // Here we should try to add [external reference keys] in lesson_tag,
				  // rather than creating the same tag AND a new external reference key 1000000000 times!
				  // TIP: It would mean changing the tag lesson relationship and setting it to OntToMany with tag owning side ;-)
				  $em->persist($tag);
				}
				
				// Aaaaaaaand we flush ;-)
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('EditLesson', 'Lesson bien modifiee');
				return $this->redirect($this->generateUrl('lesson_edit', array('lesson' => $lesson)));
			}
		}
		return $this->render(	'InkyCourseBundle:Lesson:editLesson.html.twig', 
								array(	'form' => $form->createView(), 
										'formName'=>'inky_coursebundle_lessonedittype_tags',
										'lesson' => $lesson
								)
							);
	}
	
	public function deleteAction(Lesson $lesson)
	{
		
		return $this->render(	'InkyCourseBundle:Lesson:ask.html.twig', 
								array(	'lesson' => $lesson	)
							);
	}

	public function statsAction(Lesson $lesson)
	{
		
		return $this->render(	'InkyCourseBundle:Lesson:stats.html.twig', 
								array(	'lesson' => $lesson	)
							);
	}

	public function askAction(Lesson $lesson)
	{
		
		return $this->render(	'InkyCourseBundle:Lesson:ask.html.twig', 
								array(	'lesson' => $lesson	)
							);
	}
	public function documentationAction(Lesson $lesson)
	{
		
		return $this->render(	'InkyCourseBundle:Lesson:documentation.html.twig', 
								array(	'lesson' => $lesson	)
							);
	}
	public function statisticsAction(Lesson $lesson)
	{
		
		return $this->render(	'InkyCourseBundle:Lesson:statistics.html.twig', 
								array(	'lesson' => $lesson	)
							);
	}
	
}
