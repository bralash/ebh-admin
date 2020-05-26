<template>
	<page name="Blood Requests" desc="Manage all blood requests">
		<stat-card :stats="stats"></stat-card>
		<Table :headers="headers" :items="requests" :loading="loading"></Table>
	</page>
</template>

<script>
export default {
	name: "BloodRequests",
	data() {
		return {
			loading: true,
			stats: [
				{
					name: "Blood Requests",
					value: 0,
					color: "primary",
					icon: "water",
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
					const rel = request.relationships;

					return {
						requested_by: rel.requester.name,
						phone: rel.requester.phone,
						community: rel.location.name,
						blood_type: rel.blood_type.name,
						donations: rel.donations.length,
					};
				});

				c.requests = requests;
				c.stats[0].value = c.requests.length;
				c.loading = false;
			}
		});
	},
};
</script>
