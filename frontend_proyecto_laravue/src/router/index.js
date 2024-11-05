import { createRouter, createWebHistory } from 'vue-router'
import Categoria from './../views/admin/Categoria.vue'
import Producto from './../views/admin/Producto.vue'
import Persona from './../views/admin/Persona.vue'
import Role from './../views/admin/Role.vue'
import Mensaje from '../views/admin/Mensaje.vue';
import Login from '../views/auth/Login.vue';
import AppLayout from '../layout/AppLayout.vue';
import GestionUsuario from '../views/admin/Usuario.vue'
import Inicio from '../views/web/Inicio.vue' 
import ListaPedido from '../views/admin/pedido/ListaPedido.vue'
import NuevoPedido from '../views/admin/pedido/NuevoPedido.vue'

import Departamento from './../views/admin/Departamento.vue'
import Perfil from './../views/admin/Perfil.vue'
import ResetPass from './../views/auth/ResetPassword.vue'
import CambiarPassword from './../views/auth/CambiarPassword.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/admin',
            component: AppLayout,
            meta: {requiredAuth: true},
            children: [
                {
                    path: 'perfil',
                    component: Perfil
                },
                {
                    path: 'categoria',
                    name: 'Categoria',
                    component: Categoria,
                    meta: {requiredAuth: true}
                },
                {
                    path: 'producto',
                    name: 'Producto',
                    component: Producto,
                    meta: {requiredAuth: true}
                },
                {
                    path: 'persona',
                    name: 'Persona',
                    component: Persona,
                    meta: {requiredAuth: true}
                },
                {
                    path: 'role',
                    name: 'Role',
                    component: Role,
                    meta: {requiredAuth: true}
                },
                {
                    path: 'whatsapp',
                    name: 'Whatsapp',
                    component: Mensaje
                },
                {
                    path: 'usuarios',
                    name: 'Usuario',
                    component: GestionUsuario
                },
                {
                    path: 'departamento',
                    name: 'Departamento',
                    component: Departamento
                },
                {
                    path: 'pedido',
                    name: 'ListaPedido',
                    component: ListaPedido
                },
                {
                    path: 'pedido/nuevo',
                    name: 'NuevoPedido',
                    component: NuevoPedido
                }

            ]
        },
        {
            path: '/login',
            name: 'Login',
            component: Login,
            meta: {redirectIfAuth: true}
        },
        {
            path: '',
            name: Inicio,
            component: Inicio
        },
        {
            path: '/reset',
            name: 'ResetPassword',
            component: ResetPass
        },
        {
            path: '/nuevo-password',
            name: 'CambioPassword',
            component: CambiarPassword
        }
        
      
    ]

});

router.beforeEach((to, from, next) => {
    console.log("FROM: ", from);
    console.log("TO: ", to);
    let token = null;
    try {
        let base64 = localStorage.getItem("access_token") || null
        if(base64){
            token = atob(base64);
        }
        
    } catch (error) {
        localStorage.removeItem('access_token');
        token = null
    }

    if(to.meta.requiredAuth){
        if(!token){
            return next({name: 'Login'})
        }
        return next()
    }

    if(to.meta.redirectIfAuth && token){
        return next({name: 'Persona'});
    }


    return next()
})


export default router;
