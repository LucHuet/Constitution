import React, { Component } from 'react';
import CardBoard from './CardBoard';
//permet de définit le type de props
import PropTypes from 'prop-types';
import interact from 'interactjs';
import _ from 'lodash';
//import uuid from 'uuid/v4';
import { getActeurs, deleteActeur, createActeur } from '../api/acteur_api.js';

//le mot clé export permet de dire qu'on pourra utiliser
//cette fonction à l'exterieur du fichier
export default class CardBoardApp extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    //permet  d'initialiser les states donc les
    //variables qui peuvent être modifiées.
    this.state = {
      highlightedRowId: null,
      acteurs: [],
      isLoaded: false,
      isSavingNewActeur: false,
      successMessage: '',
      newActeurValidationErrorMessage: '',
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
    };


    this.successMessageTimemoutHandle = 0;

    //bind(this) permet de faire en sorte que le this corresponde à la classe
    //et pas à la méthode.
    this.handleRowClick = this.handleRowClick.bind(this);
    this.handleAddActeur = this.handleAddActeur.bind(this);
    this.handleDeleteActeur = this.handleDeleteActeur.bind(this);

    //sorter
    this.moveItem = this.moveItem.bind(this);
    this.getXY = this.getXY.bind(this);
    this.move = this.move.bind(this);
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
        console.log(this.state.scrollable);
        //on fait le set state apres pour pouvoir récuperer les infos
        var elementTemp = document.querySelector('#sort1');
        var itemsTemp = elementTemp.querySelectorAll(elementTemp.getAttribute('data-sortable'));
        var self = this;
        this.setState({
          element: elementTemp,
          items: itemsTemp
        });
        this.setPositions();
        interact(this.state.element.dataset.sortable, {
          context: this.state.element
        }).draggable({
          inertia: false,
          manualStart: false,
          autoScroll: {
            container: self.state.scrollable,
            margin: 250,
            speed: 600
          },
          onmove: _.throttle(function (e){
            self.move(e)
          }, 16, {trailing: false})
        }).on('dragstart', (e)=>{
          var r = e.target.getBoundingClientRect();
          e.target.classList.add('is-dragged');
          //self.startPosition = e.target.dataset.position;
          //          self.offset = {
          //            x: e.clientX - r.left,
          //            y: e.clientY - r.top
          //          };
          //self.scrollTopStart = this.state.scrollable.scrollTop;
          this.setState({
            startPosition: e.target.dataset.position,
            offset: {
              x: e.clientX - r.left,
              y: e.clientY - r.top
            },
            scrollTopStart: this.state.scrollable.scrollTop
          });
        }).on('dragend', (e)=>{
          e.target.classList.remove('is-dragged');
          this.moveItem(e.target, e.target.dataset.position);
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
      });

  }

  //sorter

  setPositions(){
    var self = this;
    //récupère un rectangle de la taille d'une carte
    var rect = this.state.items[0].getBoundingClientRect();
    //récupère la longueur et largueur du rectangle
    //this.item_width = Math.floor(rect.width);
    //this.item_height = Math.floor(rect.height);
    this.setState({
      item_width: Math.floor(rect.width),
      item_height: Math.floor(rect.height)
    });

    //récupère le nombre de colonne en fonction de la taille des rectangles
    // ! dépend de element
    //this.cols = Math.floor(this.element.offsetWidth / this.item_width);
    this.setState({
      cols: Math.floor(this.state.element.offsetWidth / this.state.item_width)
    });
    //on détermine la taille de element afin de pouvoir mettre des chose dessous
    // ! dépend de element
    //this.element.style.height = (this.item_height * Math.ceil(this.items.length / this.cols)) + "px";
    var elementTemp = this.state.element;
    elementTemp.style.height = (this.state.item_height * Math.ceil(this.state.items.length / this.state.cols)) + "px";
    this.setState({
      element: elementTemp
    });

    //on change le style des cartes pour les rendre absolute
    for(var i = 0; i< this.state.items.length; i++) {
      var item = this.state.items[i];
      item.style.position = "absolute";
      item.style.top = "0px";
      item.style.left = "0px";
      item.style.transitionDuration = "0s";
      var position = item.dataset.position;
      this.moveItem(item, position);
    }
    //on réinitialise la transition pour un effet visuel
    window.setTimeout(function(){
      for(var i = 0; i< self.state.items.length; i++) {
        var item = self.state.items[i];
        item.style.transitionDuration = null;
      }
    }, 100);
  }

  moveItem(item, position){
    var p = this.getXY(position);
    item.style.transform = "translate3D(" + p.x + "px, " + p.y + "px, 0)";
    item.dataset.position = position;

  }

  getXY(position){
    var x = this.state.item_width * (position % this.state.cols);
    var y = this.state.item_height * Math.floor(position / this.state.cols);
      return {
        x: x,
        y: y
      };
  }

  move(e){
    var p = this.getXY(this.state.startPosition);
    var x = p.x + e.clientX - e.clientX0;
    var y = p.y + e.clientY - e.clientY0 + this.state.scrollable.scrollTop - this.state.scrollTopStart;
    e.target.style.transform = "translate3D(" + x + "px, " + y + "px, 0)";
    var oldPosition = e.target.dataset.position;
    var newPosition = this.guessPosition(x + this.state.offset.x, y + this.state.offset.y);
    if(oldPosition != newPosition){
      //console.log(oldPosition, newPosition);
      this.swap(oldPosition, newPosition);
      e.target.dataset.position = newPosition;
    }
    this.guessPosition(x, y);
  }

  guessPosition (x, y){
    var col = Math.floor(x / this.state.item_width);
    if(col >= this.state.cols){
      col = this.state.cols - 1;
    }
    if(col <= 0){
      col = 0;
    }

    var row = Math.floor(y / this.state.item_height);
    if(row < 0){
      row = 0;
    }

    var position = col + row * this.state.cols;
    if(position >= this.state.items.length){
      return this.state.items.length -1;
    }
    return position;
  }

  swap(start, end){
      for(var i = 0; i< this.state.items.length; i++) {
        var item = this.state.items[i];
        if(!item.classList.contains('is-dragged'))
        {
          var position = parseInt(item.dataset.position, 10);
          if(position >= end && position < start && end < start){
            this.moveItem(item, position + 1);
          } else if(position <= end && position > start && start < end){
            this.moveItem(item, position -1);
          }
        }

      }
  }

  render(){

    return (
      <CardBoard
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

CardBoardApp.propTypes = {
  //permet de mettre par defaut les type de items option de props
  itemOptions:PropTypes.array,
};

CardBoardApp.defaultProps = {
  itemOptions:[],
};
