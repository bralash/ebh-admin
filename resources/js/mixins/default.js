export const ResourceMixin = {
	data() {
		return {
			dialog: false,
			toast: false,
			toastText: "",
			requesting: false,
			showDeleteDialog: false,
			activeResource: { name: null },
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
