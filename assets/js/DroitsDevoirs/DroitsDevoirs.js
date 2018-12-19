import React from 'react';
import DroitsDevoirsListe from './DroitsDevoirsListe';
import PropTypes from 'prop-types';

export default function DroitsDevoirs(props) {

  const {
          droitsDevoirs
        } = props;

  return (
    <div>
      <h3 className="ui header centered"> Liste des droits et devoirs </h3>
      <br/>
        <table>

          <DroitsDevoirsListe droitsDevoirs={droitsDevoirs}/>

        </table>
      </div>
  );
}

DroitsDevoirs.propTypes = {
    droitsDevoirs: PropTypes.array.isRequired,
};
