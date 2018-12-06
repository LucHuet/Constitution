import React, {Component} from 'react';
import PropTypes from 'prop-types';
import Button from '../Components/Button';
import {Form} from 'semantic-ui-react';

export default class PouvoirCreator extends Component{

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.state = {
      nombreActeurError: ''
    };

    //ref permettent d'accéder à des élements du dom
    //permet de facilement récupérer les valeurs des variables
    this.nomPouvoir = React.createRef();
    this.typePouvoir = React.createRef();

    this.handleFormSubmit = this.handleFormSubmit.bind(this);
  }

  handleFormSubmit(event){
    event.preventDefault();

    //fait appel au props de l'objet
    const {onAddPouvoir, acteurSelect} = this.props;

    const nomPouvoir = this.nomPouvoir.current;
    const typePouvoir = this.typePouvoir.current;

    onAddPouvoir(
      nomPouvoir.value,
      typePouvoir.options[typePouvoir.selectedIndex].value,
      acteurSelect
    );

    //réinitialisation des données
    nomPouvoir.value = '';
    typePouvoir.selectedIndex = 0;
  }


  render(){

    const { validationErrorMessage, pouvoirOptions } = this.props;


    return (
      <div>
          <Form onSubmit={this.handleFormSubmit}>
            {validationErrorMessage && (
              <div className="alert alert-danger">
              {validationErrorMessage}
              </div>
            )}
                <Form.Field>
                  <label htmlFor="nom" className="required">Quel nom pour votre pouvoir ?</label>
                  <input type="text" id="nom" ref={this.nomPouvoir} required="required" maxLength="255" />
                </Form.Field>
                {' '}
                <Form.Field>
                  <label htmlFor="typePouvoir" className="required">Quel pouvoir ajouter ?</label>
                  <select id="typePouvoir" ref={this.typePouvoir}>
                    {pouvoirOptions.map(option => {
                      return <option value={option.id} key={option.id}>{option.text}</option>
                    } )}
                  </select>
                </Form.Field>
              {' '}
              <Button type="submit" className="btn-primary">
                Sauvegarder
              </Button>
          </Form>
      </div>
    );
  }
}

PouvoirCreator.propTypes = {
  onAddPouvoir: PropTypes.func.isRequired,
  validationErrorMessage: PropTypes.string.isRequired,
  pouvoirOptions: PropTypes.array.isRequired,
  acteurSelect: PropTypes.number.isRequired,
};
