import Vue from "vue";
import VueRouter from "vue-router";
import Summary from "../components/Summary";
import Users from "../components/Users";
import Donors from "../components/Donors";
import BloodRequests from "../components/BloodRequests";
import Donations from "../components/Donations";
import Communities from "../components/Communities";
import Badges from "../components/Badges";

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
