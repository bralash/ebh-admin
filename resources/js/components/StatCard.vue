<template>
	<v-row>
		<v-col v-for="stat in stats" :key="stat.name">
			<v-card class="" max-width="344" outlined>
				<v-list-item three-line>
					<v-list-item-content>
						<v-list-item-title
							v-if="stat.value"
							class="headline mb-1"
							>{{ stat.value }}</v-list-item-title
						>
						<v-list-item-subtitle>{{
							stat.name
						}}</v-list-item-subtitle>
					</v-list-item-content>

					<v-list-item-avatar
						tile
						size="50"
						:color="stat.color"
						class="stat-icon-wrap"
					>
						<v-icon color="white">{{ stat.icon }}</v-icon>
					</v-list-item-avatar>
				</v-list-item>
			</v-card>
		</v-col>
	</v-row>
</template>

<script>
export default {
	name: "StatCard",
	props: {
		stats: Array,
	},
};
</script>

<style lang="scss" scoped>
.stat-icon-wrap {
	border-radius: 5px;
}
</style>
