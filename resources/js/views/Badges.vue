<template>
	<page name="Badges" desc="Manage all blood requests">
		<stat-card :stats="stats"></stat-card>
		<Table :headers="headers" :items="badges" :loading="loading"></Table>
	</page>
</template>

<script>
export default {
	name: "Badges",
	data() {
		return {
			loading: true,
			stats: [
				{
					name: "Badges",
					value: 0,
					color: "primary",
					icon: "star",
				},
			],
			badges: [],
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Points", value: "points" },
			],
		};
	},

	created() {
		const c = this;

		this.$dash.resource("badges").get("", (response) => {
			if (response.data) {
				const badges = response.data.map((b) => {
					let name, points;
					return ({ name, points } = b.attributes);
				});

				c.badges = badges;
				c.loading = false;
				c.stats[0].value = c.badges.length;
			}
		});
	},
};
</script>
