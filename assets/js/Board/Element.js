import React from 'react';
import { ItemTypes } from './Constants';
import { DragSource } from 'react-dnd';

const elementSource = {
  beginDrag(props) {
    return {};
  }
};

function collect(connect, monitor) {
  return {
    connectDragSource: connect.dragSource(),
    isDragging: monitor.isDragging()
  }
}

function Element({ connectDragSource, isDragging }) {

  return connectDragSource(
    <div style={{
      opacity: isDragging ? 0.5 : 1,
      fontSize: 70,
      fontWeight: 'bold',
      cursor: 'move',
      textAlign: 'center',
    }}>
      👩‍💼
    </div>
  );
}

export default DragSource(ItemTypes.ELEMENT, elementSource, collect)(Element);
