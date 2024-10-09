import { createWebHistory, createRouter } from "vue-router";

const routes = [
    { path: "/", name: "home", component: () => import("./../views/Home.vue") },
    {
        path: "/about",
        name: "about",
        component: () => import("./../views/About.vue"),
    },
    {
        path: "/:pathMatch(.*)*",
        name: "notFound",
        component: () => import("./../views/NotFound.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
