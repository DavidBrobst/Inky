<?php
namespace Inky\UserBundle\Controller;

/* User Info Charts*/
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Inky\UserBundle\Entity\User as User;

class UserController extends Controller
{
	public function loginAction()
	{
		return $this->render('InkyUserBundle:Security:login.html.twig'
								);
	}
	public function profileAction(User $user)
	{
		$point = $this->container->get('inky_user.point');
		$point->addPoint($user,5);
		
		return $this->render('InkyUserBundle:Profile:show.html.twig', array('user'=>$user )
								);
	}
	public function ProfileMenuAction()
	{
		return $this->render('InkyUserBundle:Profile:menu.html.twig')
								;
	}
	public function profileEditAction()
	{
		return $this->render('InkyUserBundle:Profile:edit.html.twig', array('user'=>$this->getUser())
								);
	}
	public function changePasswordAction()
	{
		return $this->render('InkyUserBundle:changePassword:changePassword.html.twig')
								;
	}
	public function panelAction()
	{
		return $this->render('InkyUserBundle:Panel:panel.html.twig')
								;
	}
	public function PanelMenuAction()
	{
		return $this->render('InkyUserBundle:Panel:menu.html.twig')
								;
	}
	public function progressAction()
	{
		// Points
		$point = $this->container->get('inky_user.point');
		$pointInfo = $point->showPoint($this->getUser());
			// Need of month and points for each month
		$month = array();
		$monthlyPoint = array();
		$cumulativePoint = array();

		// for example
		foreach ($pointInfo as $pointInf) {
			$month[] = $pointInf['month'];
			$monthlyPoint[] = intval($pointInf['avgPoint']);
			$cumulativePoint[] = array_sum($monthlyPoint);
		}
		// Chart
        $series = array(
					array(
						'name'  => 'Monthly Points',
						'type'  => 'column',
						'color' => '#4572A7',
						'yAxis' => 1,
						'data'  => $monthlyPoint,
					),
					array(
						'name'  => 'Cummulative Points',
						'type'  => 'spline',
						'color' => '#AA4643',
						'data'  => $cumulativePoint,
					),
				);
				$yData = array(
					array(
						'labels' => array(
							'formatter' => new Expr('function () { return this.value + " point" }'),
							'style'     => array('color' => '#AA4643')
						),
						'title' => array(
							'text'  => 'Cummulative Points',
							'style' => array('color' => '#AA4643')
						),
						
					),
					array(
						'labels' => array(
							'formatter' => new Expr('function () { return this.value + " point" }'),
							'style'     => array('color' => '#4572A7')
						),
						'gridLineWidth' => 0,
						'title' => array(
							'text'  => 'Monthly Points',
							'style' => array('color' => '#4572A7')
						),
						'opposite' => true,
					),
				);
				$categories = $month;

				$ob = new Highchart();
				$ob->chart->renderTo('linechart'); // The #id of the div where to render the chart
				$ob->chart->type('column');
				$ob->title->text('Point evolution');
				$ob->xAxis->categories($categories);
				$ob->yAxis($yData);
				$ob->legend->enabled(false);
				$formatter = new Expr('function () {
								 var unit = {
									 "Monthly Points": "points",
									 "Cummulative Points": "points",
								 }[this.series.name];
								 return this.x + ": <b>" + this.y + "</b> " + unit;
							 }');
				$ob->tooltip->formatter($formatter);
				$ob->series($series);
		
		return $this->render('InkyUserBundle:Panel:progress.html.twig', array('pointInfo'=>$pointInfo,'chart'=>$ob))	;
	}
	public function gradesAction()
	{
		return $this->render('InkyUserBundle:Panel:grades.html.twig')
								;
	}
	public function jobToDoAction()
	{
		return $this->render('InkyUserBundle:Panel:jobtodo.html.twig')
								;
	}
	public function discussionAction()
	{
		return $this->render('InkyUserBundle:Panel:discussion.html.twig')
								;
	}
	public function wishListAction()
	{
		$courseList = $this	->getDoctrine()->getManager()->getRepository('InkyUserBundle:Wishlist')
							->getCourses($this->getUser()->getId());
								
		return $this->render('InkyUserBundle:Panel:wishlist.html.twig',
								array(	'courseList' => $courseList,
										'courseLength' => count($courseList))
							);
	}
	public function joinGroupAction()
	{
		$request = $this->getRequest();
		if ($request->getMethod() == 'GET')
		{
			if($request->query->get('sharecode'))
			{
				$sharecode = $request->query->get('sharecode');
				$repository = $this->getDoctrine()->getManager()->getRepository('InkyUserBundle:Group');
				$group = $repository->findOneByShareCode($sharecode);
				
				if(count($group)<1) $group = false;
				
				return $this->render('InkyUserBundle:Panel:joinGroup.html.twig', array(	'sharecode' => $sharecode,
																						'group' => $group));
			}
			
		}
		if ($request->getMethod() == 'POST')
		{
			if($request->request->get('sharecode'))
			{
				$sharecode =$request->request->get('sharecode');
				$em = $this->getDoctrine()->getManager();
				$group = $em->getRepository('InkyUserBundle:Group')->findOneByShareCode($sharecode);
				
				if(count($group)== 1)
				{
					if($group->hasUser($this->getUser()))
					{
						$this->get('session')->getFlashBag()->clear();
						$this->get('session')->getFlashBag()->add('joinGroupError', '<strong>It\'s all right!</strong> Vous avez deja join le groupe');
					}
					else
					{
						$group->addUser($this->getUser());
						$em->flush();
						$this->get('session')->getFlashBag()->clear();
						$this->get('session')->getFlashBag()->add('joinGroupSuccess', '<strong>Congratulations!</strong> Vous avez join le groupe');
					}
				}
				
			}
			
		}
		
		return $this->render('InkyUserBundle:Panel:joinGroup.html.twig');
	}
}
