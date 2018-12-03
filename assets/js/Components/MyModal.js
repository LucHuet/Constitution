import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Modal, Form, Button, Icon } from 'semantic-ui-react';

export default class MyModal extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      something: '',
      showModal: false,
    }
  }

  handleChangeForms(e, { value }){
    this.setState({ something: value });
  }

  handleCreateButton(evt) {
    evt.preventDefault()
    this.closeModal();
  }

  closeModal(){
    this.setState({ showModal: false })
  }

  render() {
    const {
      something,
      showModal
    } = this.state

    return (
      <Modal closeIcon onClose={this.closeModal} open={showModal}>
        <Modal.Header>My Modal</Modal.Header>
        <Modal.Content>
          <Form>
            <Form.Input
              label='Something'
              value={something}
              onChange={this.handleChangeForms}
            />
            <Button onClick={(evt) => this.handleCreateButton(evt)}>Save</Button>
          </Form>
        </Modal.Content>
      </Modal>
    )
  }
}

MyModal.propTypes = {
  showModal2: PropTypes.bool.isRequired,
};
