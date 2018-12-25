import React, {Component} from 'react';
import PropTypes from 'prop-types';
import Button from '../Components/Button';
import {Form, Table} from 'semantic-ui-react';
import { getPouvoirsReference } from '../api/partie_api.js';
import PouvoirMenuDisplay from './PouvoirMenuDisplay'


export default class PouvoirCreator extends Component{

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.state = {
      nombreActeurError: '',
      listePouvoirs: [],
    };

    //ref permettent d'accéder à des élements du dom
    //permet de facilement récupérer les valeurs des variables
    this.nomPouvoir = React.createRef();
    this.typePouvoir = React.createRef();

    this.handleFormSubmit = this.handleFormSubmit.bind(this);
    this.handleGetPouvoir = this.handleGetPouvoir.bind(this);
    this.handleBack = this.handleBack.bind(this);

  }

  componentDidMount(){
    this.handleGetPouvoir();
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

  handleBack(modalType){
    const {onShowModal, onCloseModal} = this.props;

    if(modalType == '')
    {
      onCloseModal();
      return;
    }
    onShowModal( modalType );
  }

  handleGetPouvoir(){

    if(!(this.state.listePouvoirs.length > 0))
    {
    getPouvoirsReference()
    //then signifie qu'il n'y a pas d'erreur.
      .then((data)=>{
        //méthode qui permet de redonner une valeur à un state.
        this.setState({
          listePouvoirs: data,
        });
      });
    }

  }

  render(){

    const { validationErrorMessage, pouvoirOptions, onClickPouvoir, pouvoirsSelection, previousModal} = this.props;

    return (
      <div className="pouvoir">
          <PouvoirMenuDisplay
            onClickPouvoir={onClickPouvoir}
            pouvoirsSelection={pouvoirsSelection}
            tree={this.state.listePouvoirs}
          />
          <Button onClick={() => this.handleBack(previousModal)}>Ok</Button>
      </div>
    );
  }
}

PouvoirCreator.propTypes = {
  onAddPouvoir: PropTypes.func.isRequired,
  onClickPouvoir : PropTypes.func.isRequired,
  onShowModal : PropTypes.func.isRequired,
  onCloseModal : PropTypes.func.isRequired,
  validationErrorMessage: PropTypes.string.isRequired,
  pouvoirOptions: PropTypes.array.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
  acteurSelect: PropTypes.number.isRequired,
  previousModal: PropTypes.string.isRequired,
};
