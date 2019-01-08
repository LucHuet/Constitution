import React, {Component} from 'react';
import PropTypes from 'prop-types';
import { Header, Image, Container, Divider, Segment, Flag, Icon, Button } from 'semantic-ui-react'

export default class ActeurDisplay extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    const {
        acteurPartieDisplay,
    } = this.props;

    this.state = {
      nombreActeurError: '',
      nombreIndividus: acteurPartieDisplay.nombreIndividus,
      displayCountryDescription: '',
    };

    //ref permettent d'accéder à des élements du dom
    //permet de facilement récupérer les valeurs des variables
    this.nomActeur = React.createRef();
    this.nombreActeur = React.createRef();
    this.typeActeur = React.createRef();
    this.typeDesignation = React.createRef();
    this.acteurDesignant = React.createRef();


    this.handleAjoutPouvoir = this.handleAjoutPouvoir.bind(this);
    this.nombreIndividusChange = this.nombreIndividusChange.bind(this);
    this.handleCountryDescriptionClick = this.handleCountryDescriptionClick.bind(this);
    this.handleUpdate = this.handleUpdate.bind(this);


  }

  handleUpdate(){
    //fait appel au props de l'objet
    const {onAddActeur} = this.props;

    const nomActeur = this.nomActeur.current;
    const nombreActeur = this.nombreActeur.current;
    const typeActeur = 0;
    const typeDesignation = this.typeDesignation.current;
    const acteurDesignant = this.acteurDesignant.current;
    const nomDesignation = "designation test";

    if (nombreActeur.value <= 0) {
      this.setState({
        nombreActeurError: 'Vous ne pouvez pas entrer un nombre d\'acteur négatif!'
      });
      return;
    }
    //a changer pour un update
    /*onAddActeur(
      nomActeur.value,
      nombreActeur.value,
      typeActeur,
      typeDesignation.options[typeDesignation.selectedIndex].value,
      acteurDesignant.options[acteurDesignant.selectedIndex].value,
      nomDesignation
    );*/

    //réinitialisation des données
    nombreActeur.value = '';
    this.setState({
      nombreActeurError: ''
    });

  }

  handleAjoutPouvoir(event, modalType, acteurId){
    event.preventDefault();
    const {onShowModal} = this.props;
    onShowModal( modalType, acteurId, 'Chef d\'état');
  }

  handleCountryDescriptionClick(description){
    if(this.state.displayCountryDescription == description)
    {
      description = '';
    }
    this.setState({
      displayCountryDescription: description
    });
  }

  nombreIndividusChange(nbIndibidus)
  {
    this.setState({
      nombreIndividus: nbIndibidus
    });
  }

  render(){

    const {
        acteurPartieDisplay,
        onClickPouvoir,
        pouvoirsSelection,
        designationOptions,
        acteursPartiesOptions
    } = this.props;

    const handleNomPouvoir = function(acteurPartieDisplay){
      console.log(acteurPartieDisplay.pouvoirs);
      if(acteurPartieDisplay.pouvoirs !== null){
        {acteurPartieDisplay.pouvoirs.map((pouvoir) => {
          return (
            <React.Fragment key={pouvoir.id}>
              {pouvoir.nom}
              <br/>
            </React.Fragment>
          );
        } )}
      }
      else{
        return(  <span>Pas de pouvoir</span>)
      }
    }

    return (
    <div>
    <Header as='h2' icon textAlign='center'>
      <Image size='medium' circular src='/build/static/chef.png' />
      <Header.Content>Acteur : <input type="text" id="nom" ref={this.nomActeur} defaultValue={acteurPartieDisplay.nom} required="required" maxLength="255" />
      </Header.Content>
    </Header>
    <br/>
    <Container textAlign='justified'>
      <Segment>
        <b>Nombre de personnes : </b>
        <input
          type="range"
          ref={this.nombreActeur}
          value={this.state.nombreIndividus}
          min="1" max="10"
          onChange={(e) => {
            this.nombreIndividusChange(+e.target.value)
          }}
        />
        {this.state.nombreIndividus}
      </Segment>
      <Segment>
        <b>Pouvoirs</b>
        <Divider />
        De base :
        <p>
        {handleNomPouvoir(acteurPartieDisplay)};
        </p>
        Modifier les pouvoirs :
        <p>
        <Icon name='plus square outline' onClick={(event => this.handleAjoutPouvoir(event, "pouvoir"))} size='small' /> Ajouter des pouvoirs à l acteur <br/>
        </p>
      </Segment>
      <Segment>
        <b>Désignation : </b>
        <Divider />
        <label htmlFor="designation" className="required"> Designation : </label>
      </Segment>
      <Divider />
        <Button onClick={() => this.handleUpdate()}>Sauvegarder</Button>
    </Container>
    </div>
    )
  }
}

//on défini les types des props
ActeurDisplay.propTypes = {
  onShowModal: PropTypes.func.isRequired,
  onAddActeur: PropTypes.func.isRequired,
  onClickPouvoir : PropTypes.func.isRequired,
  acteurPartieDisplay: PropTypes.object.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
  designationOptions: PropTypes.array.isRequired,
  acteursPartiesOptions: PropTypes.array.isRequired,
};
