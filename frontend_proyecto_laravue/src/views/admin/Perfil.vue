<template>
    <div class="card" v-if="perfil">
        <h1>NombreUsuario: {{ perfil.name }}</h1>
        <h1>Correo Acceso: {{ perfil.email }}</h1>
        <hr>
        <h1>Datos Personales</h1>
        <h3>Nombre completo: {{ perfil.persona.nombres }}</h3>
        <h3>Apellidos: {{ perfil.persona.apellidos }}</h3>
        <h3>Dirección: {{ perfil.persona.direccion }}</h3>
        <h3>Estado: {{ perfil.persona.estado?'Activo':'Inactivo' }}</h3>

    </div>
</template>
<script setup>
    import { onMounted, ref } from "vue"
    import authService from "./../../services/auth.service"

    const perfil = ref(null)

    onMounted(async () => {
        const {data} = await authService.funProfile();
        perfil.value = data
    })


</script>