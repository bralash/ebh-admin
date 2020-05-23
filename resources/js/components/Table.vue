<template>
	<v-data-table
		:headers="headers"
		:items="items ? items : []"
		:items-per-page="10"
		class="elevation-1"
		:loading="loading"
	>
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
		onOptionsChanged() {
			// const sort: { [key]  } = {};
			// for (const i in this.options.sortBy) {
			// 	sort[this.options.sortBy[i]] = this.options.sortDesc[i]
			// 		? "desc"
			// 		: "asc";
			// }
			// this.sort = sort;
		},
	},
};
</script>
