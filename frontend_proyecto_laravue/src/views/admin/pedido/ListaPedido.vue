<template>
  <h1>Lista Pedido</h1>

  <DataTable
    ref="dt"
    :value="pedidos"
    dataKey="id"
    lazy
    :totalRecords="totalRecords"
    :loading="loading"
    @page="onPage($event)"
    :paginator="true"
    :rows="10"
    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
    :rowsPerPageOptions="[3, 5, 10]"
    currentPageReportTemplate="Mostrando {first} al {last} de {totalRecords} pedidos"
  >
    <template #header>
      <div
        class="flex flex-wrap gap-2 align-items-center justify-content-between"
      >
        <h4 class="m-0">Lista Pedidos</h4>
        <IconField iconPosition="left">
          <InputIcon>
            <i class="pi pi-search" />
          </InputIcon>
          <InputText
            v-model="buscar"
            placeholder="Buscar..."
            @keyup.enter="getPedidos"
          />
        </IconField>
      </div>
    </template>

    <Column field="id" header="ID" sortable style="min-width: 1rem"></Column>
    <Column
      field="fecha_pedido"
      header="FECHA"
      sortable
      style="min-width: 16rem"
    ></Column>
    <Column
      field="cliente_id"
      header="CLIENTE"
      sortable
      style="min-width: 8rem"
    >
      <template #body="slotProps">
        <h5>C: {{ slotProps.data.cliente.razon_social }}</h5>
        <h6>CI/NIT: {{ slotProps.data.cliente.ci_nit }}</h6>
      </template>
    </Column>
    <Column
      field="inventoryStatus"
      header="Status"
      sortable
      style="min-width: 4rem"
    >
      <template #body="slotProps">
        {{
          slotProps.data.estado == 3
            ? "COMPLETADO"
            : slotProps.data.estado == 1
            ? "BORRADOR"
            : "EN PROCESO"
        }}
      </template>
    </Column>
    <Column :exportable="false" style="min-width: 8rem">
      <template #body="slotProps">
        <Button
          icon="pi pi-table"
          class="mr-2"
          @click="mostrarDetallePedido(slotProps.data)"
        />
        <Button
          icon="pi pi-file"
          class="mr-2"
          @click="descargarPDF(slotProps.data)"
        />
        <Button
          icon="pi pi-pencil"
          outlined
          rounded
          class="mr-2"
          @click="editarProducto(slotProps.data)"
        />
      </template>
    </Column>
  </DataTable>

  <Dialog
    v-model:visible="dialogDetalle"
    modal
    header="Detalle Pedido"
    :style="{ width: '70rem' }"
  >
    <h4>FECHA: {{ detalle.fecha_pedido }}</h4> 
    <h4>CLIENTE: {{ detalle.cliente.razon_social }}</h4> 
    <h4>ATENDIDO POR: {{ detalle.user?.email }}</h4> 

    <DataTable :value="detalle.productos" tableStyle="min-width: 50rem">
        <Column field="id" header="ID"></Column>
        <Column field="nombre" header="NOmbre"></Column>
        <Column field="precio" header="Precio"></Column>
        <Column field="pivot.cantidad" header="Cantidad"></Column>
    </DataTable>


  </Dialog>
</template>
<script setup>
import { onMounted, ref } from "vue";
import pedidoService from "../../../services/pedido.service";

const pedidos = ref([]);
const loading = ref(false);
const totalRecords = ref(0);
const buscar = ref("");
const lazyParams = ref({ page: 0 });
const dt = ref();
const detalle = ref({});

const dialogDetalle = ref(false);

onMounted(() => {
  getPedidos();
});

const getPedidos = async () => {
  const { data } = await pedidoService.funListar(1, 20, buscar.value);
  pedidos.value = data.data;
};

const onPage = (event) => {
  lazyParams.value = event;
  getPedidos();
};

const mostrarDetallePedido = (datos) => {
  detalle.value = datos;
  dialogDetalle.value = true;
};

const descargarPDF = async (pedido) => {
  const respuesta = await pedidoService.descargarPDF(pedido.id);

  const url = window.URL.createObjectURL(new Blob([respuesta.data], {type: 'application/pdf'}));

  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', 'recibo.pdf');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
</script>
