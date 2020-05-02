import Vue from "vue";
import Dash from "./vendor/dash";
import Login from "./components/Login";
import vuetify from "./plugins/vuetify";

// Vue instantiation
new Vue({
	el: "#app",
	vuetify,
	render: (h) => h(Login),
});

Dash.init({
	baseResourceURL: Dash.select("#login-form").action,
});

// Form submit handler
Dash.submit("login-form", (e, formdata, action) => {
	// API call to login
	Dash.request(Dash.url("auth"), formdata, (response) => {
		console.log(response);
	});
});
