<?php
namespace App\Controller;

use App\Controller\Base\BaseController;
use App\Entity\DroitDevoir;
use App\Repository\DroitDevoirRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @Route("/droitDevoir")
 */
class DroitDevoirController extends BaseController
{

  /**
   * @Route("/", name="droits_devoirs_liste", methods="GET", options={"expose"=true})
   */
  public function getDroitsDevoirs(DroitDevoirRepository $DroitDevoirRepository)
  {
    $models = $this->findAllDroitsDevoirsReferenceModels();
    return $this->createApiResponse([
        'items' => $models
    ]);
  }


}
