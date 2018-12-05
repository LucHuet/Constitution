import React from 'react';
import PropTypes from 'prop-types';

export default function Card(props) {

  //on descructure les props pour en récuperer les variables
  const {
    index,
    acteur,
    onDeleteActeur,
    onShowModal,
  } = props;

  const handleDeleteClick = function(event, acteurId){
    //évite le comportement normal du boutton
    //exemple évite que le submit soumette la page.
    event.preventDefault();

    onDeleteActeur(acteurId);
  };

  const handleAjout = function(event, modalType, acteurId){
    event.preventDefault();
    onShowModal( modalType, acteurId);
  };

  return(
        <div
          className="card"
          data-position={index}
          data-id={index}
        >
          <div className="extra content">
            <div className="left floated">
              <a>
                <span>Désigné par :</span>
              </a>
              <img className="ui avatar image" src="/build/static/Politician.png"/>
            </div>
            <div className="right floated">
              <a>
                <span>Controlé par :</span>
              </a>
              <i className="university icon"></i>
            </div>
          </div>
          <div className="content">
            <img className="right floated tiny ui image" src="/build/static/Politician.png"/>
            <div className="header">
              <span>{acteur.nom}</span>
            </div>
            <div className="meta">
              <a href="#" onClick={(event => handleAjout(event, "pouvoir", acteur.id))}>
                <i className="plus square outline icon"></i>Pouvoir
              </a>
              <a href="#" onClick={(event => handleAjout(event,"controle", acteur.id))}>
                <i className="plus square outline icon"></i>Contrôle
              </a>
              <a href="#" onClick={(event => handleAjout(event, "designation", acteur.id))}>
                <i className="plus square outline icon"></i>Désignation
              </a>
            </div>
            <div className="description">
              <span>Nombre individus : {acteur.nombreIndividus}</span>
              <br/>
              <span>Type acteur ?</span>
              <a href="#" onClick={(event => handleDeleteClick(event, acteur.id))}>
                <button className="right floated ui basic button">
                  <i className="trash icon"></i>
                </button>
              </a>
            </div>
          </div>
          <div className="extra content">
          <div className="left floated">
            <a>
              <span>Désigne :</span>
            </a>
            <i className="briefcase icon"></i>
            <i className="university icon"></i>
          </div>
          <div className="right floated">
            <a>
              <span>Contrôle :</span>
            </a>
            <i className="balance scale icon"></i>
            <i className="fighter jet icon"></i>
          </div>
          </div>
        </div>
  );
}

//on défini les types des props
Card.propTypes = {
  index: PropTypes.number,
  onDeleteActeur: PropTypes.func.isRequired,
  onShowModal: PropTypes.func.isRequired,
  acteur: PropTypes.object,
};
