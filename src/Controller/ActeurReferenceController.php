<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Repository\ActeurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Base\BaseController;

/**
 * @Route("/acteurReference")
 */
class ActeurReferenceController extends BaseController
{

    /**
     * @Route("/{id}", name="acteur_ref_get" , methods="GET")
     */
    public function getActeurReference(Acteur $acteur)
    {
        $apiModel = $this->createActeurRefApiModel($acteur);

        return $this->createApiResponse($apiModel);
    }

    /**
     * @Route("/", name="acteur_ref_list", methods="GET")
     */
    public function getActeursReference()
    {
        $models = $this->findAllActeursRefModels();
        return $this->createApiResponse([
            'items' => $models
        ]);
    }

}
