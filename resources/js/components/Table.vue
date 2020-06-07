<template>
	<v-card>
		<v-card-title>
			{{ resource }}
			<v-spacer></v-spacer>
			<v-text-field
				v-model="search"
				append-icon="mdi-magnify"
				label="Search"
				single-line
				hide-details
			></v-text-field>
		</v-card-title>
		<v-data-table
			:headers="headers"
			:items="items ? items : []"
			:items-per-page="10"
			:loading="loading"
			:search="search"
			@click:row="(item) => $emit('click:row', item)"
		>
			<template v-slot:item.actions="{ item }">
				<v-icon
					v-if="hideAction != 'edit'"
					small
					class="mr-2"
					@click="emitEdit(item)"
				>
					mdi-pencil
				</v-icon>
				<v-icon small @click="emitDelete(item)">
					mdi-delete
				</v-icon>
			</template>
		</v-data-table>
	</v-card>
</template>

<script>
export default {
	name: "Table",
	props: {
		resource: String,
		headers: Array,
		items: Array,
		loading: Boolean,
		hideAction: String,
	},
	data() {
		return {
			options: {
				page: 1,
				itemsPerPage: 5,
				sortBy: [],
				sortDesc: [],
			},
			search: "",
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
