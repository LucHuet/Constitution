import React from 'react';
import PropTypes from 'prop-types';

export default function PartieListe(props) {

 const { highlightedRowId, onRowClick, parties, onDeletePartie, isLoaded, isSavingNewPartie } = props;

 if (!isLoaded) {
        return (
            <tbody>
                <tr>
                    <td colSpan="4" className="text-center">Loading...</td>
                </tr>
            </tbody>
        );
    }

 const handleDeleteClick = function(event, partieId){
   event.preventDefault();

   onDeletePartie(partieId);
 }

 return (
     <tbody>

     {parties.map((partie) => (
         <tr
             key={partie.id}
             className={highlightedRowId === partie.id ? 'info' : ''}
             onClick={() => onRowClick(partie.id)}
         >
             <td>{partie.nom}</td>
             <td>
               <a href="#" onClick={(event) => handleDeleteClick(event, partie.id)}>
                <i className="trash icon"></i>
               </a>
             </td>
         </tr>
     ))}
     {isSavingNewPartie && (
       <tr>
          <td
              colSpan="4"
              className="text-center"
              style={{
                  opacity: .5
              }}
            >
            Enregistrement de la partie...
            </td>
        </tr>
     )}
     </tbody>
 )
}

PartieListe.propTypes = {
    highlightedRowId: PropTypes.any,
    onRowClick: PropTypes.func.isRequired,
    parties: PropTypes.array.isRequired,
    onDeletePartie: PropTypes.func.isRequired,
    isLoaded: PropTypes.bool.isRequired,
    isSavingNewPartie: PropTypes.bool.isRequired,
};
