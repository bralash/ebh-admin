import Vue from "vue";
import App from "./components/App";
import vuetify from "./plugins/vuetify";
import router from "./plugins/router";

// Vue instantiation
new Vue({
	el: "#app",
	vuetify,
	render: (h) => h(App),
	router,
});
