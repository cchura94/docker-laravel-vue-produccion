import { Api } from "./api.service";

export default {
    funListar: function(page=1, limit=10, q=''){
        return Api().get(`/pedido?page=${page}&limit=${limit}&q=${q}`);
    },
    guardar: function(datos){
        return Api().post('/pedido', datos);
    },
    mostrar: function(id){
        return Api().get(`/pedido/${id}`);
    },
    modificar: function(id, datos){
        return Api().put(`/pedido/${id}`, datos);
    },
    eliminar: function(id){
        return Api().delete(`/pedido/${id}`);
    },
    descargarPDF: function(id){
        return Api().get(`/pedido/${id}/pdf-report`, {responseType: 'blob'});
    }
}