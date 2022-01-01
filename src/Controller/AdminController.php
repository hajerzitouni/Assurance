<?php

namespace App\Controller;

use App\Entity\HolidayRequest;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AdminController extends AbstractController
{


    /**
     * @Route("/admin", name="list_users")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
         $list= $paginator->paginate(
             $articles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        return $this->render('bashboard/admin/manage-users/list.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/admin/add", name="add_users")
     */
    public function add(
        Request $request
        ,
        UserPasswordEncoderInterface $passwordEncoder

    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->add('Sauvegarder', SubmitType::class, [
            'attr' => ['class' => 'btn btn-success float-right'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRequest = $form->getData();
            $em = $this->getDoctrine()->getManager();

            if ($em->getRepository(User::class)->findBy([
                'email' => $userRequest->getEmail()
            ])) {
                $this->addFlash(
                    'notice',
                    "L'adresse e-mail existe déjà!"
                );
                return $this->redirectToRoute('add_users');
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $this->generateRandomString()
                )
            );

            $user->setRoles($userRequest->getRoles());
            $em->persist($userRequest);
            $em->flush();
            return $this->redirectToRoute('add_users');
        }

        return $this->render('bashboard/admin/manage-users/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    function generateRandomString($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @Route("/admin/{id}/remove}", name="remove_user")
     */
    public function remove($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        if ($user = $repository->find($id)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }
        return $this->redirectToRoute('list_users');
    }

    /**
     * @Route("/admin/list_conge", name="list_conge")
     */
    public function getListConge(Request $request, PaginatorInterface $paginator)
    {
        $articles= $this->getDoctrine()
            ->getRepository(HolidayRequest::class)
            ->findAll();
        $list= $paginator->paginate(
            $articles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );

        return $this->render('bashboard/holiday_request/list.html.twig', [
            'list' => $list,
        ]);
    }


    /**
     * @Route("/admin/modifer/{id}", name="modifer_user")
     */
    public function update(
        Request $request,
        $id
        ,
        UserPasswordEncoderInterface $passwordEncoder

    ): Response {
        $user = $this->getDoctrine()
            ->getRepository(User::class)->find($id);

        $form = $this->createForm(UserType::class, $user)
            ->add('email', TextType::class, [
                'attr' => ['readonly' => 'true'],
            ])
            ->add('Modifier', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success float-right'],
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRequest = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $user->setRoles($userRequest->getRoles());
            $em->persist($userRequest);
            $em->flush();
            return $this->redirectToRoute('list_users');
        }

        return $this->render('bashboard/admin/manage-users/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
