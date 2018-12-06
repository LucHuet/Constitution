import React from 'react';
import PropTypes from 'prop-types';

export default function PartieListe(props) {

  const { highlightedRowId, onRowClick, parties } = props;

 return (
     <tbody>

     {parties.map((partie) => (
         <tr
             key={partie.id}
             className={highlightedRowId === partie.id ? 'info' : ''}
             onClick={() => onRowClick(partie.id)}
         >
             <td>{partie.nom}</td>
             <td>...</td>
         </tr>
     ))}
     </tbody>
 )
}

PartieListe.propTypes = {
    highlightedRowId: PropTypes.any,
    onRowClick: PropTypes.func.isRequired,
    parties: PropTypes.array.isRequired
};
