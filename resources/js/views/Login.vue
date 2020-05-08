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
										prepend-icon="phone"
										type="text"
									/>

									<v-text-field
										id="password"
										label="Password"
										name="password"
										prepend-icon="lock"
										type="password"
									/>

									<v-btn type="submit" color="primary"
										>Login</v-btn
									>
									<v-progress-circular
										v-show="state.loading"
										:indeterminate="state.loading"
										color="primary"
									></v-progress-circular>
								</v-form>
							</v-card-text>
							<v-card-actions>
								<v-spacer />
							</v-card-actions>
						</v-card>
					</v-col>
				</v-row>
			</v-container>
			<v-snackbar v-model="snackbar">
				{{ snackbarText }}
				<v-btn color="pink" text @click="hideSnackbar">
					Close
				</v-btn>
			</v-snackbar>
		</v-content>
	</v-app>
</template>

<script>
import Dash from "../vendor/dash";

export default {
	name: "Login",
	props: {
		source: String,
	},

	data() {
		return {
			state: {
				loading: false,
			},
			snackbar: false,
			snackbarText: "",
		};
	},

	mounted() {
		const $component = this;

		// Form submit handler
		Dash.submit("login-form", (e, formdata, action) => {
			$component.state.loading = true;

			// API call to login
			Dash.post(
				"/login",
				formdata,
				// Success
				(response) => {
					$component.snackbarText = "Loading dashboard...";
					// Show toast
					$component.snackbar = true;

					Dash.reload();
				},
				// config
				{
					error(response) {
						$component.snackbarText = response.errors[0].detail;
						// Show toast
						$component.snackbar = true;
						// Hide loader
						$component.state.loading = false;
					},
				}
			);
		});
	},

	methods: {
		hideSnackbar() {
			this.snackbar = false;
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
