import React from 'react';
import Card from './Card';
import ActeurCreator from '../Acteur/ActeurCreator';
import PouvoirCreator from '../Pouvoir/PouvoirCreator';
import DesignationCreator from '../Designation/DesignationCreator';
import PropTypes from 'prop-types';
import { Modal, Button, Icon} from 'semantic-ui-react';


//function et pas class car pas beaucoup de logique à l'intérieur
export default function CardBoard(props){

  const {
    acteurs,
    onAddActeur,
    onAddPouvoir,
    onAddDesignation,
    onShowModal,
    onCloseModal,
    onDeleteActeur,
    isLoaded,
    isSavingNewActeur,
    successMessage,
    newActeurValidationErrorMessage,
    itemOptions,
    pouvoirOptions,
    designationOptions,
    acteursPartiesOptions,
    showModal,
    modalType,
    acteurSelect,
  } = props;


  if(!isLoaded){
    return(
          <div>Loading...</div>
    )
  }

  var modalContent = "";

  switch (modalType) {
    case 'acteur':
    modalContent =       <ActeurCreator
      onAddActeur={onAddActeur}
      validationErrorMessage={newActeurValidationErrorMessage}
      itemOptions={itemOptions}
    /> ;
      break;
    case 'pouvoir':
      modalContent =       <PouvoirCreator
              onAddPouvoir={onAddPouvoir}
              validationErrorMessage={newActeurValidationErrorMessage}
              pouvoirOptions={pouvoirOptions}
              acteurSelect={acteurSelect}
            /> ;
      break;
    case 'controle':
      modalContent = "nouveau contrôle";
      break;
    case 'designation':
    modalContent =       <DesignationCreator
            onAddDesignation={onAddDesignation}
            validationErrorMessage={newActeurValidationErrorMessage}
            designationOptions={designationOptions}
            acteursPartiesOptions={acteursPartiesOptions}
            acteurSelect={acteurSelect}
          /> ;
      break;
  }

  return (
    <div>
      <h2 className="js-custom_popover"
          data-toggle="popover"
          title="à propos"
          data-content="pour la République !"
      > La Partie
      </h2>

      <Button onClick={(event => onShowModal("acteur", 0))}>Ajout acteur</Button>
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

    <Modal
      onClose={onCloseModal}
      open={showModal}
      style = {{
        marginTop: 'auto',
        marginLeft: 'auto',
        marginRight: 'auto'
      }}
    >
      <Modal.Header>Nouvel élement</Modal.Header>
      <Modal.Content>
       {modalContent}
      </Modal.Content>
    </Modal>

  </div>
  );
}

CardBoard.propTypes = {
  onAddActeur: PropTypes.func.isRequired,
  onAddPouvoir: PropTypes.func.isRequired,
  onAddDesignation: PropTypes.func.isRequired,
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
  pouvoirOptions: PropTypes.array.isRequired,
  designationOptions: PropTypes.array.isRequired,
  acteursPartiesOptions: PropTypes.array.isRequired,
  acteurSelect: PropTypes.number.isRequired,
  modalType: PropTypes.string.isRequired,

}
