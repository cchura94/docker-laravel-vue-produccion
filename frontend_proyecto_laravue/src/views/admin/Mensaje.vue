<template>
  <h1>envío de mensajes whatsapp</h1>
  <input type="text" v-model="mensaje" />
  <button @click="enviarMensajeTexto()">Enviar Mensaje</button>

  <div class="card flex justify-content-center">
        <Stepper>
            <StepperPanel header="Header I">
                <template #content="{ nextCallback }">
                    <div class="flex flex-column h-12rem">
                        <div class="border-2 border-dashed surface-border border-round surface-ground flex-auto flex justify-content-center align-items-center font-medium">
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam officia rem animi amet est quidem veniam dicta doloribus! Eveniet nesciunt qui quis voluptate porro atque quam accusamus ducimus, eos impedit.
                          Recusandae minima vel obcaecati iste sint placeat consequatur ex laborum! Aperiam maxime facilis optio maiores nisi dolores earum, assumenda exercitationem ipsam officia, reiciendis quia qui? Dignissimos deserunt possimus magni explicabo.
                          Non ad ex voluptate amet unde eveniet dolor animi accusantium dolores. Quidem harum obcaecati, ut eaque recusandae debitis architecto, placeat libero iusto error facilis ab alias saepe nobis voluptates optio.
                        </div>
                    </div>
                    <div class="flex pt-4 justify-content-end">
                        <Button label="Next" icon="pi pi-arrow-right" iconPos="right" @click="nextCallback" />
                    </div>
                </template>
            </StepperPanel>
            <StepperPanel header="Header II">
                <template #content="{ prevCallback, nextCallback }">
                    <div class="flex flex-column h-12rem">
                        <div class="border-2 border-dashed surface-border border-round surface-ground flex-auto flex justify-content-center align-items-center font-medium">Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque voluptatibus numquam neque ut error harum voluptatum ad repudiandae, laboriosam commodi odit deleniti modi alias ex tenetur aspernatur beatae quas sapiente?
                        Iusto dolorum eius reiciendis, tenetur nostrum necessitatibus sit molestias libero accusantium eaque sequi vitae nihil, nobis ea similique veniam, id facere amet consequuntur. Ea beatae excepturi a architecto eligendi quaerat?
                        Fugiat iste ea obcaecati iure laborum recusandae, sit optio tenetur ut velit exercitationem, nesciunt est facere tempora quidem? Ad nesciunt voluptatum velit eaque numquam fugiat nulla sequi cupiditate recusandae quo!
                        Asperiores, nostrum consequuntur aut facere esse necessitatibus vitae quibusdam architecto! Dignissimos quasi eos sit dicta excepturi exercitationem doloribus quaerat corporis maxime illo! Mollitia illum ab maxime neque doloremque at placeat?
                        Adipisci sapiente voluptates obcaecati dolores iste ullam laborum dolorem saepe ratione doloribus fugiat consequatur velit exercitationem eligendi quod, nihil officia similique. Animi magni voluptates odit perspiciatis in explicabo suscipit unde.</div>
                    </div>
                    <div class="flex pt-4 justify-content-between">
                        <Button label="Back" severity="secondary" icon="pi pi-arrow-left" @click="prevCallback" />
                        <Button label="Next" icon="pi pi-arrow-right" iconPos="right" @click="nextCallback" />
                    </div>
                </template>
            </StepperPanel>
            <StepperPanel header="Header III">
                <template #content="{ prevCallback }">
                    <div class="flex flex-column h-12rem">
                        <div class="border-2 border-dashed surface-border border-round surface-ground flex-auto flex justify-content-center align-items-center font-medium">
                          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Possimus, fugit. Impedit aliquam dolor totam illum suscipit sit ratione magnam corporis dolorem cupiditate, deleniti provident exercitationem autem dolore delectus expedita sequi?
                          Suscipit aperiam sequi itaque vitae adipisci quasi nobis commodi veniam temporibus amet omnis id esse ipsum, mollitia excepturi hic necessitatibus cupiditate pariatur architecto molestiae alias unde laboriosam? Explicabo, hic ipsum!
                        </div>
                    </div>
                    <div class="flex pt-4 justify-content-start">
                        <Button label="Back" severity="secondary" icon="pi pi-arrow-left" @click="prevCallback" />
                    </div>
                </template>
            </StepperPanel>
        </Stepper>
    </div>
</template>
<script setup>

import { ref } from "vue";
import mensajeService from "./../../services/mensaje.service";
const mensaje = ref("");

function enviarMensajeWhatsapp() {
  mensajeService.enviarMensaje({
    messaging_product: "whatsapp",
    to: "59173277937",
    type: "template",
    template: {
      name: "hello_world",
      language: { code: "en_US" },
    },
  });
}

async function enviarMensajeTexto(){
    mensajeService.enviarMensajeTexto(mensaje.value)
}
</script>

<style scoped>
.p-stepper {
    flex-basis: 50rem;
}
</style>