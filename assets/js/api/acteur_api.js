/**
 * Returns a promise where the data is the rep log collection
 *
 * @return {Promise<Response>}
 */
export function getActeurs(){
  return fetch('/acteur/')
      .then(response => {
        return response.json();
      });
}
