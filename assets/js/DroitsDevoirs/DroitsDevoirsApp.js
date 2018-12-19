import React, { Component } from 'react';
import DroitsDevoirs from './DroitsDevoirs';

import { getDroitsDevoirs } from '../api/partie_api.js';

export default class DroitsDevoirsApp extends Component {

  constructor(props) {
    super(props);

    this.state = {
      droitsDevoirs : [],
      };
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

  render() {
    return (
      <div>
        <DroitsDevoirs
            {...this.props}
            {...this.state}
        />
        <br/>
        <button className="ui basic button">
          <i className="icon plus"></i>
          Droits et devoirs
        </button>
      </div>
    )
  }
}
