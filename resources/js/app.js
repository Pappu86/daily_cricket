require("./bootstrap");

window.Vue = require("vue").default;

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

Vue.component(
    "live-upcoming",
    require("./components/LiveUpcomingComponent.vue").default
);

Vue.component("home", require("./components/HomeComponent.vue").default);

const app = new Vue({
    el: "#app",
});
