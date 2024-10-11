import "./bootstrap";
import "./../../node_modules/flowbite-vue/dist/index.css";
import { createApp } from "vue";
import Root from "./Root.vue";
import router from "./routes";
import ToastPlugin from "vue-toast-notification";
import 'vue-toast-notification/dist/theme-bootstrap.css';

const app = createApp(Root);
app.use(router);
app.use(ToastPlugin);
app.mount("#app");
