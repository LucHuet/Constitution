function fetchJson(url, options) {

  let headers = {'Content-Type': 'application/json'};
  if (options && options.headers) {
      headers = {...options.headers, headers};
      delete options.headers;
  }
  return fetch(url, Object.assign({
      credentials: 'same-origin',
      headers: headers,
  }, options))
      .then(checkStatus)
      .then(response => {
          return response.text()
            .then(text => text ? JSON.parse(text) :  '')
      });
}

function checkStatus(response) {
    if (response.status >= 200 && response.status < 400) {
        return response;
    }
    const error = new Error(response.statusText);
    error.response = response;
    throw error
}

/**
---------- Methodes API pour les acteurs --------
*/

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
  return fetchJson('http://localhost:8000/acteur/', {
    method: 'POST',
    body: JSON.stringify(acteur),
  })
}

/**
---------- Methodes API pour les pouvoirs --------
*/

export function getPouvoirs(){
  return fetchJson('/pouvoir/').
    then(data => data.items);
}

export function createPouvoirPartie(pouvoir){
  return fetchJson('http://localhost:8000/pouvoir/', {
    method: 'POST',
    body: JSON.stringify(pouvoir),
  })
}

/**
---------- Methodes API pour les dé --------
*/

export function createDesignation(designation){
  return fetchJson('http://localhost:8000/designation/', {
    method: 'POST',
    body: JSON.stringify(designation),
  })
}

/**
---------- Methodes API pour la partie --------
*/

/**
 * Returns a promise where the data is the rep log collection
 *
 * @return {Promise<Response>}
 */
export function getParties(){
  return fetchJson('/partie/')
    .then(data => data.items);
}

export function deletePartie(id) {
    return fetchJson(`/partie/${id}`, {
        method: 'DELETE'
    });
}

export function createPartie(partie) {
    return fetchJson('/partie/', {
        method: 'POST',
        body: JSON.stringify(partie),
    });
}

/**
---------- Methodes API pour les droits devoirs --------
*/

export function getDroitsDevoirsReference(){
  return fetchJson('/droitDevoir/').
    then(data => data.items);
}

export function addDroitDevoir(id) {
    return fetchJson(`/partie/droitDevoir/${id}`).
      then(data => data.items);
}

export function getDroitsDevoirs(){
  return fetchJson('/partie/droitDevoir/').
    then(data => data.items);
}
