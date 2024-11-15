import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function Save({ attributes }) {
	const { imageUrl } = attributes;

	return (
		<div
			{...useBlockProps.save()}
			className="wp-block-custom-hero-custom-hero"
			style={{
				background:
					"linear-gradient(160.89deg, #EE1251 0%, #6729C1 68.46%, #1D35FD 117%)",
			}}
		>
			<div
				className="hero-section"
				style={{ display: "flex", width: "100%", height: "800px" }}
			>
				<div className="elipse elipse01"></div>
				<div className="elipse elipse02"></div>
				<div className="elipse elipse03"></div>

				{/* Left Section */}
				<div className="left-col col">
					<InnerBlocks.Content />
				</div>

				{/* Right Section with Image */}
				<div className="right-col col">
					{imageUrl && (
						<img
							src={imageUrl}
							alt="Hero Image"
							style={{ width: "100%", height: "100%" }}
						/>
					)}
				</div>
			</div>
		</div>
	);
}
