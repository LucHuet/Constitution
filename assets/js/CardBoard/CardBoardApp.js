import React, { Component } from 'react';
import CardBoard from './CardBoard';
//permet de définit le type de props
import PropTypes from 'prop-types';
import interact from 'interactjs';
import {
    getActeursPartie, deleteActeurPartie, createActeurPartie,
    getActeursReference,
    createPouvoirPartie, createDesignation
   } from '../api/partie_api.js';
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
      acteursPartie: [],
      acteursReference: [],
      pouvoirsSelection: [],
      isLoaded: false,
      isSavingNewActeur: false,
      successMessage: '',
      newActeurValidationErrorMessage: '',
      showModal:false,
      acteurSelect:0,
      modalType:"",
      previousModal:"",
      //sorter
      sortable:null,
    };


    this.successMessageTimemoutHandle = 0;

    //bind(this) permet de faire en sorte que le this corresponde à la classe
    //et pas à la méthode.
    this.handleAddActeur = this.handleAddActeur.bind(this);
    this.handleDeleteActeur = this.handleDeleteActeur.bind(this);
    this.handleAddPouvoir = this.handleAddPouvoir.bind(this);
    this.handleAddDesignation = this.handleAddDesignation.bind(this);
    this.handleShowModal = this.handleShowModal.bind(this);
    this.handleCloseModal = this.handleCloseModal.bind(this);
    this.handlePouvoirClick = this.handlePouvoirClick.bind(this);
  }

  //componentDidMount est une methode magique qui est automatiquement
  //lancée apres le render de l'app
  componentDidMount(){
    getActeursPartie()
    //then signifie qu'il n'y a pas d'erreur.
      .then((data)=>{
        //méthode qui permet de redonner une valeur à un state.
        this.setState({
          acteursPartie: data,
          isLoaded: true,
        });
        this.setState({
          sortable : new Sortable(document.querySelector('#sort1'), null)
        });
      });

      getActeursReference()
      //then signifie qu'il n'y a pas d'erreur.
        .then((data)=>{
          //méthode qui permet de redonner une valeur à un state.
          this.setState({
            acteursReference: data,
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

  handleAddActeur(
    nom,
    nombreIndividus,
    typeActeur,
    typeDesignation,
    acteurDesignant,
    nomDesignation
  ){

      const newDesignation = {
        nom: nomDesignation,
        designation : typeDesignation,
        //acteurDesigne : acteurSelect, ????
        acteurDesignant: acteurDesignant
      };

      const newActeurPartie = {
        nom: nom,
        nombreIndividus : nombreIndividus,
        typeActeur : typeActeur,
        designation: newDesignation
      };

      this.setState({
        isSavingNewActeur: true
      });


      const newState = {
        isSavingNewActeur: false,
      }

      createActeurPartie(newActeurPartie)
      //l'ajout n'as pas d'erreur
        .then(acteurPartie => {
          //prevstate est la liste des acteurs originale
          this.setState(prevState =>{
            //déclaration d'une nouvelle liste d'acteursJson
            //qui est la liste de base + le nouvel acteur
            const newActeursPartie = [...prevState.acteursPartie, acteurPartie];

            return {
              //on remet isSavingNewActeur à false
              ...newState,
              acteursPartie: newActeursPartie,
              newActeurValidationErrorMessage: '',
              showModal: false
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

  handleDeleteActeur(id) {
    //prevstate est la liste des acteursPartie originale
    this.setState((prevState) =>{
      return {
        //on fait une boucle qui redéfini acteur en lui retirant l'acteur dont l'id à été cliqué
        acteursPartie: prevState.acteursPartie.map(acteurPartie => {
          if (acteurPartie.id !== id){
            return acteurPartie;
          }
          //permet de mettre isDeleting : true pour l'acteur qui se fait supprimer
          return {...acteurPartie, isDeleting: true};
        })
      }
    });

    deleteActeurPartie(id)
      .then(() => {
        // remove the rep log without mutating state
        // filter returns a new array
        this.setState((prevState) => {
          return {
            acteursPartie: prevState.acteursPartie.filter(acteurPartie => acteurPartie.id != id)
          }
        });
        this.setSuccessMessage('Acteur supprimé !');
        this.state.sortable.setPositions(true);
      });

  }

  handleAddPouvoir(nom, typePouvoir, acteurSelect){

      const newPouvoir = {
        nom: nom,
        pouvoir : typePouvoir,
        acteurPossedant: acteurSelect
      };

      createPouvoirPartie(newPouvoir)
      //l'ajout n'as pas d'erreur
        .then(pouvoir => {
          this.setSuccessMessage('Pouvoir enregistré !');
          this.setState({showModal: false});
        })
  }

  handleAddDesignation(nom, typeDesignation, acteurDesignant, acteurSelect){

      const newDesignation = {
        nom: nom,
        designation : typeDesignation,
        acteurDesigne : acteurSelect,
        acteurDesignant: acteurDesignant
      };

      createDesignation(newDesignation)
      //l'ajout n'as pas d'erreur
        .then(pouvoir => {
          this.setSuccessMessage('Désignation enregistréé !');
          this.setState({showModal: false});
        })
  }

  handleShowModal(modalType, acteurId=0, previousModal=""){
    this.setState({
      showModal: true,
      modalType:modalType,
      acteurSelect:acteurId,
      previousModal:previousModal,
    });
  }

  handleCloseModal(acteurId){
    this.setState({
      showModal: false,
      modalType:"",
      acteurSelect:0,
      pouvoirsSelection: []
    });
  }

  handlePouvoirClick(pouvoirId) {
    //permet à highlightedRowId de prendre la valeur de l'id de la ligne sur laquelle on clique
      //this.setState({highlightedRowId:pouvoirId});
      if(this.state.pouvoirsSelection.includes(pouvoirId))
      {
        this.setState((prevState) => {
          return {
            pouvoirsSelectionTest : pouvoirId,
            pouvoirsSelection: prevState.pouvoirsSelection.filter(id => id != pouvoirId)
          }
        });
      }else {

        this.setState((prevState) => {
          //déclaration d'une nouvelle liste d'acteursJson
          //qui est la liste de base + le nouvel acteur
          return {
            pouvoirsSelectionTest : pouvoirId,
            pouvoirsSelection: [...prevState.pouvoirsSelection, pouvoirId],
          };
        });
      }
      console.log(2, this.state.pouvoirsSelection, this.state.pouvoirsSelectionTest);
  }


  render(){

    return (
      <CardBoard
        {...this.props}
        {...this.state}
        onAddActeur={this.handleAddActeur}
        onAddPouvoir={this.handleAddPouvoir}
        onClickPouvoir={this.handlePouvoirClick}
        onAddDesignation={this.handleAddDesignation}
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
  pouvoirOptions:PropTypes.array,
  designationOptions:PropTypes.array,
  acteursPartiesOptions:PropTypes.array,
};

CardBoardApp.defaultProps = {
  itemOptions:[],
  pouvoirOptions:[],
  designationOptions:[],
  acteursPartiesOptions:[],
};
