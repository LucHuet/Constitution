import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {List} from 'semantic-ui-react';

export default class PouvoirMenuDisplay extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

  }

  levelCheck(pouvoir){

    const {tree, parent, level} = this.props

    if(pouvoir.pouvoirParent == parent)
    {
      switch (level) {
      case 1:
      return (
        <span>
          <List.Item key={pouvoir.id} as='li'>{pouvoir.nom}</List.Item>
          <PouvoirMenuDisplay tree = {tree} parent = {pouvoir.id} level = {level + 1} />
        </span>
        )
      case 2:
      return (
        <span>
          <List.Item key={pouvoir.id} as='li'> - {pouvoir.nom}</List.Item>
          <PouvoirMenuDisplay tree = {tree} parent = {pouvoir.id} level = {level + 1} />
        </span>
      )
      case 3:
      return (
        <span>
          <List.Item key={pouvoir.id} as='li'> - - {pouvoir.nom}</List.Item>
          <PouvoirMenuDisplay tree = {tree} parent = {pouvoir.id} level = {level + 1} />
        </span>
      )
      case 4:
      return (
        <span>
          <List.Item key={pouvoir.id} as='li'> - - - {pouvoir.nom}</List.Item>
          <PouvoirMenuDisplay tree = {tree} parent = {pouvoir.id} level = {level + 1} />
        </span>
      )
      }
    }

  }

  render() {

    const { tree, parent,  level} = this.props

    return (
      tree.map((pouvoir) => (
        <div key={pouvoir.id}>
        {this.levelCheck(pouvoir)}
        </div>
      ))
    )

  }

}

PouvoirMenuDisplay.propTypes = {
  tree: PropTypes.array,
  parent: PropTypes.number,
  level: PropTypes.number,
}

PouvoirMenuDisplay.defaultProps = {
  tree: [],
  parent:null,
  level:1,
};
