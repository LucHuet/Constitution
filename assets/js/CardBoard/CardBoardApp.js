import React, { Component } from 'react';
import CardBoard from './CardBoard';
//permet de définit le type de props
import PropTypes from 'prop-types';
import interact from 'interactjs';
import _ from 'lodash';
import { getActeurs, deleteActeur, createActeur } from '../api/acteur_api.js';
import Sortable from './Sortable.js';

//le mot clé export permet de dire qu'on pourra utiliser
//cette fonction à l'exterieur du fichier
export default class CardBoardApp extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    //permet  d'initialiser les states donc les
    //variables qui peuvent être modifiées.
    this.state = {
      acteurs: [],
      isLoaded: false,
      isSavingNewActeur: false,
      successMessage: '',
      newActeurValidationErrorMessage: '',
      showModal:false,
      //sorter
      item_width: 0,
      item_height: 0,
      cols:0,
      element: null,
      items: null,
      scrollable: document.body,
      startPosition:0,
      offset:0,
      scrollTopStart:0,
      sortable:null,
    };


    this.successMessageTimemoutHandle = 0;

    //bind(this) permet de faire en sorte que le this corresponde à la classe
    //et pas à la méthode.
    this.handleAddActeur = this.handleAddActeur.bind(this);
    this.handleShowModal = this.handleShowModal.bind(this);
    this.handleCloseModal = this.handleCloseModal.bind(this);
    this.handleDeleteActeur = this.handleDeleteActeur.bind(this);

  }

  //componentDidMount est une methode magique qui est automatiquement
  //lancée apres le render de l'app
  componentDidMount(){
    getActeurs()
    //then signifie qu'il n'y a pas d'erreur.
      .then((data)=>{
        //méthode qui permet de redonner une valeur à un state.
        this.setState({
          acteurs: data,
          isLoaded: true,
        });
        this.setState({
          sortable : new Sortable(document.querySelector('#sort1'), null)
        });
      });
  }

  //componentWillUnmount est une methode magique qui est automatiquement
  //lancée juste apres qu'un element soit supprimé
  componentWillUnmount(){
    //remet le timeout à 0 après une suppression d'acteur
    clearTimeout(this.successMessageTimemoutHandle);
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
          this.state.sortable.setPositions(true);
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

  handleShowModal(acteurId){
    this.setState({
      showModal: true
    });
  }

  handleCloseModal(acteurId){
    this.setState({
      showModal: false
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

    deleteActeur(id)
      .then(() => {
        // remove the rep log without mutating state
        // filter returns a new array
        this.setState((prevState) => {
          return {
            acteurs: prevState.acteurs.filter(acteur => acteur.id != id)
          }
        });
        this.setSuccessMessage('Acteur supprimé !');
        this.state.sortable.setPositions(true);
      });

  }

  render(){

    return (
      <CardBoard
        {...this.props}
        {...this.state}
        onAddActeur={this.handleAddActeur}
        onShowModal={this.handleShowModal}
        onCloseModal={this.handleCloseModal}
        onDeleteActeur = {this.handleDeleteActeur}
      />
    )
  }
}

CardBoardApp.propTypes = {
  //permet de mettre par defaut les type de items option de props
  itemOptions:PropTypes.array,
};

CardBoardApp.defaultProps = {
  itemOptions:[],
};
