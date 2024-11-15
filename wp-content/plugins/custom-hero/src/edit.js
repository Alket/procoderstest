import {
	InnerBlocks,
	MediaUpload,
	MediaUploadCheck,
	useBlockProps,
} from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

const ALLOWED_BLOCKS_LEFT = ["core/heading", "core/paragraph", "core/buttons"];

export default function Edit({ attributes, setAttributes }) {
	const { imageUrl } = attributes;

	return (
		<div {...useBlockProps()}>
			<div style={{ display: "flex", width: "100%", height: "100%" }}>
				{/* Left Section*/}
				<div
					style={{
						flex: 1,
						background:
							"linear-gradient(160.89deg, #EE1251 0%, #6729C1 68.46%, #1D35FD 117%)",
						padding: "20px",
					}}
				>
					<InnerBlocks allowedBlocks={ALLOWED_BLOCKS_LEFT} />
				</div>

				{/* Right Section with Image */}
				<div style={{ flex: 1 }}>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={(media) => setAttributes({ imageUrl: media.url })}
							allowedTypes={["image"]}
							value={imageUrl}
							render={({ open }) => (
								<Button onClick={open}>
									{!imageUrl
										? __("Upload Image", "custom-hero")
										: __("Change Image", "custom-hero")}
								</Button>
							)}
						/>
					</MediaUploadCheck>
					{imageUrl && (
						<img
							src={imageUrl}
							alt="Hero Image"
							style={{ width: "100%", height: "100%", objectFit: "cover" }}
						/>
					)}
				</div>
			</div>
		</div>
	);
}
