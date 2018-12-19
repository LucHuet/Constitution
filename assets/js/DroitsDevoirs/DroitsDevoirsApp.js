import React, { Component } from 'react';
import DroitsDevoirs from './DroitsDevoirs';

import { getDroitsDevoirs } from '../api/partie_api.js';

export default class DroitsDevoirsApp extends Component {

  constructor(props) {
    super(props);

    this.state = {
      droitsDevoirs : [],
      addedRowId:null,
      droitsDevoirsReferenceShow:false,
      };

    this.handleRowClick = this.handleRowClick.bind(this);
    this.handleDroitsDevoirsReferenceListe = this.handleDroitsDevoirsReferenceListe.bind(this);

  }

//charge les droits et devoirs avant que la page charge
  componentDidMount(){
    getDroitsDevoirs()
      .then((data) => {
        console.log(data);
        this.setState({
          droitsDevoirs : data,
          isLoaded: true,
        });
        console.log(this.state.droitsDevoirs);
      });

  }

  handleRowClick(droitDevoirId) {
    //permet à highlightedRowId de prendre la valeur de l'id de la ligne sur laquelle on clique
      this.setState({addedRowId:droitDevoirId});
  }

  handleDroitsDevoirsReferenceListe(){
    this.setState((prevState)=>({
      droitsDevoirsReferenceShow: !prevState.droitsDevoirsReferenceShow
    }))
  }

  render() {
    return (
      <div>
      <button className="ui basic button" onClick={this.handleDroitsDevoirsReferenceListe}>
        <i className="icon plus"></i>
        Droits et devoirs
      </button>
      {!this.state.droitsDevoirsReferenceShow &&
        <DroitsDevoirs
            {...this.props}
            {...this.state}
            onRowClick={this.handleRowClick}
        />
      }

      </div>
    )
  }
}
