import React from 'react';
import PartieListe from './PartieListe';
import PartieCreator from './PartieCreator';
import PropTypes from 'prop-types';

export default function Parties(props) {

  const { highlightedRowId,
          onRowClick,
          parties,
          onAddPartie,
          onDeletePartie
        } = props;

  return (
    <div>
      <table className="table table-parties">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Supprimer</th>
          </tr>
        </thead>

        <PartieListe highlightedRowId={highlightedRowId}
                     onRowClick={onRowClick}
                     parties={parties}
                     onDeletePartie={onDeletePartie}/>

      </table>
      <PartieCreator onAddPartie={onAddPartie}/>
    </div>
  );
}

Parties.propTypes = {
    highlightedRowId: PropTypes.any,
    onRowClick: PropTypes.func.isRequired,
    parties: PropTypes.array.isRequired,
    onAddPartie: PropTypes.func.isRequired,
    onDeletePartie: PropTypes.func.isRequired
};
