<template>
	<page name="Users" desc="Manage all user accounts">
		<stat-card :stats="stats"></stat-card>
		<Table :headers="headers" :items="users"></Table>
	</page>
</template>

<script>
export default {
	name: "Users",
	data() {
		return {
			stats: [
				{
					name: "All Users",
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

				console.log(users);
			}
		});
	},
};
</script>
