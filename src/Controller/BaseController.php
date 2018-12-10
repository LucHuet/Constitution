<?php

namespace App\Controller;

use App\Api\ActeurApiModel;
use App\Api\PouvoirPartieApiModel;
use App\Api\PartieApiModel;
use App\Entity\ActeurPartie;
use App\Entity\PouvoirPartie;
use App\Entity\Partie;
use App\Entity\DesignationPartie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseController extends Controller
{
    /**
     * @param mixed $data Usually an object you want to serialize
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function createApiResponse($data, $statusCode = 200)
    {
      dump($data);
        $json = $this->get('serializer')
            ->serialize($data, 'json');

        return new JsonResponse($json, $statusCode, [], true);
    }

    /**
     * Returns an associative array of validation errors
     *
     * {
     *     'firstName': 'This value is required',
     *     'subForm': {
     *         'someField': 'Invalid value'
     *     }
     * }
     *
     * @param FormInterface $form
     * @return array|string
     */
    protected function getErrorsFromForm(FormInterface $form)
    {
        foreach ($form->getErrors() as $error) {
            // only supporting 1 error per field
            // and not supporting a "field" with errors, that has more
            // fields with errors below it
            return $error->getMessage();
        }

        $errors = array();
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childError = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childError;
                }
            }
        }

        return $errors;
    }


    protected function createPartieApiModel(Partie $partie)
    {
        $model = new PartieApiModel();
        $model->id = $partie->getId();
        $model->nom = $partie->getNom();

        $selfUrl = $this->generateUrl(
            'partie_get',
            ['id' => $partie->getId()]
        );
        $model->addLink('_self', $selfUrl);

        return $model;
    }

    protected function createActeurApiModel(ActeurPartie $acteurPartie)
    {
        $model = new ActeurApiModel();
        $model->id = $acteurPartie->getId();
        $model->nom = $acteurPartie->getNom();
        $model->nombreIndividus = $acteurPartie->getNombreIndividus();
        $model->image = $acteurPartie->getTypeActeur()->getImage();
        foreach ($acteurPartie->getPouvoirParties() as $pouvoir) {
          $model->pouvoirs[] = $this->createPouvoirPartieApiModel($pouvoir);
        }

        $selfUrl = $this->generateUrl(
            'acteur_partie',
            ['id' => $acteurPartie->getId()]
        );
        $model->addLink('_self', $selfUrl);

        return $model;
    }

    protected function createPouvoirPartieApiModel(PouvoirPartie $pouvoirPartie)
    {
        $model = new PouvoirPartieApiModel();
        $model->id = $pouvoirPartie->getId();
        $model->nom = $pouvoirPartie->getNom();
        $model->pouvoir = $pouvoirPartie->getPouvoir()->getId();

        $selfUrl = $this->generateUrl(
            'pouvoir_partie_show',
            ['id' => $pouvoirPartie->getId()]
        );
        $model->addLink('_self', $selfUrl);

        return $model;
    }

    protected function createDesignationPartieApiModel(DesignationPartie $designationPartie)
    {
        $model = new PouvoirPartieApiModel();
        $model->id = $designationPartie->getId();
        $model->nom = $designationPartie->getNom();
        $model->designation = $designationPartie->getDesignation()->getId();

        $selfUrl = $this->generateUrl(
            'designation_partie_show',
            ['id' => $designationPartie->getId()]
        );
        $model->addLink('_self', $selfUrl);

        return $model;
    }

    /**
     * @return ActeurApiModel[]
     */
    protected function findAllUserActeursModels()
    {
        //on récupere la partie courante afin de n'afficher que les acteurs de la partie courante
        $session = new Session();
        $partiCourante = $session->get('partieCourante');
        $acteursPartie = $this->getDoctrine()->getRepository(ActeurPartie::class)
            ->findBy(['partie' => $partiCourante])
        ;

        $models = [];
        foreach ($acteursPartie as $acteur) {
            $models[] = $this->createActeurApiModel($acteur);
        }

        return $models;
    }

    /**
     * @return PartieApiModel[]
     */
    protected function findAllUserPartiesModels()
    {

        $utilisateurCourant = $this->getUser();

        $parties = $this->getDoctrine()->getRepository(Partie::class)
            ->findBy(['user' => $utilisateurCourant])
        ;

        $models = [];
        foreach ($parties as $partie) {
            $models[] = $this->createPartieApiModel($partie);
        }

        return $models;
    }
}
