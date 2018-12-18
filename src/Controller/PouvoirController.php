<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pouvoir;
use App\Controller\Base\BaseController;

/**
 * @Route("/pouvoir")
 */
class PouvoirController extends BaseController
{

  /**
   * @Route("/", name="pouvoir_list", methods="GET")
   * @Method("GET")
   */
  public function getPouvoirs()
  {
      $models = $this->findAllPouvoirsModels();
      return $this->createApiResponse([
          'items' => $models
      ]);
  }

  /**
   * @Route("/{id}", name="pouvoir_get" , methods="GET")
   * @Method("GET")
   */
  public function getPouvoir(Pouvoir $pouvoir)
  {
      $apiModel = $this->createPouvoirApiModel($pouvoir);

      return $this->createApiResponse($apiModel);
  }
}
