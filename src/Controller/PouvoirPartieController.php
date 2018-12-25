<?php

namespace App\Controller;

use App\Entity\PouvoirPartie;
use App\Form\PouvoirPartieType;
use App\Repository\PouvoirPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Partie;
use App\Service\CheckStepService;
use App\Controller\Base\BaseController;


/**
 * @Route("/pouvoirPartie")
 */
class PouvoirPartieController extends BaseController
{
    private $checkStep;

    public function __construct(CheckStepService $checkStep)
    {
        $this->checkStep = $checkStep;
    }

    /**
     * @Route("/", name="pouvoir_partie_index", methods="GET")
     */
    public function index(PouvoirPartieRepository $pouvoirPartieRepository): Response
    {
        //on verifie la partie actuelle
        if($this->checkStep->checkPartie() != null){
          return $this->redirectToRoute($this->checkStep->checkPartie());
        }

        //on récupere la partie courante afin de n'afficher que les acteurs de la partie courante
        $session = new Session();
        $partiCourante = $session->get('partieCourante');

        return $this->render('pouvoir_partie/index.html.twig', ['pouvoir_parties' => $pouvoirPartieRepository->findBy(['partie' => $partiCourante])]);
    }

    /**
     * @Route("/", name="pouvoir_partie_new", methods="POST")
     * @Method("POST")
     */
    public function createPouvoirPartie(Request $request): Response
    {

        //recupération de la partie courante
        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');


        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }


        $form = $this->createForm(PouvoirPartieType::class, null, [
          'csrf_protection' => false
        ]);

        $form->submit($data, false);
        dump($form->getData());
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            return $this->createApiResponse([
                'errors' => $errors
            ], 400);
        }

        /** @var PouvoirPartie $pouvoirPartie */
        $pouvoirPartie = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $partieCourante = $em->merge($partieCourante);
        $pouvoirPartie->setPartie($partieCourante);
        $em->persist($pouvoirPartie);
        $em->flush();

        $apiModel = $this->createPouvoirPartieApiModel($pouvoirPartie);

        $response = $this->createApiResponse($apiModel);

        $response->headers->set(
            'Location',
            $this->generateUrl('pouvoir_partie_show', ['id' => $pouvoirPartie->getId()])
        );

        return $response;

    }

    /**
     * @Route("/{id}", name="pouvoir_partie_show", methods="GET")
     */
    public function showPouvoirPartie(PouvoirPartie $pouvoirPartie): Response
    {
        if($this->checkStep->checkPouvoir($pouvoirPartie) != null){
          return $this->redirectToRoute($this->checkStep->checkPouvoir($pouvoirPartie));
        }
        return $this->render('pouvoir_partie/show.html.twig', ['pouvoir_partie' => $pouvoirPartie]);
    }



    /**
     * @Route("/{id}", name="pouvoir_partie_delete", methods="DELETE")
     */
    public function deletePouvoirPartie(Request $request, PouvoirPartie $pouvoirPartie): Response
    {
        if($this->checkStep->checkPouvoir($pouvoirPartie) != null){
          return $this->redirectToRoute($this->checkStep->checkPouvoir($pouvoirPartie));
        }

        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        if ($this->isCsrfTokenValid('delete'.$pouvoirPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pouvoirPartie);
            $em->flush();
        }

        return $this->redirectToRoute('partie_show', ['id' => $partieCourante->getId()] );
    }
}
