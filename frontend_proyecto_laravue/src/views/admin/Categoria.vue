<template>
    <div class="card">
        <!-- comentario -->
        <h1>Componente Categoria</h1>

        <Button label="Nueva Categoria" @click="visibleDialog = true" />

        <Dialog v-model:visible="visibleDialog" modal header="Categoria" :style="{ width: '25rem' }">
            <span class="p-text-secondary block mb-5">Ingrese los datos.</span>
            <div class="flex align-items-center gap-3 mb-3">
                <label for="nom" class="font-semibold w-6rem">Nombre</label>
                <InputText id="nom" class="flex-auto" autocomplete="off" v-model="categoria.nombre" />
            </div>
            <div class="flex align-items-center gap-3 mb-5">
                <label for="det" class="font-semibold w-6rem">Detalle</label>
                <InputText id="det" class="flex-auto" autocomplete="off" v-model="categoria.detalle" />
            </div>
            <div class="flex justify-content-end gap-2">
                <Button type="button" label="Cancelar" severity="secondary" @click="visibleDialog = false"></Button>
                <Button type="button" label="Guardar" @click="guardarCategoria()"></Button>
            </div>
        </Dialog>



        <DataTable :value="categorias" tableStyle="min-width: 50rem">
            <Column field="id" header="ID"></Column>
            <Column field="nombre" header="NOMBRE"></Column>
            <Column field="detalle" header="DETALLE"></Column>  
        </DataTable>


    </div>
</template>

<script setup>
import Swal from "sweetalert2";
import { onMounted, ref } from "vue"
import categoriaService from "./../../services/categoria.service"

const visibleDialog = ref(false)
const categoria = ref({nombre: "", detalle: ""})

const categorias = ref([]);
    // mi comentario en js
    onMounted(() => {
        getListaCategorias()
        
    });

    async function getListaCategorias(){
        // FETCH
        // categoriaService.funListar()
        //                 .then(res => res.json())
        //                 .then(json => console.log(json));
        
        // AXIOS
        const res = await categoriaService.funListar();
        console.log(res.data)
        categorias.value = res.data
        
    }

    const guardarCategoria = async () => {
        try {
            const {data} = await categoriaService.guardar(categoria.value)
            visibleDialog.value = false;
            categoria.value = {}

            getListaCategorias()

            Swal.fire({
                title: "Correcto!",
                text: "Categoria registrada!",
                icon: "success"
            });
        } catch (error) {
            Swal.fire({
            icon: "error",
            title: "error...",
            text: "Ocurrió un error al registrar la categoria!"
            });
        }
    }

</script>

<style>
 /* mi comentario en css */

</style>