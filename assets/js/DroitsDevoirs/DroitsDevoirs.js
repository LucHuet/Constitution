import React from 'react';
import DroitsDevoirsReferenceListe from './DroitsDevoirsReferenceListe';
import DroitsDevoirsListe from './DroitsDevoirsListe';
import PropTypes from 'prop-types';

export default function DroitsDevoirs(props) {

  const {
          droitsDevoirs,
          addedRowId,
          droitsDevoirsReferenceShow,
          onRowClick,
          onShowDroitsDevoirsRefListe,
        } = props;

  const handleDroitsDevoirs = function(event){
    //évite le comportement normal du boutton
    //exemple évite que le submit soumette la page.
    event.preventDefault();

    onShowDroitsDevoirsRefListe();
  };

  return (
    <div>
      <button className="ui basic button" onClick={(event => handleDroitsDevoirs(event))}>
        <i className="icon plus"></i>
        Droits et devoirs
      </button>

      {!droitsDevoirsReferenceShow && (
        <React.Fragment>
          <h3 className="ui header"> Liste des droits et devoirs </h3>
            <table>

              <DroitsDevoirsReferenceListe
                droitsDevoirs={droitsDevoirs}
                onRowClick={onRowClick}
                addedRowId={addedRowId}/>

            </table>
          </React.Fragment>
        )
      }
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
    onShowDroitsDevoirsRefListe: PropTypes.func.isRequired,
    droitsDevoirsReferenceShow: PropTypes.bool.isRequired,
    addedRowId: PropTypes.any,
};
