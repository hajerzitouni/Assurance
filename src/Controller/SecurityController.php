<?php

namespace App\Controller;

use App\Entity\HolidayRequest;
use App\Entity\User;
use App\Form\HolidayRequestType;
use App\Form\UserType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        if ($this->getUser()) {

            $route = LoginFormAuthenticator::LOGIN_ROUTE;
            switch ($this->getUser()->getRoles()[0]) {
                case 'ROLE_USER' :
                    $route = 'holiday_request_add';
                    break;
                case 'ROLE_RESPONSABLE' :
                    $route = 'responsable_list';
                    break;
                case 'ROLE_HR' :
                    $route = 'hr_list_holiday';
                    break;
                case 'ROLE_ADMIN' :
                    $route = 'list_users';
                    break;
            }

            return $this->redirectToRoute($route);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/profile", name="app_profile")
     */
    public function profile(Request $request,  UserPasswordEncoderInterface $passwordEncoder): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $u = $this->getDoctrine()
            ->getRepository(User::class)->find($this->getUser());
        $form = $this->createForm(UserType::class, $user)
            ->remove('roles')
            ->add('password', PasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Votre mot de passe a été modifier avec succès!'
            );

            return $this->redirectToRoute('app_profile');
        }


            return $this->render('security/profile.html.twig',  [
            'form' => $form->createView(),
                'u'=>$u
        ]);

    }
}
