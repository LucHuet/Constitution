import React from 'react';
import DroitsDevoirsReferenceListe from './DroitsDevoirsReferenceListe';
import DroitsDevoirsListe from './DroitsDevoirsListe';
import PropTypes from 'prop-types';

export default function DroitsDevoirs(props) {

  const {
          droitsDevoirsReference,
          droitsDevoirs,
          addedRowId,
          droitsDevoirsReferenceShow,
          onRowClick,
          onShowDroitsDevoirsReferenceListe
        } = props;

  const handleDroitsDevoirsReferenceListe = function(){
    onShowDroitsDevoirsReferenceListe();
  };

  return (
    <div className="droits-devoirs-listes">

        <React.Fragment>
          <h3 className="ui header"> Droits et devoirs de la partie</h3>
          <table>
            <DroitsDevoirsListe
              droitsDevoirs={droitsDevoirs}
              onRowClick={onRowClick}/>
          </table>
        </React.Fragment>


      <br/>
      <button className="ui basic button" onClick={() => handleDroitsDevoirsReferenceListe()}>
        <i className="icon angle down"></i>
        Ajout Droits et Devoirs
      </button>
      {droitsDevoirsReferenceShow && (
        <React.Fragment>
      <h3 className="ui header">Droits et devoirs</h3>
        <table>
          <DroitsDevoirsReferenceListe
            droitsDevoirsReference={droitsDevoirsReference}
            droitsDevoirs={droitsDevoirs}
            onRowClick={onRowClick}
            addedRowId={addedRowId}
            />
        </table>
        </React.Fragment>
      )
    }
    </div>
  );
}

DroitsDevoirs.propTypes = {
  droitsDevoirsReference: PropTypes.array.isRequired,
  droitsDevoirs: PropTypes.array.isRequired,
  onRowClick: PropTypes.func.isRequired,
  onShowDroitsDevoirsReferenceListe: PropTypes.func.isRequired,
  droitsDevoirsReferenceShow: PropTypes.bool.isRequired,
  addedRowId: PropTypes.any,
};
