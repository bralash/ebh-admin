// src/plugins/vuetify.js

import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "material-design-icons-iconfont/dist/material-design-icons.css";

Vue.use(Vuetify);

const opts = {
	theme: {
		themes: {
			light: {
				primary: "#D61A01",
			},
		},
	},
};

export default new Vuetify(opts);
