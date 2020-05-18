import Vue from "vue";
import App from "./views/App.vue";
import vuetify from "./plugins/vuetify";
import router from "./plugins/router";
import Dash from "./plugins/dash";
import Page from "./components/Page.vue";
import StatCard from "./components/StatCard.vue";
import Table from "./components/Table.vue";

// Global components
Vue.component("page", Page);
Vue.component("stat-card", StatCard);
Vue.component("Table", Table);

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
