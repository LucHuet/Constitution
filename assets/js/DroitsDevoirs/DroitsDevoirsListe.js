import React from 'react';
import PropTypes from 'prop-types';

export default function DroitsDevoirsListe(props) {

   const { droitsDevoirs } = props;

   return (
       <tbody>

       {droitsDevoirs.map((droitDevoir) => (
           <tr
             key={droitDevoir.id}
            >
             <td>{droitDevoir.nom}</td>
           </tr>
       ))}
       </tbody>
   )
  }

  DroitsDevoirsListe.propTypes = {
      droitsDevoirs: PropTypes.array.isRequired,
  };
