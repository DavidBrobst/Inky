<?php

namespace Inky\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Inky\UserBundle\Entity\User as User;

use Symfony\Component\Security\Core\Util\SecureRandom;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 * @ORM\Entity(repositoryClass="Inky\UserBundle\Entity\GroupRepository")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
     protected $id;

     /**
       * @ORM\ManyToMany(targetEntity="Inky\UserBundle\Entity\User")
       * @ORM\JoinTable(name="users_groups",
       *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
       *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
       * )
       */
     private $users;

	/**
	* @ORM\ManyToOne(targetEntity="Inky\CourseBundle\Entity\Course\Course", inversedBy="groups")
	*/
	private $course;
    
	/**
	* @ORM\ManyToOne(targetEntity="Inky\UserBundle\Entity\User")
	*/
	private $groupFounder;

	/**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
	private $description;
	
	/**
     * @var string
     *
     * @ORM\Column(name="shareCode", type="string", length=255)
     */
	private $shareCode;
	
	
	public static function getConstantsChoices()
	{
		return array(
			'ACCESS_NONE' => array('ACCESS_NONE'),
			'ACCESS_VIEW' => array('ACCESS_VIEW'),
			'ACCESS_SUBMIT' => array('ACCESS_VIEW','ACCESS_SUBMIT'),
			'ACCESS_APPROVE' => array('ACCESS_VIEW','ACCESS_SUBMIT','ACCESS_APPROVE')
		);
	}
	

  public function __construct()
    {
        parent::__construct($name='',$role=array());
		$this->users = new \Doctrine\Common\Collections\ArrayCollection();
		
    }

	
	
	
	/**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString()
    {
      return $this->getName();
    }

    
    /**
     * Add users
     *
     * @param Inky\UserBundle\Entity\User $users
     */
    public function addUser(\Inky\UserBundle\Entity\User $user)
    {
        if (!$this->hasUser($user)) 
		{
            $this->users[] = $user;
        }
        return $this;
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
	
	public function hasUser($user)
    {
        if($this->users->contains($user)) return true;
		else return false;
    }
    /**
     * Remove users
     *
     * @param \Inky\UserBundle\Entity\User $users
     */
    public function removeUser(\Inky\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Set course
     *
     * @param \Inky\COurseBundle\Entity\Course $course
     * @return Group
     */
    public function setCourse(\Inky\COurseBundle\Entity\Course $course = null)
    {
        $this->course = $course;
    
        return $this;
    }

    /**
     * Get course
     *
     * @return \Inky\COurseBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set groupFounder
     *
     * @param \Inky\UserBundle\Entity\User $groupFounder
     * @return Group
     */
    public function setGroupFounder(\Inky\UserBundle\Entity\User $groupFounder = null)
    {
        $this->groupFounder = $groupFounder;
    
        return $this;
    }

    /**
     * Get groupFounder
     *
     * @return \Inky\UserBundle\Entity\User 
     */
    public function getGroupFounder()
    {
        return $this->groupFounder;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Group
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set shareCode
     *
     * @param string $shareCode
     * @return Group
     */
    public function setShareCode($shareCode)
    {
        $this->shareCode = $shareCode;
        return $this;
    }

    /**
     * Get shareCode
     *
     * @return string 
     */
    public function getShareCode()
    {
        return $this->shareCode;
    }
}