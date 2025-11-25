module.exports = {
	icon: false,
	dimensions: false,
	expandProps: 'end',
	ref: false,
	memo: false,
	svgProps: {
		height: '{props.size}',
		width: '{props.size}',
	},
	svgo: true,
	svgoConfig: {
		plugins: [
			{
				name: 'convertColors',
				params: { currentColor: true },
			},
		],
	},
};
