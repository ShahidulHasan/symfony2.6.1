<?php

namespace Project\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * DashBoard Controller.
 *
 */
class DashBoardController extends Controller
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
            ->select('COUNT(u.id) as totalUsers')
            ->where('u.enabled = :enabled')
            ->setParameter('enabled', $enabled);

        $users = $query->getQuery()->getResult();

        return $users;
    }

    public function indexAction(Request $request)
    {
        $totalActiveUsers = $this->userList(1);
        $totalInactiveUsers = $this->userList(0);

        return $this->render('ProjectViewBundle:Dashboard:index.html.twig', array(
            'totalActiveUsers' => $totalActiveUsers,
            'totalInactiveUsers' => $totalInactiveUsers,
        ));
    }
}
