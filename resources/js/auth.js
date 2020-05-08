import Vue from "vue";
import Dash from "./vendor/dash";
import Login from "./views/Login";
import vuetify from "./plugins/vuetify";

// Vue instantiation
new Vue({
	el: "#app",
	vuetify,
	render: (h) => h(Login),
});

Dash.init({
	baseResourceURL: Dash.select("#login-form").action,
	requestHeaders: [],
});

Dash.config.requestHeaders["X-CSRF-TOKEN"] = Dash.select(
	"meta[name=csrf-token]"
).getAttribute("content");
