import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {Form, Table, Button} from 'semantic-ui-react';
import { getPouvoirsReference } from '../api/partie_api.js';
import PouvoirMenuDisplay from './PouvoirMenuDisplay'


export default class PouvoirCreator extends Component{

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.state = {
      listePouvoirs: [],
    };

    //ref permettent d'accéder à des élements du dom
    //permet de facilement récupérer les valeurs des variables
    this.nomPouvoir = React.createRef();
    this.typePouvoir = React.createRef();

    this.handleGetPouvoir = this.handleGetPouvoir.bind(this);
    this.handleBack = this.handleBack.bind(this);

  }

  componentDidMount(){
    this.handleGetPouvoir();
  }

  handleBack(modalType, acteurSelect=0){
    const {onShowModal, onCloseModal} = this.props;

    if(modalType == '')
    {
      onCloseModal();
      return;
    }
    onShowModal( modalType , acteurSelect);
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

    const { validationErrorMessage, pouvoirOptions, onClickPouvoir, pouvoirsSelection, previousModal, acteurSelect} = this.props;

    return (
      <div className="pouvoir">
          <PouvoirMenuDisplay
            onClickPouvoir={onClickPouvoir}
            pouvoirsSelection={pouvoirsSelection}
            tree={this.state.listePouvoirs}
          />
          {acteurSelect == 0 ?
          <Button onClick={() => this.handleBack(previousModal)}>Retour à la création d un acteur</Button>
          :
          <Button onClick={() => this.handleBack('acteurDisplay', acteurSelect)}>Retour à la modification d un acteur</Button>
          }
      </div>
    );
  }
}

PouvoirCreator.propTypes = {
  onClickPouvoir : PropTypes.func.isRequired,
  onShowModal : PropTypes.func.isRequired,
  onCloseModal : PropTypes.func.isRequired,
  validationErrorMessage: PropTypes.string.isRequired,
  pouvoirOptions: PropTypes.array.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
  acteurSelect: PropTypes.number.isRequired,
  previousModal: PropTypes.string.isRequired,
};
