import React from 'react';
import { render } from 'react-dom';
import ActeurApp from './Acteur/ActeurApp';

const shouldShowProut = true;
const test = {itemOptions: [
  { id: '1', text: 'Groupe'},
  { id: '1', text: 'Groupe'},
]}

render(
  <ActeurApp
    withProut = {shouldShowProut}
    {...window.ACTEUR_APP_PROPS}
  />,
  document.getElementById('lift-stuff-app')
);
