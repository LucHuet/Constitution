import React, { Component } from 'react';
import Acteurs from './Acteurs';
import PropTypes from 'prop-types';
import uuid from 'uuid/v4';

export default class ActeurApp extends Component {

  constructor(props){
    super(props);

    this.state = {
      highlightedRowId: null,
      acteurs: [
        {id: uuid(),nom:"RERE",nombreIndividus:null},
        {id: uuid(),nom:"RERE2",nombreIndividus:34},
        {id: uuid(),nom:"RERE3",nombreIndividus:1}
      ]
    };

    this.handleRowClick = this.handleRowClick.bind(this);
    this.handleNewItemSubmit = this.handleNewItemSubmit.bind(this);
  }

  handleRowClick(acteurId) {
      this.setState({highlightedRowId:acteurId});
  }

  handleNewItemSubmit(acteurName, nombreIndividus, typeActeur){
      console.log(acteurName, nombreIndividus, typeActeur);

      const acteurs = this.state.acteurs;
      const newActeur = {
        id: uuid(),
        nom: acteurName,
        nombreIndividus : nombreIndividus
      }
      acteurs.push(newActeur);
      this.setState({acteurs: acteurs});
  }

  render(){

    return (
      <Acteurs
        {...this.props}
        {...this.state}
        onRowClick={this.handleRowClick}
        onNewItemSubmit={this.handleNewItemSubmit}
      />
    )
  }
}

ActeurApp.propTypes = {
  withProut: PropTypes.bool
}
