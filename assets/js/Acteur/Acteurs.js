import React from 'react';
import ActeurList from './ActeurList';
import ActeurCreator from './ActeurCreator';
import PropTypes from 'prop-types';

export default function Acteurs(props){

  const { withProut, highlightedRowId, onRowClick, acteurs, onNewItemSubmit } = props;
  let prout = '';
  if(withProut){
    prout = <span>prout</span>;
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

      <ActeurCreator
        onNewItemSubmit={onNewItemSubmit}
      />

  </div>
  );
}

Acteurs.propTypes = {
  withProut: PropTypes.bool,
  highlightedRowId: PropTypes.any,
  onRowClick: PropTypes.func.isRequired,
  onNewItemSubmit: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired
}
