import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {List} from 'semantic-ui-react';

export default class PouvoirMenuDisplay extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.levelCheck = this.levelCheck.bind(this);
  }

  levelCheck(pouvoir){

    const {tree, parent, level, onClickPouvoir, pouvoirsSelection} = this.props

    let espaceAvant = ' * '.repeat(level);

    if(pouvoir.pouvoirParent == parent)
    {
      return (
        <span>
          <div
          onClick={()=> onClickPouvoir(pouvoir.id)}
          key={pouvoir.id}
          className={pouvoirsSelection.includes(pouvoir.id) ? 'ui info message' : ''}
          >
          {espaceAvant}  {pouvoir.nom}
          </div><br/>
          <PouvoirMenuDisplay pouvoirsSelection={pouvoirsSelection} onClickPouvoir={onClickPouvoir} tree = {tree} parent = {pouvoir.id} level = {level + 1} />
        </span>
      )
    }

  }

  render() {

    const { tree, parent,  level} = this.props

    return (

        <div>
        {tree.map((pouvoir) => (
          this.levelCheck(pouvoir)
        ))}
        </div>

    )

  }

}

PouvoirMenuDisplay.propTypes = {
  onClickPouvoir : PropTypes.func.isRequired,
  pouvoirsSelection: PropTypes.array.isRequired,
  tree: PropTypes.array,
  parent: PropTypes.number,
  level: PropTypes.number,
}

PouvoirMenuDisplay.defaultProps = {
  tree: [],
  parent:null,
  level:1,
};
