import React from 'react';
import DroitsDevoirsListe from './DroitsDevoirsListe';
import PropTypes from 'prop-types';

export default function DroitsDevoirs(props) {

  const {
          droitsDevoirs,
          addedRowId,
          onRowClick,
        } = props;

  return (
    <div>
      <h3 className="ui header"> Liste des droits et devoirs </h3>
      <br/>
        <table>

          <DroitsDevoirsListe
            droitsDevoirs={droitsDevoirs}
            onRowClick={onRowClick}
            addedRowId={addedRowId}/>

        </table>
      </div>
  );
}

DroitsDevoirs.propTypes = {
    droitsDevoirs: PropTypes.array.isRequired,
    onRowClick: PropTypes.func.isRequired,
    addedRowId: PropTypes.any,
};
