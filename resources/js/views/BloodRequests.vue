<template>
	<page name="Blood Requests" desc="Manage all blood requests">
		<v-dialog v-model="showEditDialog" max-width="600px">
			<v-card>
				<v-card-title class="headline font-weight-bold">
					Request Details
				</v-card-title>
				<v-card-text>
					<v-list-item two-line>
						<v-list-item-content>
							<v-list-item-title>Requested by</v-list-item-title>
							<v-list-item-subtitle>{{
								activeResource.requested_by
							}}</v-list-item-subtitle>
						</v-list-item-content>
					</v-list-item>

					<v-list subheader>
						<v-subheader>Donations</v-subheader>
					</v-list>
				</v-card-text>
			</v-card>
		</v-dialog>
		<stat-card :stats="stats"></stat-card>
		<Table
			resource="Requests"
			:headers="headers"
			:items="requests"
			:loading="loading"
			@click:row="showDetailsModal"
		></Table>
	</page>
</template>

<script>
import { ResourceMixin } from "../mixins/default";

export default {
	name: "BloodRequests",
	mixins: [ResourceMixin],
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

	methods: {
		showDetailsModal(item) {
			this.activeResource = item;
			this.showEditDialog = true;
		},
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
