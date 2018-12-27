import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {List, Icon} from 'semantic-ui-react';

export default class PouvoirMenuDisplay extends Component {

  constructor(props){
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.levelCheck = this.levelCheck.bind(this);
  }

  levelCheck(pouvoir){

    const {tree, parent, level, onClickPouvoir, pouvoirsSelection} = this.props

    //let espaceAvant = ' * '.repeat(level);
    var maClassDiv = '';

    if(level == 1){
      maClassDiv = "levelOne";
    }
    else if (level == 2){
      maClassDiv = "levelTwo";
    }
    else if (level == 3){
      maClassDiv = "levelTree";
    }

    if(pouvoir.pouvoirParent == parent)
    {
      return (
        <React.Fragment>
          <div
          onClick={()=> onClickPouvoir(pouvoir.id)}
          key={pouvoir.id}
          className={maClassDiv}
          >
            <Icon name={pouvoirsSelection.includes(pouvoir.id) ? 'minus square outline' : 'plus square outline'}/>
            {pouvoir.nom}
          </div>
          <PouvoirMenuDisplay pouvoirsSelection={pouvoirsSelection} onClickPouvoir={onClickPouvoir} tree = {tree} parent = {pouvoir.id} level = {level + 1} />
        </React.Fragment>
      )
    }

  }

  render() {

    const { tree, parent,  level} = this.props

    return (

        <div>
        {tree.map((pouvoir) => (
          <React.Fragment key={pouvoir.id}>
          {this.levelCheck(pouvoir)}
          </React.Fragment>
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
