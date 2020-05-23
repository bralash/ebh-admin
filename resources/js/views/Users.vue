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
					<v-form id="new-user-form">
						<v-card-text>
							<v-text-field
								label="Name"
								name="name"
								required
							></v-text-field>
							<v-text-field label="Phone" required></v-text-field>
							<v-text-field
								label="Password"
								type="password"
								name="password"
								required
							></v-text-field>
							<v-select
								:items="userTypeSelect"
								label="Type"
								required
							></v-select>
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn
								color="blue darken-1"
								text
								@click="dialog = false"
								>Close</v-btn
							>
							<v-btn color="blue darken-1" type="submit"
								>Save</v-btn
							>
						</v-card-actions>
					</v-form>
				</v-card>
			</v-dialog>
		</template>
		<stat-card :stats="stats"></stat-card>
		<Table :headers="headers" :items="users" :loading="loading"></Table>
	</page>
</template>

<script>
export default {
	name: "Users",
	data() {
		return {
			dialog: false,
			loading: true,
			stats: [
				{
					name: "Users registered",
					value: 0,
					color: "blue",
					icon: "people",
				},
			],
			users: [],
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Phone", value: "phone" },
				{ text: "Type", value: "user_type" },
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
		this.$dash.submit(
			"new-user-form",
			(e, formdata, action) => {
				console.log(formdata);
			},
			["*"]
		);
	},
};
</script>
