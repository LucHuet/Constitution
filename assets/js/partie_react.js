import React from 'react';
//render permet de transformer un template en page html réelle
import { render } from 'react-dom';
import CardBoard from './CardBoard/CardBoardApp';

render(
  <CardBoard
    {...window.ACTEUR_APP_PROPS}
  />,
  document.getElementById('acteur-app')
);
