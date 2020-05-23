<template>
	<section>
		<v-toolbar class="mt-8" flat>
			<div>
				<h1 class="display-1 font-weight-bold">{{ name }}</h1>
				<span class="page-desc">{{ desc }}</span>
			</div>
			<v-spacer></v-spacer>
			<slot name="tools"></slot>
		</v-toolbar>

		<v-container class="fill-height">
			<slot> </slot>
		</v-container>
	</section>
</template>

<script>
export default {
	name: "Page",
	props: {
		name: String,
		desc: String,
	},
};
</script>
