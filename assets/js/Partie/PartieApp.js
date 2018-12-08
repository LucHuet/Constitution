import React, { Component } from 'react';
import Parties from './Parties';
import PropTypes from 'prop-types';

export default class PartieApp extends Component {

  constructor(props) {
        super(props);

        this.state = {
            highlightedRowId: null,
            parties : [
            { id: 1, nom: 'partie 1' },
            { id: 2, nom: 'partie 2' },
            { id: 3, nom: 'partie 3' }
          ]
        };

        this.handleRowClick = this.handleRowClick.bind(this);
        this.handleNewItemSubmit = this.handleNewItemSubmit.bind(this);
    }

  handleRowClick(partieId, event) {
      this.setState({highlightedRowId: partieId});
  }

  handleNewItemSubmit(partieNom) {
        const parties = this.state.parties;
        const newPartie = {
          id:'TODO-id',
          partieNom: partieNom
        };
        parties.push(newPartie);
        this.setState({parties: parties});
    }

  render() {
    return (
      <Parties
          {...this.props}
          {...this.state}
          onRowClick={this.handleRowClick}
          onNewItemSubmit={this.handleNewItemSubmit}
      />
      )
    }
  }

  PartieApp.propTypes = {
      highlightedRowId: PropTypes.any,
      onRowClick: PropTypes.func.isRequired
  };
