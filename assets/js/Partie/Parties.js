import React from 'react';
import PartieListe from './PartieListe';
import PartieCreator from './PartieCreator';
import PropTypes from 'prop-types';

export default function Parties(props) {

  const { highlightedRowId,
          onRowClick,
          parties,
          onAddPartie,
          onDeletePartie,
          isLoaded,
          isSavingNewPartie,
          successMessage
        } = props;

  return (
    <div>

      {successMessage && (
        <div className="alert alert-success text-center">
            {successMessage}
        </div>
      )}

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
                     onDeletePartie={onDeletePartie}
                     isLoaded={isLoaded}
                     isSavingNewPartie={isSavingNewPartie}/>

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
    onDeletePartie: PropTypes.func.isRequired,
    isLoaded: PropTypes.bool.isRequired,
    isSavingNewPartie: PropTypes.bool.isRequired,
    successMessage: PropTypes.string.isRequired
};
