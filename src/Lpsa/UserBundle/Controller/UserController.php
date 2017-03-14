<?php

namespace Lpsa\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lpsa\UserBundle\Form\Type\AdminChangePasswordFormType;
use FOS\UserBundle\Form\Model\ChangePassword;

use Lpsa\UserBundle\Entity\User;

class UserController extends Controller
{
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        
        $formsDelete = array();
        
        foreach ($users as $user){
            $formsDelete[$user->getId()] = $this->createDeleteForm($user)->createView();
        }
        
        return $this->render('LpsaUserBundle:User:index.html.twig', array(
                    'users' => $users,
                    'formsDelete' => $formsDelete
                )
            );
    }
    
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('Lpsa\UserBundle\Form\Type\UserEditType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'L\'utilisateur a été mis à jour.');
            return $this->redirectToRoute('lpsa_admin_user_edit', array('id' => $user->getId()));
        }

        return $this->render('LpsaUserBundle:User:edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
//        $form = $this->createDeleteForm($user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'L\utilisateur a été supprimé.');
//        }

        return $this->redirectToRoute('lpsa_user_admin_index');
    }
    public function declarantjsonAction(Request $request){
            $suggest = array();
            $tags= $request->get('search');
            $em = $this->getDoctrine()->getManager();
            $suggestions = $em->getRepository('LpsaUserBundle:User')->findLike($tags);
 
                foreach ($suggestions as $suggestion){
                    $matricule = $suggestion->getMatricule();
                    $lastname=$suggestion->getLastname();
                    $firstname=$suggestion->getFirstname();
                    $suggest[] = array(
                        'id' => $suggestion->getId(),
                        'label' => $matricule. '/' . $lastname . ' ' . $firstname,
                        'value' =>  $lastname . ' ' . $firstname
                    );
                }

            $response = new JsonResponse();
            $response->setData($suggest);
            return $response;
    }
    public function AdminChangePasswordAction(Request $request, User $user){
        
        $form=$this->createForm(new AdminChangePasswordFormType);
        $form->setData(new ChangePassword());
        
        if ('POST' === $request->getMethod()){
            $form->bind($request);
            if ($form->isValid()) {
                $user->setPlainPassword($form->getData()->new);
                $userManager=$this->get('fos_user.user_manager');
                $userManager->updateUser($user);
                $this->setFlash('success', 'change_password.flash.success');
                return $this->render('LpsaUserBundle:ChangePassword:AdminChangePasswordSuccess.html.twig',array('user' => $user));
            }
        }
        return $this->render('LpsaUserBundle:ChangePassword:AdminChangePassword.html.twig',
                array('form' => $form->createView(),
                      'user' => $user,
                ));
    }
    
    /**
     * Generate form delete
     * 
     * @param User $user
     * @return Form 
     */
    private function createDeleteForm($user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lpsa_user_admin_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * Generate the redirection url when the resetting is completed.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user)
    {
        return $this->container->get('router')->generate('fos_user_profile_show');
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}
