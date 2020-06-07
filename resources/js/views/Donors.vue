<template>
	<page name="Donors" desc="Manage all donors">
		<template v-slot:tools>
			<delete-dialog
				v-model="showDeleteDialog"
				:toDelete="activeResource.name"
				resourceType="Donor"
				@delete="deleteResource"
			></delete-dialog>
		</template>
		<stat-card :stats="stats"></stat-card>
		<Table
			resource="Donors"
			:headers="headers"
			:items="donors"
			:loading="loading"
			hide-action="edit"
			@init-delete="initDelete"
			@init-edit="initEdit"
		></Table>
		<toast v-model="toast" :text="toastText"></toast>
	</page>
</template>

<script>
import { ResourceMixin } from "../mixins/default";
import { mapGetters } from "vuex";

export default {
	name: "Donors",
	mixins: [ResourceMixin],
	data() {
		return {
			donors: [],
			loading: true,
			bloodTypeSelect: [],
			stats: [
				{
					name: "Donors",
					value: 0,
					color: "green",
					icon: "account-arrow-right",
				},
			],
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Phone", value: "phone" },
				{ text: "Community", value: "community" },
				{ text: "Blood Type", value: "blood_type" },
				{ text: "Badge", value: "badge" },
				{ text: "Actions", value: "actions", sortable: false },
			],
		};
	},

	computed: {
		...mapGetters(["badgesSelect"]),
	},

	methods: {
		deleteResource() {
			const id = this.activeResource.id;

			this.$dash
				.resource("donors")
				.delete(this.activeResource.id, (response) => {
					if (!response.errors) {
						this.showDeleteDialog = false;
						this.notify(response.meta.message);
						// Remove from local state
						this.donors.splice(
							this.donors.findIndex((el) => el.id == id),
							1
						);
						this.stats[0].value = this.donors.length;
					}
				});
		},
	},

	created() {
		// Donors
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

				this.donors = donors;
				this.loading = false;
				this.stats[0].value = this.donors.length;
			}
		});

		// Blood types
		this.$dash.resource("blood_types").get("", (response) => {
			if (response.data) {
				this.bloodTypeSelect = response.data;
			}
		});
	},
};
</script>
