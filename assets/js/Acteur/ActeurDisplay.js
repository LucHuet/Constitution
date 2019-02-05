import React, {Component} from 'react';
import PropTypes from 'prop-types';
import { Header, Image, Container, Divider, Segment, Flag, Icon, Button } from 'semantic-ui-react'

export default class ActeurDisplay extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    const {
        onClickPouvoir,
        onClickPouvoirAdd,
        acteurPartieDisplay,
        onUpdateActeur,
    } = this.props;

    this.individusMin = 0;
    this.individusMax = 0;
    switch(acteurPartieDisplay.type) {
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

    if(acteurPartieDisplay.pouvoirs != null)
    {
      acteurPartieDisplay.pouvoirs.map(pouvoirPartie =>{
        onClickPouvoirAdd(pouvoirPartie.pouvoir);
      })
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
    const {onUpdateActeur, acteurPartieDisplay} = this.props;

    const idActeur = acteurPartieDisplay.id;
    const nomActeur = this.nomActeur.current;
    const nombreActeur = this.nombreActeur.current;
    const typeActeur = acteurPartieDisplay.typeId;
    const typeDesignation = this.typeDesignation.current;
    const acteurDesignant = this.acteurDesignant.current;

    if (nombreActeur.value <= 0) {
      this.setState({
        nombreActeurError: 'Vous ne pouvez pas entrer un nombre d\'acteur négatif!'
      });
      return;
    }

    onUpdateActeur(
      idActeur,
      nomActeur.value,
      nombreActeur.value,
      typeActeur,
      typeDesignation.options[typeDesignation.selectedIndex].value,
      acteurDesignant.options[acteurDesignant.selectedIndex].value
    );


    //réinitialisation des données
    nombreActeur.value = '';
    this.setState({
      nombreActeurError: ''
    });

  }

  handleAjoutPouvoir(modalType, acteurId){
    const {onShowModal, acteurPartieDisplay} = this.props;
    onShowModal( modalType, acteurId, acteurPartieDisplay.type);
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
        onClickPouvoir,
        acteurPartieDisplay,
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
        Déja présents :
        <p>
        {acteurPartieDisplay.pouvoirs && (
          acteurPartieDisplay.pouvoirs.map((pouvoirPartiePresent) => {
          return (
            <React.Fragment key={pouvoirPartiePresent.id}>
              <span onClick={()=> onClickPouvoir(pouvoirPartiePresent.pouvoir)}>
                <Icon name={pouvoirsSelection.includes(pouvoirPartiePresent.pouvoir) ? 'minus square outline' : 'plus square outline'} size='small' />
                {pouvoirPartiePresent.nom}
              </span>
              <br/>
            </React.Fragment>
          );
          })
        )}
        </p>
        Modifier les pouvoirs :
        <p>
        <Icon name='plus square outline' onClick={() => this.handleAjoutPouvoir(event, "pouvoirSelection", acteurPartieDisplay.id)} size='small' /> Ajouter des pouvoirs à l acteur <br/>
        </p>
      </Segment>
      {acteurPartieDisplay.designations.designants != undefined && (
      <Segment>
        <b>Désignation : </b>
        <Divider />
        <label htmlFor="designation" className="required"> Mode de désignation : </label>
        <select id="designation" defaultValue={acteurPartieDisplay.designations.designants[0].typeDesignation} ref={this.typeDesignation} required="required">
          {designationOptions.map(designation => {
            return <option value={designation.id} key={designation.id}>{designation.text}</option>
          } )}
        </select>
        <Header.Content>
          Désigné par :
          <select id="acteurPartie" defaultValue={acteurPartieDisplay.designations.designants[0].nom} ref={this.acteurDesignant} required="required">
            {acteursPartiesOptions.map(acteurPartie => {
              return <option value={acteurPartie.id} key={acteurPartie.id}>{acteurPartie.text}</option>
            } )}
          </select>
        </Header.Content>
      </Segment>
      )}
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
  onClickPouvoirAdd : PropTypes.func.isRequired,
  acteurPartieDisplay: PropTypes.object.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
  designationOptions: PropTypes.array.isRequired,
  acteursPartiesOptions: PropTypes.array.isRequired,
};
