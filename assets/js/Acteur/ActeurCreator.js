import React, {Component} from 'react';
import PropTypes from 'prop-types';

export default class ActeurCreator extends Component{

  constructor(props){
    super(props);

    this.state = {
      nombreActeurError: ''
    };

    this.nomActeur = React.createRef();
    this.nombreActeur = React.createRef();
    this.typeActeur = React.createRef();

    this.typeActeurOptions = [
      { id: 'groupe', text: 'Groupe d\'individus' },
      { id: 'autorite', text: 'Autorité Indépendante' },

    ];
    this.handleFormSubmit = this.handleFormSubmit.bind(this);
  }

  handleFormSubmit(event){
    event.preventDefault();
    const {onAddActeur} = this.props;

    const nomActeur = this.nomActeur.current;
    const nombreActeur = this.nombreActeur.current;
    const typeActeur = this.typeActeur.current;

    if (nombreActeur.value <= 0) {
      this.setState({
        nombreActeurError: 'Vous ne pouvez pas entrer un nombre d\'acteur négatif!'
      });
      return;
    }

    onAddActeur(
      nomActeur.value,
      nombreActeur.value,
      typeActeur.options[typeActeur.selectedIndex].text
    );

    nomActeur.value = '';
    nombreActeur.value = '';
    typeActeur.selectedIndex = 0;
    this.setState({
      nombreActeurError: ''
    });

  }

  render(){
    const { nombreActeurError } = this.state;
    return (
      <div>
          <form method="post" data-url="/acteur/new/JS" onSubmit={this.handleFormSubmit}>
              <div className="form-group">
                <div>
                  <label htmlFor="nom" className="required">Nom</label>
                  <input type="text" id="nom" ref={this.nomActeur} required="required" maxLength="255" /></div>
                </div>
                {' '}
                <div className={`form-group ${nombreActeurError ? 'has-error' : '' }`}>
                <div>
                <label htmlFor="nombreIndividus">Nombre individus</label>
                  <input
                    type="number"
                    id="nombreIndividus"
                    ref={this.nombreActeur}
                  />
                  { nombreActeurError  && <span className="help-block">{nombreActeurError}</span>}
                </div>
                </div>
                {' '}
                <div className="form-group">
                <div>
                  <label htmlFor="typeActeur" className="required">Type acteur</label>
                  <select id="typeActeur" ref={this.typeActeur}>
                    {this.typeActeurOptions.map(option => {
                      return <option value={option.id} key={option.id}>{option.text}</option>
                    } )}
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
  onAddActeur: PropTypes.func.isRequired
};
