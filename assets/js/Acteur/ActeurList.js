import React from 'react';
import PropTypes from 'prop-types';

export default function ActeurList(props) {

  const { highlightedRowId, onRowClick, acteurs } = props;

  return(
    <tbody>
    {acteurs.map((acteur) => (
          <tr
            key={acteur.id}
            className={highlightedRowId === acteur.id ? 'info' : ''}
            onClick={()=> onRowClick(acteur.id)}
          >
              <td>{acteur.nom}</td>
              <td>{acteur.nombreIndividus}</td>
              <td></td>
              <td>...</td>
              <td>...</td>
          </tr>
      )
    )}
    </tbody>

  );
}

ActeurList.propTypes = {
  highlightedRowId: PropTypes.any,
  onRowClick: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired
};
