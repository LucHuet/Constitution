import React, {Component} from 'react';
import PropTypes from 'prop-types';
import { Header, Image, Container, Divider, Segment, Flag, Icon, Button } from 'semantic-ui-react'

export default class ActeurCreator extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);
    const {acteurReference} = this.props;

    this.individusMin = 0;
    this.individusMax = 0;
    switch(acteurReference.type) {
      case 'Chef d\'état':
        this.individusMin = 1;
        this.individusMax = 1;
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
      nombreIndividus: this.individusMin,
      displayCountryDescription: '',
    };

    //ref permettent d'accéder à des élements du dom
    //permet de facilement récupérer les valeurs des variables
    this.nomActeur = React.createRef();
    this.nombreActeur = React.createRef();
    this.typeActeur = React.createRef();
    this.typeDesignation = React.createRef();
    this.acteurDesignant = React.createRef();
    this.controlePouvoir = React.createRef();


    this.handleAjoutPouvoir = this.handleAjoutPouvoir.bind(this);
    this.nombreIndividusChange = this.nombreIndividusChange.bind(this);
    this.handleCountryDescriptionClick = this.handleCountryDescriptionClick.bind(this);
    this.handleBack = this.handleBack.bind(this);
    this.handleSave = this.handleSave.bind(this);
  }

  componentDidMount(){
    const {onClickPouvoirAdd, acteurReference} = this.props;
    acteurReference.pouvoirsBase.map((pouvoirBase) => {
      onClickPouvoirAdd(pouvoirBase.id);
    });
  }

  handleBack(modalType){
    const {onShowModal} = this.props;
    onShowModal( modalType );
  }

  handleSave(){
    //fait appel au props de l'objet
    const {onAddActeur, acteurReference} = this.props;

    const nomActeur = this.nomActeur.current;
    const nombreActeur = this.nombreActeur.current;
    const typeActeur = acteurReference.id;
    const typeDesignation = this.typeDesignation.current;
    const acteurDesignant = this.acteurDesignant.current;
    const nomDesignation = "designation test";

    if (nombreActeur.value <= 0) {
      this.setState({
        nombreActeurError: 'Vous ne pouvez pas entrer un nombre d\'acteur négatif!'
      });
      return;
    }

    onAddActeur(
      nomActeur.value,
      nombreActeur.value,
      typeActeur,
      typeDesignation.options[typeDesignation.selectedIndex].value,
      acteurDesignant.options[acteurDesignant.selectedIndex].value,
      nomDesignation
    );

    //réinitialisation des données
    nombreActeur.value = '';
    this.setState({
      nombreActeurError: ''
    });

  }

  handleAjoutPouvoir(modalType, acteurId){
    const {onShowModal, acteurReference} = this.props;
    onShowModal( modalType, acteurId, acteurReference.type);
  }

  handleCountryDescriptionClick(description){
    //si la description est déjà presente, alors on la supprime
    {(this.state.displayCountryDescription == description) ? description = '' : null}
    //on défini la description à afficher
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
        onClickPouvoir,
        acteurReference,
        pouvoirsSelection,
        pouvoirsPartie,
        designationOptions,
        acteursPartiesOptions
    } = this.props;

    return (
    <div>
    <Header as='h2' icon textAlign='center'>
      <Image size='medium' circular src={'/build/static/'+acteurReference.image} />
      <Header.Content>Ajout Acteur : <input type="text" id="nom" ref={this.nomActeur} defaultValue={acteurReference.type} required="required" maxLength="255" />
      </Header.Content>
    </Header>
    <br/>
    <Container textAlign='justified'>
      <Segment>
        <b>Description</b>
        <Divider />
        <p>
          {acteurReference.description}
        </p>
      </Segment>
      <Segment>
        <b>Dans le monde</b>
        <Divider />

        {Object.keys(acteurReference.countryDescriptions).map((countryDesc, index) => {
          return (
              <div key={acteurReference.countryDescriptions[countryDesc].code} onClick={() => this.handleCountryDescriptionClick(acteurReference.countryDescriptions[countryDesc].description)}>
                <Flag name={acteurReference.countryDescriptions[countryDesc].code} /> {acteurReference.countryDescriptions[countryDesc].country}  &nbsp;
              </div>
          )
        } )}
        <div>{this.state.displayCountryDescription}</div>
      </Segment>
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
        {acteurReference.pouvoirsBase.map((pouvoirBase) => {
          return (
            <React.Fragment key={pouvoirBase.id}>
              <span onClick={()=> onClickPouvoir(pouvoirBase.id)}>
                <Icon name={pouvoirsSelection.includes(pouvoirBase.id) ? 'minus square outline' : 'plus square outline'} size='small' />
                {pouvoirBase.nom}
              </span>
              <br/>
            </React.Fragment>
          );
        } )}
        </p>
        Supplémentaires :
        <p>
        <Icon name='plus square outline' onClick={() => this.handleAjoutPouvoir("pouvoirSelection")} size='small' /> Ajouter des pouvoirs à l acteur <br/>
        </p>
      </Segment>
      <Segment>
        <b>Désignation : </b>
        <Divider />
        <label htmlFor="designation" className="required"> Designation : </label>
        <select id="designation" ref={this.typeDesignation} required="required">
          {designationOptions.map(designation => {
            return <option value={designation.id} key={designation.id}>{designation.text}</option>
          } )}
        </select>
        <label htmlFor="acteurDesignant" className="required"> Qui désigne votre acteur ? </label>
        <select id="acteurDesignant" ref={this.acteurDesignant} required="required">
          {acteursPartiesOptions.map(acteurDesignant => {
            return <option value={acteurDesignant.id} key={acteurDesignant.id}>{acteurDesignant.text}</option>
          } )}
        </select>
      </Segment>
      <Segment>
        <b>Contrôle : </b>
        <Divider />
        <label htmlFor="controle" className="required"> Pouvoirs controllées : </label>
          {pouvoirsPartie.map(pouvoir => {
            return (
              <p key={pouvoir.id}>
                <input type="checkbox" name={pouvoir.id} value={pouvoir.id}/>
                {pouvoir.nom}
              </p>
            )
           })}
      </Segment>
      <Divider />

        <Button onClick={() => this.handleBack('acteur')}>Retour</Button>
        <Button onClick={() => this.handleSave()}>Sauvegarder</Button>
    </Container>
    </div>
    )
  }
}

//on défini les types des props
ActeurCreator.propTypes = {
  onShowModal: PropTypes.func.isRequired,
  onAddActeur: PropTypes.func.isRequired,
  acteurReference : PropTypes.object.isRequired,
  onClickPouvoirAdd : PropTypes.func.isRequired,
  onClickPouvoir : PropTypes.func.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
  pouvoirsPartie: PropTypes.array.isRequired,
  designationOptions: PropTypes.array.isRequired,
  acteursPartiesOptions: PropTypes.array.isRequired,
};
