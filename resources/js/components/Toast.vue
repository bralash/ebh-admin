<template>
	<v-snackbar :value="value" @input="emitClose" :timeout="4000" top>
		{{ text }}
		<v-btn color="pink" text @click="emitClose">
			Close
		</v-btn>
	</v-snackbar>
</template>

<script>
export default {
	name: "Toast",
	props: {
		text: String,
		value: Boolean,
	},
	methods: {
		emitClose() {
			this.$emit("input", false);
		},
	},
};
</script>
