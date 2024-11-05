<template>
  <div class="card">
    <Toolbar class="mb-4">
      <template #start>
        <Button
          label="Nuevo Producto"
          icon="pi pi-plus"
          severity="success"
          class="mr-2"
          @click="openNew"
        />
        <Button
          label="Nuevo Producto con Imagen"
          icon="pi pi-plus"
          severity="success"
          class="mr-2"
          @click="openNewProductoImagen"
        />
      </template>
      <template #end>
        <FileUpload
          mode="basic"
          accept="image/*"
          :maxFileSize="1000000"
          label="Import"
          chooseLabel="Import"
          class="mr-2 inline-block"
        />
        <Button
          label="Export"
          icon="pi pi-upload"
          severity="help"
          @click="exportCSV($event)"
        />
      </template>
    </Toolbar>

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
        style="min-width: 16rem"
      ></Column>
      <Column header="Image">
        <template #body="slotProps">
          <Image
            :src="`${urlAsset}/${slotProps.data.imagen}`"
            :alt="slotProps.data.image"
            class="border-round"
            width="64"
            preview
          />
        </template>
      </Column>
      <Column field="precio" header="Precio" sortable style="min-width: 8rem">
        <template #body="slotProps">
          {{ formatCurrency(slotProps.data.precio) }}
        </template>
      </Column>
      <Column
        field="categoria.nombre"
        header="Categoria"
        sortable
        style="min-width: 8rem"
      ></Column>
      <Column
        field="inventoryStatus"
        header="Status"
        sortable
        style="min-width: 4rem"
      >
        <template #body="slotProps">
          {{ slotProps.data.estado }}
        </template>
      </Column>
      <Column :exportable="false" style="min-width: 8rem">
        <template #body="slotProps">
          <Button
            icon="pi pi-image"
            class="mr-2"
            @click="editImagen(slotProps.data)"
          />
          <Button
            icon="pi pi-pencil"
            outlined
            rounded
            class="mr-2"
            @click="editarProducto(slotProps.data)"
          />
          <Button
            icon="pi pi-trash"
            outlined
            rounded
            severity="danger"
            @click="confirmDeleteProduct(slotProps.data)"
          />
        </template>
      </Column>
    </DataTable>
  </div>

  <Dialog
    v-model:visible="productDialog"
    :style="{ width: '450px' }"
    header="Producto"
    :modal="true"
    class="p-fluid"
  >
  <Image
  v-if="producto.imagen"
            :src="`${urlAsset}/${producto.imagen}`"
            :alt="producto.imagen"
            class="block m-auto pb-3 border-round"
            width="200"
            preview
          />
    <div class="field">
      <label for="name">Nombre</label>
      <InputText
        id="name"
        v-model.trim="producto.nombre"
        required="true"
        autofocus
        :invalid="submitted && !producto.nombre"
        autocomplete="off"
      />
      <small class="p-error" v-if="submitted && !producto.nombre"
        >Nombre es obligatorio.</small
      >
    </div>
    <div class="field">
      <label for="description">Descripción</label>
      <Textarea
        id="description"
        v-model="producto.descripcion"
        rows="3"
        cols="20"
      />
    </div>

    <div class="field">
      <label class="mb-3">Categoria</label>
      <div class="formgrid grid">
        <div
          class="field-radiobutton col-6"
          v-for="cat in categorias"
          :key="cat.id"
        >
          <RadioButton
            :id="`category${cat.id}`"
            name="category"
            :value="cat.id"
            v-model="producto.categoria_id"
          />
          <label :for="`category${cat.id}`">{{ cat.nombre }}</label>
        </div>
      </div>
    </div>

    <div class="formgrid grid">
      <div class="field col">
        <label for="price">Precio</label>
        <InputNumber
          id="price"
          v-model="producto.precio"
          mode="currency"
          currency="USD"
          locale="en-US"
        />
      </div>
      <div class="field col">
        <label for="quantity">Cantidad</label>
        <InputNumber id="quantity" v-model="producto.stock" integeronly />
      </div>
    </div>
    <template #footer>
      <Button label="Cancelar" icon="pi pi-times" text @click="hideDialog" />
      <Button label="Guardar" icon="pi pi-check" text @click="saveProduct" />
    </template>
  </Dialog>


  <Dialog
    v-model:visible="productDialogConImagen"
    :style="{ width: '450px' }"
    header="Producto"
    :modal="true"
    class="p-fluid"
  >
    <img
      v-if="producto.imagen"
      :src="`${urlAsset}/${producto.imagen}`"
      :alt="producto.imagen"
      class="block m-auto pb-3"
    />
    <div class="field">
      <label for="name">Nombre</label>
      <InputText
        id="name"
        v-model.trim="producto.nombre"
        required="true"
        autofocus
        :invalid="submitted && !producto.nombre"
        autocomplete="off"
      />
      <small class="p-error" v-if="submitted && !producto.nombre"
        >Nombre es obligatorio.</small
      >
    </div>
    <div class="field">
      <label for="description">Descripción</label>
      <Textarea
        id="description"
        v-model="producto.descripcion"
        rows="3"
        cols="20"
      />
    </div>

    <div class="field">
      <label class="mb-3">Categoria</label>
      <div class="formgrid grid">
        <div
          class="field-radiobutton col-6"
          v-for="cat in categorias"
          :key="cat.id"
        >
          <RadioButton
            :id="`category${cat.id}`"
            name="category"
            :value="cat.id"
            v-model="producto.categoria_id"
          />
          <label :for="`category${cat.id}`">{{ cat.nombre }}</label>
        </div>
      </div>
    </div>

    <div class="formgrid grid">
      <div class="field col">
        <label for="price">Precio</label>
        <InputNumber
          id="price"
          v-model="producto.precio"
          mode="currency"
          currency="USD"
          locale="en-US"
        />
      </div>
      <div class="field col">
        <label for="quantity">Cantidad</label>
        <InputNumber id="quantity" v-model="producto.stock" integeronly />
      </div>
    </div>
    <div class="field">
      <label class="mb-3">Seleccionar Imagen</label>
      <input type="file" @change="seleccionarImagen" />
    </div>
    <template #footer>
      <Button label="Cancelar" icon="pi pi-times" text @click="hideDialog" />
      <Button label="Guardar" icon="pi pi-check" text @click="guardarProductConImagen" />
    </template>
  </Dialog>

  <Dialog
    v-model:visible="deleteProductDialog"
    :style="{ width: '450px' }"
    header="Confirm"
    :modal="true"
  >
    <div class="confirmation-content">
      <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
      <span v-if="product"
        >Are you sure you want to delete <b>{{ product.name }}</b
        >?</span
      >
    </div>
    <template #footer>
      <Button
        label="No"
        icon="pi pi-times"
        text
        @click="deleteProductDialog = false"
      />
      <Button label="Yes" icon="pi pi-check" text @click="deleteProduct" />
    </template>
  </Dialog>

  <Dialog
    v-model:visible="dialogImagen"
    modal
    header="Edit Profile"
    :style="{ width: '30rem' }"
  >
    <span class="p-text-secondary block mb-5">Actualiza la imagen.</span>
    <div class="flex align-items-center gap-3 mb-3">
      <FileUpload
        name="demo[]"
        customUpload
        @uploader="uploadImagen"
        :multiple="true"
        accept="image/*"
        :maxFileSize="1000000"
      >
        <template #empty>
          <p>Drag and drop files to here to upload.</p>
        </template>
      </FileUpload>
    </div>
  </Dialog>
</template>

<script setup>
import { onMounted, ref } from "vue";
import productoService from "../../services/producto.service";
import categoriaService from "../../services/categoria.service";
import Swal from "sweetalert2";
import { urlAsset } from "../../services/api.service"

const products = ref([]);
const loading = ref(false);
const totalRecords = ref(0);
const buscar = ref("");
const lazyParams = ref({ page: 0 });

const producto = ref({});
const dialogImagen = ref(false);
const productDialog = ref(false);
const productDialogConImagen = ref(false);
const submitted = ref(false);
const deleteProductDialog = ref(false);
const categorias = ref([]);
const imagenSeleccionada = ref(null)

const dt = ref();

onMounted(() => {
  listarProductos();
  cargarCategorias();
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

const cargarCategorias = async () => {
  const { data } = await categoriaService.funListar();
  categorias.value = data;
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

const exportCSV = () => {
  dt.value.exportCSV();
};

const editImagen = (prod) => {
  producto.value = prod;
  dialogImagen.value = true;
};

const seleccionarFiles = (event) => {
  console.log(event.target.files);
};

const uploadImagen = async (event) => {
  const file = event.files[0];
  console.log(file);

  // enviar archivo al servidor
  let formData = new FormData();
  formData.append("imagen", file);

  await productoService.actualizarImagenProducto(producto.value.id, formData);

  dialogImagen.value = false;
  producto.value = {};
  listarProductos();
};

const openNew = () => {
    producto.value = {}
  productDialog.value = true;
};

const hideDialog = () => {
  productDialog.value = false;
};

const saveProduct = async () => {
    if(producto.value.id){
        try {
          const { data } = await productoService.modificar(producto.value.id, producto.value);
          Swal.fire({
            title: "Correcto!",
            text: "Producto Actualizado!",
            icon: "success",
          });
          productDialog.value = false;
          producto.value = {};
          listarProductos();
        } catch (error) {
          Swal.fire({
            icon: "error",
            title: "error...",
            text: "Ocurrió un error al modificar el producto!",
          });
        }
    }else{

        try {
          const { data } = await productoService.guardar(producto.value);
          Swal.fire({
            title: "Correcto!",
            text: "Producto registrado!",
            icon: "success",
          });
          productDialog.value = false;
          producto.value = {};
          listarProductos();
        } catch (error) {
          Swal.fire({
            icon: "error",
            title: "error...",
            text: "Ocurrió un error al registrar el producto!",
          });
        }
    }
};

const guardarProductConImagen = async () => {
  try {

    let formData = new FormData();
    formData.append("nombre", producto.value.nombre)
    formData.append("descripcion", producto.value.descripcion)
    formData.append("categoria_id", producto.value.categoria_id)
    formData.append("precio", producto.value.precio)
    formData.append("stock", producto.value.stock)
    formData.append("imagen", imagenSeleccionada.value)

    const { data } = await productoService.guardarConImagen(formData);
    Swal.fire({
      title: "Correcto!",
      text: "Producto registrado!",
      icon: "success",
    });
    productDialogConImagen.value = false;
    producto.value = {};
    listarProductos();
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "error...",
      text: "Ocurrió un error al registrar el producto!",
    });
  }
};

const openNewProductoImagen = () => {
    producto.value = {}
    productDialogConImagen.value = true;
}

const seleccionarImagen = (e) => {
    console.log(e.target.files);
    imagenSeleccionada.value = e.target.files[0];

}

const editarProducto = (datos) => {
    producto.value = datos
    productDialog.value = true;
}
</script>
