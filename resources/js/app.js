import Vue from "vue";
import App from "./views/App";
import vuetify from "./plugins/vuetify";
import router from "./plugins/router";
import Dash from "./plugins/dash";

// Install dashjs plugin
Vue.use(Dash, {
	baseResourceURL: document.querySelector("#aul .resource-url").value,
	requestHeaders: {
		"X-CSRF-TOKEN": document
			.querySelector("meta[name=csrf-token]")
			.getAttribute("content"),
	},
});

// Vue instantiation
new Vue({
	el: "#app",
	vuetify,
	render: (h) =>
		h(App, {
			props: { url: document.querySelector("#aul .app-url").value },
		}),
	router,
});
