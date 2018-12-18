import React from 'react';
import PropTypes from 'prop-types';
import PartieCreator from './DroitsDevoirsCreator';

export default function DroitsDevoirsListe(props) {

   const { droitsDevoirs } = props;

   return (
       <tbody>

       {droitsDevoirs.map((droitDevoir) => (
           <tr
             key={droitDevoir.id}
            >
             <td><a href={"/partieDisplay/" + droitDevoir.id}>{droitDevoir.nom}</a></td>
           </tr>
       ))}
       </tbody>
   )
  }

  DroitsDevoirsListe.propTypes = {
      droitsDevoirs: PropTypes.array.isRequired,
  };
