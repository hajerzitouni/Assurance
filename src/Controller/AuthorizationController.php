<?php

namespace App\Controller;

use App\Entity\Authorization;
use App\Form\AuthorizationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AuthorizationController extends AbstractController
{
    /**
     * @Route("/employee/authorization", name="authorization_request_add")
     */
    public function index(
        Request $request
    ): Response {
        $user = new Authorization();
        $form = $this->createForm(AuthorizationType::class, $user)->add('Sauvegarder', SubmitType::class, [
            'attr' => ['class' => 'btn btn-success float-right'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorizationRequest = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $authorizationRequest->setUser($this->getUser());
           // $authorizationRequest->setIsValid(false);

            $em->persist($authorizationRequest);
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre demande de authorisation a été enregistré avec succès!'
            );

            return $this->redirectToRoute('authorization_request_add');
        }

        return $this->render('bashboard/authorization/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/employee/authorization/list", name="authorization_request_list")
     */
    public function show(Request $request, PaginatorInterface $paginator): Response
    {
        $articles= $this->getDoctrine()
            ->getRepository(Authorization::class)
            ->findBy([
                'user' => $this->getUser()->getId(),

            ], [
                'id' => 'DESC'
            ]);
        $list= $paginator->paginate(
            $articles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );


        return $this->render('bashboard/authorization/list.html.twig', [
            'list'         => $list,
            'autorisation' => [
                0.3 => '30min',
                1.3 => '1 h 30 min ',
                2   => '2 h',
                2.3 => '2 h 30 min ',
                3   => '3 h',
                3.3 => '3 h 30 min ',
                4   => 'Demi journée'
            ]
        ]);
    }

    /**
     * @Route("/employee/{id}/cancel", name="autorisation_cancel_request")
     */
    public function cancel(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Authorization::class);
        if ($authorizationRequest = $repository->find($id)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($authorizationRequest);
            $em->flush();
        }
        return $this->redirectToRoute('authorization_request_list');
    }

    /**
     * @Route("/employee/authorization/{id}", name="update_autorisation_request")
     */
    public function update(
        Request $request,
        $id
    ): Response {
        $holidayRequestEntity = $this->getDoctrine()->getRepository(Authorization::class)->find($id);

        $form = $this->createForm(AuthorizationType::class, $holidayRequestEntity)
            ->add('Modifier', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success float-right'],
            ]);


        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorizationRequest = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $authorizationRequest->setUser($this->getUser());
            $authorizationRequest->setIsValid(false);

            $em->persist($authorizationRequest);
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre demande de authorisation a été modifier avec succès!'
            );

            return $this->redirectToRoute('authorization_request_list');
        }

        return $this->render('bashboard/authorization/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
