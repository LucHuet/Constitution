import React from 'react';
import PropTypes from 'prop-types';

export default function DroitsDevoirsListe(props) {

   const {
      droitsDevoirs,
      addedRowId,
      onRowClick,
    } = props;

   return (
       <tbody>

       {droitsDevoirs.map((droitDevoir) => (
           <tr
             key={droitDevoir.id}
             className={addedRowId === droitDevoir.id ? 'ui positive message' : ''}
             onClick={()=> onRowClick(droitDevoir.id)}
            >
             <td>{droitDevoir.nom}</td>
           </tr>
       ))}
       </tbody>
   )
  }

  DroitsDevoirsListe.propTypes = {
      droitsDevoirs: PropTypes.array.isRequired,
      onRowClick: PropTypes.func.isRequired,
      addedRowId: PropTypes.any,
  };
