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

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _meta_profile_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./meta/profile.js */ \"./assets/js/src/editor/meta/profile.js\");\n\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/index.js?");

/***/ }),

/***/ "./assets/js/src/editor/meta/profile.js":
/*!**********************************************!*\
  !*** ./assets/js/src/editor/meta/profile.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ \"./node_modules/@babel/runtime/helpers/esm/extends.js\");\n/* harmony import */ var _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/objectWithoutProperties */ \"./node_modules/@babel/runtime/helpers/esm/objectWithoutProperties.js\");\n/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ \"./node_modules/@babel/runtime/helpers/esm/defineProperty.js\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/plugins */ \"@wordpress/plugins\");\n/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @wordpress/icons */ \"./node_modules/@wordpress/icons/build-module/library/more.js\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);\n/* harmony import */ var _components_sidebar_panel__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./../components/sidebar-panel */ \"./assets/js/src/editor/components/sidebar-panel.jsx\");\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/compose */ \"@wordpress/compose\");\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_7__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_8__);\n/* harmony import */ var _json_prefix_json__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./../../../../json/prefix.json */ \"./assets/json/prefix.json\");\n/* harmony import */ var _json_title_json__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./../../../../json/title.json */ \"./assets/json/title.json\");\n\n\n\nvar _excluded = [\"onChange\"];\n\n// Using ESNext syntax\n//import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';\n\n\n\n\n\n\n\n\n\nfunction withPanel(component) {\n  return (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_7__.compose)([(0,_wordpress_data__WEBPACK_IMPORTED_MODULE_8__.withSelect)(function (select) {\n    return {\n      meta: select('core/editor').getEditedPostAttribute('meta'),\n      type: select('core/editor').getCurrentPostType()\n    };\n  }), (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_8__.withDispatch)(function (dispatch) {\n    return {\n      setPostMeta: function setPostMeta(newMeta) {\n        console.log(\"setPostMeta\", newMeta);\n        dispatch('core/editor').editPost({\n          meta: newMeta\n        });\n      },\n      setTerm: function setTerm(taxonomy, term) {\n        var _select = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_8__.select)('core'),\n            getTaxonomy = _select.getTaxonomy;\n\n        var _taxonomy = getTaxonomy(taxonomy);\n\n        dispatch('core/editor').editPost((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__[\"default\"])({}, _taxonomy.rest_base, term));\n      }\n    };\n  })])(component);\n}\n\nvar AboutPanel = function AboutPanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_6__.GovPackSidebarPanel, {\n    title: \"About\",\n    name: \"gov-profile-about\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"First Name\",\n    meta_key: \"first_name\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Last Name\",\n    meta_key: \"last_name\",\n    onChange: setPostMeta\n  })));\n};\n\nvar PanelTextControl = function PanelTextControl(props) {\n  var _props$meta$props$met, _props$meta;\n\n  var _onChange2 = props.onChange,\n      restProps = (0,_babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_1__[\"default\"])(props, _excluded);\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.TextControl, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__[\"default\"])({\n    label: props.label,\n    value: (_props$meta$props$met = (_props$meta = props.meta) === null || _props$meta === void 0 ? void 0 : _props$meta[props.meta_key]) !== null && _props$meta$props$met !== void 0 ? _props$meta$props$met : \"\",\n    onChange: function onChange(value) {\n      _onChange2((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__[\"default\"])({}, props.meta_key, value));\n    }\n  }, restProps));\n};\n\nvar PanelSelectControl = function PanelSelectControl(props) {\n  var _props$meta$props$met2, _props$meta2;\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {\n    label: props.label,\n    value: (_props$meta$props$met2 = (_props$meta2 = props.meta) === null || _props$meta2 === void 0 ? void 0 : _props$meta2[props.meta_key]) !== null && _props$meta$props$met2 !== void 0 ? _props$meta$props$met2 : \"\",\n    onChange: function onChange(value) {\n      props.onChange((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__[\"default\"])({}, props.meta_key, value));\n    },\n    options: props.options\n  });\n};\n\nvar RawPanelTaxonomyControl = function RawPanelTaxonomyControl(props) {\n  var _props$post_terms;\n\n  if (null === props.terms) {\n    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Spinner, null);\n  }\n\n  var options = props.terms.map(function (term) {\n    return {\n      label: term.name,\n      value: term.id\n    };\n  });\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {\n    label: props.label,\n    onChange: function onChange(value) {\n      props.onChange(props.taxonomy, value);\n    },\n    options: options,\n    value: (_props$post_terms = props.post_terms) !== null && _props$post_terms !== void 0 ? _props$post_terms : \"\"\n  });\n};\n\nvar PanelTaxonomyControl = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_7__.compose)((0,_wordpress_data__WEBPACK_IMPORTED_MODULE_8__.withSelect)(function (select, ownProps) {\n  var _select2 = select('core'),\n      getEntityRecords = _select2.getEntityRecords,\n      getTaxonomy = _select2.getTaxonomy;\n\n  var _select3 = select('core/editor'),\n      getEditedPostAttribute = _select3.getEditedPostAttribute;\n\n  var _taxonomy = getTaxonomy(ownProps.taxonomy);\n\n  return {\n    terms: getEntityRecords('taxonomy', ownProps.taxonomy, {\n      per_page: 100\n    }),\n    post_terms: _taxonomy ? getEditedPostAttribute(_taxonomy.rest_base) : []\n  };\n}))(RawPanelTaxonomyControl);\n\nvar OfficePanel = function OfficePanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_6__.GovPackSidebarPanel, {\n    title: \"Capitol Office\",\n    name: \"gov-profile-office\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Address\",\n    meta_key: \"main_office_address\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"City\",\n    meta_key: \"main_office_city\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"State\",\n    meta_key: \"main_office_state\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Zip\",\n    meta_key: \"main_office_zip\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Phone\",\n    meta_key: \"main_phone\",\n    onChange: setPostMeta\n  })));\n};\n\nvar SecondaryOfficePanel = function SecondaryOfficePanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_6__.GovPackSidebarPanel, {\n    title: \"District Office\",\n    name: \"gov-profile-secondary-office\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Address\",\n    meta_key: \"secondary_office_address\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"City\",\n    meta_key: \"secondary_office_city\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"State\",\n    meta_key: \"secondary_office_state\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Zip\",\n    meta_key: \"secondary_office_zip\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Phone\",\n    meta_key: \"secondary_phone\",\n    onChange: setPostMeta\n  })));\n};\n\nvar PositionPanel = function PositionPanel(props) {\n  var setTerm = props.setTerm,\n      setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_6__.GovPackSidebarPanel, {\n    title: \"Position\",\n    name: \"gov-profile-position\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelSelectControl, {\n    options: Object.keys(_json_title_json__WEBPACK_IMPORTED_MODULE_10__).map(function (key) {\n      return {\n        value: key,\n        label: _json_title_json__WEBPACK_IMPORTED_MODULE_10__[key]\n      };\n    }),\n    label: \"Title\",\n    meta_key: \"title\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTaxonomyControl, {\n    meta: props.meta,\n    label: \"Legislative Body\",\n    taxonomy: \"govpack_legislative_body\",\n    onChange: setTerm\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTaxonomyControl, {\n    meta: props.meta,\n    label: \"State\",\n    taxonomy: \"govpack_state\",\n    onChange: setTerm\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelSelectControl, {\n    meta: props.meta,\n    label: \"County\",\n    taxonomy: \"govpack_county\",\n    onChange: setTerm\n  })));\n};\n\nvar CommunicationsPanel = function CommunicationsPanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_6__.GovPackSidebarPanel, {\n    title: \"Communications\",\n    name: \"gov-profile-communications\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Email\",\n    meta_key: \"email\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Twitter\",\n    meta_key: \"twitter\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Facebook\",\n    meta_key: \"facebook\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"LinkedIn\",\n    meta_key: \"linkedin\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Instagram\",\n    meta_key: \"instagram\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Campaign Website\",\n    meta_key: \"campaign_url\",\n    onChange: setPostMeta,\n    placeholder: \"https://\"\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Legislative Website\",\n    meta_key: \"leg_url\",\n    onChange: setPostMeta,\n    placeholder: \"https://\"\n  })));\n};\n\nvar ComposedAboutPanel = withPanel(AboutPanel);\nvar ComposedOfficePanel = withPanel(OfficePanel);\nvar ComposedSecondaryOfficePanel = withPanel(SecondaryOfficePanel);\nvar ComposedPositionPanel = withPanel(PositionPanel);\nvar ComposedCommunicationsPanel = withPanel(CommunicationsPanel);\n\nvar GovPackProfileSidebar = function GovPackProfileSidebar() {\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(ComposedAboutPanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(ComposedOfficePanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(ComposedSecondaryOfficePanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(ComposedCommunicationsPanel, null));\n};\n\n(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_4__.registerPlugin)('profile-meta', {\n  icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_11__[\"default\"],\n  render: GovPackProfileSidebar\n});\n\n//# sourceURL=webpack://Govpack/./assets/js/src/editor/meta/profile.js?");

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

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _defineProperty)\n/* harmony export */ });\nfunction _defineProperty(obj, key, value) {\n  if (key in obj) {\n    Object.defineProperty(obj, key, {\n      value: value,\n      enumerable: true,\n      configurable: true,\n      writable: true\n    });\n  } else {\n    obj[key] = value;\n  }\n\n  return obj;\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/defineProperty.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _extends)\n/* harmony export */ });\nfunction _extends() {\n  _extends = Object.assign || function (target) {\n    for (var i = 1; i < arguments.length; i++) {\n      var source = arguments[i];\n\n      for (var key in source) {\n        if (Object.prototype.hasOwnProperty.call(source, key)) {\n          target[key] = source[key];\n        }\n      }\n    }\n\n    return target;\n  };\n\n  return _extends.apply(this, arguments);\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/extends.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/objectWithoutProperties.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/objectWithoutProperties.js ***!
  \****************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _objectWithoutProperties)\n/* harmony export */ });\n/* harmony import */ var _objectWithoutPropertiesLoose_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./objectWithoutPropertiesLoose.js */ \"./node_modules/@babel/runtime/helpers/esm/objectWithoutPropertiesLoose.js\");\n\nfunction _objectWithoutProperties(source, excluded) {\n  if (source == null) return {};\n  var target = (0,_objectWithoutPropertiesLoose_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(source, excluded);\n  var key, i;\n\n  if (Object.getOwnPropertySymbols) {\n    var sourceSymbolKeys = Object.getOwnPropertySymbols(source);\n\n    for (i = 0; i < sourceSymbolKeys.length; i++) {\n      key = sourceSymbolKeys[i];\n      if (excluded.indexOf(key) >= 0) continue;\n      if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;\n      target[key] = source[key];\n    }\n  }\n\n  return target;\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/objectWithoutProperties.js?");

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/objectWithoutPropertiesLoose.js":
/*!*********************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/objectWithoutPropertiesLoose.js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _objectWithoutPropertiesLoose)\n/* harmony export */ });\nfunction _objectWithoutPropertiesLoose(source, excluded) {\n  if (source == null) return {};\n  var target = {};\n  var sourceKeys = Object.keys(source);\n  var key, i;\n\n  for (i = 0; i < sourceKeys.length; i++) {\n    key = sourceKeys[i];\n    if (excluded.indexOf(key) >= 0) continue;\n    target[key] = source[key];\n  }\n\n  return target;\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/objectWithoutPropertiesLoose.js?");

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