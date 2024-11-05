import { Api } from "./api.service";

export default {
    funListar(){
        return Api().get('/categoria');
        // return fetch('http://127.0.0.1:8000/api/categoria')
    },
    guardar(datos){
        return Api().post('/categoria', datos);
        // return fetch('http://127.0.0.1:8000/api/categoria', {method: 'POST', body: JSON.stringify(datos)},)
    },
    mostrar(id){
        return Api().get('/categoria/'+id);
        // return fetch('http://127.0.0.1:8000/api/categoria/'+id, {method: 'GET'})
    },
    modificar(id, datos){
        return Api().put('/categoria/'+id, datos);
        // return fetch('http://127.0.0.1:8000/api/categoria/'+id, {method: 'PUT', body: JSON.stringify(datos)})
    },
    eliminar(id){
        return Api().delete('/categoria/'+id);
        // return fetch('http://127.0.0.1:8000/api/categoria/'+id, {method: 'DELETE'})
    }
}