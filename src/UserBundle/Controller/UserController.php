<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\User;

class UserController extends Controller
{
   public function indexAction(){

       $em = $this->getDoctrine()->getManager();
       $users = $em->getRepository('UserBundle:User')->findBy(array('deleted'=>false));
       return $this->render('UserBundle:user:index.html.twig', array(
           'users'=>$users
       ));
    }

    public function editAction(Request $request, User $user)
    {

        //$user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();

        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

                $url = $this->generateUrl('user_list');
                $response = new RedirectResponse($url);

            return $response;
        }
        return $this->render('UserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function userEnabledAction(User $user)
    {

        $enable = $this->isUserEnabled($user);
        $user->setEnabled($this->isUserEnabled($user));

        $this->getDoctrine()->getRepository('UserBundle:User')->update($user);

        $messageString = $enable ? $this->get('translator')->trans('User Successfully Enable') : $this->get('translator')->trans('User Successfully Disable');
        $this->get('session')->getFlashBag()->add(
            'success',
            $messageString
        );

        return $this->redirect($this->generateUrl('user_list'));
    }

    public function deleteAction(User $user)
    {
        $user->setDeleted(true);
        $user->setEnabled(false);

        $this->getDoctrine()->getRepository('UserBundle:User')->update($user);

        $messageString = $this->get('translator')->trans('User Successfully Delete');
        $this->get('session')->getFlashBag()->add(
            'success',
            $messageString
        );

        return $this->redirect($this->generateUrl('user_list'));
    }

    /**
     * @param User $user
     * @return int
     */
    protected function isUserEnabled(User $user)
    {
        if ($user->isEnabled()) {
            return false;
        } else {
            return true;
        }
    }


}