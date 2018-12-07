import React from 'react';
import PartieListe from './PartieListe';
import PropTypes from 'prop-types';

export default function Parties(props) {

  const { highlightedRowId, onRowClick, parties, onNewItemSubmit } = props;

  function handleFormSubmit(event) {
        event.preventDefault();
        console.log('I love when a good form submits!');
        console.log(event.target.elements.namedItem('partieNom').value);

        onNewItemSubmit('Nom partie : ', event.target.elements.namedItem('partieNom').value)
    }

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
      <form className="partie" method="post" onSubmit={handleFormSubmit}>
        <div className="field">
          <div id="partie">
            <div>
              <label htmlFor="partie_nom" className="required">Nom</label>
              <input type="text" id="partie_nom" name="partieNom" required="required" maxLength="255" />
            </div>
            <input type="hidden" id="partie__token" name="partie[_token]" value="5fa84MhAXvPtPgoWRDsiT8-QGo0B-sC0i1dizInLSqU" />
          </div>
        </div>

        <div className="row">
        <button type="submit" className="ui basic button">
          <i className="icon save"></i>
          Enregistrer
        </button>
        </div>
      </form>
    </div>
  );
}

Parties.propTypes = {
    highlightedRowId: PropTypes.any,
    onRowClick: PropTypes.func.isRequired,
    parties: PropTypes.array.isRequired,
    onNewItemSubmit: PropTypes.func.isRequired
};
