<?php

namespace Inky\CourseBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Security
use Symfony\app\Config\security;
use FOS\UserBundle\Model\User;
// ACL
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

// Course
use Inky\CourseBundle\Entity\Course\Course;
use Inky\CourseBundle\Entity\Course\Subscribe;
use Inky\CourseBundle\Form\CourseType;
use Inky\CourseBundle\Form\CourseEditType;
use Inky\CourseBundle\Form\ImageType;

// Chapter
use Inky\CourseBundle\Entity\InkyChap\InkyChapAdvancement;

// Group
use Inky\UserBundle\Entity\Group;
use Inky\UserBundle\Form\GroupType;
use Inky\UserBundle\Form\GroupEditType;


class CourseController extends Controller
{
    public function indexAction()
    {
        return $this->render('InkyCourseBundle:Course:index.html.twig');
    }
	
	// Course
	public function showCoursesAction()
	{
		$courseList = $this	->getDoctrine()
								->getManager()
								->getRepository('InkyCourseBundle:Course\Course')
								->getCourses('learn',$this->getUser()->getId());
								
		return $this->render(	'InkyCourseBundle:Course:showCourses.html.twig',
								array(	'courseList' => $courseList,
										'bgColor' => '#00A3EF',
										
								)
							);
	}
	public function showCreatedCoursesAction()
	{
		$courseList = $this	->getDoctrine()
								->getManager()
								->getRepository('InkyCourseBundle:Course\Course')
								->getCourses('teach',$this->getUser()->getId());
								
		return $this->render(	'InkyCourseBundle:Course:showCourses.html.twig',
								array(	'courseList' => $courseList,
										'bgColor' => '#84A823',
								)
							);
	}
	// Course Administration
	public function adminCourseAction(Course $course)
	{
		$em = $this	->getDoctrine()->getManager();
		$request = $this->getRequest();
		
		if($request->isXmlHttpRequest()) 
		{
			$lessonId= $request->request->get('lessonId');
			$InkyChap = $em -> getRepository('InkyCourseBundle:InkyChap\InkyChap')->findByLesson($lessonId);
			
			return $this->render(	'InkyCourseBundle:InkyChap:InkyChapDetail.html.twig',
									array('InkyChap'=>$InkyChap));
		}
		
		$lessonList = $em->getRepository('InkyCourseBundle:Lesson\Lesson')->findByCourse($course);
								
		return $this->render(	'InkyCourseBundle:Course:adminCourse.html.twig',
								array(	'course' => $course,
										'lessons' => $lessonList
								)
							);
	}
	
	// Subscribe course
	public function subscribeCourseAction(Course $course)
	{
		$em = $this->getDoctrine()->getManager();
		$subscribe = $em->getRepository('InkyCourseBundle:Course\Subscribe')->	findBy(array(	'user' => $this->getUser(),
																								'course' => $course->getId()
																							)
																				);
		if(count($subscribe)<1)
		{
			$repository = $em->getRepository('InkyCourseBundle:InkyChap\InkyChap');
			$resume = $repository -> getFirstChap($course);
			$lesson = $resume->getLesson();
			$inkychap = $resume;

			$subscribe = new Subscribe();
			$subscribe ->setCourse($course);
			$subscribe ->setUser($this->getUser());
			$em->persist($subscribe);
			$em->flush($subscribe);
			

		}
		else
		{
			$resume = $em->getRepository('InkyCourseBundle:InkyChap\InkyChapAdvancement')->getLastChap( $course , $this->getUser() );
			$lesson = $resume->getInkychap()->getLesson();
			$inkychap = $resume->getInkyChap();
		}
		return $this->redirect	($this->generateUrl	('course_take', array(	'inkychap' => $inkychap->getId(),
																			'lesson' => $lesson->getId(),
																			'course' => $course->getId(),
																	)
													)
								);
	}
	
	// View Course
	public function viewCourseAction(Course $course)
	{
		$em = $this->getDoctrine()->getManager();
		
		$repository = $em->getRepository('InkyCourseBundle:Lesson\Lesson');
		if ($this->getUser()){$lessonList = $repository->getLessons($course->getId(), $this->getUser());}
		else {$lessonList = $repository->getLessons($course->getId());}
		
		return $this->render(	'InkyCourseBundle:Course:viewCourse.html.twig',
								array(	'course' => $course,
										'lessonList' => $lessonList,
								)
							);
	}
	
	// AddCourse
	public function addCourseAction()
	{
		$new_course = new Course;
		$new_course->setUser($this->getUser());
		
		$form = $this->createForm(new CourseType(), $new_course);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new course
				$em = $this->getDoctrine()->getManager();
				$em->persist($new_course);
				$em->flush();
				
				// Ajout des tags au cours
				foreach ($form->get('tags')->getData() as $tag) {
				  $tag->addCourse($new_course);
				  $em->persist($tag);
				}
				$em->flush();
				
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($new_course);
				$acl = $aclProvider->createAcl($objectIdentity);

				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);

				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
				
				$this->get('session')->getFlashBag()->add('lessonInfo', 'Votre cours a bien ete ajoute');
				return $this->redirect($this->generateUrl('lesson_new', array('courseId' => $new_course->getId())));
			}
		}
	
	return $this->render('InkyCourseBundle:Course:new.html.twig', array('form' => $form->createView(), 'formName'=>'inky_coursebundle_coursetype_tags'));
	}
	
	public function editCourseAction(Course $course)
	{
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $course)) {
            throw new AccessDeniedException();
        }
		
		$listTags = array();
		foreach ($course->getTags() as $gT) {$listTags[] = $gT;}
		
		$form = $this->createForm(new CourseEditType(), $course);
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$course->getTags()->clear();
			$form->bind($request);
			if ($form->isValid()) 
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($course);
				$em->flush();
				
				// On ajoute les nouveaux Tags
				

				// On supprime les anciens tags
				foreach($listTags as $originalTag)
				{
					foreach($form->get('tags')->getData() as $tag)
					{
						if($originalTag==$tag) {}
						else{
							$tag->addCourse($course);
							$em->persist($tag);
						}
					}
				}
				
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('info', 'course bien modifiée');
				return $this->redirect($this->generateUrl('course_edit', array('course' => $course)));
			}
		}
		return $this->render(	'InkyCourseBundle:Course:editCourse.html.twig', 
								array(	'form' => $form->createView(), 
										'formName'=>'inky_coursebundle_courseedittype_tags',
										'course' => $course
								)
							);
	}
	
	// Group
    public function viewGroupAction(Course $course)
    {
		$repository = $this->getDoctrine()->getManager()->getRepository('InkyUserBundle:Group');
		// Gets groups of the course
		$groupList = $repository->findByCourse($course->getId());

		return $this->render(	'InkyCourseBundle:Course:viewGroup.html.twig',
								array(	'course' => $course,
										'groupList' => $groupList,

								)
							);
	
    }

    public function addGroupAction(Course $course)
    {//We still have to add a role setting system!
	
		// Creation of a group and definition of the Founder
		$group = new Group;
		if ($this->getUser()) { $group->setGroupFounder($this->getUser());}
		$group->setCourse($course);
				
		// Creation of the associated form
		$form = $this->createForm(new GroupType(), $group, array('roles' => $this->container->getParameter('security.role_hierarchy.roles')));
		
		// If we have a Post request, we treat the inofrmation
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				
				
				$tokenGenerator = $this->get('fos_user.util.token_generator');
				$shareCode = $tokenGenerator->generateToken();
				$group->setShareCode($shareCode);
				
				$em->persist($group);
				$em->flush();
		
				$this->get('session')->getFlashBag()->add('infoGroup', 'Groupe bien ajouté');
				return $this->redirect($this->generateUrl('course_group_edit', array('group' => $group->getId())));
			}
		}
		return $this->render('InkyCourseBundle:Course:addGroup.html.twig', array('form' => $form->createView(), 'course'=>$course));
    }

    public function editGroupAction(Group $group)
    {
		$form = $this->createForm(new GroupEditType(), $group, array('roles' => $this->container->getParameter('security.role_hierarchy.roles')));
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($group);
				$em->flush();
				
				$this->get('session')->getFlashBag()->add('infoGroup', 'Groupe bien modifie');
				return $this->redirect($this->generateUrl('course_group_edit', array('group' => $group->getId())));
			}
		}
		return $this->render(	'InkyCourseBundle:Course:editGroup.html.twig', 
								array(	'form' => $form->createView(), 
										'group' => $group
								)
							);
	}
	
	public function generalSearchAction($search)
    {
		if ($search)
		{
			$search_result = $this->getDoctrine()->getManager()->getRepository('InkyCourseBundle:Course\Course')
								->searchCourse($search);
							
				return $this->render(	'InkyCourseBundle:Course:showCourses.html.twig', 
										array(	'courseList' => $search_result,
												'bgColor' => '#00A3EF',
												)
									);
		}
	}
	public function unsubscribeAction($id)
    {
	
	}
    
    public function progressAction()
    {
	}
}
