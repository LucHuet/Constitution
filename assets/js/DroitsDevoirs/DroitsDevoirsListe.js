import React from 'react';
import PropTypes from 'prop-types';

export default function DroitsDevoirsListe(props) {

  const { droitsDevoirs } = props;


  if(droitsDevoirs != null){
    return (

        <tbody>
        {droitsDevoirs.map((droitsDevoirs) => (
            <tr
              key={droitsDevoirs.id}
             >
              <td><i className='ui icon minus square outline'></i>{droitsDevoirs.nom}</td>
            </tr>
        ))}
        </tbody>
    )
  }
  else{
    return (
      <tbody>
        Pas de droits et devoir dans cette partie.
      </tbody>
    )
  }
}

  DroitsDevoirsListe.propTypes = {
    droitsDevoirs: PropTypes.array.isRequired,
  };
