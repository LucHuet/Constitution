import React, { Component } from 'react';
import PropTypes from 'prop-types';
import {Form} from 'semantic-ui-react';

export default class PartieCreator extends Component {

  constructor(props) {
    super(props);
    this.partieNomInput = React.createRef();
    this.handleFormSubmit = this.handleFormSubmit.bind(this);
  }

  handleFormSubmit(event) {
    event.preventDefault();

    const { onAddPartie } = this.props;
    const partieNomInput = this.partieNomInput.current;

    onAddPartie(partieNomInput.value);

    partieNomInput.value='';
    }

  render(){
    return (
      <form className="partie" method="post" onSubmit={this.handleFormSubmit}>
        <div className="field">
          <div id="partie">
            <div>
              <label htmlFor="partie_nom" className="required">Nom</label>
              <input type="text"
                     id="partie_nom"
                     ref={this.partieNomInput}
                     required="required"
                     maxLength="255"
              />
            </div>
            <input type="hidden" id="partie__token" name="partie[_token]" value="5fa84MhAXvPtPgoWRDsiT8-QGo0B-sC0i1dizInLSqU" />
          </div>
        </div>

        <div className="row">
        <button type="submit" className="ui basic button">
          <i className="icon save"></i>
          Enregistrer
        </button>
        </div>
      </form>
    );
  }
}

PartieCreator.propTypes = {
    onNewItemSubmit: PropTypes.func.isRequired,
};
