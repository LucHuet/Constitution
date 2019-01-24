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
      showModal:false,
      };

    this.handleLaunchEvent = this.handleLaunchEvent.bind(this);
    this.handleShowPastEvent = this.handleShowPastEvent.bind(this);
    this.handleCloseModal = this.handleCloseModal.bind(this);
  }

//charge les droits et devoirs avant que la page charge
  componentDidMount(){
    /*getPastEvents()
      .then((data) => {
        this.setState({
          pastEvents : data
        });
      });*/
  }

  handleLaunchEvent(droitDevoirId) {
    //permet à handleRowClick de prendre la valeur de l'id de la ligne sur laquelle on clique
      this.setState({addedRowId:droitDevoirId});

      launchEvent()
      .then((data) => {
        this.setState({
          eventResult : data,
          showModal : true,
        });
      });
  }

  handleShowPastEvent(){
    this.setState((prevState)=>({
      pastEventsShow: !prevState.pastEventsShow
    }))
  }

  handleCloseModal(){
    this.setState({
      showModal : false
    });
  }

  render() {
    return (
        <Event
            {...this.props}
            {...this.state}
            onLaunchEvent={this.handleLaunchEvent}
            onShowPastEvent={this.handleShowPastEvent}
            onCloseModal={this.handleCloseModal}
        />

    )
  }
}
