<template>
    <div class="card">
        <!-- comentario -->
        <h1>Componente Persona</h1>
        <form @submit.prevent="funGuardarPersona()">
            <label for="">Ingrese Nombres</label>
            <input type="text" v-model="persona.nombres">
            <br>
            <label for="">Ingrese apellidos</label>
            <input type="text" v-model="persona.apellidos">
            <br>
            <label for="">Ingrese direccion</label>
            <input type="text" v-model="persona.direccion">
            <br>
            <label >Seleccione el Usuario:</label>
            
            <select v-model="persona.user_id">
                <option value="">Seleccione el usuario</option>

                <option v-for="user in usuarios" :value="user.id" :key="user.id">{{ user.email }}</option>
            </select>
            <br>
            <input type="submit">

        </form>

        <DataTable :value="personas" tableStyle="min-width: 50rem">
            <Column field="id" header="ID"></Column>
            <Column field="nombres" header="Nombres"></Column>
            <Column field="apellidos" header="Apellidos"></Column>
            <Column field="direccion" header="DIrección"></Column>
        </DataTable>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>apellidos</th>
                    <th>direccion</th>
                    <th>USER ID</th>
                    <th>ACCION</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="per in personas" :key="per.id">
                    <td>{{ per.id }}</td>
                    <td>{{ per.nombres }}</td>
                    <td>{{ per.apellidos }}</td>
                    <td>{{ per.direccion }}</td>
                    <td>{{ per.user_id }}</td>
                    <td>
                        <button @click="funEditar(per)">EDITAR</button>
                        <button @click="funEliminar(per.id)">ELIMINAR</button>
                    </td>
                </tr>
            </tbody>

        </table>
        <pre>{{ personas }}</pre>
    </div>
</template>

<script setup>
    // mi comentario en js
    import personaService from "./../../services/persona.service.js"
    import usuarioService from "./../../services/user.service"
    import {ref, onMounted} from 'vue'
    import Swal from 'sweetalert2'

    const personas = ref([])
    const usuarios = ref([])

    const persona = ref({
        "nombres": "",
        "apellidos": "",
        "direccion": "",
        "estado": 1,
        "user_id": 44
    })

    onMounted(() => {
        getPersonas()
        getUsuarios()
    })

    async function getUsuarios(){
        try {
            const res = await usuarioService.funListar()
            usuarios.value = res.data  
        } catch (error) {
            console.log(error)
        }
    }

    async function getPersonas() {
        try {
            const res = await personaService.funListar()
            personas.value = res.data  
        } catch (error) {
            console.log(error)
        }

        // fetch("http://127.0.0.1:8000/api/persona")
        // .then(
        //     (res) => {
        //         return res.json()
        //         
        //     }
        // ).then(json => {
        //     personas.value = json
        // }).catch(error => {
        //     console.log(error)
        // })
    }

    async function funGuardarPersona(){
        try {
            if(persona.value.id){
                // modificar
                const res = await personaService.modificar(persona.value.id, persona.value)
            }else{
                // guardar
                const res = await personaService.guardar(persona.value)
            }

            Swal.fire({
                title: 'Correcto!',
                text: 'Persona ok',
                icon: 'success',
                confirmButtonText: 'Ok'
                })

            getPersonas() 

        } catch (error) {
            console.log(error)
            Swal.fire({
            title: 'Error!',
            text: 'Ocurrió un error',
            icon: 'error',
            confirmButtonText: 'Cerrar'
            })
        }
    }

    function funEditar(per){
        persona.value = per;
    }

    async function funEliminar(id){
        if(confirm("¿Está segur@ de eliminar la persona?")){
            await personaService.eliminar(id)
            
            Swal.fire({
                title: 'Eliminado!',
                text: 'Para continuar',
                icon: 'success',
                confirmButtonText: 'CERRAR'
                })

            getPersonas() 


        }
    }

</script>

<style>
 /* mi comentario en css */

</style>