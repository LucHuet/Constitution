import React from 'react';
import PartieListe from './PartieListe';
import PartieCreator from './PartieCreator';
import PropTypes from 'prop-types';

export default function Parties(props) {

  const { highlightedRowId, onRowClick, parties, onNewItemSubmit } = props;

  return (
    <div>
      <table className="table table-parties">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Actions</th>
          </tr>
        </thead>

        <PartieListe highlightedRowId={highlightedRowId}
                     onRowClick={onRowClick}
                     parties={parties}/>

      </table>
      <PartieCreator  onNewItemSubmit={onNewItemSubmit}/>
    </div>
  );
}

Parties.propTypes = {
    highlightedRowId: PropTypes.any,
    onRowClick: PropTypes.func.isRequired,
    parties: PropTypes.array.isRequired,
    onNewItemSubmit: PropTypes.func.isRequired
};
