<template>
	<v-dialog v-model="show" max-width="290">
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
				<v-btn color="grey darken-1" @click="show = false" text>
					Cancel
				</v-btn>
				<v-btn color="red" @click="emitDelete" text>
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
		show: Boolean,
	},
	data() {
		return {
			showSelf: this.show || true,
		};
	},
	methods: {
		emitDelete() {
			this.$emit("delete");
		},
	},
};
</script>
