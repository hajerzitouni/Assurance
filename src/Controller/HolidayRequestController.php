<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\HolidayRequest;
use App\Entity\User;
use App\Form\HolidayRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Knp\Component\Pager\PaginatorInterface;

class HolidayRequestController extends AbstractController
{
    /**
     * @Route("/holiday-request", name="holiday_request_add")
     */
    public function index(

        Request $request
    ): Response {

        $form = $this->createForm(HolidayRequestType::class, new HolidayRequest())
            ->add('Sauvegarder', SubmitType::class, [
            'attr' => ['class' => 'btn btn-success float-right'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $holidayRequest = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $star = $holidayRequest->getStartDate();
            $end = $holidayRequest->getEndDate();
            //$diff = date_diff( $holidayRequest->getStartDate(), $holidayRequest->getEndDate());


            $holidayRequest->setUserId($this->getUser());

           // $em->persist($holidayRequest);
            //$em->flush();

            $date = date('Y-m-d');
            //  $i=new \DateTime('2021-12-27');
            /*$ee = $this->getDoctrine()
                 ->getRepository(Booking::class)
                 ->findOneBy([
                     'title' => 'jour']);*/
            /* $ee = $this->getDoctrine()
                 ->getRepository(Booking::class)->find(5);
             $ee->getBeginAt()->format('Y-m-d');*/

            // $id=5;

            /*$i=new \DateTime('2021-12-27');
             $e = $this->getDoctrine()
                 ->getRepository(Booking::class)
                ->findBy(array(
                     'beginAt' => $i));
             $ee=$e->getBeginAt();*/
            $days = 0;
            // $arr = ['2021-12-27', '2021-12-29', '2021-12-24'];
            $list = $this->getDoctrine()
                ->getRepository(Booking::class)->findAll();
            /*while ($star->diff($end)->days > 0) {
                $days += $star->format('N') < 6 ? 1 : 0;
                $star = $star->add(new \DateInterval("P1D"));
            }*/
            /*$holidayRequest->setNbjours($days);
            foreach ($list as $event) {
                //  echo('hello');
                $ee = $event->getBeginAt();
                $data = ['hello' => 'world'];
                var_dump('vardump', $data);
            }*/
            // echo $e->format('H:i:s \O\n Y-m-d');

            // $logger = new ConsoleLogger($e);
            // var_dump($e);
            // echo $e->format(' Y-m-d');
            //($e);


            //\Doctrine\Common\Util\Debug::dump($event->getBeginAt()->format(' Y-m-d'));
            // echo serialize($event->getBeginAt()->format(' Y-m-d'));
            /*  while($star->diff($end)->days > 0) {
                  $days += $star->format('N') < 6 ? 1 : 0;
                  $star = $star->add(new \DateInterval("P1D"));
              }*/
            /* for ($i = $star; $i <= $end; $i->modify('+1 day')) {
                 $a = $this->getDoctrine()
                     ->getRepository(Booking::class)
                     ->findOneBy([
                         'beginAt' => $i]);
             }
                 /*$a = $this->getDoctrine()
                     ->getRepository(Booking::class)->find(5);*/

            /*while ($star->diff($end)->days > 0) {
                $days += $star->format('N') < 6 ? 1 : 0;
                $star = $star->add(new \DateInterval("P1D"));
            }

            if (empty($a)) {
                $days = $days - 1;
                $holidayRequest->setNbjours($days);
            } /*for ($i = $star; $i <= $end; $i->modify('+1 day')) {
                $a = $this->getDoctrine()
                    ->getRepository(Booking::class)
                    ->findOneBy([
                        'beginAt' => $i]);


                if (empty($a)) {

                    $holidayRequest->setNbjours($days);

                } else {
                    $days = $days - 1;
                    $holidayRequest->setNbjours($days);
                }*/


            /*else {

                $holidayRequest->setNbjours($days);
            }*/
            $user1=$this->getDoctrine()
                ->getRepository(User::class)->find($this->getUser());
            if($user1->getSoldecong() >= $days) {
                $this->addFlash(
                    'notice',
                    'Votre demande de congé a été enregistré avec succès!'
                );

                $holidayRequest->setNbjours($days);
                $em->persist($holidayRequest);
                $em->flush();
                $p = $star->format('m');

                $a = $this->getDoctrine()
                    ->getRepository(Booking::class)->findBydate($p);
                if(!empty($a)) {
                    $m = $a->getBeginAt()->format('Y-m-d');


                    //foreach ($list as $event) {


                       // $ee = $event->getBeginAt()->format('Y-m-d');
                        $s = $star->format('Y-m-d');

                        $e = $end->format('Y-m-d');


                       // $data = ['hello' => 'world'];
                        if ($m >= $s && $m <= $e) {
                            $a = "between";
                            while ($star->diff($end)->days > 0) {
                                $days += $star->format('N') < 6 ? 1 : 0;
                                $star = $star->add(new \DateInterval("P1D"));
                            }
                            $holidayRequest->setNbjours($days - 1);
                            $userId = $holidayRequest->getUserId();
                            $user = $this->getDoctrine()
                                ->getRepository(User::class)->find($userId);
                            $solde = $user->getSoldecong();
                            $user->setSoldecong($solde - ($days - 1));
                            $em->persist($user);
                            $em->flush();
                        } else {
                            $a = "no";
                            while ($star->diff($end)->days > 0) {
                                $days += $star->format('N') < 6 ? 1 : 0;
                                $star = $star->add(new \DateInterval("P1D"));
                            }
                            $holidayRequest->setNbjours($days);
                            $userId = $holidayRequest->getUserId();
                            $user = $this->getDoctrine()
                                ->getRepository(User::class)->find($userId);
                            $solde = $user->getSoldecong();
                            $user->setSoldecong($solde - $days);
                            $em->persist($user);
                            $em->flush();
                        }


                      //  var_dump('vardump', $data);


                        $em->persist($holidayRequest);
                        $em->flush();


                        return $this->redirectToRoute('holiday_request_add', array( 'star' => $s, 'result' => $a, 'm' => $m));



                }
                else{

                    while ($star->diff($end)->days > 0) {
                        $days += $star->format('N') < 6 ? 1 : 0;
                        $star = $star->add(new \DateInterval("P1D"));
                    }
                    $holidayRequest->setNbjours($days);
                    $em->persist($holidayRequest);
                    $em->flush();


                    return $this->redirectToRoute('holiday_request_add');


                }

            }
            else{
                $this->addFlash(
                    'notice',
                    'Votre demande de congé est réfusé!votre solde congé est insuffisant !'
                );
                return $this->redirectToRoute('holiday_request_add');
            }
        }

        return $this->render('bashboard/holiday_request/index.html.twig', [
            'form' => $form->createView(),

        ]);
    }


    /**
     * @Route("/holiday-request/list", name="holiday_request_list")
     */
    public function show(Request $request, PaginatorInterface $paginator): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(HolidayRequest::class)
            ->findBy([
                'user_id' => $this->getUser()->getId(),

            ], [
                'id' => 'DESC'
            ]);
        $list= $paginator->paginate(
            $articles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        return $this->render('bashboard/holiday_request/list.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/holiday-request/mylist", name="holiday_request_mylist")
     */
    public function show1(Request $request, PaginatorInterface $paginator): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(HolidayRequest::class)
            ->findBy([
                'user_id' => $this->getUser()->getId(),


            ]);
        $list= $paginator->paginate(
            $articles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        return $this->render('bashboard/holiday_request/mylist.html.twig', [
            'list' => $list,
        ]);
    }

    /**
     * @Route("/{id}/cancel", name="holiday_cancel_request")
     */
    public function cancel(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(HolidayRequest::class);
        if ($holidayRequest = $repository->find($id)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($holidayRequest);
            $em->flush();
        }
        return $this->redirectToRoute('holiday_request_list');
    }
    /**
     * @Route("/holiday/update/{id}", name="update_holiday_request")
     * Method ({"GET", "POST"})
     */
    public function update(Request $request, $id)
    {
        $holidayRequestEntity = $this->getDoctrine()->getRepository(HolidayRequest::class)->find($id);

        $form = $this->createForm(HolidayRequestType::class, $holidayRequestEntity)
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

            return $this->redirectToRoute('holiday_request_list');
        }

        return $this->render('bashboard/holiday_request/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
