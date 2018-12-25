import React from 'react';
//render permet de transformer un template en page html réelle
import { render } from 'react-dom';
import CardBoardApp from './CardBoard/CardBoardApp';
import DroitsDevoirsApp from './DroitsDevoirs/DroitsDevoirsApp';

render(

  <CardBoardApp
    {...window.PARTIE_APP_PROPS}
  />,
  document.getElementById('cardBoard-app'),
);

render(
  <DroitsDevoirsApp
    {...window.PARTIE_APP_PROPS}
  />,
  document.getElementById('droitsDevoirs-app')
);
