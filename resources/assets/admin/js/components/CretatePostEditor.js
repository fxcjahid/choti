/**
 * setup code editorjs
 * Document: https://github.com/editor-js
 * Plugin: https://github.com/editor-js/awesome-editorjs
 **/
import EditorJS from "../vendor/@editorjs/editorjs";
import Header from "@editorjs/header";
import NestedList from "@editorjs/nested-list";
import Table from "@editorjs/table";
import Embed from "@editorjs/embed";
import LinkAutocomplete from "@editorjs/link-autocomplete";
import ImageTool from "@editorjs/image";
import Underline from "@editorjs/underline";
import Alert from "editorjs-alert";
import ChangeCase from "editorjs-change-case";
const LinkTool = require("@editorjs/link");
const RawTool = require("@editorjs/raw");
const Checklist = require("@editorjs/checklist");
const Warning = require("@editorjs/warning");
const TableContent = require("@editorjs/table-of-content");
const Idea = require("@editorjs/idea");
const Marker = require("@editorjs/marker");
const Paragraph = require("@editorjs/paragraph");
const AlignmentTuneTool = require("editorjs-text-alignment-blocktune");
const ImageGallery = require("@rodrigoodhin/editorjs-image-gallery");
const Hyperlink = require("editorjs-hyperlink");

export default {
	template: '<div id="editorjs"></div>',
	props: ["setdata"],
	methods: {
		setupEditor() {
			const setData = JSON.parse(this.setdata);
			window.EditorJS = new EditorJS({
				placeholder: "Let`s write an awesome story!",
				tools: {
					alignment: {
						class: AlignmentTuneTool,
						config: {
							default: "left",
							blocks: {
								header: "left",
								list: "left",
							},
						},
					},
					header: {
						class: Header,
						shortcut: "CMD+SHIFT+H",
						config: {
							placeholder: "Enter a heading",
							levels: [1, 2, 3, 4, 5, 6],
							defaultLevel: 1,
						},
						tunes: ["alignment"],
					},
					paragraph: {
						class: Paragraph,
						inlineToolbar: true,
						tunes: ["alignment"],
					},
					list: {
						class: NestedList,
						inlineToolbar: true,
					},
					table: {
						class: Table,
						inlineToolbar: true,
						config: {
							rows: 2,
							cols: 3,
						},
					},
					linkTool: {
						class: LinkTool,
						config: {
							// Your backend endpoint for url data fetching.
							// https://github.com/editor-js/link#backend-response-format-
							endpoint: "https://codex.so/editor/fetchUrl?",
						},
					},
					embed: Embed,
					underline: Underline,
					raw: RawTool,
					imageGallery: ImageGallery,
					link: {
						class: LinkAutocomplete,
						config: {
							// https://github.com/editor-js/link-autocomplete
							endpoint: "https://codex.so/editor/fetchUrl?",
							queryParam: "search",
						},
					},
					image: {
						class: ImageTool,
						config: {
							field: "image",
							endpoints: {
								/**
								 * https://github.com/editor-js/image
								 * */
								byFile: route("admin.editorjs.byFile"), // Your backend file uploader endpoint
								byUrl: route("admin.editorjs.byURL"), // Your endpoint that provides uploading by Url
							},
							additionalRequestHeaders: {
								"X-CSRF-TOKEN": $(
									'meta[name="csrf-token"]'
								).attr("content"),
							},
						},
						tunes: ["alignment"],
					},
					TableContent: {
						class: TableContent,
						config: {
							title: 'Table of content',
						}
					},
					checklist: {
						class: Checklist,
						inlineToolbar: true,
					},
					warning: {
						class: Warning,
						inlineToolbar: true,
						shortcut: "CMD+SHIFT+W",
						config: {
							titlePlaceholder: "Title",
							messagePlaceholder: "Message",
						},
					},
					Idea: {
						class: Idea,
						inlineToolbar: true,
						shortcut: "CMD+SHIFT+W",
						config: {
							titlePlaceholder: "Title",
							messagePlaceholder: "Message",
						},
					},
					Marker: {
						class: Marker,
						shortcut: "CMD+SHIFT+M",
					},
					alert: {
						class: Alert,
						inlineToolbar: true,
						shortcut: "CMD+SHIFT+A",
						config: {
							defaultType: "primary",
							messagePlaceholder: "Enter something",
						},
						tunes: ["alignment"],
					},
					hyperlink: {
						class: Hyperlink,
						config: {
							shortcut: "CMD+L",
							target: "_self",
							rel: "dofollow",
							availableTargets: ["_self", "_blank", "_parent"],
							availableRels: [
								"dofollow",
								"author",
								"nofollow",
								"noreferrer",
								"bookmark",
								"help",
								"external",
								"search",
								"tag",
							],
							validate: true,
						},
					},
					changeCase: {
						class: ChangeCase,
					},
				},
				onChange: function (api, event) {
					//console.log("something changed", event);
				},
				data: setData,
			});
		},
	},
	mounted() {
		this.setupEditor();
	},
}; 