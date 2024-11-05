import axios from 'axios';

let urlBackend = 'https://graph.facebook.com/v18.0/106430075725576';

export function Api(){

    let api = axios.create({
        baseURL: urlBackend,
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer EAATZC0PN8ZCycBOZBZAbBuqid7Op9XNXYM9yolcwUalyGzACBj7RAxmTOtSrZC0KNkgYnDgl1tTV7i3uEfXhDvLBrLyICxIFaNOAaN8zrWxVTLqWU6wAzPO76Jf3AY6rC258sXOHMHzhu0DAJDV6X5ZB9MieTv8k4GjdNh5nAj7EdDgobSoOi74FZCzE5iZC25n1C8TgPu1FSrhzUtyDDIYZD'
        },
        timeout: 60000
    });

    return api;
}
