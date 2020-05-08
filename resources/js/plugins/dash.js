import Dash from "../vendor/dash";

export default {
	install(Vue, options) {
		// Initialize dashjs
		Vue.prototype.$dash = Dash.init(options);
	},
};
