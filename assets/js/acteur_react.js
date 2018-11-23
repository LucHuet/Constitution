import React from 'react';
//render permet de transformer un template en page html réelle
import { render } from 'react-dom';
import ActeurApp from './Acteur/ActeurApp';
import Board from './Board/Board';
import { observe } from './Board/Game';

const shouldShowProut = true;

const root = document.getElementById('board-app');

observe(elementPosition =>
  render(
    <Board elementPosition={elementPosition} />,
    root
  )
);

//render(
//  <ActeurApp
//    withProut = {shouldShowProut}
//    {...window.ACTEUR_APP_PROPS}
//  />,
//  document.getElementById('acteur-app')
//);
