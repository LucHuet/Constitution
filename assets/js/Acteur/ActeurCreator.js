import React, {Component} from 'react';
import PropTypes from 'prop-types';

export default class ActeurCreator extends Component{

  constructor(props){
    super(props);

    this.nomActeur = React.createRef();
    this.nombreActeur = React.createRef();
    this.typeActeur = React.createRef();

    this.handleFormSubmit = this.handleFormSubmit.bind(this);
  }

  handleFormSubmit(event){
    event.preventDefault();
    const {onNewItemSubmit} = this.props;

    const nomActeur = this.nomActeur.current;
    const nombreActeur = this.nombreActeur.current;
    const typeActeur = this.typeActeur.current;

    onNewItemSubmit(
      nomActeur.value,
      nombreActeur.value,
      typeActeur.options[typeActeur.selectedIndex].text
    );

    nomActeur.value = '';
    nombreActeur.value = '';
    typeActeur.selectedIndex = 0;

  }

  render(){
    return (
      <div>
          <form method="post" className="form-inline" data-url="/acteur/new/JS" onSubmit={this.handleFormSubmit}>
              <div className="form-group">
                <div>
                  <label htmlFor="nom" className="required">Nom</label>
                  <input type="text" id="nom" ref={this.nomActeur} required="required" maxLength="255" /></div>
                </div>
                {' '}
                <div className="form-group">
                <div>
                  <label htmlFor="nombreIndividus">Nombre individus</label>
                  <input
                    type="number"
                    id="nombreIndividus"
                    ref={this.nombreActeur}
                  /></div>
                </div>
                {' '}
                <div className="form-group">
                <div>
                  <label htmlFor="typeActeur" className="required">Type acteur</label>
                  <select id="typeActeur" ref={this.typeActeur}>
                    <option value="4">Groupe d&#039;individus</option>
                    <option value="6">Autorité Indépendante</option>
                  </select>
                </div>
              </div>
              {' '}
              <button className="btn">Save</button>
          </form>
      </div>
    );
  }
}

ActeurCreator.propTypes = {
  onNewItemSubmit: PropTypes.func.isRequired
};
