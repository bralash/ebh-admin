<template>
	<v-card class="mx-auto" max-width="344" outlined>
		<v-list-item three-line>
			<v-list-item-content>
				<v-list-item-title class="headline mb-1">{{
					details.value
				}}</v-list-item-title>
				<v-list-item-subtitle>{{ details.name }}</v-list-item-subtitle>
			</v-list-item-content>

			<v-list-item-avatar
				tile
				size="50"
				:color="details.color"
				class="stat-icon-wrap"
			>
				<v-icon color="white">{{ details.icon }}</v-icon>
			</v-list-item-avatar>
		</v-list-item>
	</v-card>
</template>

<script>
export default {
	name: "StatCard",
	props: {
		details: Object,
	},
};
</script>

<style lang="scss" scoped>
.stat-icon-wrap {
	border-radius: 5px;
}
</style>
