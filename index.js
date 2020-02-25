panel.plugin("medienbaecker/likes", {
	fields: {
		likes: {
			props: {
				label: String,
				help: String,
				likeCount: String
			},
			template: `
			<k-field class="k-likes-field" disabled="true" :label="label" :help="help">
				<k-input icon="heart" theme="field" type="text" name="textfield" :value="likeCount">
			</k-field>
			`
		}
	}
});