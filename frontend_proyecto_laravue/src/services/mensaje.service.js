import { Api } from "./meta.service";

export default {
    enviarMensaje: (msg="Hola") => {
        return Api().post('/messages', msg);
    },
    enviarMensajeTexto: (msg = "Hola") => {
        let data = {
            "messaging_product": "whatsapp",
            "recipient_type": "individual",
            "to": "59173277937",
            "type": "text",
            "text": { 
                "preview_url": true,
                "body": msg
            }
        }
        return Api().post('/messages', data);
    }
}