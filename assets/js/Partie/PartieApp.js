import React, { Component } from 'react';

export default class PartieApp extends Component {
  render() {

    const parties = [
     { id: 9, nom: 'partie 1' },
     { id: 10, nom: 'partie 2' },
     { id: 11, nom: 'partie 3' }
   ];

    return (
      <div>
        <table className="table table-parties">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          {parties.map((partie) => {
              return (
                  <tr key={partie.id}>
                      <td>{partie.nom}</td>
                      <td>...</td>
                  </tr>
              )
          })};

          </tbody>
        </table>
        <form className="partie" method="post">
          <div className="field">
            <div id="partie">
              <div>
                <label htmlFor="partie_nom" className="required">Nom</label>
                <input type="text" id="partie_nom" name="partie[nom]" required="required" maxLength="255" />
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
  }
