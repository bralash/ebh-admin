import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		stats: {},
	},

	mutations: {
		updateStats(state, stats) {
			state.stats = stats;
		},
	},
});
