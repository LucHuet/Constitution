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
    }

  handleRowClick(partieId, event) {
      this.setState({highlightedRowId: partieId});
  }

  handleNewItemSubmit(itemName,partieNom) {
        event.preventDefault();
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
