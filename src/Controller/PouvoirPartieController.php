<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PouvoirPartie;
use App\Controller\Base\BaseController;

/**
 * @Route("/pouvoirPartie")
 */
class PouvoirPartieController extends BaseController
{

  /**
   * @Route("/{id<\d+>}", name="pouvoir_partie_get" , methods="GET")
   */
  public function getPouvoirPartie(PouvoirPartie $pouvoirPartie)
  {
      $apiModel = $this->createPouvoirPartieApiModel($pouvoirPartie);

      return $this->createApiResponse($apiModel);
  }

  /**
   * @Route("/", name="pouvoir_partie_list", methods="GET")
   */
  public function getPouvoirsPartie()
  {
      $models = $this->findAllPouvoirsPartieModels();
      return $this->createApiResponse([
          'items' => $models
      ]);
  }


}
