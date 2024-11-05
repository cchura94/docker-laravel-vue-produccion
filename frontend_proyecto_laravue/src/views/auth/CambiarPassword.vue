<template>
    <h1>Ingres su nueva contraseña</h1>

    <label for="em" class="block text-900 text-xl font-medium mb-2">Ingrese Su Correo</label>
    <InputText id="em" type="email" placeholder="Ingrese su Correo" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="email" />
    
    <label for="pass" class="block text-900 text-xl font-medium mb-2">Ingrese Su nueva contraseña</label>
    <InputText id="pass" type="password" placeholder="Ingrese su nueva contraseña" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="password" />

    <label for="npass" class="block text-900 text-xl font-medium mb-2">Repita su nueva contraseña</label>
    <InputText id="npass" type="password" placeholder="Repita su nueva contraseña" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="password_confirmation" />

    <button @click="cambiarContrasena()">CAMBIAR CONTRASEÑA</button>
    <hr>
</template>

<script setup>
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import authService from "../../services/auth.service";

const route = useRoute()
const router = useRouter()



const password = ref("");
const token = ref(route.query.token);
const email = ref("")
const password_confirmation = ref("")

const cambiarContrasena = async () => {
    await authService.cambiarPassword({token: token.value, password: password.value, email: email.value, password_confirmation: password_confirmation.value})
    router.push({name: "Login"})
}

</script>