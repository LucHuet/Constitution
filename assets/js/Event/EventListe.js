import React from 'react';
import PropTypes from 'prop-types';

export default function EventListe(props) {

  const { pastEvents } = props;


  if(pastEvents != null){
    return (

        <tbody>
        {pastEvents.map((event) => (
            <tr
              key={event.id}
             >
              <td><i className='ui icon minus square outline'></i>{event.nom}</td>
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

  EventListe.propTypes = {
    pastEvents: PropTypes.array.isRequired,
  };
