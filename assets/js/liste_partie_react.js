import React from 'react';
//render permet de transformer un template en page html réelle
import { render } from 'react-dom';
import PartieApp from './Partie/PartieApp';

render(
  <PartieApp
    {...window.PARTIE_APP_PROPS}
  />,
  document.getElementById('partie-app')
);
