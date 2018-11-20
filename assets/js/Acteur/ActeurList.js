import React from 'react';
import PropTypes from 'prop-types';

export default function ActeurList(props) {

  //on descructure les props pour en récuperer les variables
  const {
    highlightedRowId,
    onRowClick,
    acteurs,
    onDeleteActeur,
    isLoaded,
    isSavingNewActeur,
  } = props;

  const handleDeleteClick = function(event, acteurId){
    event.preventDefault();

    onDeleteActeur(acteurId);
  };

  if(!isLoaded){
    return(
      <tbody>
          <tr>
              <td colSpan="4" className="text-center">Loading...</td>
          </tr>
      </tbody>
    )
  }

  return(
    <tbody>
    {acteurs.map((acteur) => (
          <tr
            key={acteur.id}
            className={highlightedRowId === acteur.id ? 'info' : ''}
            onClick={()=> onRowClick(acteur.id)}
            style={{
                opacity: acteur.isDeleting ? .3 : 1
            }}
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
    {isSavingNewActeur && (
      <tr>
          <td
              colSpan="4"
              className="text-center"
              style={{
                  opacity: .5
              }}

          >En ajout ...</td>
      </tr>
    )}
    </tbody>

  );
}

//on défini les types des props
ActeurList.propTypes = {
  highlightedRowId: PropTypes.any,
  onRowClick: PropTypes.func.isRequired,
  onDeleteActeur: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired,
  isLoaded: PropTypes.bool.isRequired,
  isSavingNewActeur: PropTypes.bool.isRequired,
};
