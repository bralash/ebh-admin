export const NotificationMixin = {
	data() {
		return {
			toast: false,
			toastText: "",
		};
	},
	methods: {
		notify(message) {
			const $comp = this;

			$comp.toastText = message;
			$comp.toast = true;
		},
	},
};
