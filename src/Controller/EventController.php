<?php

namespace App\Controller;

//base controller used for api
use App\Controller\Base\BaseController;
//common uses
use Symfony\Component\Routing\Annotation\Route;
//specific uses
use App\Service\CheckEvents;
use App\Entity\EventPartie;

/**
 * @Route("/event")
 */
class EventController extends BaseController
{
    /**
     * @Route("/launch/", name="launch_event", methods="GET")
     */
    public function launch(CheckEvents $checkEvents)
    {

              $eventPartie = $checkEvents->checkEvent1();
              $eventPartie->setId(hexdec( uniqid() ));
              $eventApiModel = $this->createEventApiModel($eventPartie);
              //dump($this->createApiResponse($eventApiModel)); die();
              return $this->createApiResponse($eventApiModel);
    }

    /**
     * @Route("/getPast", name="get_past_events", methods="GET")
     */
    public function getPastEvents()
    {
    }

    /**
    * @Route("/{id}", name="event_get" , methods="GET")
     */
    public function getEvent(EventPartie $eventPartie)
    {
      dump($eventPartie); die();
    }

}
