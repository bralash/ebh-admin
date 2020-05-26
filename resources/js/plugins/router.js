import Vue from "vue";
import VueRouter from "vue-router";

const Summary = () => import("../views/Summary.vue");
const Users = () => import("../views/Users.vue");
const Donors = () => import("../views/Donors.vue");
const BloodRequests = () => import("../views/BloodRequests.vue");
const Donations = () => import("../views/Donations.vue");
const Communities = () => import("../views/Communities.vue");
const Badges = () => import("../views/Badges.vue");

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
