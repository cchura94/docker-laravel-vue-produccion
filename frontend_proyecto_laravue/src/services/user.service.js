import { Api } from "./api.service";

export default {
    funListar: function(){
        return Api().get('/usuario');
    },
    guardar: function(datos){
        return Api().post('/usuario', datos);
    },
    mostrar: function(id){
        return Api().get(`/usuario/${id}`);
    },
    modificar: function(id, datos){
        return Api().put(`/usuario/${id}`, datos);
    },
    eliminar: function(id){
        return Api().delete(`/usuario/${id}`);
    },
    importarArchivoExcel: (fd) => {
        return Api().post(`/user/excel/import`, fd);

    }
}