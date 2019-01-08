import React from 'react';
import PropTypes from 'prop-types';
import { Card, Image } from 'semantic-ui-react'

export default function ActeurCard(props) {

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

  const handleDisplay = function(event, modalType, acteurId){
    event.preventDefault();
    onShowModal( modalType, acteurId);
  };

  console.log(acteur.designations);

  const handleDesignantImage = function(acteur){
    if(acteur.designations.designants !== undefined){
      return(
        <React.Fragment>
          <span>Désigné par :</span>
          <Image avatar={true} src={"/build/static/"+acteur.designations.designants.image}/>
        </React.Fragment>)
    }
    else{
      return(  <span>Non désigné</span>)
    }
  }

  const handleDesigneImage = function(acteur){
    if(acteur.designations.designes !== undefined){
      return(
        <React.Fragment>
          <span>Designe :</span>
          <Image avatar={true} src={"/build/static/"+acteur.designations.designes.image}/>
        </React.Fragment>)
    }
    else{
      return(  <span>Ne désigne personne</span>)
    }
  }

  return(
        <Card
          data-position={index}
          data-id={index}
        >
          <Card.Content extra>
            <div className="left floated">

            {handleDesignantImage(acteur)}

            </div>
          </Card.Content>
          <Card.Content>
            <Image
              size="tiny"
              floated="right"
              src={"/build/static/"+acteur.image}
              onClick={(event => handleDisplay(event, "acteurDisplay", acteur.id))}
            />
            <Card.Header>{acteur.nom}</Card.Header>
            <div className="meta">
              <a href="#" onClick={(event => handleAjout(event, "pouvoir", acteur.id))}>
                <i className="plus square outline icon"></i>Pouvoir
              </a>
              <a href="#" onClick={(event => handleAjout(event, "designation", acteur.id))}>
                <i className="plus square outline icon"></i>Désignation
              </a>
            </div>
            <div className="description">
              <span>Nombre individus : {acteur.nombreIndividus}</span>
              <a href="#" onClick={(event => handleDeleteClick(event, acteur.id))}>
                <button className="right floated ui basic button">
                  <i className="trash icon"></i>
                </button>
              </a>
            </div>
          </Card.Content>
          <Card.Content extra>
          <div className="left floated">
            {handleDesigneImage(acteur)}
          </div>
          </Card.Content>
        </Card>
  );
}

//on défini les types des props
ActeurCard.propTypes = {
  index: PropTypes.number,
  onDeleteActeur: PropTypes.func.isRequired,
  onShowModal: PropTypes.func.isRequired,
  acteur: PropTypes.object,
};
