import React, { Component } from 'react';
import Acteurs from './Acteurs';
import PropTypes from 'prop-types';

export default class ActeurApp extends Component {

  constructor(props){
    super(props);

    this.state = {
      highlightedRowId: null,
      acteurs: [
        {id: 1,nom:"RERE",nombreIndividus:null},
        {id: 2,nom:"RERE2",nombreIndividus:34},
        {id: 3,nom:"RERE3",nombreIndividus:1}
      ]
    };

    this.handleRowClick = this.handleRowClick.bind(this);
  }

  handleRowClick(acteurId) {
      this.setState({highlightedRowId:acteurId});
  }

  render(){

    return (
      <Acteurs
        {...this.props}
        {...this.state}
        onRowClick={this.handleRowClick}
      />
    )
  }
}

ActeurApp.propTypes = {
  withProut: PropTypes.bool
}
