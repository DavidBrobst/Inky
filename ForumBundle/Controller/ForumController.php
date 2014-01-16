<?php

namespace Inky\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Security
use Symfony\app\Config\security;
use FOS\UserBundle\Model\User;
use Symfony\Component\Form\FormError;

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
use Inky\ForumBundle\Form\MessageType;

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
				
				$this->get('session')->getFlashBag()->add('success', 'board_added');
				return $this->redirect($this->generateUrl('inky_forum_newTopic', array('board' => $new_board->getId())));
			}
		}
		return $this->render('InkyForumBundle:Forum:newBoard.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_boardtype',
								'board'=>$board
							)
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
			$this->get('session')->getFlashBag()->add('success', 'board_modified');
			return $this->redirect($this->generateUrl('inky_forum_boards'));
		}
		
	
	
		return $this->render('InkyForumBundle:Forum:editBoard.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_board_edit_type',
								'board'=>$board)
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
			$this->get('session')->getFlashBag()->add('success', 'board_added');
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
								->findByBoard($board);
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
				$boardCount = intval($board->getCachedTopicNb()+1);
				$board -> setCachedTopicNb($boardCount);
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
				
				$this->get('session')->getFlashBag()->add('success', 'topic_added');
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
			$this->get('session')->getFlashBag()->add('success', 'topic_added');
			return $this->redirect($this->generateUrl('inky_forum_threads', array('topic' => $topic->getId())));
		}
		
		return $this->render('InkyForumBundle:Forum:editTopic.html.twig',
							array(	'form' => $form->createView(),	
									'formName'=>'inky_forumbundle_topic_edit_type',
									'topic' => $topic,
								)
							);
	}
	
	public function deleteTopicAction(Topic $topic)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('DELETE', $topic)) 
		{
            $this->get('session')->getFlashBag()->add('error', 'topic_not_deleted_unsufficient_access');
			return $this->redirect($this->generateUrl('inky_forum_threads', array('topic'=>$topic->getId())));
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
				$boardCount = intval($board->getCachedPostNb()-1);
				$board -> setCachedPostNb($boardCount);
				$em->persist($board);
				
				$em->flush();
			}
			$this->get('session')->getFlashBag()->add('success', 'topic_added');
			return $this->redirect($this->generateUrl('inky_forum_topics', array('board'=>$topic->getBoard()->getId())));
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
		$request = $this->getRequest();	
		$em = $this->getDoctrine()->getManager();
		
		// nb Threads Per Page
		$nbThread = 50;
		$totalNbThread = $em->getRepository('InkyForumBundle:Thread')->countThreads($topic);
		
		if($request->isXmlHttpRequest()) 
		{
			$threadStart= $request->request->get('ThreadStart');

			
			$threadList = $em -> getRepository('InkyForumBundle:Thread')->getSomeThreads($topic, $threadStart, $nbThread);
			
			return $this->render(	'InkyForumBundle:Forum:showThreadContent.html.twig',
									array('threadList'=>$threadList,'a'=>$threadStart)
								);
		}
		
		$threadList = $em	->getRepository('InkyForumBundle:Thread')
							->getSomeThreads($topic);
        return $this->render('InkyForumBundle:Forum:showThreads.html.twig',
								array(	'threadList'=>$threadList,
										'topic'=>$topic,
										'nbThread'=>$nbThread,
										'totalNbThread'=>$totalNbThread)
							);
    }
	
	// List of messages in a thread
	public function showThreadAction(Thread $thread)
    {
		// Entity manager
		$em = $this->getDoctrine()->getManager();
		// Thread View Update
		$updated_views = intval($thread->getViews()+1);
		$thread->setViews($updated_views);
		// Creation of Message form
		$new_message = new Message;
		$form = $this->createForm(new MessageType(), $new_message);
		// Current user
		$user = $this->getUser();
		$lastMessageUser = $em->getRepository('InkyForumBundle:Message')->getLastMessageUser($thread)->getUser();
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST')
		{
			$form->bind($request);
			if($user == $lastMessageUser)
			{
				$form->get('content')->addError(new FormError('antispam_message'));
			}
			elseif ($form->isValid())
			{
				// Add new message to thread
				$new_message->setThread($thread);
				$new_message->setIsFirstMessage(false);
				$new_message->setUser($user);

				// Update Message count in Thread
				$thread_updated_replies = intval($thread->getReplies()+1);
				$thread->setReplies($thread_updated_replies);
				$thread->setLast(new \Datetime());
				
				// Update Post count in Topic
				$topic = $thread->getTopic();
				$topicCount = intval($topic->getCachedPostNb()+1);
				$topic -> setCachedPostNb($topicCount);

				// Update Post count in Board
				$board = $thread->getTopic()->getBoard();
				$topicCount = intval($topic->getCachedPostNb()+1);
				$topic -> setCachedPostNb($topicCount);


				
				$em->persist($topic);
				$em->persist($new_message);
				$em->flush();
				
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($new_message);
				$acl = $aclProvider->createAcl($objectIdentity);

				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);

				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
				}
		}
		$em->persist($thread);
		$em->flush();
		
		// Message List, with possibly newly created message
		$messageList = $em->getRepository('InkyForumBundle:Message')->findBy(array('thread'=>$thread->getId(),'isDeleted'=>false));   
		return $this->render(	'InkyForumBundle:Forum:showThread.html.twig',
								array(	'messageList'=>$messageList,
										'thread'=>$thread,
										'form'=>$form->createView()));
    }
	
	public function newThreadAction(Topic $topic)
    {
		$new_message = new Message;
		$new_message->setUser($this->getUser());
		$new_message->setIsFirstMessage(true);
		
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
				$slug = substr($new_message->getContent(),0,150);
				$new_thread->setSlugFirstMessage($slug);
				

				// Update Post count in Topic
				$topicCount = intval($topic->getCachedPostNb()+1);
				$topic -> setCachedPostNb($topicCount);
				
				// Update Thread count in Topic
				$topicCount = intval($topic->getCachedThreadNb()+1);
				$topic -> setCachedThreadNb($topicCount);
				
				// Update Post count in Board
				$board = $topic->getBoard();
				$boardCount = intval($board->getCachedPostNb()+1);
				$board -> setCachedPostNb($boardCount);
				
				// Let's be persistent XD
				$em->persist($new_thread);
				$em->persist($new_message);
				$em->persist($topic);
				$em->persist($board);
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
				
				$this->get('session')->getFlashBag()->add('success', 'thread_added');
				return $this->redirect($this->generateUrl('inky_forum_thread', array('thread' => $new_thread->getId())));
			}
		}
		return $this->render('InkyForumBundle:Forum:newThread.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_threadtype',
								'topic'=>$topic)
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
			$this->get('session')->getFlashBag()->add('success', 'thread_added');
			return $this->redirect($this->generateUrl('inky_forum_thread', array('thread' => $thread->getId())));
		}
		
		return $this->render('InkyForumBundle:Forum:editThread.html.twig',
						array(	'form' => $form->createView(),	
								'formName'=>'inky_forumbundle_thread_edit_type',
								'thread' => $thread,
							)
							);
	}
	
	public function deleteThreadAction(Thread $thread)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('DELETE', $thread)) 
		{
			$this->get('session')->getFlashBag()->add('error', 'thread_not_deleted_unsufficient_permissions');
			return $this->redirect($this->generateUrl('inky_forum_thread', array('thread' => $thread->getId())));
		}
		$em = $this->getDoctrine()->getManager();
				
		// Update Thread count in Topic
		$topic = $thread->getTopic();
		$topicCount = intval($topic->getCachedThreadNb()-1);
		$topic -> setCachedThreadNb($topicCount);
		// Update Post Count in Topic
		$nbPost = $thread->getReplies()+1;
		$topicCount = $topic->getCachedPostNb()- $nbPost;
		$topic = $topic -> setCachedPostNb($topicCount);
		// Update Post in Board
		$board = $topic->getBoard();
		$boardCount = $board ->getCachedPostNb()- $nbPost;
		$board = $board -> setCachedPostNb($boardCount);
		$em->persist($board);
				
		$em->remove($thread);
		$em->flush();

		$this->get('session')->getFlashBag()->add('success', 'thread_deleted');
		return $this->redirect($this->generateUrl('inky_forum_threads', array('topic' => $topic->getId())));
	}
	
	public function showMessageAction(Message $message)
	{
		$qrMessage = $this	->getDoctrine()->getManager()->getRepository('InkyForumBundle:Message')
							->findOneById($message);
		
        return $this->render('InkyForumBundle:Forum:showMessage.html.twig',array('message'=>$qrMessage));
	}
	
	
	public function deleteMessageAction(Message $message)
    {
		$securityContext = $this->get('security.context');

        // check for edit access
        if (false === $securityContext->isGranted('DELETE', $message)) 
		{
			$this->get('session')->getFlashBag()->add('error', 'message_not_deleted_unsuffiecient_access');
			return $this->redirect($this->generateUrl('inky_forum_thread', array( 'thread' => $message->getThread()->getId() )));
		}
		
		
		$thread = $message->getThread();
		$topic = $thread->getTopic();
		$board = $topic->getBoard();
		
		// Update Message count in Thread
		$repliesCount = intval($thread->getReplies()-1);
		$thread -> setReplies($repliesCount);
		
		// Update Post count in Topic
		$topicCount = intval($topic->getCachedPostNb()-1);
		$topic -> setCachedPostNb($topicCount);
		
		// Update Post count in Topic
		$boardCount = intval($board->getCachedPostNb()-1);
		$board -> setCachedPostNb($boardCount);

		// Soft Deletion of message
		$message->setIsDeleted(true);

		$em = $this->getDoctrine()->getManager();		
		// Let's persist it all
		$em->persist($message);
		$em->persist($thread);
		$em->persist($topic);
		$em->persist($board);
		
		$em->flush();

		$this->get('session')->getFlashBag()->add('success', 'message_deleted');
		return $this->redirect($this->generateUrl('inky_forum_thread', array('thread' => $thread->getId())));
	}


}
