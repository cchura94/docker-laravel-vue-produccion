<template>
  <h1>Combos departamento</h1>

  <label for="">Departamentos:</label>
  <select name="" id="" v-model="dep_seleccionado" @change="buscarProvincias">
    <option>Seleccione una opción</option>
    <option :value="dep.id" v-for="dep in departamentos" :key="dep.id">
      {{ dep.nombre }}
    </option>
  </select>

  <h4>OPCION SELECCIONADO: {{ dep_seleccionado }}</h4>

  <label for="">Provincias:</label>
  <select name="" id="" v-model="prov_seleccionado" @change="buscarCiudades">
    <option>Seleccione una Provincia</option>
    <option :value="dep.id" v-for="dep in provincias" :key="dep.id">
      {{ dep.nombre }}
    </option>
  </select>

  <h4>OPCION SELECCIONADO: {{ prov_seleccionado }}</h4>

  <label for="">Ciudades:</label>
  <select name="" id="" v-model="ciudad_seleccionado">
    <option>Seleccione una Ciudad</option>
    <option :value="dep.id" v-for="dep in ciudades" :key="dep.id">
      {{ dep.nombre }}
    </option>
  </select>

  <h4>OPCION SELECCIONADO: {{ ciudad_seleccionado }}</h4>
</template>

<script setup>
import { ref } from "vue";

const dep_seleccionado = ref(null);
const prov_seleccionado = ref(null);
const ciudad_seleccionado = ref(null);
const departamentos = ref([
  { id: 1, nombre: "La Paz" },
  { id: 2, nombre: "Santa Cruz" },
  { id: 3, nombre: "Cochabamba" },
]);
const provincias = ref([]);
const ciudades = ref([]);

const buscarProvincias = () => {
  // id buscado = dep_seleccionado
  provincias.value = [
    { id: 1, nombre: "Murillo" },
    { id: 2, nombre: "Otro 2" },
    { id: 3, nombre: "Otro 3" },
  ];
};
const buscarCiudades = () => {
  // id buscado = prov_seleccionado
  ciudades.value = [
    { id: 1, nombre: "El Alto" },
    { id: 2, nombre: "La Paz" },
    { id: 3, nombre: "Otro 3" },
  ];
};
</script>
