import React, { Component } from 'react';
import Parties from './Parties';
import PropTypes from 'prop-types';
import uuid from 'uuid/v4';

export default class PartieApp extends Component {

  constructor(props) {
        super(props);

        this.state = {
            highlightedRowId: null,
            parties : [
            { id: uuid(), nom: 'partie 1' },
            { id: uuid(), nom: 'partie 2' },
            { id: uuid(), nom: 'partie 3' }
          ]
        };

        this.handleRowClick = this.handleRowClick.bind(this);
        this.handleAddPartie = this.handleAddPartie.bind(this);
        this.handleDeletePartie = this.handleDeletePartie.bind(this);
    }

  handleRowClick(partieId, event) {
      this.setState({highlightedRowId: partieId});
  }

  handleAddPartie(nom) {
      const newPartie = {
        id: uuid(),
        nom: nom
      };
      this.setState(prevState => {
        const newParties = [...prevState.parties, newPartie];
        return {parties: newParties};
      })
    }

    handleDeletePartie(id){
      this.setState((prevState) => {
        return{
          parties: this.state.parties.filter(partie => partie.id !== id)
        };
      });
    }

  render() {
    return (
      <Parties
          {...this.props}
          {...this.state}
          onRowClick={this.handleRowClick}
          onAddPartie={this.handleAddPartie}
          onDeletePartie={this.handleDeletePartie}
      />
      )
    }
  }

  PartieApp.propTypes = {
      highlightedRowId: PropTypes.any,
      onRowClick: PropTypes.func.isRequired
  };
