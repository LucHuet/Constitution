import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {Card, Form, Image} from 'semantic-ui-react';

export default class ActeurCreatorSelection extends Component{

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

  }

  handleSelection(modalType){
    const {onShowModal} = this.props;
    onShowModal( modalType);
  }


  render(){

    const { validationErrorMessage, acteursReference } = this.props;

    return (
      <Card.Group>
      {acteursReference.map(acteurRef => {
        if(acteurRef.type != 'Peuple')
        {
        return (
          <Card key={acteurRef.id} onClick={() => this.handleSelection(acteurRef.type)}>

            <Card.Content>
              <Image floated='right' size='mini' src={'/build/static/'+acteurRef.image} />
              <Card.Header>{acteurRef.type}</Card.Header>
              <Card.Description>
                {acteurRef.description}
              </Card.Description>
            </Card.Content>

          </Card>
        )
        }
      } )}
      </Card.Group>
    );
  }
}

ActeurCreatorSelection.propTypes = {
  onAddActeur: PropTypes.func.isRequired,
  validationErrorMessage: PropTypes.string.isRequired,
  acteursReference: PropTypes.array.isRequired,
  onShowModal: PropTypes.func.isRequired,
};
