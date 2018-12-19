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
 * Returns a promise where the data is the rep log collection
 *
 * @return {Promise<Response>}
 */
 //le mot clé export permet de dire qu'on pourra utiliser
 //cette fonction à l'exterieur du fichier
export function getActeursPartie(){
  return fetchJson('/acteurPartie/').
    then(data => data.items);
}

export function createActeurPartie(acteur){
  return fetchJson('http://localhost:8000/acteurPartie/', {
    method: 'POST',
    body: JSON.stringify(acteur),
  })
}

export function deleteActeurPartie(id) {
  return fetchJson(`/acteurPartie/${id}`, {
    method:'DELETE'
  });
}

export function getActeursReference(){
  return fetchJson('/acteurReference/').
    then(data => data.items);
}

export function getPouvoirsReference(){
  return fetchJson('/pouvoirReference/').
    then(data => data.items);
}



export function createPouvoirPartie(pouvoir){
  return fetchJson('http://localhost:8000/pouvoir/', {
    method: 'POST',
    body: JSON.stringify(pouvoir),
  })
}

export function createDesignation(designation){
  return fetchJson('http://localhost:8000/designation/', {
    method: 'POST',
    body: JSON.stringify(designation),
  })
}

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
