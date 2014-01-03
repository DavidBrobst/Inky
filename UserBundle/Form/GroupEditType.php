<?php

namespace Inky\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupEditType extends GroupType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);

	}
	
	public function getName()
	{
		return 'inky_userbundle_groupedittype';
	}
}
