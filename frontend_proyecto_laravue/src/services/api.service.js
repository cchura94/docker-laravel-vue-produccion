import axios from 'axios';

const baseURL = "http://127.0.0.1:8000"
// const baseURL = "https://laravue2.blumbit.net/back/public";

export const urlAsset = baseURL;

let urlBackend = `${baseURL}/api`;

export function Api(){

    let token = null;
    try {
        token = atob(localStorage.getItem("access_token"));
        
    } catch (error) {
        localStorage.removeItem('access_token');
        token = null
    }


    let api = axios.create({
        baseURL: urlBackend,
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+token
        },
        timeout: 60000
    });

    // interceptar errores 401
    api.interceptors.response.use(
        (response) => {
            return response;
        },
        (error) => {
            if(error.response.status === 401) {
                localStorage.removeItem("access_token")
                window.location.href = "/login"
            }

            return Promise.reject(error)
        }
    )

    return api;
}
