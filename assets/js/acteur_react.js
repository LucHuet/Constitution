import React from 'react';
//render permet de transformer un template en page html réelle
import { render } from 'react-dom';
import ActeurApp from './Acteur/ActeurApp';

const shouldShowProut = true;

render(
  <ActeurApp
    withProut = {shouldShowProut}
    {...window.ACTEUR_APP_PROPS}
  />,
  document.getElementById('acteur-app')
);
