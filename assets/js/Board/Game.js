import React from 'react';

let elementPosition = [0, 0];
let observer = null;

function emitChange() {
  observer(elementPosition);
}

export function observe(o) {
  if (observer) {
    throw new Error('Multiple observers not implemented.');
  }

  observer = o;
  emitChange();
}

export function moveElement(toX, toY) {
  elementPosition = [toX, toY];
  emitChange();
}

export function canMoveElement(toX, toY) {
  const [x, y] = elementPosition;
  const dx = toX - x;
  const dy = toY - y;

  return (Math.abs(dx) === 2 && Math.abs(dy) === 1) ||
         (Math.abs(dx) === 1 && Math.abs(dy) === 2);
}
