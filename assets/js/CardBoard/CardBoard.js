import React from 'react';
import Card from './Card';
import ActeurCreator from '../Acteur/ActeurCreator';
import PropTypes from 'prop-types';
import { Modal, Form, Button, Icon } from 'semantic-ui-react';


//function et pas class car pas beaucoup de logique à l'intérieur
export default function CardBoard(props){

  const {
    acteurs,
    onAddActeur,
    onShowModal,
    onCloseModal,
    onDeleteActeur,
    isLoaded,
    isSavingNewActeur,
    successMessage,
    newActeurValidationErrorMessage,
    itemOptions,
    showModal,
  } = props;


  if(!isLoaded){
    return(
          <div>Loading...</div>
    )
  }

  return (
    <div>
      <h2 className="js-custom_popover"
          data-toggle="popover"
          title="à propos"
          data-content="pour la République !"
      > La Partie
      </h2>

      <button type="button" className="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Ajouter un acteur</button>

      { /*
        Si message de succès on l'affiche
      */ }
      {successMessage && (
        <div className="alert alert-success text-center">
            {successMessage}
        </div>
      )}

      <div id="sort1" className="ui cards" data-sortable=".card">
      {acteurs.map((acteur, index) => (

          <Card
            key = {index}
            index={index}
            acteur={acteur}
            onDeleteActeur={onDeleteActeur}
            onShowModal={onShowModal}
          />
        )
      )}
      {isSavingNewActeur && (
        <div id="sort1" className="ui cards" data-sortable=".card">
          En ajout ...
        </div>
      )}
    </div>
      { /*
      ItemOptions : ensemble des options de types acteurs
    */ }


    <div id="myModal" className="modal fade" role="dialog">
      <div className="modal-dialog">

        <div className="modal-content">
          <div className="modal-header">
            <button type="button" className="close" data-dismiss="modal">&times;</button>
            <h4 className="modal-title">Modal Header</h4>
          </div>
          <div className="modal-body">
            <ActeurCreator
              onAddActeur={onAddActeur}
              validationErrorMessage={newActeurValidationErrorMessage}
              itemOptions={itemOptions}
            />
          </div>
        </div>

      </div>
    </div>

    <Modal closeIcon onClose={onCloseModal} open={showModal}>
      <Modal.Header>My Modal</Modal.Header>
      <Modal.Content>
        <span>TEST</span>
      </Modal.Content>
    </Modal>

  </div>
  );
}

CardBoard.propTypes = {
  onAddActeur: PropTypes.func.isRequired,
  onShowModal: PropTypes.func.isRequired,
  onCloseModal: PropTypes.func.isRequired,
  onDeleteActeur: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired,
  isLoaded: PropTypes.bool.isRequired,
  isSavingNewActeur: PropTypes.bool.isRequired,
  showModal: PropTypes.bool.isRequired,
  successMessage: PropTypes.string.isRequired,
  newActeurValidationErrorMessage: PropTypes.string.isRequired,
  itemOptions: PropTypes.array.isRequired,

}
