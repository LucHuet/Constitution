import React from 'react';

export default function Square({black, children}) {
  const fill = black ? 'black' : 'white';

  return (
    <div style={{
        backgroundColor: fill,
        width: '100%',
        height: '100px'
      }}>
      {children}
    </div>
  );
}
