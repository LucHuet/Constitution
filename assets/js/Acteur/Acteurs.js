import React from 'react';
import ActeurList from './ActeurList';
import PropTypes from 'prop-types';

export default function Acteurs(props){

  const { withProut, highlightedRowId, onRowClick, acteurs } = props;
  let prout = '';
  if(withProut){
    prout = <span>prout</span>;
  }

  return (
    <div data-acteurs="{{ acteursJson|e('html_attr') }}">
      <h2 className="js-custom_popover"
          data-toggle="popover"
          title="à propos"
          data-content="pour la République !"
      >
        Partie en cours {prout}
      </h2>

      <table className="table" >
          <thead>
              <tr>
                  <th>Nom</th>
                  <th>Nb Individus</th>
                  <th>Actions</th>
                  <th>Pouvoirs de l acteur</th>
                  <th>Désigné par</th>
                  <th>Force</th>
                  <th></th>
              </tr>
          </thead>


          <ActeurList
            highlightedRowId={highlightedRowId}
            onRowClick={onRowClick}
            acteurs={acteurs}
          />

      </table>
      <div>
          <form method="post" className="form-inline" data-url="/acteur/new/JS">
              <div className="form-group">
              <div><label htmlFor="nom" className="required">Nom</label><input type="text" id="nom" name="nom" required="required" maxLength="255" /></div>
              </div>
              {' '}
              <div className="form-group">
              <div><label htmlFor="nombreIndividus">Nombre individus</label><input type="number" id="nombreIndividus" name="nombreIndividus" /></div>
              </div>
              {' '}
              <div className="form-group">
              <div><label htmlFor="typeActeur" className="required">Type acteur</label><select id="typeActeur" name="typeActeur"><option value="4">Groupe d&#039;individus</option><option value="6">Autorité Indépendante</option></select></div>
              </div>
              {' '}
              <button className="btn">Save</button>
          </form>
      </div>
  </div>
  );
}

Acteurs.propTypes = {
  withProut: PropTypes.bool,
  highlightedRowId: PropTypes.any,
  onRowClick: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired
}
