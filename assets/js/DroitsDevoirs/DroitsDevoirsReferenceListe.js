import React from 'react';
import PropTypes from 'prop-types';

export default function DroitsDevoirsReferenceListe(props) {

   const {
      droitsDevoirs,
      droitsDevoirsReference,
      addedRowId,
      onRowClick,
    } = props;


   const checkInArray = function(droitDevoir){
      var inPartie = true;

       droitsDevoirs.forEach((droitDevoirPartie) => {

         if(droitDevoirPartie.id == droitDevoir.id){
           inPartie = false;
         }
         console.log("in partie ? " + inPartie);

      });

      return inPartie;
   }

   return (
       <tbody>

       {droitsDevoirsReference.map((droitDevoir) => (
           <tr
             key={droitDevoir.id}
             onClick={()=> onRowClick(droitDevoir.id)}
            >
             <td><i className={checkInArray(droitDevoir) ? 'ui plus square outline icon' : 'ui minus square outline icon'}></i>{droitDevoir.nom}</td>
           </tr>
       ))}
       </tbody>
   )
  }

  DroitsDevoirsReferenceListe.propTypes = {
      droitsDevoirs: PropTypes.array.isRequired,
      onRowClick: PropTypes.func.isRequired,
      addedRowId: PropTypes.any,
      droitsDevoirsReference: PropTypes.array.isRequired,
  };
