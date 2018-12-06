import React, { Component } from 'react';
import PartieListe from './PartieListe';
import Parties from './Parties';
import PropTypes from 'prop-types';

export default class PartieApp extends Component {

  constructor(props) {
        super(props);

        this.state = {
            highlightedRowId: null,
            parties : [
            { id: 22, nom: 'partie 1' },
            { id: 10, nom: 'partie 2' },
            { id: 11, nom: 'partie 3' }
          ]
        };

        this.handleRowClick = this.handleRowClick.bind(this);
    }

  handleRowClick(partieId, event) {
      this.setState({highlightedRowId: partieId});
  }

  render() {

    const { highlightedRowId, parties } = this.state;

    return <Parties
              highlightedRowId={highlightedRowId}
              onRowClick={this.handleRowClick}
              parties={parties}/>
    }
  }

  PartieApp.propTypes = {
      highlightedRowId: PropTypes.any,
      onRowClick: PropTypes.func.isRequired
  };
