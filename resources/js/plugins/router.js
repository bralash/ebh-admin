import Vue from "vue";
import VueRouter from "vue-router";
import Summary from "../views/Summary";
import Users from "../views/Users";
import Donors from "../views/Donors";
import BloodRequests from "../views/BloodRequests";
import Donations from "../views/Donations";
import Communities from "../views/Communities";
import Badges from "../views/Badges";

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
