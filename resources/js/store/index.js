import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		badges: {},
	},

	mutations: {
		setBadges(state, badges) {
			state.badges = badges;
		},
	},

	actions: {
		fetchBadges({ commit }) {
			this._vm.$dash.resource("badges").get("", (response) => {
				if (response.data) {
					const badges = response.data.map((b) => {
						let name,
							points,
							badge = ({ name, points } = b.attributes);
						badge.id = b.id;

						return badge;
					});

					commit("setBadges", badges);
				}
			});
		},
	},

	getters: {
		badgesSelect: (state) => {
			return state.badges.map((b) => {
				return {
					text: b.name,
					value: b.id,
				};
			});
		},
	},
});
