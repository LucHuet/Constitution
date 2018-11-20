import React from 'react';
import { render } from 'react-dom';
import ActeurApp from './Acteur/ActeurApp';

const shouldShowProut = false;

render(
  <ActeurApp
    withProut={shouldShowProut}
    {...window.ACTEUR_APP_PROPS}
  />,
  document.getElementById('lift-stuff-app')
);
