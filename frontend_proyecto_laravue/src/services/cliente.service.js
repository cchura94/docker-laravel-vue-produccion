import { Api } from "./api.service";

export default {
    funListar: () => {
        return Api().get('/cliente');
    },
    guardar: (datos) => {
        return Api().post('/cliente', datos);
    },
    mostrar: (id) => {
        return Api().get(`/cliente/${id}`);
    },
    modificar: (id, datos) => { 
        return Api().put(`/cliente/${id}`, datos);
    },
    eliminar: (id) => {
        return Api().delete(`/cliente/${id}`);
    },
    buscar: (q) => {
        return Api().get(`/cliente/buscar?buscar=${q}`);
    }
}