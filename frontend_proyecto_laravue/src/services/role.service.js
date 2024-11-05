import { Api } from "./api.service";

export default {
    funListar: function(){
        return Api().get('/role');
    },
    guardar: function(datos){
        return Api().post('/role', datos);
    },
    mostrar: function(id){
        return Api().get(`/role/${id}`);
    },
    modificar: function(id, datos){
        return Api().put(`/role/${id}`, datos);
    },
    eliminar: function(id){
        return Api().delete(`/role/${id}`);
    }
}