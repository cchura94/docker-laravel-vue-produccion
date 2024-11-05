<template>
  <div class="card">
    <DataTable
      ref="dt"
      :value="products"
      dataKey="id"
      lazy
      :totalRecords="totalRecords"
      :loading="loading"
      @page="onPage($event)"
      :paginator="true"
      :rows="10"
      paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
      :rowsPerPageOptions="[3, 5, 10]"
      currentPageReportTemplate="Mostrando {first} al {last} de {totalRecords} productos"
    >
      <template #header>
        <div
          class="flex flex-wrap gap-2 align-items-center justify-content-between"
        >
          <h4 class="m-0">Gestión Productos</h4>
          <IconField iconPosition="left">
            <InputIcon>
              <i class="pi pi-search" />
            </InputIcon>
            <InputText
              v-model="buscar"
              placeholder="Buscar..."
              @keyup.enter="listarProductos"
            />
          </IconField>
        </div>
      </template>

      <Column field="id" header="ID" sortable style="min-width: 1rem"></Column>
      <Column
        field="nombre"
        header="Nombre"
        sortable
        style="min-width: 10rem"
      ></Column>
      <Column header="Image">
        <template #body="slotProps">
          <Image
            :src="`${urlAsset}/${slotProps.data.imagen}`"
            :alt="slotProps.data.image"
            class="border-round"
            width="32"
            preview
          />
        </template>
      </Column>
      <Column field="precio" header="Precio" sortable style="min-width: 2rem">
        <template #body="slotProps">
          {{ formatCurrency(slotProps.data.precio) }}
        </template>
      </Column>
      <Column
        field="categoria.nombre"
        header="Categoria"
        sortable
        style="min-width: 3rem"
      ></Column>
      <Column :exportable="false" style="min-width: 3rem">
        <template #body="slotProps">
          <Button
            icon="pi pi-plus"
            class="mr-2"
            @click="asignarAlCarrito(slotProps.data)"
          />
        </template>
      </Column>
    </DataTable>
  </div>
</template>
<script setup>
import productoService from "../../services/producto.service";
import { onMounted, ref } from "vue";
import { urlAsset } from "../../services/api.service";

const products = ref([]);
const loading = ref(false);
const totalRecords = ref(0);
const buscar = ref("");
const lazyParams = ref({ page: 0 });

const emit = defineEmits(['add-carrito'])

onMounted(() => {
  listarProductos();
});

const listarProductos = async () => {
  let page = lazyParams.value.page + 1;
  let limit = lazyParams.value.rows;

  loading.value = true;
  const { data } = await productoService.funListar(page, limit, buscar.value);
  console.log(data);
  products.value = data.data;
  totalRecords.value = data.total;

  loading.value = false;
};

const onPage = (event) => {
  lazyParams.value = event;
  listarProductos();
};
const formatCurrency = (value) => {
  if (value)
    return value.toLocaleString("en-US", {
      style: "currency",
      currency: "USD",
    });
  return;
};

const asignarAlCarrito = (prod) => {
    const datos = {
        producto_id: prod.id,
        cantidad: 1,
        nombre: prod.nombre,
        precio: prod.precio
    }
    emit('add-carrito', datos)
}
</script>
