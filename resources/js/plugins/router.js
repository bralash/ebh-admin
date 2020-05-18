import Vue from "vue";
import VueRouter from "vue-router";
import Summary from "../views/Summary.vue";
import Users from "../views/Users.vue";
import Donors from "../views/Donors.vue";
import BloodRequests from "../views/BloodRequests.vue";
import Donations from "../views/Donations.vue";
import Communities from "../views/Communities.vue";
import Badges from "../views/Badges.vue";

Vue.use(VueRouter);

export default new VueRouter({
	// Routes definition
	routes: [
		{
			path: "/",
			component: Summary,
			name: "summary",
		},
		{
			path: "/users",
			component: Users,
			name: "users",
		},
		{
			path: "/donors",
			component: Donors,
			name: "donors",
		},
		{
			path: "/requests",
			component: BloodRequests,
			name: "requests",
		},
		{
			path: "/donations",
			component: Donations,
			name: "donations",
		},
		{
			path: "/communities",
			component: Communities,
			name: "communities",
		},
		{
			path: "/badges",
			component: Badges,
			name: "badges",
		},
	],
});
