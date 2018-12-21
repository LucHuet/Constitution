import React from 'react';
import PropTypes from 'prop-types';

export default function DroitsDevoirsReferenceListe(props) {

   const {
      droitsDevoirsReference,
      addedRowId,
      onRowClick,
    } = props;

   return (
       <tbody>

       {droitsDevoirsReference.map((droitDevoirReference) => (
           <tr
             key={droitDevoirReference.id}
             onClick={()=> onRowClick(droitDevoirReference.id)}
            >
             <td><i className={addedRowId === droitDevoirReference.id ? 'ui icon minus' : 'ui icon plus'}></i>{droitDevoirReference.nom}</td>
           </tr>
       ))}
       </tbody>
   )
  }

  DroitsDevoirsReferenceListe.propTypes = {
      droitsDevoirsReference: PropTypes.array.isRequired,
      onRowClick: PropTypes.func.isRequired,
      addedRowId: PropTypes.any,
  };
