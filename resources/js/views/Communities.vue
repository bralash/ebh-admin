<template>
	<page name="Communities" desc="Manage all blood requests">
		<stat-card :stats="stats"></stat-card>
		<Table
			:headers="headers"
			:items="communities"
			:loading="loading"
		></Table>
	</page>
</template>

<script>
export default {
	name: "Communities",
	data() {
		return {
			loading: true,
			stats: [
				{
					name: "Communities",
					color: "grey darken-2",
					value: 0,
					icon: "place",
				},
			],
			communities: [],
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Region", value: "region" },
				{ text: "District", value: "district" },
				{ text: "GPS Adress", value: "gps" },
			],
		};
	},

	created() {
		const c = this;

		this.$dash.resource("communities").get("", (response) => {
			if (response.data) {
				const communities = response.data.map((comm) => {
					return comm.attributes;
				});

				c.communities = communities;
				c.loading = false;
				c.stats[0].value = c.communities.length;
			}
		});
	},
};
</script>
