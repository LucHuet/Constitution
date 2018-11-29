import React from 'react';
import PropTypes from 'prop-types';

export default function Card(props) {

  //on descructure les props pour en récuperer les variables
  const {
    acteurs,
    onDeleteActeur,
    isLoaded,
    isSavingNewActeur,

  } = props;

  const handleDeleteClick = function(event, acteurId){
    //évite le comportement normal du boutton
    //exemple évite que le submit soumette la page.
    event.preventDefault();

    onDeleteActeur(acteurId);
  };

  if(!isLoaded){
    return(
          <div>Loading...</div>
    )
  }

  return(
    <div>
      { /*
      pour chaque acteur restant on le met dans le tableau
    */ }
      <div id="sort1" className="ui cards" data-sortable=".card">
      {acteurs.map((acteur, index) => (
        <div
          className="card"
          key={acteur.id}
          data-position={index}
          data-id={index}
        >
          <div className="extra content">
            <a>
              Cet acteur a été désigné par :
            </a>
            <div className="right floated">
              <i className="meh icon"></i>
              <i className="meh icon"></i>
            </div>
          </div>
          <div className="content">
            <img className="right floated tiny ui image" src="/build/static/card.jpg"/>
            <div className="header">
              {acteur.nom}
              <a href="#" onClick={(event => handleDeleteClick(event, acteur.id))}>
                  <span className="fa fa-trash"></span>
              </a>
            </div>
            <div className="meta">
              Type acteur ?
            </div>
            <div className="description">
              Nombre individus : {acteur.nombreIndividus}
              <br/>
              <button className="right floated ui basic button">
                <i className="icon plus"></i>
                  Ajout pouvoir
              </button>
            </div>
          </div>
          <div className="extra content">
            <a>
              <i className="users icon"></i>
              Cet acteur désigne :
            </a>
            <div className="right floated">
              <i className="bug icon"></i>
              <i className="meh icon"></i>
            </div>
          </div>
        </div>
        )
      )}
      </div>
      {isSavingNewActeur && (
        <div id="sort1" className="ui cards" data-sortable=".card">
          En ajout ...
        </div>
      )}
    </div>

  );
}

//on défini les types des props
Card.propTypes = {
  onDeleteActeur: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired,
  isLoaded: PropTypes.bool.isRequired,
  isSavingNewActeur: PropTypes.bool.isRequired,
  isPageOnLoad: PropTypes.bool,
};
