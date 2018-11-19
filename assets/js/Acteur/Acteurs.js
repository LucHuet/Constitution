import React from 'react';
import ActeurList from './ActeurList';
import ActeurCreator from './ActeurCreator';
import PropTypes from 'prop-types';

export default function Acteurs(props){

  const {
    withProut,
    highlightedRowId,
    onRowClick,
    acteurs,
    onAddActeur,
    numberOfProuts,
    onProutChange
  } = props;

  let prout = '';
  if(withProut){
    prout = <span>{'Prout '.repeat(numberOfProuts)}</span>;
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

      <table className="table" >
          <thead>
              <tr>
                  <th>Nom</th>
                  <th>Nb Individus</th>
                  <th>Actions</th>
                  <th>Pouvoirs de l acteur</th>
                  <th>Désigné par</th>
                  <th>Force</th>
                  <th></th>
              </tr>
          </thead>


          <ActeurList
            highlightedRowId={highlightedRowId}
            onRowClick={onRowClick}
            acteurs={acteurs}
          />

      </table>
      <div className="row">
        <div className="col-md-6">
          <ActeurCreator
            onAddActeur={onAddActeur}
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
  onProutChange: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired,
  numberOfProuts: PropTypes.number.isRequired,
}
