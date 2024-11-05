import { Api } from "./api.service";

export default {
    funLogin: function(credenciales){
        return Api().post('/v1/auth/login', credenciales);
    },

    funRegister: function(datos){
        return Api().post('/v1/auth/register', datos);
    },

    funProfile: function(){
        return Api().get('/v1/auth/profile');
    },

    funLogout: function(){
        return Api().post('/v1/auth/logout', {});
    },

    sendEmailResetPassword: function(datos){
        return Api().post('reset-password', datos)
    },

    cambiarPassword: function(datos){
        return Api().post('/cambio-password', datos)
    }

    
}