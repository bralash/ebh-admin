<template>
	<page name="Donations" desc="Manage blood donations">
		<stat-card :stats="stats"></stat-card>
		<Table
			resource="Donations"
			:headers="headers"
			:items="donations"
			:loading="loading"
		></Table>
	</page>
</template>

<script>
export default {
	name: "Donations",
	data() {
		return {
			loading: true,
			stats: [
				{
					name: "Donations made",
					value: 0,
					color: "primary",
					icon: "blood-bag",
				},
			],
			donations: [],
			headers: [
				{ text: "Donor", value: "donor" },
				{ text: "Donation Type", value: "donation_type" },
				{ text: "blood Type", value: "blood_type" },
				{ text: "Volume", value: "volume" },
				{ text: "Stage", value: "stage" },
				{ text: "Event", value: "event" },
			],
		};
	},

	created() {
		const c = this;

		this.$dash.resource("donations").get("", (response) => {
			if (response.data) {
				const donations = response.data.map((don) => {
					return {
						donor: don.relationships.donor.firstname,
						donation_type: don.attributes.donation_type,
						blood_type: don.relationships.donor.blood_type.name,
						volume: don.attributes.volume,
						stage: don.attributes.stage,
						event: "n/a",
					};
				});

				c.loading = false;
				c.donations = donations;
				c.stats[0].value = c.donations.length;
			}
		});
	},
};
</script>
