import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {Form, Button} from 'semantic-ui-react';

export default class DesignationCreator extends Component{

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.state = {
      nombreActeurError: ''
    };

    //ref permettent d'accéder à des élements du dom
    //permet de facilement récupérer les valeurs des variables
    this.nomDesignation = React.createRef();
    this.typeDesignation = React.createRef();
    this.acteurDesignant = React.createRef();

    this.handleFormSubmit = this.handleFormSubmit.bind(this);
  }

  handleFormSubmit(){

    //fait appel au props de l'objet
    const {onAddDesignation, acteurSelect} = this.props;

    const nomDesignation = this.nomDesignation.current;
    const typeDesignation = this.typeDesignation.current;
    const acteurDesignant = this.acteurDesignant.current;

    onAddDesignation(
      nomDesignation.value,
      typeDesignation.options[typeDesignation.selectedIndex].value,
      acteurDesignant.options[acteurDesignant.selectedIndex].value,
      acteurSelect
    );

    //réinitialisation des données
    nomDesignation.value = '';
    typeDesignation.selectedIndex = 0;
    acteurDesignant.selectedIndex = 0;
  }


  render(){

    const { validationErrorMessage, designationOptions,  acteursPartiesOptions} = this.props;


    return (
      <div>
      <Form onSubmit={() => this.handleFormSubmit()}>
          <Form.Field>
            <label htmlFor="nom" className="required">Nom</label>
            <input type="text" id="nom" ref={this.nomDesignation} required="required" maxLength="255" />
          </Form.Field>
          <Form.Field>
            <label htmlFor="designation" className="required">Designation</label>
            <select id="designation" ref={this.typeDesignation} required="required">
              {designationOptions.map(designation => {
                return <option value={designation.id} key={designation.id}>{designation.text}</option>
              } )}
            </select>
          </Form.Field>
          <Form.Field>
            <label htmlFor="acteurDesignant" className="required">Qui désigne votre acteur ?</label>
            <select id="acteurDesignant" ref={this.acteurDesignant} required="required">
              {acteursPartiesOptions.map(acteurDesignant => {
                return <option value={acteurDesignant.id} key={acteurDesignant.id}>{acteurDesignant.text}</option>
              } )}
            </select>
          </Form.Field>
          <Button type="submit" className="btn-primary">
            Sauvegarder
          </Button>
      </Form>
      </div>
    );
  }
}

DesignationCreator.propTypes = {
  onAddDesignation: PropTypes.func.isRequired,
  validationErrorMessage: PropTypes.string.isRequired,
  designationOptions: PropTypes.array.isRequired,
  acteursPartiesOptions: PropTypes.array.isRequired,
  acteurSelect: PropTypes.number.isRequired,
};
