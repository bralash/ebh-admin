<template>
	<page name="Donors" desc="Manage all donors">
		<template v-slot:tools>
			<v-dialog v-model="dialog" persistent max-width="600px">
				<template v-slot:activator="{ on }">
					<v-btn color="primary" v-on="on">New </v-btn>
				</template>
				<v-card>
					<v-card-title
						class="headline font-weight-bold grey lighten-2"
					>
						New Donor
					</v-card-title>
					<v-form ref="newUser" id="new-user-form">
						<v-card-text>
							<v-text-field
								label="Name"
								name="name"
								required
							></v-text-field>
							<v-text-field
								label="Phone"
								name="phone"
								required
							></v-text-field>
							<v-text-field
								label="Password"
								type="password"
								name="password"
								required
							></v-text-field>
							<v-select
								:items="bloodTypeSelect"
								label="Blood Type"
								name="blood_type"
								filled
								required
							></v-select>
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="black" text @click="dialog = false"
								>Close</v-btn
							>
							<v-btn
								:loading="requesting"
								color="primary"
								type="submit"
								>Save</v-btn
							>
						</v-card-actions>
					</v-form>
				</v-card>
			</v-dialog>
			<delete-dialog
				:show="showDeleteDialog"
				:toDelete="activeResource.name"
				resourceType="User"
				@delete="deleteResource"
			></delete-dialog>
		</template>
		<stat-card :stats="stats"></stat-card>
		<Table :headers="headers" :items="donors" :loading="loading"></Table>
	</page>
</template>

<script>
import { ResourceMixin } from "../mixins/default";

export default {
	name: "Donors",
	mixins: [ResourceMixin],
	data() {
		return {
			loading: true,
			bloodTypeSelect: [],
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

				c.donors = donors;
				c.loading = false;
				c.stats[0].value = c.donors.length;
			}
		});

		// Blood types
		this.$dash.resource("blood_types").get("", (response) => {
			if (response.data) {
				c.bloodTypeSelect = response.data;
			}
		});
	},
};
</script>
