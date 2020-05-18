<template>
	<page name="Donors" desc="Manage all donors">
		<stat-card :stats="stats"></stat-card>
		<Table :headers="headers" :items="donors"></Table>
	</page>
</template>

<script>
export default {
	name: "Donors",
	data() {
		return {
			stats: [
				{
					name: "Donors",
					value: 0,
					color: "green",
					icon: "person",
				},
			],
			donors: [],
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Phone", value: "phone" },
				{ text: "Community", value: "community" },
				{ text: "Blood Type", value: "blood_type" },
				{ text: "Badge", value: "badge" },
			],
		};
	},

	created() {
		const c = this;

		this.$dash.resource("donors").get("", (response) => {
			if (response.data) {
				const donors = response.data.map((donor) => {
					return {
						id: donor.id,
						name:
							donor.attributes.firstname +
							" " +
							donor.attributes.lastname,
						phone: donor.attributes.phone,
						community: donor.relationships.community.name,
						blood_type: donor.relationships.blood_type.name,
						badge: donor.relationships.badge.name,
					};
				});

				c.donors = donors;
			}
		});
	},
};
</script>
