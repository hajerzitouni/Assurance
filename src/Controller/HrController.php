<?php

namespace App\Controller;

use App\Entity\Authorization;
use App\Entity\HolidayRequest;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HrController extends AbstractController
{

    const STATUS = [
        'encours' => 0,
        'valide'  => 1,
        'annuler' => -1
    ];


    /**
     * @Route("/hr", name="hr_list_holiday")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $articles= $this->getDoctrine()
            ->getRepository(HolidayRequest::class)
            ->findByNot('user_id', $this->getUser());

        $list= $paginator->paginate(
            $articles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5// Nombre de résultats par page
        );
        return $this->render('bashboard/responsable/validation.html.twig', [
            'list' => $list,
            'routeName' => 'hr_list_holiday',


        ]);
    }


    /**
     * @Route("/hr/list_autorisations", name="hr_list_autorisations")
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
            'routeName' => 'hr_list_autorisations'
        ]);
    }
}
