<template>
	<v-dialog :value="value" @input="emitClose" max-width="290">
		<v-card>
			<v-card-title class="headline"
				>Delete {{ resourceType }}</v-card-title
			>
			<v-card-text>
				Are you sure you want to delete
				<b>{{ toDelete }}</b> ?
			</v-card-text>

			<v-card-actions>
				<v-spacer></v-spacer>
				<v-btn color="grey darken-1" @click="emitClose" text>
					Cancel
				</v-btn>
				<v-btn color="red" :loading="loading" @click="emitDelete" text>
					Delete
				</v-btn>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>

<script>
export default {
	name: "DeleteDialog",
	props: {
		resourceType: String,
		toDelete: String,
		value: Boolean,
	},
	data() {
		return {
			loading: false,
		};
	},
	methods: {
		emitDelete() {
			this.loading = true;
			this.$emit("delete");
		},
		emitClose() {
			this.loading = false;
			this.$emit("input", false);
		},
	},
	watch: {
		value: function (newVal) {
			if (newVal == false) this.loading = false;
		},
	},
};
</script>
