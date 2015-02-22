<?php

namespace SklepBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SklepBundle\Entity\Movie;
use SklepBundle\Form\MovieType;

class ContactController extends Controller {
	/**
	* @Route("/Contact", name="contact")
	* @Template()
	*/
	public function indexAction()
	{
		return array();
	}
}