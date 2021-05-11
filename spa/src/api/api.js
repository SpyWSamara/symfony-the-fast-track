function fetchCollectionPath(path) {
    return fetch(ENV_API_ENDPOINT + path).then(resp => resp.json()).then(json => json['hydra:member']);
}

export function findConferences() {
    return fetchCollectionPath('api/conferences');
}

export function findComments(conference) {
    return fetchCollectionPath('api/comments?conference=' + conference.id);
}
