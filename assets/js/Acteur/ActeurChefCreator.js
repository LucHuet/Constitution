import React from 'react';
import PropTypes from 'prop-types';
import { Header, Image, Container, Divider, Segment, Flag, Icon, Button } from 'semantic-ui-react'

export default function ActeurChefCreator(props) {

  //on descructure les props pour en récuperer les variables
  const {
    onShowModal,
    acteursReferenceChef
  } = props;

  const handleBack = function(modalType){
    onShowModal( modalType );
  };

  const handleSave = function(){
    console.log("Ajout à FAIRE");
  };
  acteursReferenceChef.pouvoirsBase.map((pouvoirBase) => {
    console.log(pouvoirBase.nom);
  } );
  return(
  <div>
  <Header as='h2' icon textAlign='center'>
    <Image size='medium' circular src='/build/static/chef.png' />
    <Header.Content>Ajout Acteur : {acteursReferenceChef.type}</Header.Content>
  </Header>
  <br/>
  <Container textAlign='justified'>
    <Segment>
      <b>Description</b>
      <Divider />
      <p>
        {acteursReferenceChef.description}
      </p>
    </Segment>
    <Segment>
      <b>Dans le monde</b>
      <Divider />
      {Object.keys(acteursReferenceChef.countryDescriptions).map((countryDesc, index) => {
        return (
          <React.Fragment key={countryDesc}> <Flag name='france' /> {countryDesc}  &nbsp;  </React.Fragment>
        )
      } )}
    </Segment>
    <Segment>
      <b>Nombre de personnes : </b>
    </Segment>
    <Segment>
      <b>Pouvoirs</b>
      <Divider />
      De base :
      <p>
      {acteursReferenceChef.pouvoirsBase.map((pouvoirBase) => {
        return (
        <React.Fragment key={pouvoirBase.id}><Icon name='minus square outline' size='small' />{pouvoirBase.nom}<br/></React.Fragment>
        );
      } )}
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
    <Divider />

      <Button onClick={() => handleBack('acteur')}>Retour</Button>

      <Button onClick={() => handleSave()}>Sauvegarder</Button>
  </Container>
  </div>
  );
}

//on défini les types des props
ActeurChefCreator.propTypes = {
  onShowModal: PropTypes.func.isRequired,
  acteursReferenceChef : PropTypes.object.isRequired,
};
