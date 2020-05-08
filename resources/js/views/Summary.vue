<template>
	<v-app>
		<h1 class="ma-1">Summary</h1>
		<v-row>
			<v-col v-for="stat in stats" :key="stat.name">
				<stat-card :details="stat"></stat-card>
			</v-col>
		</v-row>
	</v-app>
</template>

<script>
import StatCard from "../components/StatCard";
import Dash from "../vendor/dash";

export default {
	name: "Summary",
	components: {
		StatCard,
	},

	created() {
		// Get stats from API
		this.$dash.resource("stats").get("", (response) => {});
	},

	data() {
		return {
			stats: [
				{
					color: "blue",
					icon: "people",
				},
				{
					color: "green",
					icon: "person",
				},
				{
					color: "red",
					icon: "opacity",
				},
				{
					color: "green darken-1",
					icon: "eco",
				},
			],
		};
	},
};
</script>
