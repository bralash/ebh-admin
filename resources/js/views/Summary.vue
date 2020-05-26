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
		const c = this;
		this.$dash.resource("stats").get("", (response) => {
			if (response.data) {
				const data = response.data;
				let statistics = [];

				for (const key in data) {
					if (data.hasOwnProperty(key)) {
						const element = data[key];

						statistics.push({
							name: element.attributes.name,
							value: element.attributes.value,
						});
					}
				}
				statistics.forEach((stat, index) => {
					stat = Object.assign(stat, c.stats[index]);
				});
				c.stats = statistics;

				// Add to state
				c.$store.commit("updateStats", statistics);
			}
		});
	},
	data() {
		return {
			stats: [
				{
					color: "blue",
					icon: "account-multiple",
				},
				{
					color: "green",
					icon: "account-arrow-right",
				},
				{
					color: "red",
					icon: "water",
				},
				{
					color: "green darken-1",
					icon: "blood-bag",
				},
			],
		};
	},
};
</script>
