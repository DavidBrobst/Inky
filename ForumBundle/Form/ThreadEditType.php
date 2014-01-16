<?php

namespace Inky\ForumBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ThreadEditType extends ThreadType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}
	public function getName()
	{
		return 'inky_forumbundle_thread_edit_type';
	}
}
