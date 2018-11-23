import React from 'react';
import Square from './Square';
import { canMoveElement, moveElement } from './Game';
import { ItemTypes } from './Constants';
import { DropTarget } from 'react-dnd';

const squareTarget = {
  drop(props) {
    moveElement(props.x, props.y);
  }
};

function collect(connect, monitor) {
  return {
    connectDropTarget: connect.dropTarget(),
    isOver: monitor.isOver()
  };
}

function BoardSquare({ x, y, connectDropTarget, isOver, children }) {
  const black = (x + y) % 2 === 1;

  return connectDropTarget(
    <div style={{
      position: 'relative',
      width: '100%',
      height: '100%'
    }}>
      <Square black={black}>
        {children}
      </Square>
      {isOver &&
        <div style={{
          position: 'absolute',
          top: 0,
          left: 0,
          height: '100%',
          width: '100%',
          zIndex: 1,
          opacity: 0.5,
          backgroundColor: 'yellow',
        }} />
      }
    </div>
  );
}

export default DropTarget(ItemTypes.ELEMENT, squareTarget, collect)(BoardSquare);
