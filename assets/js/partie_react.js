import React from 'react';
//render permet de transformer un template en page html réelle
import { render } from 'react-dom';
import CardBoardApp from './CardBoard/CardBoardApp';

render(
  <CardBoardApp
    {...window.ACTEUR_APP_PROPS}
    {...window.POUVOIR_APP_PROPS}
  />,
  document.getElementById('cardBoard-app')
);
