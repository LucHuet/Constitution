import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class PartieCreator extends Component {

  constructor(props) {
    super(props);
    this.partieNomInput = React.createRef();
    this.handleFormSubmit = this.handleFormSubmit.bind(this);
  }

  handleFormSubmit() {
    event.preventDefault();
    const { onAddPartie } = this.props;
    const partieNomInput = this.partieNomInput.current;

    onAddPartie(partieNomInput.value);
    partieNomInput.value='';
    }

  render(){
    return (
      <tr className="ui form">
        <td>
        <div className="field">
          <input type="text"
            id="partie_nom"
            ref={this.partieNomInput}
            required="required"
            maxLength="255"
            placeholder="Nom de la nouvelle partie"
          />
        </div>
        </td>
        <td>
          <input type="hidden" id="partie__token" name="partie[_token]" value="5fa84MhAXvPtPgoWRDsiT8-QGo0B-sC0i1dizInLSqU" />
          <a href="#" onClick={() => {this.handleFormSubmit()}}>
            <i className="icon save"></i>
          </a>
        </td>
      </tr>
    );
  }
}

PartieCreator.propTypes = {
    onAddPartie: PropTypes.func.isRequired,
};
