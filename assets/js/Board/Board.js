import React, {Component} from 'react';
import { DragDropContextProvider } from 'react-dnd';
import HTML5Backend from 'react-dnd-html5-backend';
import Square from './Square';
import BoardSquare from './BoardSquare';
import Element from './Element';
import {canMoveElement, moveElement } from './Game';

export default class Board extends Component{

  constructor(props) {
    //super(props) permet d'appeler le constructeur parent
    super(props);

    this.renderSquare = this.renderSquare.bind(this);
    this.renderPiece = this.renderPiece.bind(this);
    this.handleSquareClick = this.handleSquareClick.bind(this);

  }

  renderSquare(i, elementPosition) {
    const x = i % 8;
    const y = Math.floor(i / 8);
    return (
      <div key={i}
           style={{ width: '12.5%', height: '12.5%' }}>
        <BoardSquare x={x}
                     y={y}>
          {this.renderPiece(x, y, elementPosition)}
        </BoardSquare>
      </div>
    );
  }

  renderPiece(x, y, [elementX, elementY]) {
      if (x === elementX && y === elementY) {
      return <Element />;
    }
  }

  handleSquareClick(toX, toY) {
    if (canMoveElement(toX, toY)) {
      moveElement(toX, toY);
    }
  }

  render(){
    const {elementPosition} = this.props;
    const squares = [];
      for (let i = 0; i < 64; i++) {
        squares.push(this.renderSquare(i, elementPosition));
      }
    return (
      <DragDropContextProvider backend={HTML5Backend}>
      <div style={{
        width: '100%',
        height: '100%',
        display: 'flex',
        flexWrap: 'wrap'
      }}>
        {squares}
      </div>
      </DragDropContextProvider>
    )
  }


}
