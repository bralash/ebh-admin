export const ResourceMixin = {
	data() {
		return {
			toast: false,
			toastText: "",
			requesting: false,
			showDeleteDialog: false,
			showEditDialog: false,
			activeResourceModel: {},
			activeResource: {},
		};
	},
	methods: {
		initEdit(item) {
			this.showEditDialog = true;
			this.activeResourceModel = Object.assign({}, item);
			this.activeResource = item;
		},

		initDelete(item) {
			this.showDeleteDialog = true;
			this.activeResourceModel = Object.assign({}, item);
			this.activeResource = item;
		},

		notify(message) {
			this.toastText = message;
			this.toast = true;
		},

		triggerEditDialog() {
			this.showEditDialog = true;
			this.activeResource = {};
		},
	},
};
