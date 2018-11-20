import React, { Component } from 'react';
import Acteurs from './Acteurs';
import PropTypes from 'prop-types';
import uuid from 'uuid/v4';
import { getActeurs, deleteActeur, createActeur } from '../api/acteur_api.js';


export default class ActeurApp extends Component {

  constructor(props){
    super(props);


    this.state = {
      highlightedRowId: null,
      acteurs: [],
      numberOfProuts: 1,
      isLoaded: false,
      isSavingNewActeur: false,
      successMessage: '',
    };

    this.successMessageTimemoutHandle = 0;

    this.handleRowClick = this.handleRowClick.bind(this);
    this.handleAddActeur = this.handleAddActeur.bind(this);
    this.handleProutChange = this.handleProutChange.bind(this);
    this.handleDeleteActeur = this.handleDeleteActeur.bind(this);
  }
  //componentDidMount est une methode magique qui est automatiquement
  //lancée apres le render de l'app
  componentDidMount(){
    getActeurs()
      .then((data)=>{
        this.setState({
          acteurs: data,
          isLoaded: true
        });
      });
  }
  //componentWillUnmount est une methode magique qui est automatiquement
  //lancée juste apres qu'un element soit supprimé
  componentWillUnmount(){
    clearTimeout(this.successMessageTimemoutHandle);
  }

  handleRowClick(acteurId) {
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

      createActeur(newActeur)
        .then(acteur => {
          this.setState(prevState =>{
            const newActeurs = [...prevState.acteurs, acteur];

            return {
              acteurs: newActeurs,
              isSavingNewActeur: false,
            };
          });
          this.setSuccessMessage('Acteur enregistré !');
        });
  }

  setSuccessMessage(message){

    this.setState({
      successMessage: message
    });

    clearTimeout(this.successMessageTimemoutHandle);
    this.successMessageTimemoutHandle = setTimeout(() => {
      this.setState({
        successMessage: ''
      });

      this.successMessageTimemoutHandle =  0;
    }, 3000);
  }

  handleProutChange(proutsCount) {
    this.setState({
      numberOfProuts: proutsCount
    });
  }

  handleDeleteActeur(id) {

    this.setState((prevState) =>{
      return {
        acteurs: prevState.acteurs.map(acteur => {
          if (acteur.id !== id){
            return acteur;
          }

          return Object.assign({}, acteur, {isDeleting: true});
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
  withProut: PropTypes.bool
}
