import React, { Component } from 'react';
import PropTypes from 'prop-types';

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
  
<div className="ui raised very padded text container segment">
  <h2 className="ui header centered">Nouvelle partie</h2>
  <form className="partie" method="post" onSubmit={this.handleFormSubmit}>
    <div id="partie">
      <div className="ui form">
        <div className="inline fields">

          <div className="three wide field">
            <label htmlFor="partie_nom" className="required">Nom de la partie</label>
          </div>
          <div className="three wide field">
              <input type="text"
                id="partie_nom"
                ref={this.partieNomInput}
                required="required"
                maxLength="255"
              />
            </div>
            <input type="hidden" id="partie__token" name="partie[_token]" value="5fa84MhAXvPtPgoWRDsiT8-QGo0B-sC0i1dizInLSqU" />
            <div className="five wide field">
              <button type="submit" className="ui basic button">
                <i className="icon save"></i>
                Enregistrer
              </button>
            </div>

          </div>
        </div>
      </div>
    </form>
</div>
    );
  }
}

PartieCreator.propTypes = {
    onNewItemSubmit: PropTypes.func.isRequired,
};
