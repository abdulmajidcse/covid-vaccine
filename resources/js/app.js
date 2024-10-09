import "./bootstrap";
import { createApp } from "vue";
import Root from "./Root.vue";
import router from "./routes";

const app = createApp(Root);
app.use(router);
app.mount("#app");
