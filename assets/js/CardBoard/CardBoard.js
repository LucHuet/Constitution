import React from 'react';
import ActeurCard from './ActeurCard';
import ActeurCreatorSelection from '../Acteur/ActeurCreatorSelection';
import ActeurDisplay from '../Acteur/ActeurDisplay';
import ActeurCreator from '../Acteur/ActeurCreator';
import PouvoirCreator from '../Pouvoir/PouvoirCreator';
import PropTypes from 'prop-types';
import { Modal, Button, Icon} from 'semantic-ui-react';


//function et pas class car pas beaucoup de logique à l'intérieur
export default function CardBoard(props){

  const {
    acteursPartie,
    acteursReference,
    onAddActeur,
    onAddPouvoir,
    onAddDesignation,
    onShowModal,
    onCloseModal,
    onDeleteActeur,
    onClickPouvoir,
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
    previousModal,
    acteurSelect,
    pouvoirsSelection,
  } = props;


  if(!isLoaded){
    return(
          <div>Loading...</div>
    )
  }

  var modalContent = "";

  switch (modalType) {
    case 'acteur':
    modalContent = <ActeurCreatorSelection
                    onAddActeur={onAddActeur}
                    onShowModal={onShowModal}
                    validationErrorMessage={newActeurValidationErrorMessage}
                    acteursReference={acteursReference}
                  /> ;
      break;
    case 'acteurDisplay':
      var acteurPartieDisplay = [];
      acteursPartie.forEach(function(acteurPartie) {
        if(acteurPartie.id == acteurSelect)
        {
          acteurPartieDisplay = acteurPartie;
        }
      });

      modalContent = <ActeurDisplay
                      acteurPartieDisplay={acteurPartieDisplay}
                      onShowModal={onShowModal}
                      onAddActeur={onAddActeur}
                      onClickPouvoir = {onClickPouvoir}
                      pouvoirsSelection={pouvoirsSelection}
                      acteursPartiesOptions={acteursPartiesOptions}
                      designationOptions={designationOptions}
                    /> ;
        break;
    case 'pouvoir':
      modalContent = <PouvoirCreator
                      pouvoirsSelection={pouvoirsSelection}
                      onAddPouvoir={onAddPouvoir}
                      onClickPouvoir = {onClickPouvoir}
                      onShowModal={onShowModal}
                      onCloseModal={onCloseModal}
                      validationErrorMessage={newActeurValidationErrorMessage}
                      pouvoirOptions={pouvoirOptions}
                      acteurSelect={acteurSelect}
                      previousModal={previousModal}
                    /> ;
      break;
    default:
    if(modalType == "")
    {
      break;
    }
    var acteurRef;
    acteursReference.forEach(function(acteurRef2) {
      if(acteurRef2.type == modalType)
      {
        acteurRef = acteurRef2;
      }
    });
    modalContent = <ActeurCreator
                    onShowModal={onShowModal}
                    onAddActeur={onAddActeur}
                    onClickPouvoir = {onClickPouvoir}
                    acteurReference={acteurRef}
                    pouvoirsSelection={pouvoirsSelection}
                    acteursPartiesOptions={acteursPartiesOptions}
                    designationOptions={designationOptions}
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
      {acteursPartie.map((acteur, index, acteurDesignant) => (
          <ActeurCard
            key = {index}
            index={index}
            acteur={acteur}
            acteurDesignant={acteurDesignant}
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
      size='large'
    >
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
  onClickPouvoir: PropTypes.func.isRequired,
  onAddDesignation: PropTypes.func.isRequired,
  onShowModal: PropTypes.func.isRequired,
  onCloseModal: PropTypes.func.isRequired,
  onDeleteActeur: PropTypes.func.isRequired,
  acteursPartie: PropTypes.array.isRequired,
  acteursReference: PropTypes.array.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
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
  previousModal: PropTypes.string.isRequired,

}
