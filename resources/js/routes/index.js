import { createWebHistory, createRouter } from "vue-router";

const routes = [
    { path: "/", name: "home", component: () => import("./../views/Home.vue") },

    {
        path: "/register",
        name: "register",
        component: () => import("./../views/Register.vue"),
    },

    {
        path: "/search",
        name: "search",
        component: () => import("./../views/Search.vue"),
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
