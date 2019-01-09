import React, {Component} from 'react';
import PropTypes from 'prop-types';
import { Header, Image, Container, Divider, Segment, Flag, Icon, Button } from 'semantic-ui-react'

export default class ActeurDisplay extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    const {
        acteurPartieDisplay,
        onUpdateActeur,
    } = this.props;

    this.individusMin = 0;
    this.individusMax = 0;
    switch(acteurPartieDisplay.type) {
      case 'Chef d\'état':
        this.individusMin = 1;
        this.individusMax = 10;
        break;
      case 'Parlement':
        this.individusMin = 200;
        this.individusMax = 1000;
        break;
      case 'Gouvernement':
        this.individusMin = 5;
        this.individusMax = 20;
        break;
      case 'Conseil':
        this.individusMin = 5;
        this.individusMax = 20;
        break;
    }

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

/*  componentDidMount(){
    const {onClickPouvoir, acteurReference} = this.props;
    acteurReference.pouvoirsBase.map((pouvoirBase) => {
      onClickPouvoir(pouvoirBase.id);
    });
  }*/

  handleUpdate(){
    //fait appel au props de l'objet
    const {onUpdateActeur} = this.props;

    const nomActeur = this.nomActeur.current;
    const nombreActeur = this.nombreActeur.current;
    const typeActeur = 0;
    const typeDesignation = this.typeDesignation.current;
    const acteurDesignant = this.acteurDesignant.current;
    const nomDesignation = "designation test";

    console.log("test");
    console.log(this.nomActeur.current);
    console.log(nombreActeur);
    console.log(typeActeur);
    console.log(typeDesignation);
    console.log(acteurDesignant);
    console.log(nomDesignation);


    if (nombreActeur.value <= 0) {
      this.setState({
        nombreActeurError: 'Vous ne pouvez pas entrer un nombre d\'acteur négatif!'
      });
      return;
    }

    onUpdateActeur(
      console.log("saved")
    );


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
      <Image size='medium' circular src={"/build/static/"+acteurPartieDisplay.image} />
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
          min={this.individusMin} max={this.individusMax}
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
        <label htmlFor="designation" className="required"> Mode de désignation : </label>
        <select id="designation" ref={this.typeDesignation} required="required">
          {designationOptions.map(designation => {
            return <option value={designation.id} key={designation.id}>{designation.text}</option>
          } )}
        </select>
        <Header.Content>
          Désigné par :
          <select id="acteurPartie" defaultValue={acteurPartieDisplay.designations.designants.nom} ref={this.acteursPartiesOptions} required="required">
            {acteursPartiesOptions.map(acteurPartie => {
              return <option value={acteurPartie.nom} key={acteurPartie.id}>{acteurPartie.text}</option>
            } )}
          </select>
        </Header.Content>
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
  onUpdateActeur: PropTypes.func.isRequired,
  onClickPouvoir : PropTypes.func.isRequired,
  acteurPartieDisplay: PropTypes.object.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
  designationOptions: PropTypes.array.isRequired,
  acteursPartiesOptions: PropTypes.array.isRequired,
};
