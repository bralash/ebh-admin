export const ResourceMixin = {
	data() {
		return {
			toast: false,
			toastText: "",
			requesting: false,
			showDeleteDialog: false,
			showEditDialog: false,
			activeResource: {},
		};
	},
	methods: {
		initEdit(item) {
			this.showEditDialog = true;
			this.activeResource = item;
		},

		initDelete(item) {
			this.showDeleteDialog = true;
			this.activeResource = item;
		},

		notify(message) {
			const $comp = this;

			$comp.toastText = message;
			$comp.toast = true;
		},
	},
};
