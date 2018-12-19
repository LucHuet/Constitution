import React from 'react';
import PropTypes from 'prop-types';

export default function DroitsDevoirsReferenceListe(props) {

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
             onClick={()=> onRowClick(droitDevoir.id)}
            >
             <td><i className={addedRowId === droitDevoir.id ? 'ui icon minus' : 'ui icon plus'}></i>{droitDevoir.nom}</td>
           </tr>
       ))}
       </tbody>
   )
  }

  DroitsDevoirsReferenceListe.propTypes = {
      droitsDevoirs: PropTypes.array.isRequired,
      onRowClick: PropTypes.func.isRequired,
      addedRowId: PropTypes.any,
  };
