<?php

namespace Inky\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Inky\UserBundle\Entity\Group;

class GroupType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$items = Group::getConstantsChoices();
        $builder

		->add('name', 'text')
		->add('description', 'textarea')
        ->add('users')
		->add('roles', 'choice', array(	'choices' => $this->refactorRoles($items),
										'multiple' => true,'expanded' => true)
	);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inky\UserBundle\Entity\Group',
			'roles' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inky_userbundle_group';
    }
	
	private function refactorRoles($originRoles)
	{
		$roles = array();
		$rolesAdded = array();

		// Add herited roles
		foreach ($originRoles as $roleParent => $rolesHerit) {
			$tmpRoles = array_values($rolesHerit);
			$rolesAdded = array_merge($rolesAdded, $tmpRoles);
			$roles[$roleParent] = array_combine($tmpRoles, $tmpRoles);
		}
		// Add missing superparent roles
		$rolesParent = array_keys($originRoles);
		foreach ($rolesParent as $roleParent) {
			if (!in_array($roleParent, $rolesAdded)) {
				$roles['-----'][$roleParent] = $roleParent;
			}
		}

		return $roles[$roleParent];
	}
}
