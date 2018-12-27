import React from 'react';
import DroitsDevoirsReferenceListe from './DroitsDevoirsReferenceListe';
import DroitsDevoirsListe from './DroitsDevoirsListe';
import PropTypes from 'prop-types';

export default function DroitsDevoirs(props) {

  const {
          droitsDevoirsReference,
          droitsDevoirs,
          addedRowId,
          droitsDevoirsPartieShow,
          onRowClick,
          onShowDroitsDevoirsPartieListe
        } = props;

  const handleDroitsDevoirsPartie = function(event){
    //évite le comportement normal du boutton
    //exemple évite que le submit soumette la page.
    event.preventDefault();

    onShowDroitsDevoirsPartieListe();
  };

  return (
    <div className="droits-devoirs-listes">
      <h3 className="ui header">Droits et devoirs</h3>
        <table>
          <DroitsDevoirsReferenceListe
            droitsDevoirsReference={droitsDevoirsReference}
            droitsDevoirs={droitsDevoirs}
            onRowClick={onRowClick}
            addedRowId={addedRowId}
            />
        </table>
      <br/>

      <button className="ui basic button" onClick={(event => handleDroitsDevoirsPartie(event))}>
        <i className="icon angle down"></i>
        Droits et devoirs de la partie
      </button>
      {!droitsDevoirsPartieShow && (
        <React.Fragment>
          <h3 className="ui header"> Droits et devoirs de la partie</h3>
          <table>

            <DroitsDevoirsListe
              droitsDevoirs={droitsDevoirs}
              onRowClick={onRowClick}/>
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
  onShowDroitsDevoirsPartieListe: PropTypes.func.isRequired,
  droitsDevoirsPartieShow: PropTypes.bool.isRequired,
  addedRowId: PropTypes.any,
};
