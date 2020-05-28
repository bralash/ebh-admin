<template>
	<page name="Users" desc="Manage all user accounts">
		<template v-slot:tools>
			<v-dialog v-model="dialog" persistent max-width="600px">
				<template v-slot:activator="{ on }">
					<v-btn color="primary" v-on="on">New </v-btn>
				</template>
				<v-card>
					<v-card-title
						class="headline font-weight-bold grey lighten-2"
					>
						User Profile
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
								:items="userTypeSelect"
								label="Type"
								name="type"
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
		<Table
			:headers="headers"
			:items="users"
			:loading="loading"
			@init-delete="initDelete"
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
					text: "Donor",
					value: 2,
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

	mounted() {
		const $comp = this;

		this.$dash.submitAll(
			"new-user-form",
			(e, formdata, action) => {
				const type = this.$dash.select("[name=type]").value;
				if (type == "") {
					$comp.notify("The type field is required");
					return;
				}

				$comp.requesting = true;
				// API request
				this.$dash.resource("users").create(
					formdata,
					(response) => {
						if (response.data) {
							$comp.notify("User created successfully");
							this.$refs.newUser.reset();
							$comp.dialog = false;

							let id, name, phone, user_type;
							$comp.users.push(
								({
									id,
									name,
									phone,
									user_type,
								} = response.data.attributes)
							);

							$comp.stats[0].value = $comp.users.length;
						}
						$comp.requesting = false;
					},
					{
						error({ errors }) {
							$comp.notify(errors[0].detail);
							$comp.requesting = false;
						},
					}
				);
			},
			(e) => {
				$comp.notify("The " + e.inputs[0].name + " is required");
			}
		);
	},

	methods: {
		initDelete(item) {
			this.showDeleteDialog = true;
			this.activeResource = item;
		},

		deleteResource() {
			const id = this.activeResource.id,
				$comp = this;

			this.$dash.resource("users").delete(id, (response) => {
				if (!response.errors) {
					this.showDeleteDialog = false;
					$comp.notify(response.meta.message);
					// Remove from local state
					this.users.splice(
						this.users.findIndex((el) => el.id == id),
						1
					);
					$comp.stats[0].value = $comp.users.length;
				}
			});
		},
	},
};
</script>
