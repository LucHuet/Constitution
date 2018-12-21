import React, {Component} from 'react';
import PropTypes from 'prop-types';
import { Header, Image, Container, Divider, Segment, Flag, Icon, Button } from 'semantic-ui-react'

export default class ActeurChefCreator extends Component {

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

    this.handleBack = this.handleBack.bind(this);
    this.handleSave = this.handleSave.bind(this);
    this.handleAjoutPouvoir = this.handleAjoutPouvoir.bind(this);

  }

  handleBack(modalType){
    const {onShowModal} = this.props;
    onShowModal( modalType );
  }

  handleSave(){
    console.log("Ajout à FAIRE");

    //fait appel au props de l'objet
    const {onAddActeur, acteursReferenceChef} = this.props;

    const nomActeur = acteursReferenceChef.type;
    const nombreActeur = this.nombreActeur.current;
    const typeActeur = acteursReferenceChef.id;

    if (nombreActeur.value <= 0) {
      this.setState({
        nombreActeurError: 'Vous ne pouvez pas entrer un nombre d\'acteur négatif!'
      });
      return;
    }

    onAddActeur(
      nomActeur,
      nombreActeur.value,
      typeActeur
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

  render(){

    const {acteursReferenceChef, pouvoirsSelection} = this.props;

    return (
    <div>
    <Header as='h2' icon textAlign='center'>
      <Image size='medium' circular src='/build/static/chef.png' />
      <Header.Content>Ajout Acteur : {acteursReferenceChef.type}</Header.Content>
    </Header>
    <br/>
    <Container textAlign='justified'>
      <Segment>
        <b>Description</b>
        <Divider />
        <p>
          {acteursReferenceChef.description}
        </p>
      </Segment>
      <Segment>
        <b>Dans le monde</b>
        <Divider />
        {Object.keys(acteursReferenceChef.countryDescriptions).map((countryDesc, index) => {
          return (
            <React.Fragment key={countryDesc}> <Flag name='france' /> {countryDesc}  &nbsp;  </React.Fragment>
          )
        } )}
      </Segment>
      <Segment>
        <b>Nombre de personnes : </b>
        <input
          type="range"
          ref={this.nombreActeur}
          min="1" max="10"
        />
      </Segment>
      <Segment>
        <b>Pouvoirs</b>
        <Divider />
        De base :
        <p>
        {acteursReferenceChef.pouvoirsBase.map((pouvoirBase) => {
          return (
            <React.Fragment key={pouvoirBase.id}>
              <span onClick={()=> this.onClickPouvoir(pouvoirBase.id)}>
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
        <Icon name='plus square outline' onClick={(event => this.handleAjoutPouvoir(event, "pouvoir"))} size='small' /> Ajouter des pouvoirs à l acteur <br/>
        </p>
      </Segment>
      <Segment>
        <b>Désignation : </b>
        <Divider />
        QUI - QUOI
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
ActeurChefCreator.propTypes = {
  onShowModal: PropTypes.func.isRequired,
  onAddActeur: PropTypes.func.isRequired,
  acteursReferenceChef : PropTypes.object.isRequired,
  onClickPouvoir : PropTypes.func.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
};
