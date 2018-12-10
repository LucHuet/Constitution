import React from 'react';
import PropTypes from 'prop-types';
import { Header, Image, Container, Divider, Segment, Flag, Icon } from 'semantic-ui-react'

export default function ActeurChefCreator(props) {

  //on descructure les props pour en récuperer les variables
  const {
    onShowModal,
  } = props;

  const handleAjout = function(event, modalType, acteurId){
    event.preventDefault();
    onShowModal( modalType, acteurId);
  };

  return(
  <div>
  <Header as='h2' icon textAlign='center'>
    <Image size='medium' circular src='/build/static/chef.png' />
    <Header.Content>Ajout Acteur : Chef</Header.Content>
  </Header>
  <br/>
  <Container textAlign='justified'>
    <Segment>
      <b>Description</b>
      <Divider />
      <p>
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
        Aenean massa strong. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur
        ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla
        consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget,
        arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu
        pede link mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.
        Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend
        ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra
        nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel
        augue. Curabitur ullamcorper ultricies nisi.
      </p>
    </Segment>
    <Segment>
      <b>Dans le monde</b>
      <Divider />
        <Flag name='france' /> France  &nbsp;
        <Flag name='us' />Etats Unis  &nbsp;
        <Flag name='gb' />Grande Bretagne  &nbsp;
        <Flag name='de' />Allemagne  &nbsp;
    </Segment>
    <Segment>
      <b>Nombre de personnes : </b>
    </Segment>
    <Segment>
      <b>Pouvoirs</b>
      <Divider />
      De base :
      <p>
      <Icon name='plus square outline' size='small' /> Pouvoir 1 <br/>
      <Icon name='plus square outline' size='small' /> Pouvoir 1 <br/>
      <Icon name='plus square outline' size='small' /> Pouvoir 1 <br/>
      <Icon name='plus square outline' size='small' /> Pouvoir 1 <br/>
      <Icon name='plus square outline' size='small' /> Pouvoir 1 <br/>
      </p>
      Suggerés :
      <p>
      <Icon name='minus square outline' size='small' /> Pouvoir 2 <br/>
      <Icon name='minus square outline' size='small' /> Pouvoir 2 <br/>
      <Icon name='minus square outline' size='small' /> Pouvoir 2 <br/>
      <Icon name='minus square outline' size='small' /> Pouvoir 2 <br/>
      </p>
      Supplémentaires :
      <p>
      <Icon name='minus square outline' size='small' /> Pouvoir 3 <br/>
      <Icon name='minus square outline' size='small' /> Pouvoir 3 <br/>
      </p>
    </Segment>
    <Segment>
      <b>Désignation : </b>
      <Divider />
      QUI - QUOI
    </Segment>
  </Container>
  </div>
  );
}

//on défini les types des props
ActeurChefCreator.propTypes = {
  onShowModal: PropTypes.func.isRequired,
};
