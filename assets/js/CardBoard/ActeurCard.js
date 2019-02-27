import React from 'react';
import PropTypes from 'prop-types';
import { Card, Image, Button, Icon } from 'semantic-ui-react'

export default function ActeurCard(props) {

  //on descructure les props pour en récuperer les variables
  const {
    index,
    acteurPartie,
    onDeleteActeur,
    onShowModal,
  } = props;

  const handleDeleteClick = function(acteurId){
    onDeleteActeur(acteurId);
  };

  const handleDisplay = function(modalType, acteurId){
    onShowModal( modalType, acteurId);
  };

  const showBasket = function(acteurType){
    if (acteurType != 'Peuple')
    {
      return(
        <Button floated="right" onClick={() => handleDeleteClick(acteurPartie.id)} >
          <Icon name="trash"></Icon>
        </Button>
      )
    }else {
      return(
        <Button floated="right" disabled >
          <Icon name="trash" disabled ></Icon>
        </Button>
      )
  }
}

  const handleDesignantImage = function(acteurPartie){
    if(acteurPartie.designations.designants !== undefined){
      return(
        <React.Fragment>
          <span>Désigné par :</span>
          {acteurPartie.designations.designants.map((acteurDesignant) => (
            <Image key={acteurDesignant.id} avatar src={"/build/static/"+acteurDesignant.image}/>
          ))}
        </React.Fragment>)
    }
    else{
      //TODO : changer le message l'acteur est désigné par tirage au sort ou concour
      return(  <span>Non désigné</span>)
    }
  }

  const handleDesigneImage = function(acteurPartie){
    if(acteurPartie.designations.designes !== undefined){
      return(
        <React.Fragment>
          <span>Designe :</span>
          {acteurPartie.designations.designes.map((acteurDesigne) => (
            <Image key={acteurDesigne.id} avatar src={"/build/static/"+acteurDesigne.image}/>
          ))}
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

            {handleDesignantImage(acteurPartie)}

            </div>
          </Card.Content>
          <Card.Content>
            <Image
              size="tiny"
              floated="right"
              src={"/build/static/"+acteurPartie.image}
              onClick={() => handleDisplay("acteurDisplay", acteurPartie.id)}
            />
            <Card.Header>{acteurPartie.nom}</Card.Header>
            <div className="description">
              <span>Nombre individus : {acteurPartie.nombreIndividus}</span>
              {showBasket(acteurPartie.type)}
            </div>
          </Card.Content>
          <Card.Content extra>
          <div className="left floated">
            {handleDesigneImage(acteurPartie)}
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
  acteurPartie: PropTypes.object,

}
