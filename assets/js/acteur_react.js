import React from 'react';
import { render } from 'react-dom';
import ActeurApp from './Acteur/ActeurApp';

const shouldShowProut = true;

render(
  <ActeurApp withProut={shouldShowProut}/>,
  document.getElementById('lift-stuff-app')
);
