function fetchJson(url, options) {
    return fetch(url, Object.assign({
        credentials: 'same-origin',
    }, options))
        .then(response => {
            return response.text()
              .then(text => text ? JSON.parse(text) :  '')
        });
}

/**
 * Returns a promise where the data is the rep log collection
 *
 * @return {Promise<Response>}
 */
 //le mot clé export permet de dire qu'on pourra utiliser
 //cette fonction à l'exterieur du fichier
export function getActeurs(){
  return fetchJson('/acteur/').
    then(data => data.items);
}

export function deleteActeur(id) {
  return fetchJson(`/acteur/${id}`, {
    method:'DELETE'
  });
}

export function createActeur(acteur){
  return fetchJson('http://localhost:8000/acteur/new/JS', {
    method: 'POST',
    body: JSON.stringify(acteur),
    header: {
      'Content-Type': 'application/json',
    }
  })
}
