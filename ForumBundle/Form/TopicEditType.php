<?php

namespace Inky\ForumBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TopicEditType extends TopicType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}
	public function getName()
	{
		return 'inky_forumbundle_topic_edit_type';
	}
}
