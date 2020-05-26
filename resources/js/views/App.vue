<template>
	<v-app id="inspire">
		<v-navigation-drawer v-model="drawer" app clipped>
			<v-list dense>
				<v-list-item
					v-for="item in items"
					:key="item.url"
					:to="item.url"
					active-class=""
				>
					<v-list-item-action>
						<v-icon>mdi-{{ item.icon }}</v-icon>
					</v-list-item-action>
					<v-list-item-content>
						<v-list-item-title>
							{{ item.text }}
						</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
				<v-subheader class="mt-4 grey--text text--darken-1"
					>Quick Actions</v-subheader
				>
				<v-list-item link>
					<v-list-item-action>
						<v-icon color="grey darken-1"
							>mdi-logout-variant</v-icon
						>
					</v-list-item-action>
					<v-list-item-title
						class="grey--text text--darken-1"
						@click="initLogout"
						>Sign Out</v-list-item-title
					>
				</v-list-item>
			</v-list>
		</v-navigation-drawer>

		<v-app-bar app clipped-left color="red" dense class="white--text">
			<v-app-bar-nav-icon @click.stop="drawer = !drawer" />
			<v-icon class="mx-4" large>
				<!-- Replace with logo -->
			</v-icon>
			<v-toolbar-title class="mr-12 align-center">
				<span class="title">EBH Admin</span>
			</v-toolbar-title>
			<v-spacer />
			<v-row align="center" style="max-width: 650px;"> </v-row>
		</v-app-bar>

		<v-content>
			<router-view></router-view>
		</v-content>
	</v-app>
</template>

<script>
export default {
	props: {
		source: String,
		url: String,
	},
	data: () => ({
		drawer: null,
		items: [
			{ icon: "view-dashboard", text: "Summary", url: "/" },
			{ icon: "account-multiple", text: "Users", url: "users" },
			{ icon: "account-arrow-right", text: "Donors", url: "donors" },
			{ icon: "water", text: "Blood Requests", url: "requests" },
			{ icon: "blood-bag", text: "Donations", url: "donations" },
			{ icon: "map-marker", text: "Communities", url: "communities" },
			{ icon: "star-outline", text: "Badges", url: "badges" },
		],
		items2: [{ picture: 28, text: "Joseph" }],
	}),

	methods: {
		initLogout() {
			window.location.href = this.url + "/logout";
		},
	},
};
</script>

<style lang="scss" scoped>
.v-list-item--active {
	color: #d61a01 !important;
}
</style>
