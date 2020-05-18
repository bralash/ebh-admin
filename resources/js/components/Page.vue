<template>
	<v-app>
		<h1 class="">{{ name }}</h1>
		<span class="page-desc">{{ desc }}</span>

		<section class="wrapper">
			<slot> </slot>
		</section>
	</v-app>
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
