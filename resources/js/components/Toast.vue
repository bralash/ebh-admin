<template>
	<v-snackbar v-model="show" :timeout="4000" top>
		{{ text }}
		<v-btn color="pink" text @click="show = false">
			Close
		</v-btn>
	</v-snackbar>
</template>

<script>
export default {
	name: "Toast",
	props: {
		show: Boolean,
		text: String,
	},
};
</script>
