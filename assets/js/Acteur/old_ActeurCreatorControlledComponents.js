import React, {Component} from 'react';
import PropTypes from 'prop-types';

export default class ActeurCreator extends Component{

  constructor(props){
    super(props);

    this.state = {
      typeActeur:'groupe',
      nombreActeur: 0,
      nomActeur: '',
      nombreActeurError: '',
    };

    this.typeActeurOptions = [
      { id: 'groupe', text: 'Groupe d\'individus' },
      { id: 'autorite', text: 'Autorité Indépendante' },
    ];

    this.handleFormSubmit = this.handleFormSubmit.bind(this);

    this.handleSelectedItemChange = this.handleSelectedItemChange.bind(this);
    this.handleNombreInputChange = this.handleNombreInputChange.bind(this);
    this.handleNomInputChange = this.handleNomInputChange.bind(this);
  }

  handleFormSubmit(event){
    event.preventDefault();
    const {onAddActeur} = this.props;
    const {nomActeur, nombreActeur, typeActeur} = this.state;

    const typeActeurLabel = this.typeActeurOptions.find((option) => {
      return option.id === typeActeur;
    }).text;

    if (nombreActeur <= 0) {
      this.setState({
        nombreActeurError: 'Vous ne pouvez pas entrer un nombre d\'acteur négatif!'
      });
      return;
    }

    onAddActeur(
      nomActeur,
      nombreActeur,
      typeActeurLabel
    );


    this.setState({
      nomActeur: '',
      nombreActeur: '',
      typeActeur: 0,
      nombreActeurError: ''
    });

  }

  handleSelectedItemChange(event){
    this.setState({
      typeActeur: event.target.value
    })
  }

  handleNombreInputChange(event){
    this.setState({
      nombreActeur: event.target.value
    })
  }

  handleNomInputChange(event){
    this.setState({
      nomActeur: event.target.value
    })
  }

  render(){
    const { nombreActeurError,  nombreActeur, typeActeur, nomActeur} = this.state;
    return (
      <div>
          <form method="post" data-url="/acteur/new/JS" onSubmit={this.handleFormSubmit}>
              <div className="form-group">
                <div>
                  <label htmlFor="nom" className="required">Nom</label>
                  <input
                    type="text"
                    id="nom"
                    value={nomActeur}
                    onChange={this.handleNomInputChange}
                    required="required"
                    maxLength="255"
                  /></div>
                </div>
                {' '}
                <div className={`form-group ${nombreActeurError ? 'has-error' : '' }`}>
                <div>
                <label htmlFor="nombreIndividus">Nombre individus</label>
                  <input
                    type="number"
                    id="nombreIndividus"
                    value = {nombreActeur}
                    onChange={this.handleNombreInputChange}
                  />
                  { nombreActeurError  && <span className="help-block">{nombreActeurError}</span>}
                </div>
                </div>
                {' '}
                <div className="form-group">
                <div>
                  <label htmlFor="typeActeur" className="required">Type acteur</label>
                  <select
                    id="typeActeur"
                    value={typeActeur}
                    onChange={this.handleSelectedItemChange}
                  >
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
