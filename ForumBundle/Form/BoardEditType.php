<?php

namespace Inky\ForumBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BoardEditType extends BoardType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}
	public function getName()
	{
		return 'inky_forumbundle_board_edit_type';
	}
}
