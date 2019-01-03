import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {Card, Form, Image} from 'semantic-ui-react';

export default class ActeurCreator extends Component{

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.state = {
      nombreActeurError: ''
    };

    //ref permettent d'accéder à des élements du dom
    //permet de facilement récupérer les valeurs des variables
    this.nomActeur = React.createRef();
    this.nombreActeur = React.createRef();
    this.typeActeur = React.createRef();

    this.handleFormSubmit = this.handleFormSubmit.bind(this);
    this.handleAjout = this.handleAjout.bind(this);
  }

  handleFormSubmit(event){
    event.preventDefault();

    //fait appel au props de l'objet
    const {onAddActeur} = this.props;

    const nomActeur = this.nomActeur.current;
    const nombreActeur = this.nombreActeur.current;
    const typeActeur = this.typeActeur.current;

    if (nombreActeur.value <= 0) {
      this.setState({
        nombreActeurError: 'Vous ne pouvez pas entrer un nombre d\'acteur négatif!'
      });
      return;
    }

    onAddActeur(
      nomActeur.value,
      nombreActeur.value,
      typeActeur.options[typeActeur.selectedIndex].value
    );

    //réinitialisation des données
    nomActeur.value = '';
    nombreActeur.value = '';
    typeActeur.selectedIndex = 0;
    this.setState({
      nombreActeurError: ''
    });

  }

  handleAjout(event, modalType){
    const {onShowModal} = this.props;
    event.preventDefault();
    onShowModal( modalType);
  }


  render(){
    const { nombreActeurError } = this.state;
    const { validationErrorMessage, acteursReference } = this.props;


    return (
      <Card.Group>
      {acteursReference.map(acteurRef => {
        return  (
          <Card key={acteurRef.id} onClick={(event => this.handleAjout(event,acteurRef.type))}>

            <Card.Content>
              <Image floated='right' size='mini' src={'/build/static/'+acteurRef.image} />
              <Card.Header>{acteurRef.type}</Card.Header>
              <Card.Description>
                {acteurRef.description}
              </Card.Description>
            </Card.Content>

          </Card>
                )
      } )}
      </Card.Group>
    );
  }
}

ActeurCreator.propTypes = {
  onAddActeur: PropTypes.func.isRequired,
  validationErrorMessage: PropTypes.string.isRequired,
  acteursReference: PropTypes.array.isRequired,
  onShowModal: PropTypes.func.isRequired,
};
