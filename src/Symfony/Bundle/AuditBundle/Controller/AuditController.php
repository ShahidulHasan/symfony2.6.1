<?php

namespace Symfony\Bundle\AuditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuditController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjectViewBundle:Audit:index.html.twig', array(
        ));
    }
}
