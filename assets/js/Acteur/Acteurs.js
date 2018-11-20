import React from 'react';
import ActeurList from './ActeurList';
import ActeurCreator from './ActeurCreator';
//import ActeurCreator from './ActeurCreatorControlledComponents';
import PropTypes from 'prop-types';

export default function Acteurs(props){

  const {
    withProut,
    highlightedRowId,
    onRowClick,
    acteurs,
    onAddActeur,
    numberOfProuts,
    onProutChange,
    onDeleteActeur,
    isLoaded,
    isSavingNewActeur,
    successMessage,
    newActeurValidationErrorMessage,
    itemOptions,
  } = props;

  let prout = '';
  if(withProut){
    prout = <span>{'🌬️ '.repeat(numberOfProuts)}</span>;
  }

  return (
    <div data-acteurs="{{ acteursJson|e('html_attr') }}">
      <h2 className="js-custom_popover"
          data-toggle="popover"
          title="à propos"
          data-content="pour la République !"
      >
        Partie en cours {prout}
      </h2>

      <input
        type="range"
        value={numberOfProuts}
        onChange={(e) => {
          onProutChange(+e.target.value)
        }}
      />
      {successMessage && (
        <div className="alert alert-success text-center">
            {successMessage}
        </div>
      )}
      <table className="table" >
          <thead>
              <tr>
                  <th>Nom</th>
                  <th>Nb Individus</th>
                  <th>Actions</th>
                  <th>Désigné par</th>
                  <th></th>
              </tr>
          </thead>


          <ActeurList
            highlightedRowId={highlightedRowId}
            onRowClick={onRowClick}
            acteurs={acteurs}
            onDeleteActeur={onDeleteActeur}
            isLoaded={isLoaded}
            isSavingNewActeur={isSavingNewActeur}
          />

      </table>
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

Acteurs.propTypes = {
  withProut: PropTypes.bool,
  highlightedRowId: PropTypes.any,
  onRowClick: PropTypes.func.isRequired,
  onAddActeur: PropTypes.func.isRequired,
  onDeleteActeur: PropTypes.func.isRequired,
  onProutChange: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired,
  numberOfProuts: PropTypes.number.isRequired,
  isLoaded: PropTypes.bool.isRequired,
  isSavingNewActeur: PropTypes.bool.isRequired,
  successMessage: PropTypes.string.isRequired,
  newActeurValidationErrorMessage: PropTypes.string.isRequired,
  itemOptions: PropTypes.array.isRequired,

}
