<template>
    <!--
    <h1>Login</h1>

    <label for="">Ingrese Correo</label>
    <input type="text" v-model="credenciales.email">
    <br>
    <label for="">Ingrese Contraseña</label>
    <input type="password" v-model="credenciales.password">
    <br>
    <button @click="funLogin()">Ingresar</button>
-->
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <img src="https://blog.agenciadosite.com.br/wp-content/uploads/2017/02/logos-para-empresas-como-criar.png" alt="Image" height="50" class="mb-3" />
                        <div class="text-900 text-3xl font-medium mb-3">Bienvenido!</div>
                        <span class="text-600 font-medium">Ingrese sus datos</span>
                    </div>

                    <div>
                        <label for="email1" class="block text-900 text-xl font-medium mb-2">Correo Electronico</label>
                        <InputText id="email1" type="text" placeholder="Correo Electronico" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="credenciales.email" />

                        <label for="password1" class="block text-900 font-medium text-xl mb-2">Contraseña</label>
                        <Password id="password1" v-model="credenciales.password" placeholder="Contraseña" :toggleMask="true" class="w-full mb-3" inputClass="w-full" :inputStyle="{ padding: '1rem' }"></Password>

                        <div class="flex align-items-center justify-content-between mb-5 gap-5">
                            <div class="flex align-items-center">
                                <Checkbox v-model="checked" id="rememberme1" binary class="mr-2"></Checkbox>
                                <label for="rememberme1">Recordar</label>
                            </div>
                            <a href="/reset" class="font-medium no-underline ml-2 text-right cursor-pointer" style="color: var(--primary-color)">¿Olvidaste tu Contraseña?</a>
                        </div>
                        <Button label="Ingresar" class="w-full p-3 text-xl" @click="funLogin()"></Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AppConfig simple />

</template>

<script setup>

import authService from "./../../services/auth.service.js"
import { ref } from "vue";
import { useRouter } from "vue-router";

import AppConfig from '@/layout/AppConfig.vue';

const checked = ref(false);

const router = useRouter()

const credenciales = ref({email: "", password: ""});


const funLogin = async () => {
    try {
        const {data} = await authService.funLogin(credenciales.value);

        console.log(data);
        localStorage.setItem("access_token", btoa(data.access_token))

        router.push({name: "Categoria"});
        
    } catch (error) {
        console.log(error);
    }
    
}

</script>