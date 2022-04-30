require("./bootstrap");
window.Vue = require("vue").default;

// import { createApp } from "vue";
// import App from "./components/App.vue";
// import Home from "./components/ExampleComponent.vue";
// import LiveUpcoming from "./components/LiveUpcomingComponent.vue";

// const routes = [
//     {
//         name: "/",
//         path: "/",
//         component: Home,
//     },
//     {
//         name: "/live_upcoming",
//         path: "/live_upcoming",
//         component: LiveUpcoming,
//     },
// ];

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

Vue.component(
    "live-upcoming",
    require("./components/LiveUpcomingComponent.vue").default
);

const app = new Vue({
    el: "#app",
});
