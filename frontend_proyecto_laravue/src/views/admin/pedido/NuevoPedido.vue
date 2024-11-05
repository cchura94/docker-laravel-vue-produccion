<template>
  <div class="grid">
    <div class="col-7">
      <div class="text-center p-1 border-round-sm bg-primary font-bold">Lista de productos</div>
     
      <lista-producto @add-carrito="addCarrito"></lista-producto>

    </div>
    <div class="col">
      <div class="grid">
        <div class="col-12">
          <div class="text-center p-1 border-round-sm bg-primary font-bold">
            Detalle de Venta
          </div>
          <div class="card">
            <DataTable :value="carrito">
              <Column field="nombre" header="Nombre"></Column>
              <Column field="precio" header="Precio"></Column>
              <Column field="cantidad" header="Category"></Column>
              <Column header="Accion">
                <template #body="slotProps">
                  <Button
                    icon="pi pi-trash"
                    class="mr-2"
                    @click="quitarCarrito(slotProps.data)"
                  />
                </template>
      </Column>
          </DataTable>

          </div>
        </div>
        <div class="col-12">
          <div class="text-center p-1 border-round-sm bg-primary font-bold">
            Datos Cliente
          </div>
          <div class="card">
            <IconField iconPosition="left">
            <InputIcon>
              <i class="pi pi-search" />
            </InputIcon>
            <InputText
              v-model="buscar"
              placeholder="Buscar..."
              @keyup.enter="buscarCliente"
            />
          </IconField>
          <Button
            label="Nuevo Cliente"
            icon="pi pi-plus"
            severity="success"
            class="mr-2"
            @click="openNewCliente"
          />

          <div v-if="cliente_seleccionado.id">
            <h5>CLIENTE: {{ cliente_seleccionado.razon_social }}</h5>
            <h5>CI/NIT: {{ cliente_seleccionado.ci_nit }}</h5>
            <h5>CORREO: {{ cliente_seleccionado.correo }}</h5>
            
          </div>
        </div>
        </div>

        <div class="col-12">
          <div class="text-center p-1 border-round-sm bg-primary font-bold">
            Guardar Pedido
          </div>
          <div class="card">
          <Button
            label="Guardar Pedido"
            icon="pi pi-plus"
            severity="success"
            class="mr-2"
            @click="guardarPedido()"
          />
        </div>
        </div>
      </div>
    </div>
  </div>


<Dialog v-model:visible="visible" modal header="Nuevo Cliente" :style="{ width: '25rem' }">
    <span class="p-text-secondary block mb-5">Registra los datos de cliente.</span>
   
    <div class="flex align-items-center gap-3 mb-3">
        <label for="razon_social" class="font-semibold w-6rem">Razon Social</label>
        <InputText id="razon_social" class="flex-auto" autocomplete="off" v-model="cliente.razon_social" />
    </div>
    <div class="flex align-items-center gap-3 mb-5">
        <label for="ci_nit" class="font-semibold w-6rem">ci_nit</label>
        <InputText id="ci_nit" class="flex-auto" autocomplete="off" v-model="cliente.ci_nit" />
    </div>
    <div class="flex align-items-center gap-3 mb-5">
        <label for="correo" class="font-semibold w-6rem">correo</label>
        <InputText id="correo" class="flex-auto" autocomplete="off" v-model="cliente.correo" />
    </div>
    <div class="flex justify-content-end gap-2">
        <Button type="button" label="Cancelar" severity="secondary" @click="visible = false"></Button>
        <Button type="button" label="Guardar" @click="guardarCliente()"></Button>
    </div>
</Dialog>

</template>

<script setup>
import Swal from 'sweetalert2';
import { ref } from 'vue';
import ListaProducto from '../../../components/pedido/ListaProducto.vue';
import clienteService from "./../../../services/cliente.service"
import pedidoService from "./../../../services/pedido.service"


const carrito = ref([]);
const buscar = ref("")
const listarProductos = ref([])
const visible = ref(false)
const cliente = ref({})
const cliente_seleccionado = ref({})

function addCarrito(prod) {
  console.log("LLEGO: ", prod)

  carrito.value.push(prod)

} 

function quitarCarrito(prod){
  let pos = carrito.value.indexOf(prod)
  carrito.value.splice(pos, 1);
}

function openNewCliente(){
  visible.value = true
}

async function guardarCliente(){
  
  const {data} = await clienteService.guardar(cliente.value)

  cliente_seleccionado.value = data;
  visible.value = false
}

async function guardarPedido(){
  let datos = {
    cliente_id: cliente_seleccionado.value.id,
    productos: carrito.value
  }
  await pedidoService.guardar(datos);

  Swal.fire({
    title: "Pedido Registrado!",
    text: "El pedido ha sido registrado!",
    icon: "success"
  });

  cliente_seleccionado.value = {}
  carrito.value = []


}

const buscarCliente = async () => {
  const {data} = await clienteService.buscar(buscar.value);
  cliente_seleccionado.value = data
}

</script>