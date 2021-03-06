import React from 'react';
import PropTypes from 'prop-types';
import PartieCreator from './PartieCreator';
import { Button, Header, Image, Modal } from 'semantic-ui-react'

export default function PartieListe(props) {

 const { parties, onDeletePartie, isLoaded, isSavingNewPartie, onAddPartie } = props;

 if (!isLoaded) {
      return (
          <tbody>
              <tr>
                  <td colSpan="4" className="text-center">Loading...</td>
              </tr>
          </tbody>
      );
    }

 const handleDeleteClick = function(partieId){
   onDeletePartie(partieId);
 }

 return (
     <tbody>

     {parties.map((partie) => (
         <tr
           key={partie.id}
          >
           <td><a href={"/partieDisplay/" + partie.id}>{partie.nom}</a></td>
           <td>
             <a href="#" onClick={() => handleDeleteClick(partie.id)}>
              <i className="trash icon"></i>
             </a>
           </td>
         </tr>
     ))}


    <PartieCreator onAddPartie={onAddPartie}/>

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
    parties: PropTypes.array.isRequired,
    onDeletePartie: PropTypes.func.isRequired,
    onAddPartie: PropTypes.func.isRequired,
    isLoaded: PropTypes.bool.isRequired,
    isSavingNewPartie: PropTypes.bool.isRequired,
};
