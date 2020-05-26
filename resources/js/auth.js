import Vue from "vue";
import Dash from "./vendor/dash";
import Login from "./views/Login.vue";
import vuetify from "./plugins/vuetify";
import Toast from "./components/Toast.vue";

Vue.component("toast", Toast);

// Vue
new Vue({
	el: "#app",
	vuetify,
	render: (h) => h(Login),
});

Dash.init({
	baseResourceURL: Dash.select("#login-form").action,
	requestHeaders: {
		"X-CSRF-TOKEN": Dash.select("meta[name=csrf-token]").getAttribute(
			"content"
		),
	},
});
