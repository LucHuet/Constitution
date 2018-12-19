import React from 'react';
import DroitsDevoirsReferenceListe from './DroitsDevoirsReferenceListe';
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
      <div className = "droitsDevoirsRefernceListe">
        <h3 className="ui header"> Liste des droits et devoirs </h3>
        <br/>
          <table>

            <DroitsDevoirsReferenceListe
              droitsDevoirs={droitsDevoirs}
              onRowClick={onRowClick}
              addedRowId={addedRowId}/>

          </table>
        </div>
        <br/>
        
        <h3 className="ui header"> Droits et devoirs de la partie</h3>
        <table>

          <DroitsDevoirsListe/>

        </table>


      </div>
  );
}

DroitsDevoirs.propTypes = {
    droitsDevoirs: PropTypes.array.isRequired,
    onRowClick: PropTypes.func.isRequired,
    addedRowId: PropTypes.any,
};
