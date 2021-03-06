import Vue from "vue";
import App from "./views/App.vue";
import vuetify from "./plugins/vuetify";
import router from "./plugins/router";
import Dash from "./plugins/dash";
import store from "./store";
import Page from "./components/Page.vue";
import StatCard from "./components/StatCard.vue";
import Table from "./components/Table.vue";
import Toast from "./components/Toast.vue";
import DeleteDialog from "./components/DeleteDialog.vue";

// Global components
Vue.component("page", Page);
Vue.component("stat-card", StatCard);
Vue.component("Table", Table);
Vue.component("toast", Toast);
Vue.component("delete-dialog", DeleteDialog);

// Install dashjs plugin
Vue.use(Dash, {
	baseResourceURL: document.querySelector("#aul .resource-url").value,
	requestHeaders: {
		"X-CSRF-TOKEN": document
			.querySelector("meta[name=csrf-token]")
			.getAttribute("content"),
	},
});

// Vue
new Vue({
	el: "#app",
	vuetify,
	store,
	render: (h) =>
		h(App, {
			props: { url: document.querySelector("#aul .app-url").value },
		}),
	router,
});
