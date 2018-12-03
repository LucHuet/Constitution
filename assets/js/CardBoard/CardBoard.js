import React from 'react';
import Card from './Card';
import ActeurCreator from '../Acteur/ActeurCreator';
import PouvoirCreator from '../Pouvoir/PouvoirCreator';
import PropTypes from 'prop-types';
import { Modal} from 'semantic-ui-react';


//function et pas class car pas beaucoup de logique à l'intérieur
export default function CardBoard(props){

  const {
    acteurs,
    onAddActeur,
    onAddPouvoir,
    onShowModal,
    onCloseModal,
    onDeleteActeur,
    isLoaded,
    isSavingNewActeur,
    successMessage,
    newActeurValidationErrorMessage,
    itemOptions,
    pouvoirOptions,
    showModal,
    acteurSelect,
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

    <Modal
      onClose={onCloseModal}
      open={showModal}
      style = {{
        marginTop: 'auto',
        marginLeft: 'auto',
        marginRight: 'auto'
      }}
    >
      <Modal.Header>Nouveau pouvoir</Modal.Header>
      <Modal.Content>
      <PouvoirCreator
        onAddPouvoir={onAddPouvoir}
        validationErrorMessage={newActeurValidationErrorMessage}
        pouvoirOptions={pouvoirOptions}
        acteurSelect={acteurSelect}
      />
      </Modal.Content>
    </Modal>

  </div>
  );
}

CardBoard.propTypes = {
  onAddActeur: PropTypes.func.isRequired,
  onAddPouvoir: PropTypes.func.isRequired,
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
  acteurSelect: PropTypes.number.isRequired,

}
