<template>
    <div class="card">
        <h1>Ingrese su correo para recuperar su contraseña</h1>
        <label for="email1" class="block text-900 text-xl font-medium mb-2">Correo Electronico</label>
        <InputText id="email1" type="text" placeholder="Correo Electronico" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="email" />

        <button @click="enviarEmailResetPassword">Enviar Correo</button>

    </div>
</template>
<script setup>
import { ref } from "vue"
import authService from "../../services/auth.service";


const email = ref("");

const enviarEmailResetPassword = () => {
    authService.sendEmailResetPassword({email: email.value})
}
</script>