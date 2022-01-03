<?php

namespace App\Controller;

use App\Entity\Authorization;
use App\Entity\HolidayRequest;
use App\Form\HolidayRequestType2;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ResponsableController extends AbstractController
{
    const STATUS = [
        'encours' => 0,
        'valide'  => 1,
        'annuler' => -1
    ];

    /**
     * @Route("/holiday/edit/{id}", name="update_description")
     * Method ({"GET", "POST"})
     */
    public function update(Request $request, $id)
    {
        $holidayRequestEntity = $this->getDoctrine()->getRepository(HolidayRequest::class)->find($id);

        $form = $this->createForm(HolidayRequestType2::class, $holidayRequestEntity)
            ->add('Modifier', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success float-right'],
            ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $holidayRequest = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $holidayRequest->setUserId($this->getUser());

            $em->persist($holidayRequest);
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre demande de congé à été mise a jour avec succès!'
            );

            return $this->redirectToRoute('hr_list_holiday');
        }

        return $this->render('bashboard/responsable/index2.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/responsable", name="responsable_list")
     */
    public function index(): Response
    {
        return $this->render('bashboard/responsable/index.html.twig', [
            'controller_name' => 'ResponsableController',
        ]);
    }





    /**
     * @Route("/responsable/list_conge", name="responsable_list_conge")
     */
    public function getListConge(Request $request, PaginatorInterface $paginator)
    {
        $articles = $this->getDoctrine()
            ->getRepository(HolidayRequest::class)
            ->findByNot('user_id', $this->getUser());
        $list= $paginator->paginate(
            $articles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5// Nombre de résultats par page
        );

        return $this->render('bashboard/responsable/validation.html.twig', [
            'list' => $list,
            'routeName' => 'responsable_list_conge'
        ]);
    }

    /**
     * @Route("/responsable/list_autorisations", name="responsable_list_autorisations")
     */
    public function getListAutorisations()
    {
        $list = $this->getDoctrine()
            ->getRepository(Authorization::class)
            ->findByNot('user', $this->getUser());

        return $this->render('bashboard/responsable/validation.authorization.html.twig', [
            'list'         => $list,
            'autorisation' => [
                0.3 => '30min',
                1.3 => '1 h 30 min ',
                2   => '2 h',
                2.3 => '2 h 30 min ',
                3   => '3 h',
                3.3 => '3 h 30 min ',
                4   => 'Demi journée'
            ],
             'routeName' => 'responsable_list_autorisations'
        ]);
    }


    /**
     * @Route("/{id}/{action}/{route}/confirm_request", name="confirm_request")
     */
    public function confirmRequest(Request $request, $id, $action,$route)
    {
        $repository = $this->getDoctrine()->getRepository(HolidayRequest::class);
        if ($holidayRequest = $repository->find($id)) {
            $em = $this->getDoctrine()->getManager();
            $status = self::STATUS[$action];
            $holidayRequest->setStatus($status);
            $holidayRequest->setValidby($this->getUser());
            $em->persist($holidayRequest);
            $em->flush();
        }
        if($action =="annuler")
        {
            $holidayRequestEntity = $this->getDoctrine()->getRepository(HolidayRequest::class)->find($id);

            $form = $this->createForm(HolidayRequestType2::class, $holidayRequestEntity)
                ->add('Save', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-success float-right'],
                ]);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $holidayRequest = $form->getData();
                $em = $this->getDoctrine()->getManager();


                $em->persist($holidayRequest);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Votre demande de congé à été mise a jour avec succès!'
                );

                return $this->redirectToRoute('hr_list_holiday');
            }

            return $this->render('bashboard/responsable/index2.html.twig', [
                'form' => $form->createView()
            ]);
        }
        else {


            return $this->redirectToRoute($route);
        }
    }








    /**
     * @Route("/{id}/{action}/{route}/autorisation_validate_request", name="autorisation_validate_request")
     */
    public function confirmAutorisations(Request $request, $id, $action, $route)
    {
        $repository = $this->getDoctrine()->getRepository(Authorization::class);
        if ($autorisationRequest = $repository->find($id)) {
            $em = $this->getDoctrine()->getManager();
            $status = self::STATUS[$action];

            $autorisationRequest->setValidateBy($this->getUser());
            $autorisationRequest->setStatus($status);
            $em->persist($autorisationRequest);
            $em->flush();
        }
        return $this->redirectToRoute($route);
    }



}
