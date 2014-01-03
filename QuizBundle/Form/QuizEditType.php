<?php

namespace Inky\QuizBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuizEditType extends QuizType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}
	public function getName()
	{
		return 'inky_quizbundle_quizedittype';
	}
}
