import React, { Component } from 'react';

export default class PartieListe extends Component {

  render() {
    const { highlightedRowId, onRowClick } = this.props;

    const parties = [
     { id: 22, nom: 'partie 1' },
     { id: 10, nom: 'partie 2' },
     { id: 11, nom: 'partie 3' }
   ];

   console.log(parties);

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
  }
