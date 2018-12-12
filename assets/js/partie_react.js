import React from 'react';
//render permet de transformer un template en page html réelle
import { render } from 'react-dom';
import CardBoardApp from './CardBoard/CardBoardApp';

render(
  <CardBoardApp
    {...window.PARTIE_APP_PROPS}
  />,
  document.getElementById('cardBoard-app')
);
