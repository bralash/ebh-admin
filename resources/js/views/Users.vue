<template>
	<page name="Users" desc="Manage all user accounts">
		<template v-slot:tools>
			<v-dialog v-model="showEditDialog" persistent max-width="600px">
				<template v-slot:activator="{ on }">
					<v-btn color="primary" v-on="on">New </v-btn>
				</template>
				<v-card>
					<v-card-title
						class="headline font-weight-bold grey lighten-2"
					>
						User Details
					</v-card-title>
					<v-form ref="newUserForm" id="new-user-form">
						<v-card-text>
							<v-text-field
								label="Name"
								name="name"
								v-model="activeResource.name"
								required
							></v-text-field>
							<v-text-field
								label="Phone"
								name="phone"
								v-model="activeResource.phone"
								required
							></v-text-field>
							<v-text-field
								label="Password"
								type="password"
								name="password"
								required
							></v-text-field>

							<v-select
								v-if="!activeResource.id"
								:items="userTypeSelect"
								label="Type"
								name="type"
								filled
								required
							></v-select>
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn
								color="black"
								text
								@click="showEditDialog = false"
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
			<delete-dialog
				v-model="showDeleteDialog"
				:toDelete="activeResource.name"
				resourceType="User"
				@delete="deleteResource"
			></delete-dialog>
		</template>
		<stat-card :stats="stats"></stat-card>
		<Table
			:headers="headers"
			:items="users"
			:loading="loading"
			@init-delete="initDelete"
			@init-edit="initEdit"
		>
		</Table>
		<toast :show="toast" :text="toastText"></toast>
	</page>
</template>

<script>
import { ResourceMixin } from "../mixins/default";

export default {
	name: "Users",
	mixins: [ResourceMixin],
	data() {
		return {
			loading: true,
			stats: [
				{
					name: "Users registered",
					value: 0,
					color: "blue",
					icon: "account-multiple",
				},
			],
			users: [],
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Phone", value: "phone" },
				{ text: "Type", value: "user_type" },
				{ text: "Actions", value: "actions", sortable: false },
			],
			userTypeSelect: [
				{ text: "General", value: 1 },
				{
					text: "Admin",
					value: 5,
				},
				{
					text: "Blood bank contact",
					value: 3,
				},
				{
					text: "Organization contact",
					value: 4,
				},
			],
		};
	},

	created() {
		const c = this;

		this.$dash.resource("users").get("", (response) => {
			if (response.data) {
				const users = response.data.map((user) => {
					let id, name, phone, user_type;
					return ({ id, name, phone, user_type } = user.attributes);
				});

				c.users = users;
				c.loading = false;
				c.stats[0].value = c.users.length;
			}
		});
	},

	methods: {
		deleteResource() {
			const id = this.activeResource.id;

			this.$dash.resource("users").delete(id, (response) => {
				if (!response.errors) {
					this.showDeleteDialog = false;
					this.notify(response.meta.message);
					// Remove from local state
					this.users.splice(
						this.users.findIndex((el) => el.id == id),
						1
					);
					this.stats[0].value = this.users.length;
				}
			});
		},

		mutateResource() {
			const id = this.activeResource.id,
				data = this.$dash.form.serializeData(
					this.$refs.newUserForm.$el
				);

			if (this.activeResource.hasOwnProperty("id")) {
				// Update user
				this.$dash.resource("users").update(
					id,
					data,
					(response) => {
						if (!response.error) {
							this.showEditDialog = false;
							this.notify("User updated succefully");
						}
					},
					{
						usePost: true,
					}
				);
			} else {
				// Create user
				this.$dash.submitAll(
					"new-user-form",
					(formdata) => {
						const type = this.$dash.select("[name=type]").value;

						if (type == "") {
							this.notify("The type field is required");
							return;
						}

						this.requesting = true;
						// API request
						this.$dash.resource("users").create(
							formdata,
							(response) => {
								if (response.data) {
									this.notify("User created successfully");
									this.$refs.newUserForm.reset();
									this.showEditDialog = false;

									let id, name, phone, user_type;
									this.users.push(
										({
											id,
											name,
											phone,
											user_type,
										} = response.data.attributes)
									);

									this.stats[0].value = this.users.length;
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
			}
		},
	},
};
</script>
