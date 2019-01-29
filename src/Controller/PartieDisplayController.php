<?php

namespace App\Controller;

use App\Entity\Partie;
use App\Entity\Acteur;
use App\Entity\ActeurPartie;
use App\Form\PartieType;
use App\Repository\PartieRepository;
use App\Repository\ActeurRepository;
use App\Repository\PouvoirRepository;
use App\Repository\DesignationRepository;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Service\CheckEvents;
use App\Service\CheckStepService;
use App\Controller\Base\BaseController;

/**
 * @Route("/partieDisplay")
 */
class PartieDisplayController extends BaseController
{

    private $checkStep;

    public function __construct(CheckStepService $checkStep)
    {
        $this->checkStep = $checkStep;
    }

    /**
     * @Route("/liste/", name="partie_liste", methods="GET")
     */
    public function liste(PartieRepository $partieRepository): Response
    {
        // verification qu'un utilisateur est loggé
        if($this->checkStep->checkLogin() != null){
          return $this->redirectToRoute($this->checkStep->checkLogin());
        }

        return $this->render('partie/index.html.twig', [
          'parties' => $partieRepository->findAll()
        ]);

    }

    /**
     * @Route("/{id<\d+>}", name="partie_show", methods="GET")
     */
    public function show(
      Partie $partieCourante,
      PouvoirPartieRepository $pouvoirPartieRepository,
      ActeurRepository $acteurRepository,
      DesignationRepository $designationRepository,
      PouvoirRepository $pouvoirRepository,
      CheckEvents $checkEvents
    ): Response
    {


        $session = new Session();
        $session->set('partieCourante', $partieCourante);

        // verification de la partie courante
        if($this->checkStep->checkPartie($partieCourante) != null){
          return $this->redirectToRoute($this->checkStep->checkPartie($partieCourante));
        }

        $partieAppProps = [
            'itemOptions' => [],
            'pouvoirOptions' => [],
            'designationOptions' => [],
            'acteursPartiesOptions' => [],
        ];

        foreach ($acteurRepository->findAll() as $acteur) {
            $partieAppProps['itemOptions'][] = [
                'id' => $acteur->getId(),
                'text' => $acteur->getType(),
                'desc' => $acteur->getDescription(),
                'image' => $acteur->getImage(),
            ];
        }

        foreach ($pouvoirRepository->findAll() as $pouvoir) {
            $partieAppProps['pouvoirOptions'][] = [
                'id' => $pouvoir->getId(),
                'text' => $pouvoir->getNom(),
            ];
        }

        foreach ($partieCourante->getActeurParties() as $acteursPartie) {
            $partieAppProps['acteursPartiesOptions'][] = [
                'id' => $acteursPartie->getId(),
                'text' => $acteursPartie->getNom(),
            ];
        }

        foreach ($designationRepository->findAll() as $designation) {
            $partieAppProps['designationOptions'][] = [
                'id' => $designation->getId(),
                'text' => $designation->getNom(),
            ];
        }



        return $this->render('partie/partiePagePrincipale.html.twig', [
          'partieCourante' => $partieCourante,
          'pouvoir_parties' => $pouvoirPartieRepository->findBy(['partie' => $partieCourante]),
          'partieAppProps' => $partieAppProps
        ]);
    }

    /**
     * @Route("/new/", name="partie_display_new", methods="GET|POST")
     */
    public function new(Request $request, ActeurRepository $acteurRepository): Response
    {
        // verification qu'un utilisateur est loggé
        if($this->checkStep->checkLogin() != null){
          return $this->redirectToRoute($this->checkStep->checkLogin());
        }

        $partieCourante = new Partie();
        $form = $this->createForm(PartieType::class, $partieCourante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partieCourante->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            //faire en sorte que le peuple soit présent par défaut
            $acteurPartie = new ActeurPartie();
            //ajout de l'acteur peuple
            $acteurPeuple = $acteurRepository->findOneBy(['type'=>'Peuple']);
            $acteurPartie->setPartie($partieCourante);
            $acteurPartie->setTypeActeur($acteurPeuple);
            $acteurPartie->setNom($acteurPeuple->getType());
            //persister le peuple
            $em->persist($acteurPartie);
            $em->persist($partieCourante);
            $em->flush();
            $session = new Session();
            $session->set('partieCourante', $partieCourante);
            return $this->redirectToRoute('partie_show', ['id' =>$partieCourante->getId()]);
        }

        return $this->render('partie/new.html.twig', [
            'partie' => $partieCourante,
            'form' => $form->createView(),
        ]);
    }

}
