import React from 'react';
import PropTypes from 'prop-types';

export default function ActeurList(props) {

  const {
    highlightedRowId,
    onRowClick,
    acteurs,
    onDeleteActeur
  } = props;

  const handleDeleteClick = function(event, acteurId){
    event.preventDefault();

    onDeleteActeur(acteurId);
  };

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
              <td></td>
              <td>
                <a href="#" onClick={(event => handleDeleteClick(event, acteur.id))}>
                    <span className="fa fa-trash"></span>
                </a>
              </td>
          </tr>
      )
    )}
    </tbody>

  );
}

ActeurList.propTypes = {
  highlightedRowId: PropTypes.any,
  onRowClick: PropTypes.func.isRequired,
  onDeleteActeur: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired
};
