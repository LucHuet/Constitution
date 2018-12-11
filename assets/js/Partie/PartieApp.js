import React, { Component } from 'react';
import Parties from './Parties';
import PropTypes from 'prop-types';

import { getParties, createPartie, deletePartie } from '../api/partie_api.js';

export default class PartieApp extends Component {

  constructor(props) {
    super(props);

    this.state = {
        highlightedRowId: null,
        parties : [],
        isLoaded: false,
        isSavingNewPartie: false,
        successMessage: ''
    };

    this.successMessageTimeoutHandle = 0;
    this.handleRowClick = this.handleRowClick.bind(this);
    this.handleAddPartie = this.handleAddPartie.bind(this);
    this.handleDeletePartie = this.handleDeletePartie.bind(this);
  }

  componentDidMount(){
    getParties()
      .then((data) => {
        this.setState({
          parties : data,
          isLoaded: true
        })
      });
  }

  componentWillUnmount() {
       clearTimeout(this.successMessageTimeoutHandle);
   }

  handleRowClick(partieId, event) {
      this.setState({highlightedRowId: partieId});
  }

  handleAddPartie(nom) {
      const newPartie = {
        nom: nom
      };

    this.setState({
      isSavingNewPartie: true
    });

    createPartie(newPartie)
        .then(partie => {
          this.setState(prevState => {
          const newParties = [...prevState.parties, newPartie];
          return {parties: newParties,
                  isSavingNewPartie: false,
                };
          });
          this.setSuccessMessage('Partie créée!');
        })
    ;
  }

  handleDeletePartie(id){
    deletePartie(id)
      .then(() => {
        this.setState((prevState) => {
          return{
            parties: this.state.parties.filter(partie => partie.id !== id)
          };
        });
          this.setSuccessMessage('La partie a été supprimée.');
      });
  }

  setSuccessMessage(message) {
    this.setState({
        successMessage: message
    });
    clearTimeout(this.successMessageTimeoutHandle);
    this.successMessageTimeoutHandle = setTimeout(() => {
        this.setState({
            successMessage: ''
        });
        this.successMessageTimeoutHandle = 0;
    }, 3000)
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
