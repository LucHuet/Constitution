import React from 'react';
import PartieListe from './PartieListe';
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
        <div className="ui raised very padded text container segment">
          <h2 className="ui header centered"> Liste de vos parties </h2>
          <br/>
            {successMessage && (
              <div className="ui success message">
                <div className="header">
                    {successMessage}
                </div>
              </div>
            )}

              <table className="ui very basic collapsing celled table parties-table">
                <thead>
                  <tr>
                    <th><h3 className="ui header">Nom de la partie</h3></th>
                    <th><h3 className="ui header">Supprimer</h3></th>
                  </tr>
                </thead>

                <PartieListe highlightedRowId={highlightedRowId}
                             onRowClick={onRowClick}
                             parties={parties}
                             onDeletePartie={onDeletePartie}
                             onAddPartie={onAddPartie}
                             isLoaded={isLoaded}
                             isSavingNewPartie={isSavingNewPartie}/>

              </table>
            </div>
            <br/>
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
