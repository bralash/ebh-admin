import Vue from "vue";
import Vuetify from "vuetify/lib";
import "vuetify/dist/vuetify.min.css";

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
