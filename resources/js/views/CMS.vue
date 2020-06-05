<template>
	<page name="Content" desc="Manage application content">
		<v-card class="" max-width="344">
			<v-card-text>
				<div><v-icon>mdi-information</v-icon> Info</div>
				<p class="display-1 text--primary">Why donate blood?</p>
				<div class="text--primary">No content added</div>
			</v-card-text>
			<v-card-actions>
				<v-btn text color="deep-purple accent-4">
					Edit
				</v-btn>
			</v-card-actions>
		</v-card>
		<toast :show="toast" :text="toastText"></toast>
	</page>
</template>

<script>
import { ResourceMixin } from "../mixins/default";

export default {
	name: "CMS",
	mixins: [ResourceMixin],
};
</script>
