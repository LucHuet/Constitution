import React, { Component } from 'react';
import Acteurs from './Acteurs';
import PropTypes from 'prop-types';
import uuid from 'uuid/v4';
import { getActeurs } from '../api/acteur_api.js';


export default class ActeurApp extends Component {

  constructor(props){
    super(props);

    getActeurs()
      .then((data)=>{
        console.log(data);
      });

    this.state = {
      highlightedRowId: null,
      acteurs: [
        {id: uuid(),nom:"RERE",nombreIndividus:null},
        {id: uuid(),nom:"RERE2",nombreIndividus:34},
        {id: uuid(),nom:"RERE3",nombreIndividus:1}
      ],
      numberOfProuts: 1,
    };

    this.handleRowClick = this.handleRowClick.bind(this);
    this.handleAddActeur = this.handleAddActeur.bind(this);
    this.handleProutChange = this.handleProutChange.bind(this);
    this.handleDeleteActeur = this.handleDeleteActeur.bind(this);
  }

  handleRowClick(acteurId) {
      this.setState({highlightedRowId:acteurId});
  }

  handleAddActeur(acteurName, nombreIndividus, typeActeur){

      const newActeur = {
        id: uuid(),
        nom: acteurName,
        nombreIndividus : nombreIndividus
      };

      this.setState(prevStat => {
        const newActeurs = [...prevStat.acteurs, newActeur];

        return {acteurs: newActeurs}
      });
  }

  handleProutChange(proutsCount) {
    this.setState({
      numberOfProuts: proutsCount
    });
  }

  handleDeleteActeur(id) {
    // remove the rep log without mutating state
    // filter returns a new array
    this.setState((prevState) => {
      return {
        acteurs: prevState.acteurs.filter(acteur => acteur.id != id)
      }
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
