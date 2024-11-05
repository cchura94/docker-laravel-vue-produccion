<template>
    <div class="card">
        <h1>Gestión Usuarios</h1>

        importar EXCEL
        <input type="file" @change="seleccionarArchivoExcel" />

        <DataTable :value="lista_usuarios" tableStyle="min-width: 50rem">
            <template #header>
                <div class="flex flex-wrap align-items-center justify-content-between gap-2">
                    <span class="text-xl text-900 font-bold">Usuarios</span>
                    <Button label="Nuevo Usuario" @click="visible=true" />
                    <Button icon="pi pi-refresh" rounded raised />
                </div>
            </template>

            <Column field="id" header="ID"></Column>
            <Column field="name" header="NOMBRE"></Column>
            <Column field="email" header="CORREO"></Column>
            <Column field="persona" header="NOMBRES">
                <template #body="slotProps">
                    {{ slotProps.data.persona?.nombres }}
                </template>
            </Column>
            <Column field="persona" header="APELLIDOS">
                <template #body="slotProps">
                    {{ slotProps.data.persona?.apellidos }}
                </template>
            </Column>
            <Column field="persona" header="ESTADO">
                <template #body="slotProps">
                    {{ slotProps.data.persona?.estado?'ACTIVO':'INACTIVO' }}
                </template>
            </Column>
            <Column field="roles" header="ROLES">
                <template #body="slotProps">
                    <h6 v-for="rol in slotProps.data.roles" :key="rol.id">{{ rol.nombre }}</h6>
                </template>
            </Column>
            <Column field="accion" header="accion">
                <template #body="slotProps">
                    <Button label="modificar" @click="editarUsuario(slotProps.data)" />
                </template>
            </Column>

        </DataTable>

        <pre>{{ lista_usuarios }}</pre>
        
    </div>

    <Dialog v-model:visible="visible" modal header="Nuevo Usuario" :style="{ width: '25rem' }">
        <!--{{ usuario }}-->
        <span class="p-text-secondary block mb-5">Llena los datos de usuario.</span>
        <div class="flex align-items-center gap-3 mb-3">
            <label for="username" class="font-semibold w-6rem">Usuario</label>
            <InputText id="username" class="flex-auto" autocomplete="off" v-model="usuario.name" />
        </div>
        <div class="flex align-items-center gap-3 mb-5">
            <label for="email" class="font-semibold w-6rem">Correo</label>
            <InputText id="email" class="flex-auto" autocomplete="off" v-model="usuario.email" />
        </div>
        <div class="flex align-items-center gap-3 mb-5">
            <label for="pass" class="font-semibold w-6rem">Contraseña</label>
            <InputText type="password" id="pass" class="flex-auto" autocomplete="off" v-model="usuario.password" />
        </div>

        <div class="flex align-items-center gap-3 mb-5">
            <label for="pass" class="font-semibold w-6rem">Roles</label>
            <div class="card flex flex-wrap justify-content-center gap-3">
                <div class="flex align-items-center" v-for="rol in lista_roles" :key="rol.id">
                    <Checkbox v-model="usuario.roles" inputId="rol{{rol.id}}" name="role" :value="rol.id" />
                    <label for="rol{{rol.id}}" class="ml-2"> {{ rol.nombre }} </label>
                </div>
                
            </div>
        </div>
        

        <div class="flex justify-content-end gap-2">
            <Button type="button" label="Cancelar" severity="secondary" @click="visible = false"></Button>
            <Button type="button" label="Guardar" @click="guardarUsuario()"></Button>
        </div>

    </Dialog>

</template>

<script setup>
// importaciones
import { onMounted, ref } from 'vue'
import userService from '../../services/user.service'
import roleService from '../../services/role.service'

// variables
const lista_usuarios = ref([])
const lista_roles = ref([])
const visible = ref(false)

// const name = ref("")
// const email = ref("")
// const password = ref("")

const usuario = ref({name: '', email: '', password: ''})

// constructor
onMounted(() => {
    listarUsuarios()
    listarRoles()
})

// funciones
const listarUsuarios = async () => {
    const { data } = await userService.funListar();
    lista_usuarios.value = data
}

const listarRoles = async () => {
    const { data } = await roleService.funListar();
    lista_roles.value = data
}


const guardarUsuario = async () => {
    if(usuario.value.id){
        await userService.modificar(usuario.value.id, usuario.value)

    }else{
        await userService.guardar(usuario.value)

    }
    visible.value = false
    usuario.value = {}
    listarUsuarios()

}

const editarUsuario = (data) => {
    usuario.value = data;
    visible.value = true
}

const seleccionarArchivoExcel = async (e) => {
    console.log(e.target.files);
    let formData = new FormData()
    formData.append("file", e.target.files[0])
    await userService.importarArchivoExcel(formData);

    listarUsuarios()
}


</script>