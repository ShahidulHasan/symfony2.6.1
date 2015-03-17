<?php

namespace Symfony\Bundle\UserBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\UserBundle\Entity\User;
use Symfony\Bundle\UserBundle\Form\UserFormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Controller.
 *
 */
class UserController extends Controller
{
    /**
     * @return object
     */
    protected function doctrineManager()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('SymfonyUserBundle:User');
        return $em;
    }

    /**
     * @param $enabled
     */
    protected function userList($enabled)
    {
        $query = $this->doctrineManager()
            ->createQueryBuilder('u')
            ->where('u.enabled = :enabled')
            ->setParameter('enabled', $enabled);

        $users = $query->getQuery()->getResult();

        return $users;
    }

    /**
     * @param $getId
     */
    protected function userInformation($getId)
    {
        $query = $this->doctrineManager()
            ->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $getId);

        $users = $query->getQuery()->getResult();

        return $users;
    }

    public function indexAction(Request $request)
    {
        $activeUsers = $this->userList(1);
        $inactiveUsers = $this->userList(0);

        return $this->render('ProjectViewBundle:User:index.html.twig', array(
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
        ));
    }

    public function detailsAction(Request $request, User $user)
    {
        return $this->render('ProjectViewBundle:User:details.html.twig', array(
            'user' => $user
        ));
    }

    public function addAction(Request $request)
    {
        $user = new User();

        $service = $this->get('symfony_user.registration.form.type');

        $form = $this->createForm($service, $user);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->getDoctrine()->getRepository('SymfonyUserBundle:User')->create($user);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'User Add Successfully!'
                );

                return $this->redirect($this->generateUrl('user_home'));
            }
        }

        return $this->render('ProjectViewBundle:User:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(new UserFormType(), $user);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->getDoctrine()->getRepository('SymfonyUserBundle:User')->update($user);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'User Updated Successfully!'
                );

                return $this->redirect($this->generateUrl('user_home'));
            }
        }

        return $this->render('ProjectViewBundle:User:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function profileAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();

        $userInformation = $this->userInformation($userId);

        return $this->render('ProjectViewBundle:User:profile.html.twig', array(
            'userInformation' => $userInformation,
        ));
    }

    public function taskAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();

        $userInformation = $this->userInformation($userId);

        return $this->render('ProjectViewBundle:User:task.html.twig', array(
            'userInformation' => $userInformation,
        ));
    }

    public function userEnabledAction(User $user)
    {
        $enabled = $this->isUserEnabled($user);

        $user->setEnabled($enabled);

        $this->getDoctrine()->getRepository('SymfonyUserBundle:User')->update($user);

        $this->get('session')->getFlashBag()->add(
            'success',
            'User Successfully Enabled'
        );

        return $this->redirect($this->generateUrl('user_home'));
    }

    public function deleteAction(User $user)
    {
        $this->getDoctrine()->getRepository('SymfonyUserBundle:User')->delete($user);

        $this->get('session')->getFlashBag()->add(
            'success',
            'User Successfully Delete'
        );

        return $this->redirect($this->generateUrl('user_home'));
    }

    public function lockAction(Request $request)
    {
        return $this->render('SymfonyUserBundle:Security:lock.html.twig', array(

        ));
    }

    /**
     * @param User $user
     * @return int
     */
    protected function isUserEnabled(User $user)
    {
        if ($user->isEnabled()) {
            $enabled = 0;
            return $enabled;
        } else {
            $enabled = 1;
            return $enabled;
        }
    }
}