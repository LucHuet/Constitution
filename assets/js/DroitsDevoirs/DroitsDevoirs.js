import React from 'react';
import DroitsDevoirsListe from './DroitsDevoirsListe';
import PropTypes from 'prop-types';

export default function Parties(props) {

  const {
          successMessage,
          droitsDevoirs
        } = props;

  return (
      <div>
        <div className="ui raised very padded text container segment">
          <h2 className="ui header centered"> Liste des droits et devoirs </h2>
          <br/>
            {successMessage && (
              <div className="ui success message">
                <div className="header">
                    {successMessage}
                </div>
              </div>
            )}

            <table className="ui very basic collapsing celled table parties-table">

              <DroitsDevoirsListe droitsDevoirs={droitsDevoirs}/>

            </table>
          </div>
        <br/>
    </div>
  );
}

Parties.propTypes = {
    droitsDevoirs: PropTypes.array.isRequired,
    successMessage: PropTypes.string.isRequired,
};
