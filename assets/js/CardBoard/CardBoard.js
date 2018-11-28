import React from 'react';
import Card from './Card';
import ActeurCreator from '../Acteur/ActeurCreator';
import PropTypes from 'prop-types';

//function et pas class car pas beaucoup de logique à l'intérieur
export default function CardBoard(props){

  const {
    highlightedRowId,
    onRowClick,
    acteurs,
    onAddActeur,
    onDeleteActeur,
    isLoaded,
    isSavingNewActeur,
    successMessage,
    newActeurValidationErrorMessage,
    itemOptions,
  } = props;


  return (
    <div>
      <h2 className="js-custom_popover"
          data-toggle="popover"
          title="à propos"
          data-content="pour la République !"
      >
      </h2>

      { /*
        Si message de succès on l'affiche
      */ }
      {successMessage && (
        <div className="alert alert-success text-center">
            {successMessage}
        </div>
      )}

          { /*
            On appelle acteurList pour récupérer la liste des acteurs
          */ }
          <Card
            highlightedRowId={highlightedRowId}
            onRowClick={onRowClick}
            acteurs={acteurs}
            onDeleteActeur={onDeleteActeur}
            isLoaded={isLoaded}
            isSavingNewActeur={isSavingNewActeur}
          />

      { /*
      ItemOptions : ensemble des options de types acteurs
    */ }
      <div className="row">
        <div className="col-md-6">
          <ActeurCreator
            onAddActeur={onAddActeur}
            validationErrorMessage={newActeurValidationErrorMessage}
            itemOptions={itemOptions}
          />
        </div>
      </div>

  </div>
  );
}

CardBoard.propTypes = {
  highlightedRowId: PropTypes.any,
  onRowClick: PropTypes.func.isRequired,
  onAddActeur: PropTypes.func.isRequired,
  onDeleteActeur: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired,
  isLoaded: PropTypes.bool.isRequired,
  isSavingNewActeur: PropTypes.bool.isRequired,
  successMessage: PropTypes.string.isRequired,
  newActeurValidationErrorMessage: PropTypes.string.isRequired,
  itemOptions: PropTypes.array.isRequired,

}
