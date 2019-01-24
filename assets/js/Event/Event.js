import React from 'react';
import EventListe from './EventListe';
import PropTypes from 'prop-types';
import { Modal } from 'semantic-ui-react';

export default function Event(props) {

  const {
          pastEvents,
          eventResult,
          pastEventsShow,
          onLaunchEvent,
          onShowPastEvent,
          onCloseModal,
          showModal,
        } = props;


  const handleLaunchEvent = function(){
    onLaunchEvent();
  };

  const handleShowPastEvent = function(){
    onShowPastEvent();
  };

  const handleCloseModal = function(){
    onCloseModal();
  };

  return (
    <React.Fragment>
    <div className="droits-devoirs-listes">
      <br/>
      <button className="ui basic button" onClick={() => handleLaunchEvent()}>
        Soumettre ma constitution à un evenement
      </button>
      <button className="ui basic button" onClick={() => handleShowPastEvent()}>
        Voir les evenements précédents
        <i className="icon angle down"></i>
      </button>
      {pastEventsShow && (
        <React.Fragment>
          <table>
            <EventListe
              pastEvents={pastEvents}
            />
          </table>
        </React.Fragment>
      )}
    </div>

    {eventResult != null &&
      <Modal
        onClose={handleCloseModal}
        open={showModal}
        size='large'
      >
        <Modal.Content>
        {eventResult.nomReference}
        <br/>
        {eventResult.explicationReference}
        <br/>
        {eventResult.explicationResultatEventPartie}
        </Modal.Content>
      </Modal>
    }
    </React.Fragment>
  );
}

Event.propTypes = {
  pastEvents: PropTypes.array.isRequired,
  eventResult: PropTypes.object,
  pastEventsShow: PropTypes.bool.isRequired,
  showModal: PropTypes.bool.isRequired,
  onLaunchEvent: PropTypes.func.isRequired,
  onShowPastEvent: PropTypes.func.isRequired,
  onCloseModal: PropTypes.func.isRequired,
};
