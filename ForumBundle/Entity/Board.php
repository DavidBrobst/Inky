<?php

namespace Inky\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Board
 *
 * @ORM\Table(name="forum_board")
 * @ORM\Entity(repositoryClass="Inky\ForumBundle\Entity\BoardRepository")
 */
class Board
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="cachedPosts", type="integer")
     */
    private $cachedPosts;

    /**
     * @var integer
     *
     * @ORM\Column(name="cachedTopics", type="integer")
     */
    private $cachedTopics;

	/**
	 * @ORM\OneToMany(targetEntity="Inky\ForumBundle\Entity\Topic",cascade={"persist"}, mappedBy="board")
	 */
	private $topic;
	
	/**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	*/
	private $user;
		
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Board
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Board
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set cachedPosts
     *
     * @param integer $cachedPosts
     * @return Board
     */
    public function setCachedPosts($cachedPosts)
    {
        $this->cachedPosts = $cachedPosts;
    
        return $this;
    }

    /**
     * Get cachedPosts
     *
     * @return integer 
     */
    public function getCachedPosts()
    {
        return $this->cachedPosts;
    }

    /**
     * Set cachedTopics
     *
     * @param integer $cachedTopics
     * @return Board
     */
    public function setCachedTopics($cachedTopics)
    {
        $this->cachedTopics = $cachedTopics;
    
        return $this;
    }

    /**
     * Get cachedTopics
     *
     * @return integer 
     */
    public function getCachedTopics()
    {
        return $this->cachedTopics;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->topic = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add topic
     *
     * @param \Inky\ForumBundle\Entity\Topic $topic
     * @return Board
     */
    public function addTopic(\Inky\ForumBundle\Entity\Topic $topic)
    {
        $this->topic[] = $topic;
    
        return $this;
    }

    /**
     * Remove topic
     *
     * @param \Inky\ForumBundle\Entity\Topic $topic
     */
    public function removeTopic(\Inky\ForumBundle\Entity\Topic $topic)
    {
        $this->topic->removeElement($topic);
    }

    /**
     * Get topic
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set user
     *
     * @param \Inky\UserBundle\Entity\User $user
     * @return Board
     */
    public function setUser(\Inky\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Inky\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}