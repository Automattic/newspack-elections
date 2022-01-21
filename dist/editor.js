/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@wordpress/icons/build-module/library/more.js":
/*!********************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/more.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ \"@wordpress/primitives\");\n/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);\n\n\n/**\n * WordPress dependencies\n */\n\nconst more = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {\n  viewBox: \"0 0 24 24\",\n  xmlns: \"http://www.w3.org/2000/svg\"\n}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {\n  d: \"M4 9v1.5h16V9H4zm12 5.5h4V13h-4v1.5zm-6 0h4V13h-4v1.5zm-6 0h4V13H4v1.5z\"\n}));\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (more);\n//# sourceMappingURL=more.js.map\n\n//# sourceURL=webpack://Govpack/./node_modules/@wordpress/icons/build-module/library/more.js?");

/***/ }),

/***/ "./assets/js/src/editor/blocks/profile-meta-selected.js":
/*!**************************************************************!*\
  !*** ./assets/js/src/editor/blocks/profile-meta-selected.js ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ \"./node_modules/@babel/runtime/helpers/esm/defineProperty.js\");\n/* harmony import */ var _babel_runtime_helpers_objectSpread2__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/objectSpread2 */ \"./node_modules/@babel/runtime/helpers/esm/objectSpread2.js\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/blocks */ \"@wordpress/blocks\");\n/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ \"@wordpress/i18n\");\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! lodash */ \"lodash\");\n/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_5__);\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/block-editor */ \"@wordpress/block-editor\");\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_7__);\n/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/core-data */ \"@wordpress/core-data\");\n/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_8__);\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__);\n/* harmony import */ var _components_profile_selector__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../components/profile-selector */ \"./assets/js/src/editor/components/profile-selector.js\");\n\n\n\n\n\nvar __ = _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__;\n\n\n\n\n\n\n\n\n\nvar ListItem = function ListItem(props) {\n  console.log(props);\n\n  var updateMeta = function updateMeta(newValue) {\n    console.log(newValue, props);\n    props.setMeta((0,_babel_runtime_helpers_objectSpread2__WEBPACK_IMPORTED_MODULE_1__[\"default\"])((0,_babel_runtime_helpers_objectSpread2__WEBPACK_IMPORTED_MODULE_1__[\"default\"])({}, props.meta), {}, (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__[\"default\"])({}, props.meta_key, newValue)));\n  };\n\n  var value = props.meta[props.meta_key];\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.__experimentalHStack, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(\"dt\", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.__experimentalText, null, props.label)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(\"dt\", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.__experimentalText, null, value)));\n};\n/**\n * @param {Object} props The component properties.\n */\n\n\nfunction Edit(props) {\n  var _props$attributes$id;\n\n  var ref = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useRef)();\n  var blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.useBlockProps)({\n    ref: ref\n  });\n  var postType = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_7__.useSelect)(function (select) {\n    return select('core/editor').getCurrentPostType();\n  }, []);\n  var profile = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_7__.select)('core').getEntityRecord('postType', 'govpack_profiles', (_props$attributes$id = props.attributes.id) !== null && _props$attributes$id !== void 0 ? _props$attributes$id : 0);\n  /**\n  * @param {string} value The selected format.\n  */\n\n  function updateFormat(value) {\n    props.setAttributes({\n      format: value\n    });\n  }\n\n  console.log(\"render Selected Profile\", props);\n  var hasProfile = !(0,lodash__WEBPACK_IMPORTED_MODULE_5__.isUndefined)(profile);\n  console.log(\"pro?\", profile, hasProfile);\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(\"div\", blockProps, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(\"h2\", null, \"Meta Demo Selected\"), hasProfile && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(\"dl\", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(ListItem, {\n    label: \"Prefix\",\n    meta_key: \"prefix\",\n    key: \"prefix\",\n    meta: profile.meta\n  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(ListItem, {\n    label: \"First Name\",\n    meta_key: \"first_name\",\n    key: \"first_name\",\n    meta: profile.meta\n  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(ListItem, {\n    label: \"Last Name\",\n    meta_key: \"last_name\",\n    key: \"last_name\",\n    meta: profile.meta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(\"hr\", null)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.Panel, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelBody, {\n    title: __('Govpack Profile', 'govpack')\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_components_profile_selector__WEBPACK_IMPORTED_MODULE_10__[\"default\"], {\n    props: props\n  }))))));\n}\n\n(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_3__.registerBlockType)('govpack/profile-meta-selected', {\n  apiVersion: 2,\n  title: 'Govpack Profile Meta Selected',\n  icon: 'groups',\n  category: 'embed',\n  keywords: ['govpack'],\n  attributes: {\n    id: {\n      type: 'number',\n      \"default\": 0\n    }\n  },\n  edit: Edit,\n  save: function save() {\n    return null;\n  }\n});\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/blocks/profile-meta-selected.js?");

/***/ }),

/***/ "./assets/js/src/editor/blocks/profile-meta.js":
/*!*****************************************************!*\
  !*** ./assets/js/src/editor/blocks/profile-meta.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ \"./node_modules/@babel/runtime/helpers/esm/slicedToArray.js\");\n/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ \"./node_modules/@babel/runtime/helpers/esm/defineProperty.js\");\n/* harmony import */ var _babel_runtime_helpers_objectSpread2__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/objectSpread2 */ \"./node_modules/@babel/runtime/helpers/esm/objectSpread2.js\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/blocks */ \"@wordpress/blocks\");\n/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/block-editor */ \"@wordpress/block-editor\");\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_6__);\n/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/core-data */ \"@wordpress/core-data\");\n/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_7__);\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__);\n/* harmony import */ var React__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! React */ \"react\");\n/* harmony import */ var React__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(React__WEBPACK_IMPORTED_MODULE_9__);\n\n\n\n\n\n\n\n\n\n\n\n\n\nvar ListItem = function ListItem(props) {\n  console.log(props);\n\n  var updateMeta = function updateMeta(newValue) {\n    console.log(newValue, props);\n    props.setMeta((0,_babel_runtime_helpers_objectSpread2__WEBPACK_IMPORTED_MODULE_2__[\"default\"])((0,_babel_runtime_helpers_objectSpread2__WEBPACK_IMPORTED_MODULE_2__[\"default\"])({}, props.meta), {}, (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__[\"default\"])({}, props.meta_key, newValue)));\n  };\n\n  var value = props.meta[props.meta_key];\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(\"div\", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(\"dt\", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.__experimentalText, null, props.label)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(\"dd\", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.TextControl, {\n    value: value,\n    onChange: function onChange(val) {\n      //console.log(\"Change\", val)\n      updateMeta(val);\n    }\n  })));\n};\n/**\n * @param {Object} props The component properties.\n */\n\n\nfunction Edit(props) {\n  /**\n   * @param {string} value The selected format.\n   */\n  function updateFormat(value) {\n    props.setAttributes({\n      format: value\n    });\n  }\n\n  var postType = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.useSelect)(function (select) {\n    return select('core/editor').getCurrentPostType();\n  }, []);\n\n  var _useEntityProp = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_7__.useEntityProp)('postType', postType, 'meta'),\n      _useEntityProp2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(_useEntityProp, 2),\n      meta = _useEntityProp2[0],\n      setMeta = _useEntityProp2[1];\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(\"div\", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(\"h2\", null, \"Meta Demo\"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(\"dl\", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(ListItem, {\n    label: \"Prefix\",\n    meta_key: \"prefix\",\n    key: \"prefix\",\n    meta: meta,\n    setMeta: setMeta\n  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(ListItem, {\n    label: \"First Name\",\n    meta_key: \"first_name\",\n    key: \"first_name\",\n    meta: meta,\n    setMeta: setMeta\n  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(ListItem, {\n    label: \"Last Name\",\n    meta_key: \"last_name\",\n    key: \"last_name\",\n    meta: meta,\n    setMeta: setMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(\"hr\", null));\n}\n\n(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_4__.registerBlockType)('govpack/profile-meta', {\n  apiVersion: 2,\n  title: 'Govpack Profile Meta',\n  icon: 'groups',\n  category: 'embed',\n  keywords: ['govpack'],\n  attributes: {},\n  edit: Edit,\n  save: function save() {\n    return null;\n  }\n});\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/blocks/profile-meta.js?");

/***/ }),

/***/ "./assets/js/src/editor/blocks/profile.js":
/*!************************************************!*\
  !*** ./assets/js/src/editor/blocks/profile.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n\n\n/**\n * WordPress dependencies\n */\n//import { __ } from '@wordpress/i18n';\n//import { registerBlockType } from '@wordpress/blocks';\n//import { InspectorControls, useBlockProps } from '@wordpress/block-editor';\n//import { Panel, PanelBody, PanelRow, RadioControl } from '@wordpress/components';\n//import { useRef } from '@wordpress/element';\n\n/*\n * import { ServerSideRender } from '@wordpress/editor'\n *    is deprecated.\n * Use\n *    import ServerSideRender from @wordpress/server-side-render\n * instead. But it only has a default export, not a named export,\n * so you can't use braces.\n */\n//import ServerSideRender from '@wordpress/server-side-render';\n//import ProfileSelector from '../components/profile-selector';\n\n/**\n * @param {Object} props The component properties.\n */\nfunction Edit(props) {\n  /**\n   * @param {string} value The selected format.\n   */\n  function updateFormat(value) {\n    props.setAttributes({\n      format: value\n    });\n  }\n\n  var ref = useRef();\n  var blockProps = useBlockProps({\n    ref: ref\n  });\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(\"div\", blockProps, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Panel, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {\n    title: __('Govpack Profile', 'govpack')\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ProfileSelector, {\n    props: props\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RadioControl, {\n    label: \"Format\",\n    selected: props.attributes.format,\n    options: [{\n      value: 'full',\n      label: 'Full'\n    }, {\n      value: 'mini',\n      label: 'Mini'\n    }, {\n      value: 'wiki',\n      label: 'Wiki'\n    }],\n    onChange: updateFormat\n  }))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ServerSideRender, {\n    block: \"govpack/profile\",\n    attributes: props.attributes\n  }));\n}\n/*\nregisterBlockType( 'govpack/profile', {\n\tapiVersion: 2,\n\ttitle: 'Govpack',\n\ticon: 'groups',\n\tcategory: 'embed',\n\tkeywords: [ 'govpack' ],\n\tattributes: {\n\t\tid: {\n\t\t\ttype: 'number',\n\t\t\tdefault: 0,\n\t\t},\n\t\tformat: {\n\t\t\ttype: 'string',\n\t\t\tdefault: 'full',\n\t\t},\n\t},\n\n\tedit: Edit,\n\tsave() {\n\t\treturn null;\n\t},\n} );\n\n*/\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/blocks/profile.js?");

/***/ }),

/***/ "./assets/js/src/editor/components/profile-selector.js":
/*!*************************************************************!*\
  !*** ./assets/js/src/editor/components/profile-selector.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ \"@wordpress/i18n\");\n/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ \"@wordpress/block-editor\");\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);\n\n\n/**\n * WordPress dependencies\n */\n\nvar __ = _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__;\n\n\n\n\nvar ProfileSelector = function ProfileSelector(_ref) {\n  var props = _ref.props;\n  // prettier-ignore\n  var profiles = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(function (select) {\n    return select('core').getEntityRecords('postType', 'govpack_profiles', {\n      per_page: 100\n    });\n  });\n\n  var profilesMapped = function profilesMapped() {\n    if (profiles) {\n      var mapped = profiles.map(function (profile) {\n        console.log(profile);\n        return {\n          value: profile.id,\n          label: \"\".concat(profile.meta.first_name, \" \").concat(profile.meta.last_name)\n        };\n      });\n      return mapped;\n    }\n  };\n  /**\n   * Handle profile selection.\n   *\n   * @param {number} profileId The selected Profile.\n   */\n\n\n  var handleSelect = function handleSelect(profileId) {\n    if (!profileId) {\n      return;\n    }\n\n    props.setAttributes({\n      id: Number(profileId)\n    });\n  };\n\n  var OutputControl = function OutputControl() {\n    var label = __('Select a profile', 'govpack');\n\n    var options = profilesMapped();\n\n    if (!options) {\n      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Spinner, null);\n    }\n\n    if (options.length === 0) {\n      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.RichText, {\n        tagName: 'p',\n        value: __('No profiles have been created', 'govpack')\n      });\n    }\n\n    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ComboboxControl, {\n      label: label,\n      options: options,\n      value: props.attributes.id,\n      onChange: handleSelect,\n      isLoading: false,\n      allowReset: true\n    });\n  };\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(OutputControl, null);\n};\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ProfileSelector);\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/components/profile-selector.js?");

/***/ }),

/***/ "./assets/js/src/editor/components/sidebar-panel.jsx":
/*!***********************************************************!*\
  !*** ./assets/js/src/editor/components/sidebar-panel.jsx ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"GovPackSidebarPanel\": () => (/* binding */ GovPackSidebarPanel),\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/edit-post */ \"@wordpress/edit-post\");\n/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/compose */ \"@wordpress/compose\");\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);\n\n\n\n\n\n\nvar RawGovPackSidebarPanel = function RawGovPackSidebarPanel(props) {\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__.PluginDocumentSettingPanel, {\n    title: props.title,\n    name: props.name,\n    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null)\n  }, props.children);\n};\n\nvar GovPackSidebarPanel = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__.compose)([(0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.withSelect)(function (select) {\n  return {\n    meta: select('core/editor').getEditedPostAttribute('meta'),\n    type: select('core/editor').getCurrentPostType()\n  };\n}), (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.withDispatch)(function (dispatch) {\n  return {\n    setPostMeta: function setPostMeta(newMeta) {\n      dispatch('core/editor').editPost({\n        meta: newMeta\n      });\n    }\n  };\n})])(RawGovPackSidebarPanel);\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (GovPackSidebarPanel);\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/components/sidebar-panel.jsx?");

/***/ }),

/***/ "./assets/js/src/editor/index.js":
/*!***************************************!*\
  !*** ./assets/js/src/editor/index.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _meta_profile_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./meta/profile.js */ \"./assets/js/src/editor/meta/profile.js\");\n/* harmony import */ var _blocks_profile_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./blocks/profile.js */ \"./assets/js/src/editor/blocks/profile.js\");\n/* harmony import */ var _blocks_profile_meta_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./blocks/profile-meta.js */ \"./assets/js/src/editor/blocks/profile-meta.js\");\n/* harmony import */ var _blocks_profile_meta_selected_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./blocks/profile-meta-selected.js */ \"./assets/js/src/editor/blocks/profile-meta-selected.js\");\n//import './blocks/issue.js';\n//import './blocks/issue-archive.js';\n\n\n\n\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/index.js?");

/***/ }),

/***/ "./assets/js/src/editor/meta/profile.js":
/*!**********************************************!*\
  !*** ./assets/js/src/editor/meta/profile.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ \"./node_modules/@babel/runtime/helpers/esm/defineProperty.js\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/plugins */ \"@wordpress/plugins\");\n/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/icons */ \"./node_modules/@wordpress/icons/build-module/library/more.js\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _components_sidebar_panel__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./../components/sidebar-panel */ \"./assets/js/src/editor/components/sidebar-panel.jsx\");\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/compose */ \"@wordpress/compose\");\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_5__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_6__);\n/* harmony import */ var _json_prefix_json__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./../../../../json/prefix.json */ \"./assets/json/prefix.json\");\n/* harmony import */ var _json_title_json__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./../../../../json/title.json */ \"./assets/json/title.json\");\n\n\n// Using ESNext syntax\n//import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';\n\n\n\n\n\n\n\n\n\nfunction withPanel(component) {\n  return (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_5__.compose)([(0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.withSelect)(function (select) {\n    return {\n      meta: select('core/editor').getEditedPostAttribute('meta'),\n      type: select('core/editor').getCurrentPostType()\n    };\n  }), (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.withDispatch)(function (dispatch) {\n    return {\n      setPostMeta: function setPostMeta(newMeta) {\n        console.log(\"setPostMeta\", newMeta);\n        dispatch('core/editor').editPost({\n          meta: newMeta\n        });\n      },\n      setTerm: function setTerm(taxonomy, term) {\n        var _select = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.select)('core'),\n            getTaxonomy = _select.getTaxonomy;\n\n        var _taxonomy = getTaxonomy(taxonomy);\n\n        dispatch('core/editor').editPost((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__[\"default\"])({}, _taxonomy.rest_base, term));\n      }\n    };\n  })])(component);\n}\n\nvar AboutPanel = function AboutPanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_4__.GovPackSidebarPanel, {\n    title: \"About\",\n    name: \"gov-profile-about\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelSelectControl, {\n    options: Object.keys(_json_prefix_json__WEBPACK_IMPORTED_MODULE_7__).map(function (key) {\n      return {\n        value: key,\n        label: _json_prefix_json__WEBPACK_IMPORTED_MODULE_7__[key]\n      };\n    }),\n    label: \"Prefix\",\n    meta_key: \"prefix\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"First Name\",\n    meta_key: \"first_name\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Last Name\",\n    meta_key: \"last_name\",\n    onChange: setPostMeta\n  })));\n};\n\nvar PanelTextControl = function PanelTextControl(props) {\n  var _props$meta$props$met, _props$meta;\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.TextControl, {\n    label: props.label,\n    value: (_props$meta$props$met = (_props$meta = props.meta) === null || _props$meta === void 0 ? void 0 : _props$meta[props.meta_key]) !== null && _props$meta$props$met !== void 0 ? _props$meta$props$met : \"\",\n    onChange: function onChange(value) {\n      console.log(value, props, (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__[\"default\"])({}, props.meta_key, value));\n      props.onChange((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__[\"default\"])({}, props.meta_key, value));\n    }\n  });\n};\n\nvar PanelSelectControl = function PanelSelectControl(props) {\n  var _props$meta$props$met2, _props$meta2;\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {\n    label: props.label,\n    value: (_props$meta$props$met2 = (_props$meta2 = props.meta) === null || _props$meta2 === void 0 ? void 0 : _props$meta2[props.meta_key]) !== null && _props$meta$props$met2 !== void 0 ? _props$meta$props$met2 : \"\",\n    onChange: function onChange(value) {\n      props.onChange((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__[\"default\"])({}, props.meta_key, value));\n    },\n    options: props.options\n  });\n};\n\nvar RawPanelTaxonomyControl = function RawPanelTaxonomyControl(props) {\n  var _props$post_terms;\n\n  if (null === props.terms) {\n    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Spinner, null);\n  }\n\n  var options = props.terms.map(function (term) {\n    return {\n      label: term.name,\n      value: term.id\n    };\n  });\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {\n    label: props.label,\n    onChange: function onChange(value) {\n      props.onChange(props.taxonomy, value);\n    },\n    options: options,\n    value: (_props$post_terms = props.post_terms) !== null && _props$post_terms !== void 0 ? _props$post_terms : \"\"\n  });\n};\n\nvar PanelTaxonomyControl = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_5__.compose)((0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.withSelect)(function (select, ownProps) {\n  var _select2 = select('core'),\n      getEntityRecords = _select2.getEntityRecords,\n      getTaxonomy = _select2.getTaxonomy;\n\n  var _select3 = select('core/editor'),\n      getEditedPostAttribute = _select3.getEditedPostAttribute;\n\n  var _taxonomy = getTaxonomy(ownProps.taxonomy);\n\n  return {\n    terms: getEntityRecords('taxonomy', ownProps.taxonomy, {\n      per_page: 100\n    }),\n    post_terms: _taxonomy ? getEditedPostAttribute(_taxonomy.rest_base) : []\n  };\n}))(RawPanelTaxonomyControl);\n\nvar OfficePanel = function OfficePanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_4__.GovPackSidebarPanel, {\n    title: \"Office\",\n    name: \"gov-profile-office\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Address\",\n    meta_key: \"main_office_address\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"City\",\n    meta_key: \"main_office_city\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"State\",\n    meta_key: \"main_office_state\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Zip\",\n    meta_key: \"main_office_zip\",\n    onChange: setPostMeta\n  })));\n};\n\nvar SecondaryOfficePanel = function SecondaryOfficePanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_4__.GovPackSidebarPanel, {\n    title: \"Secondary Office\",\n    name: \"gov-profile-secondary-office\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Address\",\n    meta_key: \"secondary_office_address\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"City\",\n    meta_key: \"secondary_office_city\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"State\",\n    meta_key: \"secondary_office_state\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Zip\",\n    meta_key: \"secondary_office_zip\",\n    onChange: setPostMeta\n  })));\n};\n\nvar PositionPanel = function PositionPanel(props) {\n  var setTerm = props.setTerm,\n      setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_4__.GovPackSidebarPanel, {\n    title: \"Position\",\n    name: \"gov-profile-position\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelSelectControl, {\n    options: Object.keys(_json_title_json__WEBPACK_IMPORTED_MODULE_8__).map(function (key) {\n      return {\n        value: key,\n        label: _json_title_json__WEBPACK_IMPORTED_MODULE_8__[key]\n      };\n    }),\n    label: \"Title\",\n    meta_key: \"title\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTaxonomyControl, {\n    meta: props.meta,\n    label: \"Legislative Body\",\n    taxonomy: \"govpack_legislative_body\",\n    onChange: setTerm\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTaxonomyControl, {\n    meta: props.meta,\n    label: \"State\",\n    taxonomy: \"govpack_state\",\n    onChange: setTerm\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelSelectControl, {\n    meta: props.meta,\n    label: \"County\",\n    taxonomy: \"govpack_county\",\n    onChange: setTerm\n  })));\n};\n\nvar CommunicationsPanel = function CommunicationsPanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_4__.GovPackSidebarPanel, {\n    title: \"Communications\",\n    name: \"gov-profile-communications\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Main Phone\",\n    meta_key: \"main_phone\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Secondary Phone\",\n    meta_key: \"secondary_phone\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Email\",\n    meta_key: \"email\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Twitter\",\n    meta_key: \"twitter\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Facebook\",\n    meta_key: \"facebook\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"LinkedIn\",\n    meta_key: \"linked\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Instagram\",\n    meta_key: \"instagram\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Campaign Website\",\n    meta_key: \"campaign_url\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Legislative Website\",\n    meta_key: \"leg_url\",\n    onChange: setPostMeta\n  })));\n};\n\nvar ComposedAboutPanel = withPanel(AboutPanel);\nvar ComposedOfficePanel = withPanel(OfficePanel);\nvar ComposedSecondaryOfficePanel = withPanel(SecondaryOfficePanel);\nvar ComposedPositionPanel = withPanel(PositionPanel);\nvar ComposedCommunicationsPanel = withPanel(CommunicationsPanel);\n\nvar GovPackProfileSidebar = function GovPackProfileSidebar() {\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(ComposedAboutPanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(ComposedOfficePanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(ComposedSecondaryOfficePanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(ComposedPositionPanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(ComposedCommunicationsPanel, null));\n};\n\n(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_2__.registerPlugin)('profile-meta', {\n  icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_9__[\"default\"],\n  render: GovPackProfileSidebar\n});\nconsole.log(\"profile-meta loaded\");\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/meta/profile.js?");

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/***/ ((module) => {

module.exports = window["lodash"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/compose":
/*!*********************************!*\
  !*** external ["wp","compose"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["compose"];

/***/ }),

/***/ "@wordpress/core-data":
/*!**********************************!*\
  !*** external ["wp","coreData"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["coreData"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/edit-post":
/*!**********************************!*\
  !*** external ["wp","editPost"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["editPost"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/plugins":
/*!*********************************!*\
  !*** external ["wp","plugins"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["plugins"];

/***/ }),

/***/ "@wordpress/primitives":
/*!************************************!*\
  !*** external ["wp","primitives"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["primitives"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _arrayLikeToArray)\n/* harmony export */ });\nfunction _arrayLikeToArray(arr, len) {\n  if (len == null || len > arr.length) len = arr.length;\n\n  for (var i = 0, arr2 = new Array(len); i < len; i++) {\n    arr2[i] = arr[i];\n  }\n\n  return arr2;\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _arrayWithHoles)\n/* harmony export */ });\nfunction _arrayWithHoles(arr) {\n  if (Array.isArray(arr)) return arr;\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _defineProperty)\n/* harmony export */ });\nfunction _defineProperty(obj, key, value) {\n  if (key in obj) {\n    Object.defineProperty(obj, key, {\n      value: value,\n      enumerable: true,\n      configurable: true,\n      writable: true\n    });\n  } else {\n    obj[key] = value;\n  }\n\n  return obj;\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/defineProperty.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _iterableToArrayLimit)\n/* harmony export */ });\nfunction _iterableToArrayLimit(arr, i) {\n  var _i = arr == null ? null : typeof Symbol !== \"undefined\" && arr[Symbol.iterator] || arr[\"@@iterator\"];\n\n  if (_i == null) return;\n  var _arr = [];\n  var _n = true;\n  var _d = false;\n\n  var _s, _e;\n\n  try {\n    for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {\n      _arr.push(_s.value);\n\n      if (i && _arr.length === i) break;\n    }\n  } catch (err) {\n    _d = true;\n    _e = err;\n  } finally {\n    try {\n      if (!_n && _i[\"return\"] != null) _i[\"return\"]();\n    } finally {\n      if (_d) throw _e;\n    }\n  }\n\n  return _arr;\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js":
/*!********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js ***!
  \********************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _nonIterableRest)\n/* harmony export */ });\nfunction _nonIterableRest() {\n  throw new TypeError(\"Invalid attempt to destructure non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\");\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/objectSpread2.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/objectSpread2.js ***!
  \******************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _objectSpread2)\n/* harmony export */ });\n/* harmony import */ var _defineProperty_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./defineProperty.js */ \"./node_modules/@babel/runtime/helpers/esm/defineProperty.js\");\n\n\nfunction ownKeys(object, enumerableOnly) {\n  var keys = Object.keys(object);\n\n  if (Object.getOwnPropertySymbols) {\n    var symbols = Object.getOwnPropertySymbols(object);\n    enumerableOnly && (symbols = symbols.filter(function (sym) {\n      return Object.getOwnPropertyDescriptor(object, sym).enumerable;\n    })), keys.push.apply(keys, symbols);\n  }\n\n  return keys;\n}\n\nfunction _objectSpread2(target) {\n  for (var i = 1; i < arguments.length; i++) {\n    var source = null != arguments[i] ? arguments[i] : {};\n    i % 2 ? ownKeys(Object(source), !0).forEach(function (key) {\n      (0,_defineProperty_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(target, key, source[key]);\n    }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) {\n      Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));\n    });\n  }\n\n  return target;\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/objectSpread2.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/slicedToArray.js ***!
  \******************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _slicedToArray)\n/* harmony export */ });\n/* harmony import */ var _arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithHoles.js */ \"./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js\");\n/* harmony import */ var _iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArrayLimit.js */ \"./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js\");\n/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ \"./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js\");\n/* harmony import */ var _nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableRest.js */ \"./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js\");\n\n\n\n\nfunction _slicedToArray(arr, i) {\n  return (0,_arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(arr) || (0,_iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"])(arr, i) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(arr, i) || (0,_nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__[\"default\"])();\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/slicedToArray.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _unsupportedIterableToArray)\n/* harmony export */ });\n/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ \"./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js\");\n\nfunction _unsupportedIterableToArray(o, minLen) {\n  if (!o) return;\n  if (typeof o === \"string\") return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(o, minLen);\n  var n = Object.prototype.toString.call(o).slice(8, -1);\n  if (n === \"Object\" && o.constructor) n = o.constructor.name;\n  if (n === \"Map\" || n === \"Set\") return Array.from(o);\n  if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(o, minLen);\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js?");

/***/ }),

/***/ "./assets/json/prefix.json":
/*!*********************************!*\
  !*** ./assets/json/prefix.json ***!
  \*********************************/
/***/ ((module) => {

eval("module.exports = JSON.parse('{\"Mr.\":\"Mr.\",\"Mrs.\":\"Mrs.\",\"Ms\":\"Ms\",\"Dr.\":\"Dr.\",\"Rev.\":\"Rev.\"}');\n\n//# sourceURL=webpack://Govpack/./assets/json/prefix.json?");

/***/ }),

/***/ "./assets/json/title.json":
/*!********************************!*\
  !*** ./assets/json/title.json ***!
  \********************************/
/***/ ((module) => {

eval("module.exports = JSON.parse('{\"President\":\"President\",\"Vice President\":\"Vice President\",\"Senator\":\"Senator\",\"Representative\":\"Representative\",\"State Senator\":\"State Senator\",\"State Represenative\":\"State Representative\",\"City Council Member\":\"City Council Member\"}');\n\n//# sourceURL=webpack://Govpack/./assets/json/title.json?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/js/src/editor/index.js");
/******/ 	var __webpack_export_target__ = window;
/******/ 	for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
/******/ 	if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ 	
/******/ })()
;