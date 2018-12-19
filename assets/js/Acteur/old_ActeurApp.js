import React, { Component } from 'react';
import Acteurs from './Acteurs';
//permet de définit le type de props
import PropTypes from 'prop-types';
//import uuid from 'uuid/v4';
import { getActeursPartie, deleteActeurPartie, createActeur } from '../api/acteur_api.js';

//le mot clé export permet de dire qu'on pourra utiliser
//cette fonction à l'exterieur du fichier
export default class ActeurApp extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    //permet  d'initialiser les states donc les
    //variables qui peuvent être modifiées.
    this.state = {
      highlightedRowId: null,
      acteurs: [],
      numberOfProuts: 1,
      isLoaded: false,
      isSavingNewActeur: false,
      successMessage: '',
      newActeurValidationErrorMessage: '',
    };

    this.successMessageTimemoutHandle = 0;

    //bind(this) permet de faire en sorte que le this corresponde à la classe
    //et pas à la méthode.
    this.handleRowClick = this.handleRowClick.bind(this);
    this.handleAddActeur = this.handleAddActeur.bind(this);
    this.handleProutChange = this.handleProutChange.bind(this);
    this.handleDeleteActeur = this.handleDeleteActeur.bind(this);
  }
  //componentDidMount est une methode magique qui est automatiquement
  //lancée apres le render de l'app
  componentDidMount(){
    getActeursPartie()
    //then signifie qu'il n'y a pas d'erreur.
      .then((data)=>{
        //méthode qui permet de redonner une valeur à un state.
        this.setState({
          acteurs: data,
          isLoaded: true
        });
      });
  }
  //componentWillUnmount est une methode magique qui est automatiquement
  //lancée juste apres qu'un element soit supprimé
  componentWillUnmount(){
    //remet le timeout à 0 après une suppression d'acteur
    clearTimeout(this.successMessageTimemoutHandle);
  }

  handleRowClick(acteurId) {
    //permet à highlightedRowId de prendre la valeur de l'id de la ligne sur laquelle on clique
      this.setState({highlightedRowId:acteurId});
  }

  handleAddActeur(nom, nombreIndividus, typeActeur){

      const newActeur = {
        nom: nom,
        nombreIndividus : nombreIndividus,
        typeActeur : typeActeur
      };

      this.setState({
        isSavingNewActeur: true
      });


      const newState = {
        isSavingNewActeur: false,
      }

      createActeur(newActeur)
      //l'ajout n'as pas d'erreur
        .then(acteur => {
          //prevstate est la liste des acteurs originale
          this.setState(prevState =>{
            //déclaration d'une nouvelle liste d'acteursJson
            //qui est la liste de base + le nouvel acteur
            const newActeurs = [...prevState.acteurs, acteur];

            return {
              //on remet isSavingNewActeur à false
              ...newState,
              acteurs: newActeurs,
              newActeurValidationErrorMessage: ''
            };

          });
          this.setSuccessMessage('Acteur enregistré !');
        })
        //il y a une erreur dans l'ajout
        .catch(error=> {
          error.response.json().then(errorsData => {
            const errors = errorsData.errors;
            const firstError = errors[Object.keys(errors)[0]];

            this.setState({
              ...newState,
              newActeurValidationErrorMessage: firstError,
            });
          })
        })
  }

  setSuccessMessage(message){

    this.setState({
      successMessage: message
    });

    clearTimeout(this.successMessageTimemoutHandle);
    //setTimeout permet de définir ce qu'il faut faire une fois que l'on ne veut plus du message d'erreur. (au bout de 3s)
    this.successMessageTimemoutHandle = setTimeout(() => {
      this.setState({
        successMessage: ''
      });

      this.successMessageTimemoutHandle =  0;
    }, 3000);
  }

  //quand on change la barre on change le nombre de prout à ajouter.
  handleProutChange(proutsCount) {
    this.setState({
      numberOfProuts: proutsCount
    });
  }

  handleDeleteActeur(id) {
    //prevstate est la liste des acteurs originale
    this.setState((prevState) =>{
      return {
        //on fait une boucle qui redéfini acteur en lui retirant l'acteur dont l'id à été cliqué
        acteurs: prevState.acteurs.map(acteur => {
          if (acteur.id !== id){
            return acteur;
          }
          //permet de mettre isDeleting : true pour l'acteur qui se fait supprimer
          return {...acteur, isDeleting: true};
        })
      }
    });

    deleteActeurPartie(id)
      .then(() => {
        // remove the rep log without mutating state
        // filter returns a new array
        this.setState((prevState) => {
          return {
            acteurs: prevState.acteurs.filter(acteur => acteur.id != id)
          }
        });
        this.setSuccessMessage('Acteur supprimé !');
      });

  }

  render(){

    return (
      <Acteurs
        {...this.props}
        {...this.state}
        onRowClick={this.handleRowClick}
        onAddActeur={this.handleAddActeur}
        onProutChange={this.handleProutChange}
        onDeleteActeur = {this.handleDeleteActeur}
      />
    )
  }
}

ActeurApp.propTypes = {
  withProut: PropTypes.bool,
  //permet de mettre par defaut les valeurs de items option de props
  itemOptions:PropTypes.array,
};

ActeurApp.defaultProps = {
  itemOptions:[],
};
