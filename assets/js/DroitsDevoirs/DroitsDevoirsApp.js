import React, { Component } from 'react';
import DroitsDevoirs from './DroitsDevoirs';

import { getDroitsDevoirsReference, addDroitDevoir, getDroitsDevoirs } from '../api/partie_api.js';

export default class DroitsDevoirsApp extends Component {

  constructor(props) {
    super(props);

    this.state = {
      droitsDevoirsReference : [],
      droitsDevoirs: [],
      addedRowId:null,
      droitsDevoirsReferenceShow:false,
      };

    this.handleRowClick = this.handleRowClick.bind(this);
    this.handleDroitsDevoirsReferenceListe = this.handleDroitsDevoirsReferenceListe.bind(this);

  }

//charge les droits et devoirs avant que la page charge
  componentDidMount(){
    getDroitsDevoirsReference()
      .then((data) => {
        this.setState({
          droitsDevoirsReference : data,
          isLoaded: true,
        });
      });
    getDroitsDevoirs()
      .then((data) => {
        this.setState({
          droitsDevoirs : data
        });
      });
  }

  handleRowClick(droitDevoirId) {
    //permet à handleRowClick de prendre la valeur de l'id de la ligne sur laquelle on clique
      this.setState({addedRowId:droitDevoirId});

      addDroitDevoir(droitDevoirId)
      .then((data) => {
        this.setState({
          droitsDevoirs : data
        });
      });
  }

  handleDroitsDevoirsReferenceListe(){
    this.setState((prevState)=>({
      droitsDevoirsReferenceShow: !prevState.droitsDevoirsReferenceShow
    }))
  }

  render() {
    return (
        <DroitsDevoirs
            {...this.props}
            {...this.state}
            onRowClick={this.handleRowClick}
            onShowDroitsDevoirsRefListe={this.handleDroitsDevoirsReferenceListe}
        />

    )
  }
}
