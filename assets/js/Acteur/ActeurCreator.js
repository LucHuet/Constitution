import React, {Component} from 'react';
import PropTypes from 'prop-types';
import Button from '../Components/Button';

export default class ActeurCreator extends Component{

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.state = {
      nombreActeurError: ''
    };

    //ref permettent d'accéder à des élements du dom
    //permet de facilement récupérer les valeurs des variables
    this.nomActeur = React.createRef();
    this.nombreActeur = React.createRef();
    this.typeActeur = React.createRef();

    this.handleFormSubmit = this.handleFormSubmit.bind(this);
  }

  handleFormSubmit(event){
    event.preventDefault();

    //fait appel au props de l'objet
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
      typeActeur.options[typeActeur.selectedIndex].value
    );

    //réinitialisation des données
    nomActeur.value = '';
    nombreActeur.value = '';
    typeActeur.selectedIndex = 0;
    this.setState({
      nombreActeurError: ''
    });

  }

  render(){
    const { nombreActeurError } = this.state;
    const { validationErrorMessage, itemOptions } = this.props;
    return (
      <div>
          <form onSubmit={this.handleFormSubmit}>
            {validationErrorMessage && (
              <div className="alert alert-danger">
              {validationErrorMessage}
              </div>
            )}
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
                    {itemOptions.map(option => {
                      return <option value={option.id} key={option.id}>{option.text}</option>
                    } )}
                  </select>
                </div>
              </div>
              {' '}
              <Button type="submit" className="btn-primary">
                Sauvegarder
              </Button>
          </form>
      </div>
    );
  }
}

ActeurCreator.propTypes = {
  onAddActeur: PropTypes.func.isRequired,
  validationErrorMessage: PropTypes.string.isRequired,
  itemOptions: PropTypes.array.isRequired,
};
