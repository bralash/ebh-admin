<template>
	<v-data-table
		:headers="headers"
		:items="items ? items : []"
		:items-per-page="10"
		class="elevation-1"
		:loading="loading"
	>
		<template v-slot:item.actions="{ item }">
			<v-icon small class="mr-2" @click="emitEdit(item)">
				mdi-pencil
			</v-icon>
			<v-icon small @click="emitDelete(item)">
				mdi-delete
			</v-icon>
		</template>
	</v-data-table>
</template>

<script>
export default {
	name: "Table",
	props: {
		headers: Array,
		filters: Object,
		search: String,
		items: Array,
		loading: Boolean,
	},
	data() {
		return {
			options: {
				page: 1,
				itemsPerPage: 5,
				sortBy: [],
				sortDesc: [],
			},
			filter: {},
		};
	},
	watch: {
		options: "onOptionsChanged",
	},
	methods: {
		emitEdit: function (item) {
			this.$emit("init-edit", item);
		},

		emitDelete: function (item) {
			this.$emit("init-delete", item);
		},
	},
};
</script>
