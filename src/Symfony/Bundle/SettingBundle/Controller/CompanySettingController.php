<?php

namespace Symfony\Bundle\SettingBundle\Controller;

use Symfony\Bundle\SettingBundle\Entity\CompanySetting;
use Symfony\Bundle\SettingBundle\Form\CompanySettingFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CompanySettingController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $companySettingQuery    = $em->getRepository('SymfonySettingBundle:CompanySetting')
            ->createQueryBuilder('c')
            ->where('c.status = 1');
        $companySetting = $companySettingQuery->getQuery()->getResult();

        if(!$companySetting){
            $val = 1;
        }else{
            $val = 0;
        }

        return $this->render('SymfonySettingBundle:CompanySetting:index.html.twig', array(
            'companySetting' => $companySetting,
            'val' => $val
        ));
    }

    public function addAction(Request $request)
    {
        $companySetting = new CompanySetting();

        $form = $this->createForm(new CompanySettingFormType(),  $companySetting);

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $companySetting->setStatus(1);

                $this->getDoctrine()->getRepository('SymfonySettingBundle:CompanySetting')->create($companySetting);

                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Company Setting Successfully Add'
                );

                return $this->redirect($this->generateUrl('company_homepage'));
            }
        }

        return $this->render('SymfonySettingBundle:CompanySetting:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, CompanySetting $companySetting)
    {
        $form = $this->createForm(new CompanySettingFormType(),  $companySetting);

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $companySetting->setStatus(1);

                $this->getDoctrine()->getRepository('SymfonySettingBundle:CompanySetting')->create($companySetting);

                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Company Setting Successfully Update'
                );

                return $this->redirect($this->generateUrl('company_homepage'));
            }
        }

        return $this->render('SymfonySettingBundle:CompanySetting:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
