<template>
	<page name="Communities" desc="Manage all blood requests">
		<template v-slot:tools>
			<v-btn color="primary" @click="triggerEditDialog">New</v-btn>
			<v-dialog v-model="showEditDialog" max-width="600px">
				<v-card>
					<v-card-title
						class="headline font-weight-bold grey lighten-2"
					>
						Community Details
					</v-card-title>
					<v-form ref="communityForm" id="community-form">
						<v-card-text>
							<v-text-field
								label="Name"
								name="name"
								maxlength="50"
								required
							></v-text-field>

							<v-select
								:items="regionSelect"
								label="Region"
								name="region"
								required
							></v-select>
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn
								color="black"
								text
								@click="this.showEditDialog = false"
								>Close</v-btn
							>
							<v-btn
								:loading="requesting"
								color="primary"
								type="submit"
								@click.prevent="mutateResource"
								>Save</v-btn
							>
						</v-card-actions>
					</v-form>
				</v-card>
			</v-dialog>
		</template>

		<stat-card :stats="stats"></stat-card>
		<Table
			resource="Communities"
			:headers="headers"
			:items="communities"
			:loading="loading"
		></Table>
		<toast v-model="toast" :text="toastText"></toast>
	</page>
</template>

<script>
import { ResourceMixin } from "../mixins/default";

export default {
	name: "Communities",
	mixins: [ResourceMixin],
	data() {
		return {
			loading: true,
			stats: [
				{
					name: "Communities",
					color: "grey darken-4",
					value: 0,
					icon: "map-marker",
				},
			],
			communities: [],
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Region", value: "region" },
			],

			regionSelect: [
				"Ashanti",
				"Bono Region",
				"Bono East Region",
				"Ahafo Region",
				"Central",
				"Eastern",
				"Greater Accra",
				"Northern",
				"Savannah",
				"North East",
				"Upper East",
				"Upper West",
				"Volta Region",
				"Oti",
				"Western Region",
				"Western North",
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
				c.stats[0].value = response.meta.total;
			}
		});
	},

	methods: {
		mutateResource() {
			this.$dash.submitAll(
				"community-form",
				(formdata) => {
					this.requesting = true;
					// API request
					this.$dash.resource("communities").create(
						formdata,
						(response) => {
							if (response.data) {
								this.notify("Community created successfully");
								this.$refs.communityForm.reset();
								this.showEditDialog = false;

								let id, name, region, user_type;
								this.communities.push(
									({
										id,
										name,
										region,
									} = response.data.attributes)
								);

								this.stats[0].value = this.communities.length;
							}

							this.requesting = false;
						},
						{
							error({ errors }) {
								this.notify(errors[0].detail);
								this.requesting = false;
							},
						}
					);
				},
				(e) => {
					this.notify("The " + e.inputs[0].name + " is required");
				}
			);
		},
	},
};
</script>
