<template>
	<v-app id="inspire">
		<v-content>
			<v-container class="fill-height" fluid>
				<v-row align="center" justify="center">
					<v-col cols="12" sm="8" md="4">
						<div class="logo">
							<img src="/img/logo-icon.png" alt="EBH" />
						</div>
						<v-card class="elevation-12">
							<v-toolbar color="primary" dark flat>
								<v-toolbar-title>Login</v-toolbar-title>
							</v-toolbar>
							<v-card-text>
								<v-form action="/api/v1" id="login-form">
									<v-text-field
										label="Phone"
										name="phone"
										prepend-icon="mdi-phone"
										type="text"
									/>

									<v-text-field
										id="password"
										label="Password"
										name="password"
										prepend-icon="mdi-lock"
										type="password"
									/>

									<v-btn
										:loading="loading"
										type="submit"
										color="primary"
										@click.prevent="submit"
										>Login</v-btn
									>
								</v-form>
							</v-card-text>
							<v-card-actions>
								<v-spacer />
							</v-card-actions>
						</v-card>
					</v-col>
				</v-row>
			</v-container>
			<toast v-model="toast" :text="toastText"></toast>
		</v-content>
	</v-app>
</template>

<script>
import Dash from "../vendor/dash";
import { ResourceMixin } from "../mixins/default";

export default {
	name: "Login",
	props: {
		source: String,
	},
	mixins: [ResourceMixin],
	data() {
		return {
			loading: false,
			toast: false,
			toastText: "",
		};
	},
	methods: {
		submit() {
			Dash.submitAll(
				"login-form",
				(formdata) => {
					this.loading = true;

					Dash.post(
						"/login",
						formdata,
						// Success
						(response) => {
							if (response.data) {
								this.toastText = "Loading dashboard...";
								this.toast = true;

								Dash.reload();
							}
						},
						// config
						{
							error: (response) => {
								this.toastText = response.errors[0].detail;
								this.toast = true;
								this.loading = false;
							},
						}
					);
				},
				(e) => {
					this.notify(
						"The " + e.inputs[0].name + " field is required"
					);
				}
			);
		},
	},
};
</script>

<style lang="sass">
.logo {
	margin: 0 0 2em;
	text-align: center;

	img {
		width: 7em;
	}
}
</style>
