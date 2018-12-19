<?php
namespace App\Controller;

use App\Controller\Base\BaseController;
use App\Repository\DroitDevoirRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/droitDevoir")
 */
class DroitDevoirController extends BaseController
{

  /**
   * @Route("/", name="droits_devoirs_liste", methods="GET", options={"expose"=true})
   * @Method("GET")
   */
  public function getDroitsDevoirs(DroitDevoirRepository $DroitDevoirRepository)
  {
    dump("test");
      $models = $this->findAllDroitsDevoirsModels();
      return $this->createApiResponse([
          'items' => $models
      ]);
  }
}
