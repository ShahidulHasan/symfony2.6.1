<?php

namespace Symfony\Bundle\UserBundle\Controller;

use Doctrine\Common\Util\Debug;
use FOS\UserBundle\Event\GetResponseGroupEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Bundle\UserBundle\Entity\Group;
use FOS\UserBundle\Controller\GroupController as Controller;
use JMS\SecurityExtraBundle\Annotation as JMS;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Group Controller.
 *
 */
class GroupController extends Controller
{
    /**
     * @return object
     */
    protected function doctrineManager()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('SymfonyUserBundle:Group');
        return $em;
    }

    /**
     * @return object
     */
    protected function groupList()
    {
        $query = $this->doctrineManager()
            ->createQueryBuilder('g');

        $groups = $query->getQuery()->getResult();

        return $groups;
    }

    public function indexAction(Request $request)
    {
        $groups = $this->groupList();

        return $this->render('ProjectViewBundle:Group:index.html.twig', array(
            'groups' => $groups
        ));
    }

    public function detailsAction(Request $request, Group $group)
    {
        return $this->render('ProjectViewBundle:Group:details.html.twig', array(
            'group' => $group
        ));
    }

    public function addAction(Request $request)
    {
        $group = new Group('', '');

        $service = $this->get('symfony_user.group.form.type');

        $form = $this->createForm($service, $group);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->getDoctrine()->getRepository('SymfonyUserBundle:Group')->create($group);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Group Add Successfully!'
                );

                return $this->redirect($this->generateUrl('group_home'));
            }
        }

        return $this->render('ProjectViewBundle:Group:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function groupEditAction(Request $request, Group $group)
    {
        $service = $this->get('symfony_user.group.form.type');

        $form = $this->createForm($service, $group);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->getDoctrine()->getRepository('SymfonyUserBundle:Group')->create($group);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Group Update Successfully!'
                );

                return $this->redirect($this->generateUrl('group_home'));
            }
        }

        return $this->render('ProjectViewBundle:Group:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function groupDeleteAction(Request $request, Group $group)
    {
        $this->container->get('fos_user.group_manager')->deleteGroup($group);

        $response = new RedirectResponse($this->container->get('router')->generate('group_home'));

        $this->get('session')->getFlashBag()->add(
            'success',
            'Group Deleted Successfully!'
        );

        return $response;
    }
}