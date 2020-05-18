<template>
	<page name="Summary" desc="Here is an overview of things">
		<stat-card :stats="stats"></stat-card>
	</page>
</template>

<script>
import StatCard from "../components/StatCard.vue";
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
