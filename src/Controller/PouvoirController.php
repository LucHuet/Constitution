<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pouvoir;
use App\Controller\Base\BaseController;

/**
 * @Route("/pouvoirReference")
 */
class PouvoirController extends BaseController
{

  /**
   * @Route("/", name="pouvoir_ref_list", methods="GET")
   * @Method("GET")
   */
  public function getPouvoirsReference()
  {
      $models = $this->findAllPouvoirsRefModels();
      return $this->createApiResponse([
          'items' => $models
      ]);
  }

  /**
   * @Route("/{id<\d+>}", name="pouvoir_ref_get" , methods="GET")
   * @Method("GET")
   */
  public function getPouvoirReference(Pouvoir $pouvoir)
  {
      $apiModel = $this->createPouvoirApiModel($pouvoir);

      return $this->createApiResponse($apiModel);
  }
}
