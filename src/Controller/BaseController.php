<?php

namespace App\Controller;

use App\Api\ActeurApiModel;
use App\Entity\ActeurPartie;
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

    /**
     * Turns a RepLog into a RepLogApiModel for the API.
     *
     * This could be moved into a service if it needed to be
     * re-used elsewhere.
     *
     * @param ActeurPartie $acteurPartie
     * @return ActeurApiModel
     */
    protected function createActeurApiModel(ActeurPartie $acteurPartie)
    {
        $model = new ActeurApiModel();
        $model->id = $acteurPartie->getId();
        $model->nom = $acteurPartie->getNom();
        $model->nombreIndividus = $acteurPartie->getNombreIndividus();

        $selfUrl = $this->generateUrl(
            'acteur_partie',
            ['id' => $acteurPartie->getId()]
        );
        $model->addLink('_self', $selfUrl);

        return $model;
    }

    /**
     * @return RepLogApiModel[]
     */
    protected function findAllUsersActeursModels()
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
}
