import React, { Component } from 'react';
import Event from './Event';

import { launchEvent, getPastEvents } from '../api/partie_api.js';

export default class EventApp extends Component {

  constructor(props) {
    super(props);

    this.state = {
      pastEvents: [],
      eventResult: null,
      pastEventsShow:false,
      };

    this.handleLaunchEvent = this.handleLaunchEvent.bind(this);
    this.handleShowPastEvent = this.handleShowPastEvent.bind(this);

  }

//charge les droits et devoirs avant que la page charge
  componentDidMount(){
    getPastEvents()
      .then((data) => {
        this.setState({
          pastEvents : data
        });
      });
  }

  handleLaunchEvent(droitDevoirId) {
    //permet à handleRowClick de prendre la valeur de l'id de la ligne sur laquelle on clique
      this.setState({addedRowId:droitDevoirId});

      launchEvent()
      .then((data) => {
        this.setState({
          eventResult : data
        });
        console.log(this.state.eventResult);
      });
  }

  handleShowPastEvent(){
    this.setState((prevState)=>({
      pastEventsShow: !prevState.pastEventsShow
    }))
  }

  render() {
    return (
        <Event
            {...this.props}
            {...this.state}
            onLaunchEvent={this.handleLaunchEvent}
            onShowPastEvent={this.handleShowPastEvent}
        />

    )
  }
}
