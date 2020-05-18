<template>
	<page name="Communities" desc="Manage all blood requests">
		<stat-card :stats="stats"></stat-card>
		<Table :headers="headers" :items="requests"></Table>
	</page>
</template>

<script>
export default {
	name: "Communities",
	data() {
		return {
			stats: [
				{
					name: "Blood Requests",
					value: 0,
					color: "primary",
					icon: "opacity",
				},
			],
			requests: [],
			headers: [
				{ text: "Requested by", value: "requested_by" },
				{ text: "Phone", value: "phone" },
				{ text: "Community", value: "community" },
				{ text: "Blood Type", value: "blood_type" },
				{ text: "Donations", value: "donations" },
			],
		};
	},

	created() {
		const c = this;

		this.$dash.resource("blood_requests").get("", (response) => {
			if (response.data) {
				const requests = response.data.map((request) => {
					return {
						requested_by: request.relationships.requester.name,
						phone: request.relationships.requester.phone,
						community: request.relationships.location.name,
						blood_type: request.relationships.blood_type.name,
						donations: request.relationships.donations.length,
					};
				});

				c.requests = requests;
			}
		});
	},
};
</script>
