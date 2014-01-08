<?php

namespace Inky\ForumBundle\Controller;

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
use Inky\ForumBundle\Entity\Board;
use Inky\ForumBundle\Entity\Topic;
use Inky\ForumBundle\Entity\Thread;
use Inky\ForumBundle\Entity\Message;

// Form
use Inky\ForumBundle\Form\BoardType;
use Inky\ForumBundle\Form\BoardEditType;
use Inky\ForumBundle\Form\TopicType;
use Inky\ForumBundle\Form\TopicEditType;
use Inky\ForumBundle\Form\ThreadType;
use Inky\ForumBundle\Form\ThreadEditType;

class ForumController extends Controller
{


	// BOARD //
    public function showBoardsAction()
    {
		$boardList = $this	->getDoctrine()
								->getManager()
								->getRepository('InkyForumBundle:Board')
								->findAll();
        return $this->render('InkyForumBundle:Forum:showBoards.html.twig',array('boardList'=>$boardList));
    }
	
	public function newBoardAction()
    {
		$new_board = new Board;
		$new_board->setUser($this->getUser());

		$form = $this->createForm(new BoardType(), $new_board);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new board
				$em = $this->getDoctrine()->getManager();
				$em->persist($new_board);
				$em->flush();
				
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($new_board);
				$acl = $aclProvider->createAcl($objectIdentity);

				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);

				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
				
				$this->get('session')->getFlashBag()->add('topicInfo', 'board_added');
				return $this->redirect($this->generateUrl('inky_forum_newTopic', array('boardId' => $new_board->getId())));
			}
		}
		return $this->render('InkyForumBundle:Forum:newBoard.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_boardtype')
							);
	}
	
	public function editBoardAction(Board $board)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $board)) {
            throw new AccessDeniedException();
        }
		
		$form = $this->createForm(new BoardEditType(), $board);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new board
				$em = $this->getDoctrine()->getManager();
				$em->persist($board);
				$em->flush();
			}
			$this->get('session')->getFlashBag()->add('topicInfo', 'board_added');
			return $this->redirect($this->generateUrl('topic_new', array('boardId' => $board->getId())));
		}
		
	
	
		return $this->render('InkyForumBundle:Forum:editBoard.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_board_edit_type')
							);
	}
	
	public function deleteBoardAction(Board $board)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('DELETE', $board)) {
            throw new AccessDeniedException();
        }
		// We create an empty form containing only a CSRF field for security measures
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new board
				$em = $this->getDoctrine()->getManager();
				$em->remove($board);
				$em->flush();
			}
			$this->get('session')->getFlashBag()->add('SuccessInfo', 'board_added');
			return $this->redirect($this->generateUrl('inky_forum_boards'));
		}
		return $this->render('InkyForumBundle:Forum:showBoards.html.twig',
						array(	'form' => $form->createView(),	
								'board'=>$board)
							);
	}	
	
	
	
	
	// TOPIC //
	
    public function showTopicsAction(Board $board)
    {
		$topicList = $this	->getDoctrine()
								->getManager()
								->getRepository('InkyForumBundle:Topic')
								->findAllByBoard($board);
        return $this->render('InkyForumBundle:Forum:showTopics.html.twig',array('topicList'=>$topicList));
    }
	
	public function newTopicAction(Board $board)
    {
		$new_topic = new Topic;
		$new_topic->setUser($this->getUser());
		$new_topic->setBoard($board);

		$form = $this->createForm(new TopicType(), $new_topic);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new topic
				$em = $this->getDoctrine()->getManager();
				$em->persist($new_topic);
				
				// Update Topic count in Board
				$boardCount = intval($board->getCachedPosts()+1);
				$board -> setCachedPosts($boardCount);
				$em->persist($board);
				
				$em->flush();
				
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($new_topic);
				$acl = $aclProvider->createAcl($objectIdentity);

				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);

				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
				
				$this->get('session')->getFlashBag()->add('topicInfo', 'topic_added');
				return $this->redirect($this->generateUrl('inky_forum_newThread', array('topic' => $new_topic->getId())));
			}
		}
		return $this->render('InkyForumBundle:Forum:newTopic.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_topictype')
							);
	}
	
	public function editTopicAction(Topic $topic)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $topic)) {
            throw new AccessDeniedException();
        }
		
		$form = $this->createForm(new TopicEditType(), $topic);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new topic
				$em = $this->getDoctrine()->getManager();
				$em->persist($topic);
				$em->flush();
			}
			$this->get('session')->getFlashBag()->add('topicInfo', 'topic_added');
			return $this->redirect($this->generateUrl('topic_new', array('topicId' => $topic->getId())));
		}
		
		return $this->render('InkyForumBundle:Forum:editTopic.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_topic_edit_type')
							);
	}
	
	public function deleteTopicAction(Topic $topic)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('DELETE', $topic)) {
            throw new AccessDeniedException();
        }
		// We create an empty form containing only a CSRF field for security measures
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new topic
				$em = $this->getDoctrine()->getManager();
				$em->remove($topic);
				
				// Update Topic count in Board
				$board = $topic->getBoard();
				$boardCount = intval($board->getCachedPosts()-1);
				$board -> setCachedPosts($boardCount);
				$em->persist($board);
				
				$em->flush();
			}
			$this->get('session')->getFlashBag()->add('SuccessInfo', 'topic_added');
			return $this->redirect($this->generateUrl('inky_forum_topics', array('boardId'=>$topic->getBoard()->getId())));
		}
		
	
	
		return $this->render('InkyForumBundle:Forum:showBoards.html.twig',
						array(	'form' => $form->createView(),
								'topic'=>$topic)
							);
	}	
	
	
	
	// THREAD //
	
	// List of threads
    public function showThreadsAction(Topic $topic)
    {
		$threadList = $this	->getDoctrine()
								->getManager()
								->getRepository('InkyForumBundle:Thread')
								->findAllByTopic($topic);
        return $this->render('InkyForumBundle:Forum:showThreads.html.twig',array('threadList'=>$threadList));
    }
	
	// List of messages in a thread
	public function showThreadAction(Thread $thread)
    {
		$messageList = $this	->getDoctrine()
								->getManager()
								->getRepository('InkyForumBundle:Message')
								->findByThread($thread->getId());
        return $this->render('InkyForumBundle:Forum:showThread.html.twig',array('messageList'=>$messageList));
    }
	
	public function newThreadAction(Topic $topic)
    {
		$new_message = new Message;
		$new_message->setUser($this->getUser());
		
		$new_thread = new Thread;
		$new_thread->setUser($this->getUser());
		$new_thread->setTopic($topic);
		$new_thread->addMessage($new_message);
		
		$form = $this->createForm(new ThreadType(), $new_thread);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new thread
				$em = $this->getDoctrine()->getManager();
				$slug = substr($new_message->getContent(),0,250);
				$new_thread->setSlugFirstMessage($slug);
				$em->persist($new_thread);
				
				// Update Topic count in Board
				$topicCount = intval($topic->getCachedThreadNb()+1);
				$topic -> setCachedThreadNb($topicCount);
				$em->persist($topic);
				
				$em->flush();
				
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($new_thread);
				$acl = $aclProvider->createAcl($objectIdentity);

				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);

				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
				
				$this->get('session')->getFlashBag()->add('threadInfo', 'thread_added');
				return $this->redirect($this->generateUrl('inky_forum_thread', array('thread' => $new_thread->getId())));
			}
		}
		return $this->render('InkyForumBundle:Forum:newThread.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_threadtype')
							);
	}
	
	public function editThreadAction(Thread $thread)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $thread)) {
            throw new AccessDeniedException();
        }
		
		$form = $this->createForm(new ThreadEditType(), $thread);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Edit thread
				$em = $this->getDoctrine()->getManager();
				$em->persist($thread);
				$em->flush();
			}
			$this->get('session')->getFlashBag()->add('threadInfo', 'thread_added');
			return $this->redirect($this->generateUrl('inky_forum_thread', array('threadId' => $thread->getId())));
		}
		
		return $this->render('InkyForumBundle:Forum:editThread.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_thread_edit_type')
							);
	}
	
	public function deleteThreadAction(Thread $thread)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('DELETE', $thread)) {
            throw new AccessDeniedException();
        }
		// We create an empty form containing only a CSRF field for security measures
		$form = $this->createFormBuilder()->getForm();
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if ($form->isValid()) 
			{
				// Add new thread
				$em = $this->getDoctrine()->getManager();
				$em->remove($thread);
				
				// Update Thread count in Topic
				$topic = $thread->getTopic();
				$topicCount = intval($topic->getCachedPosts()-1);
				$topic -> setCachedPosts($topicCount);
				$em->persist($topic);
				
				$em->flush();
			}
			$this->get('session')->getFlashBag()->add('SuccessInfo', 'thread_added');
			return $this->redirect($this->generateUrl('inky_forum_threads', array('topicId'=>$thread->getTopic()->getId())));
		}
		
	
	
		return $this->render('InkyForumBundle:Forum:showTopic.html.twig',
						array(	'form' => $form->createView(),
								'topic'=>$topic->getId())
							);
	}

}
