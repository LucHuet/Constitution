<?php

namespace App\Controller\Base;

use App\Api\ActeurPartieApiModel;
use App\Api\ActeurRefApiModel;
use App\Api\PouvoirPartieApiModel;
use App\Api\PartieApiModel;
use App\Api\PouvoirRefApiModel;
use App\Api\PouvoirApiModel;
use App\Api\DroitDevoirApiModel;
use App\Api\EventPartieApiModel;
use App\Entity\ActeurPartie;
use App\Entity\Acteur;
use App\Entity\PouvoirPartie;
use App\Entity\DroitDevoir;
use App\Entity\Partie;
use App\Entity\Pouvoir;
use App\Entity\DesignationPartie;
use App\Entity\EventPartie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Controller\Base\BaseController;

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

    protected function createPouvoirRefApiModel(Pouvoir $pouvoirReference)
    {
        $model = new PouvoirRefApiModel();
        $model->id = $pouvoirReference->getId();
        $model->nom = $pouvoirReference->getNom();
        $model->description = $pouvoirReference->getDescription();
        $model->type = $pouvoirReference->getType();
        if($pouvoirReference->getPouvoirParent() != null)
        {
        $model->pouvoirParent = $pouvoirReference->getPouvoirParent()->getId();
        }


        $selfUrl = $this->generateUrl(
            'pouvoir_ref_get',
            ['id' => $pouvoirReference->getId()]
        );
        $model->addLink('_self', $selfUrl);

        return $model;
    }

    protected function createActeurPartieApiModel(ActeurPartie $acteurPartie)
    {
        $model = new ActeurPartieApiModel();
        $model->id = $acteurPartie->getId();
        $model->nom = $acteurPartie->getNom();
        $model->nombreIndividus = $acteurPartie->getNombreIndividus();
        $model->image = $acteurPartie->getTypeActeur()->getImage();
        $model->type = $acteurPartie->getTypeActeur()->getType();
        //$designation['designants'] =
        $listeDesignationActeurPartieDesignants = $acteurPartie->getActeursDesignants();
        $listeDesignationActeurPartieDesignes = $acteurPartie->getActeursDesignes();
        $acteurDesigneSimple = [];
        $designation = [];
        foreach($listeDesignationActeurPartieDesignes as $designationActeurDesigne)
        {
          $acteurDesigneSimple = [];
          $acteurDesigne = $designationActeurDesigne->getActeurDesignant();
          $acteurDesigneSimple['id'] = $acteurDesigne->getId();
          $acteurDesigneSimple['nom'] = $acteurDesigne->getNom();
          $acteurDesigneSimple['type'] = $acteurDesigne->getTypeActeur()->getType();
          $acteurDesigneSimple['typeDesignation'] = $designationActeurDesigne->getDesignation()->getNom();

          $acteurDesigneSimple['image'] = $acteurDesigne->getTypeActeur()->getImage();
          $designation['designants'][] = $acteurDesigneSimple;
        }

        foreach($listeDesignationActeurPartieDesignants as $designationActeurDesigne)
        {
          $acteurDesigneSimple = [];
          $acteurDesigne = $designationActeurDesigne->getActeurDesigne();
          $acteurDesigneSimple['id'] = $acteurDesigne->getId();
          $acteurDesigneSimple['nom'] = $acteurDesigne->getNom();
          $acteurDesigneSimple['type'] = $acteurDesigne->getTypeActeur()->getType();
          $acteurDesigneSimple['typeDesignation'] = $designationActeurDesigne->getDesignation()->getNom();
          $acteurDesigneSimple['image'] = $acteurDesigne->getTypeActeur()->getImage();
          $designation['designes'][] = $acteurDesigneSimple;
        }

        $model->designations = $designation;

        foreach ($acteurPartie->getPouvoirParties() as $pouvoir) {
          $model->pouvoirs[] = $this->createPouvoirPartieApiModel($pouvoir);
        }

        foreach ($acteurPartie->getControlesParties() as $controlePartie) {
          $model->pouvoirsControles[] = $this->createPouvoirPartieApiModel($controlePartie->getPouvoirPartie());
        }

        $selfUrl = $this->generateUrl(
            'acteur_partie_get',
            ['id' => $acteurPartie->getId()]
        );
        $model->addLink('_self', $selfUrl);

        return $model;
    }

    protected function createActeurRefApiModel(Acteur $acteur)
    {
      $model = new ActeurRefApiModel();
      $model->id = $acteur->getId();
      $model->type = $acteur->getType();
      $model->description = $acteur->getDescription();
      $model->image = $acteur->getImage();
      foreach ($acteur->getCountryDescriptions() as $countryDescription) {
        $country ['country'] = $countryDescription->getCountry();
        $country ['description'] = $countryDescription->getDescription();
        $country ['code'] = $countryDescription->getCountryCode();
        $model->countryDescriptions[$countryDescription->getCountryCode()] = $country;
      }
      foreach ($acteur->getPouvoirsBase() as $pouvoirBase) {
        $model->pouvoirsBase[] = $this->createPouvoirRefApiModel($pouvoirBase);
      }

      $selfUrl = $this->generateUrl(
          'acteur_ref_get',
          ['id' => $acteur->getId()]
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

    protected function createEventApiModel(EventPartie $eventPartie)
    {
        $model = new EventPartieApiModel();
        $model->id = $eventPartie->getId();
        $model->nomReference = $eventPartie->getEventReference()->getNom();
        $model->explicationReference = $eventPartie->getEventReference()->getExplication();

        switch ($eventPartie->getResultat()) {
          case 0:
            $model->resultatReference = $eventPartie->getEventReference()->getResultatNull();
            break;
          case 1:
            $model->resultatReference = $eventPartie->getEventReference()->getResultatOK();
            break;
          case 2:
            $model->resultatReference = $eventPartie->getEventReference()->getResultatNOK();
            break;
        }
        $model->resultatEventPartie = $eventPartie->getResultat();
        $model->explicationResultatEventPartie = $eventPartie->getExplicationResultat();

        $selfUrl = $this->generateUrl(
            'event_get',
            ['id' => $eventPartie->getId()]
        );
        $model->addLink('_self', $selfUrl);

        return $model;
    }

    /**
     * @return ActeurRefApiModel[]
     */
    protected function findAllActeursRefModels()
    {
        $acteursRef = $this->getDoctrine()->getRepository(Acteur::class)
            ->findAll()
        ;

        $models = [];
        foreach ($acteursRef as $acteurRef) {
            $models[] = $this->createActeurRefApiModel($acteurRef);
        }

        return $models;
    }

    /**
     * @return ActeurPartieApiModel[]
     */
    protected function findAllActeursPartieModels()
    {
        //on récupere la partie courante afin de n'afficher que les acteurs de la partie courante
        $session = new Session();
        $partiCourante = $session->get('partieCourante');
        $acteursPartie = $this->getDoctrine()->getRepository(ActeurPartie::class)
            ->findBy(['partie' => $partiCourante])
        ;

        $models = [];
        foreach ($acteursPartie as $acteur) {
            $models[] = $this->createActeurPartieApiModel($acteur);
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

    /**
     * @return PartieApiModel[]
     */
    protected function findAllPouvoirsRefModels()
    {

        $pouvoirs = $this->getDoctrine()->getRepository(Pouvoir::class)
            ->findAll();

        $models = [];
        foreach ($pouvoirs as $pouvoir) {
            $models[] = $this->createPouvoirRefApiModel($pouvoir);
        }

        return $models;
    }

    /**
     * @return PouvoirPartieApiModel[]
     */
     protected function findAllPouvoirsPartieModels()
     {
         //on récupere la partie courante afin de n'afficher que les acteurs de la partie courante
         $session = new Session();
         $partiCourante = $session->get('partieCourante');

         $pouvoirsPartie = $this->getDoctrine()->getRepository(PouvoirPartie::class)
             ->findBy(['partie' => $partiCourante])
         ;

         $models = [];
         foreach ($pouvoirsPartie as $pouvoirPartie) {
             $models[] = $this->createPouvoirPartieApiModel($pouvoirPartie);
         }

         return $models;
     }
    /**
     * Methode permettant de récupérer la liste des droits et devoirs de réference
     * @return DroitDevoirApiModel[]
     */
    protected function findAllDroitsDevoirsReferenceModels()
    {
        $droitsDevoirseference = $this->getDoctrine()->getRepository(DroitDevoir::class)
            ->findAll();

        $models = [];

        foreach ($droitsDevoirseference as $droitDevoir) {
            $models[] = $this->createDroitDevoirApiModel($droitDevoir);
        }

        return $models;
    }

    /**
     * Methode permettant de récupérer la liste des droits et devoirs de la partie
     * @return DroitDevoirApiModel[]
     */
    protected function findAllDroitsDevoirsModels()
    {
        $session = new Session();
        $partieCourante = $session->get('partieCourante');
        $em = $this->getDoctrine()->getManager();
        $partieCourante = $em->merge($partieCourante);
        $droitsDevoirs = $partieCourante->getDroitDevoirs();

        $models = [];
        foreach ($droitsDevoirs as $droitDevoir) {
            $models[] = $this->createDroitDevoirApiModel($droitDevoir);
        }

        return $models;
    }

    protected function createDroitDevoirApiModel(DroitDevoir $droitDevoir)
    {
        $model = new DroitDevoirApiModel();
        $model->id = $droitDevoir->getId();
        $model->nom = $droitDevoir->getNom();

        $selfUrl = $this->generateUrl(
            'droits_devoirs_liste');
        $model->addLink('_self', $selfUrl);

        return $model;
    }

}
