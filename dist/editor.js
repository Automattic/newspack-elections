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

/***/ "./src/editor/meta/view.scss":
/*!***********************************!*\
  !*** ./src/editor/meta/view.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://Govpack/./src/editor/meta/view.scss?");

/***/ }),

/***/ "./src/components/sidebar-panel.jsx":
/*!******************************************!*\
  !*** ./src/components/sidebar-panel.jsx ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"GovPackSidebarPanel\": () => (/* binding */ GovPackSidebarPanel),\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/edit-post */ \"@wordpress/edit-post\");\n/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/compose */ \"@wordpress/compose\");\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);\n\n\n\n\n\n\nvar RawGovPackSidebarPanel = function RawGovPackSidebarPanel(props) {\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_1__.PluginDocumentSettingPanel, {\n    title: props.title,\n    name: props.name,\n    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null)\n  }, props.children);\n};\n\nvar GovPackSidebarPanel = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__.compose)([(0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.withSelect)(function (select) {\n  return {\n    meta: select('core/editor').getEditedPostAttribute('meta'),\n    type: select('core/editor').getCurrentPostType()\n  };\n}), (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.withDispatch)(function (dispatch) {\n  return {\n    setPostMeta: function setPostMeta(newMeta) {\n      dispatch('core/editor').editPost({\n        meta: newMeta\n      });\n    }\n  };\n})])(RawGovPackSidebarPanel);\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (GovPackSidebarPanel);\n\n//# sourceURL=webpack://Govpack/./src/components/sidebar-panel.jsx?");

/***/ }),

/***/ "./src/editor/index.js":
/*!*****************************!*\
  !*** ./src/editor/index.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _meta_profile_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./meta/profile.js */ \"./src/editor/meta/profile.js\");\n\n\n//# sourceURL=webpack://Govpack/./src/editor/index.js?");

/***/ }),

/***/ "./src/editor/meta/profile.js":
/*!************************************!*\
  !*** ./src/editor/meta/profile.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ \"./node_modules/@babel/runtime/helpers/esm/slicedToArray.js\");\n/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ \"./node_modules/@babel/runtime/helpers/esm/extends.js\");\n/* harmony import */ var _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/objectWithoutProperties */ \"./node_modules/@babel/runtime/helpers/esm/objectWithoutProperties.js\");\n/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ \"./node_modules/@babel/runtime/helpers/esm/defineProperty.js\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var _view_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./view.scss */ \"./src/editor/meta/view.scss\");\n/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/plugins */ \"@wordpress/plugins\");\n/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_6__);\n/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @wordpress/icons */ \"./node_modules/@wordpress/icons/build-module/library/more.js\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_7__);\n/* harmony import */ var _wordpress_date__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/date */ \"@wordpress/date\");\n/* harmony import */ var _wordpress_date__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_date__WEBPACK_IMPORTED_MODULE_8__);\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__);\n/* harmony import */ var _components_sidebar_panel__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./../../components/sidebar-panel */ \"./src/components/sidebar-panel.jsx\");\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @wordpress/compose */ \"@wordpress/compose\");\n/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_11__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_12__);\n\n\n\n\nvar _excluded = [\"onChange\", \"meta\", \"meta_key\"],\n    _excluded2 = [\"onChange\", \"meta\"],\n    _excluded3 = [\"onChange\", \"meta\"];\n\n// Using ESNext syntax\n//import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';\n\n\n\n\n\n\n\n\n\n\nfunction withPanel(component) {\n  return (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_11__.compose)([(0,_wordpress_data__WEBPACK_IMPORTED_MODULE_12__.withSelect)(function (select) {\n    return {\n      meta: select('core/editor').getEditedPostAttribute('meta'),\n      type: select('core/editor').getCurrentPostType()\n    };\n  }), (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_12__.withDispatch)(function (dispatch) {\n    return {\n      setPostMeta: function setPostMeta(newMeta) {\n        console.log(\"setPostMeta\", newMeta);\n        dispatch('core/editor').editPost({\n          meta: newMeta\n        });\n      },\n      setTerm: function setTerm(taxonomy, term) {\n        var _select = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_12__.select)('core'),\n            getTaxonomy = _select.getTaxonomy;\n\n        var _taxonomy = getTaxonomy(taxonomy);\n\n        dispatch('core/editor').editPost((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_3__[\"default\"])({}, _taxonomy.rest_base, term));\n      }\n    };\n  })])(component);\n}\n\nvar AboutPanel = function AboutPanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_10__.GovPackSidebarPanel, {\n    title: \"About\",\n    name: \"gov-profile-about\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Name\",\n    meta_key: \"name\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Prefix\",\n    meta_key: \"name_prefix\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"First Name\",\n    meta_key: \"name_first\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Middle Name\",\n    meta_key: \"name_middle\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Last Name\",\n    meta_key: \"last_middle\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Suffix\",\n    meta_key: \"name_suffix\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Nickname\",\n    meta_key: \"nickname\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Occupation\",\n    meta_key: \"occupation\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Education\",\n    meta_key: \"education\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Gender\",\n    meta_key: \"gender\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Race\",\n    meta_key: \"race\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Ethnicity\",\n    meta_key: \"ethnicity\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelDatePickerControl, {\n    meta: props.meta,\n    label: \"Date of Birth\",\n    meta_key: \"date_of_birth\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelDatePickerControl, {\n    meta: props.meta,\n    label: \"Date of Death\",\n    meta_key: \"date_of_death\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Party\",\n    meta_key: \"party\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"State\",\n    meta_key: \"state\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Status\",\n    meta_key: \"status\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"District\",\n    meta_key: \"district\",\n    onChange: setPostMeta\n  })));\n};\n\nvar PanelTextControl = function PanelTextControl(props) {\n  var _props$meta$props$met, _props$meta;\n\n  var _onChange2 = props.onChange,\n      meta = props.meta,\n      meta_key = props.meta_key,\n      restProps = (0,_babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(props, _excluded);\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.TextControl, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_1__[\"default\"])({\n    label: props.label,\n    value: (_props$meta$props$met = (_props$meta = props.meta) === null || _props$meta === void 0 ? void 0 : _props$meta[props.meta_key]) !== null && _props$meta$props$met !== void 0 ? _props$meta$props$met : \"\",\n    onChange: function onChange(value) {\n      _onChange2((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_3__[\"default\"])({}, props.meta_key, value));\n    }\n  }, restProps));\n};\n\nvar PanelTextareaControl = function PanelTextareaControl(props) {\n  var _props$meta$props$met2, _props$meta2;\n\n  var _onChange4 = props.onChange,\n      meta = props.meta,\n      restProps = (0,_babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(props, _excluded2);\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.TextareaControl, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_1__[\"default\"])({\n    label: props.label,\n    value: (_props$meta$props$met2 = (_props$meta2 = props.meta) === null || _props$meta2 === void 0 ? void 0 : _props$meta2[props.meta_key]) !== null && _props$meta$props$met2 !== void 0 ? _props$meta$props$met2 : \"\",\n    onChange: function onChange(value) {\n      _onChange4((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_3__[\"default\"])({}, props.meta_key, value));\n    }\n  }, restProps));\n};\n\nvar PanelDatePickerControl = function PanelDatePickerControl(props) {\n  var onChange = props.onChange,\n      meta = props.meta,\n      restProps = (0,_babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(props, _excluded3);\n\n  var _useState = (0,react__WEBPACK_IMPORTED_MODULE_7__.useState)(new Date()),\n      _useState2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(_useState, 2),\n      date = _useState2[0],\n      setDate = _useState2[1];\n\n  var settings = (0,_wordpress_date__WEBPACK_IMPORTED_MODULE_8__.__experimentalGetSettings)();\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(\"span\", null, props.label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.Dropdown, {\n    renderToggle: function renderToggle(_ref) {\n      var isOpen = _ref.isOpen,\n          onToggle = _ref.onToggle;\n      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.Button, {\n        onClick: onToggle,\n        \"aria-expanded\": isOpen,\n        variant: \"tertiary\"\n      }, (0,_wordpress_date__WEBPACK_IMPORTED_MODULE_8__.dateI18n)(settings.formats.date, date));\n    },\n    renderContent: function renderContent(_ref2) {\n      var onClose = _ref2.onClose;\n      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.DatePicker, {\n        currentDate: date,\n        onChange: function onChange(newDate) {\n          return setDate(newDate);\n        },\n        onClose: onClose\n      });\n    }\n  }));\n};\n\nvar PanelSelectControl = function PanelSelectControl(props) {\n  var _props$meta$props$met3, _props$meta3;\n\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.SelectControl, {\n    label: props.label,\n    value: (_props$meta$props$met3 = (_props$meta3 = props.meta) === null || _props$meta3 === void 0 ? void 0 : _props$meta3[props.meta_key]) !== null && _props$meta$props$met3 !== void 0 ? _props$meta$props$met3 : \"\",\n    onChange: function onChange(value) {\n      props.onChange((0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_3__[\"default\"])({}, props.meta_key, value));\n    },\n    options: props.options\n  });\n};\n\nvar RawPanelTaxonomyControl = function RawPanelTaxonomyControl(props) {\n  var _props$post_terms;\n\n  if (null === props.terms) {\n    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.Spinner, null);\n  }\n\n  var options = props.terms.map(function (term) {\n    return {\n      label: term.name,\n      value: term.id\n    };\n  });\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.SelectControl, {\n    label: props.label,\n    onChange: function onChange(value) {\n      props.onChange(props.taxonomy, value);\n    },\n    options: options,\n    value: (_props$post_terms = props.post_terms) !== null && _props$post_terms !== void 0 ? _props$post_terms : \"\"\n  });\n};\n\nvar PanelTaxonomyControl = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_11__.compose)((0,_wordpress_data__WEBPACK_IMPORTED_MODULE_12__.withSelect)(function (select, ownProps) {\n  var _select2 = select('core'),\n      getEntityRecords = _select2.getEntityRecords,\n      getTaxonomy = _select2.getTaxonomy;\n\n  var _select3 = select('core/editor'),\n      getEditedPostAttribute = _select3.getEditedPostAttribute;\n\n  var _taxonomy = getTaxonomy(ownProps.taxonomy);\n\n  return {\n    terms: getEntityRecords('taxonomy', ownProps.taxonomy, {\n      per_page: 100\n    }),\n    post_terms: _taxonomy ? getEditedPostAttribute(_taxonomy.rest_base) : []\n  };\n}))(RawPanelTaxonomyControl);\n\nvar OfficePanel = function OfficePanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_10__.GovPackSidebarPanel, {\n    title: \"Office\",\n    name: \"gov-profile-office\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextareaControl, {\n    meta: props.meta,\n    label: \"Address (Capitol)\",\n    meta_key: \"address_capitol\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextareaControl, {\n    meta: props.meta,\n    label: \"Address (District)\",\n    meta_key: \"address_district\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextareaControl, {\n    meta: props.meta,\n    label: \"Address (Campaign)\",\n    meta_key: \"address_campaign\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Contact Form URL\",\n    meta_key: \"contact_form_url\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelDatePickerControl, {\n    meta: props.meta,\n    label: \"Date assumed office\",\n    meta_key: \"date_assumed_office\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Appointed by\",\n    meta_key: \"appointed_by\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelDatePickerControl, {\n    meta: props.meta,\n    label: \"Date appointed\",\n    meta_key: \"appointed_date\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelDatePickerControl, {\n    meta: props.meta,\n    label: \"Date confirmed\",\n    meta_key: \"confirmed_date\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelDatePickerControl, {\n    meta: props.meta,\n    label: \"Date term ends\",\n    meta_key: \"term_end_data\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Congress Year/Batch\",\n    meta_key: \"congress_year\",\n    onChange: setPostMeta\n  })));\n};\n\nvar SecondaryOfficePanel = function SecondaryOfficePanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return null;\n  /*\n     return (\n         <GovPackSidebarPanel \n             title=\"District Office\"\n             name=\"gov-profile-secondary-office\"\n         >\n         \n             <PanelRow>\n                 <PanelTextControl meta={props.meta} label= \"Address\" meta_key=\"district_office_address\" onChange={setPostMeta}/>\n             </PanelRow>\n              <PanelRow>\n                 <PanelTextControl meta={props.meta} label = \"City\" meta_key=\"district_office_city\" onChange={setPostMeta}/>\n             </PanelRow>\n              <PanelRow>\n                 <PanelTextControl meta={props.meta} label = \"State\" meta_key=\"district_office_state\" onChange={setPostMeta}/>\n             </PanelRow>\n              <PanelRow>\n                 <PanelTextControl meta={props.meta} label = \"Zip\" meta_key=\"district_office_zip\" onChange={setPostMeta}/>\n             </PanelRow>\n  \t\t\t<PanelRow>\n                 <PanelTextControl meta={props.meta} label= \"Phone\" meta_key=\"district_phone\" onChange={setPostMeta}/>\n             </PanelRow>\n  \n         </GovPackSidebarPanel>\n     )\n  */\n};\n\nvar PositionPanel = function PositionPanel(props) {\n  var setTerm = props.setTerm,\n      setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_10__.GovPackSidebarPanel, {\n    title: \"Position\",\n    name: \"gov-profile-position\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelSelectControl, {\n    options: Object.keys(titles).map(function (key) {\n      return {\n        value: key,\n        label: titles[key]\n      };\n    }),\n    label: \"Title\",\n    meta_key: \"title\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTaxonomyControl, {\n    meta: props.meta,\n    label: \"Legislative Body\",\n    taxonomy: \"govpack_legislative_body\",\n    onChange: setTerm\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTaxonomyControl, {\n    meta: props.meta,\n    label: \"State\",\n    taxonomy: \"govpack_state\",\n    onChange: setTerm\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelSelectControl, {\n    meta: props.meta,\n    label: \"County\",\n    taxonomy: \"govpack_county\",\n    onChange: setTerm\n  })));\n};\n\nvar SocialPanel = function SocialPanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_10__.GovPackSidebarPanel, {\n    title: \"Social\",\n    name: \"gov-profile-social\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Twitter (Official)\",\n    meta_key: \"twitter_official\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Twitter (Personal)\",\n    meta_key: \"twitter_personal\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Twitter (Campaign)\",\n    meta_key: \"twitter_campaign\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Instagram (Official)\",\n    meta_key: \"Instagram_official\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Instagram (Personal)\",\n    meta_key: \"Instagram_personal\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Instagram (Campaign)\",\n    meta_key: \"Instagram_campaign\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"facebook (Official)\",\n    meta_key: \"facebook_official\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"facebook (Personal)\",\n    meta_key: \"facebook_personal\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"facebook (Campaign)\",\n    meta_key: \"facebook_campaign\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"LinkedIn\",\n    meta_key: \"linkedin\",\n    onChange: setPostMeta\n  })));\n};\n\nvar CommunicationsPanel = function CommunicationsPanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_10__.GovPackSidebarPanel, {\n    title: \"Communications\",\n    name: \"gov-profile-communications\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Email (Official)\",\n    meta_key: \"email_official\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Email (Campaign)\",\n    meta_key: \"email_campaign\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Email (Other)\",\n    meta_key: \"email_other\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Email\",\n    meta_key: \"email\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Phone (District)\",\n    meta_key: \"phone_district\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Phone (Campaign)\",\n    meta_key: \"phone_campaign\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Fax (District)\",\n    meta_key: \"fax_district\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Fax (Campaign)\",\n    meta_key: \"fax_campaign\",\n    onChange: setPostMeta\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Website (Personal)\",\n    meta_key: \"website_personal\",\n    onChange: setPostMeta,\n    placeholder: \"https://\"\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Website (Campaign)\",\n    meta_key: \"website_campaign\",\n    onChange: setPostMeta,\n    placeholder: \"https://\"\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Website (Legislative)\",\n    meta_key: \"website_legislative\",\n    onChange: setPostMeta,\n    placeholder: \"https://\"\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"RSS\",\n    meta_key: \"rss\",\n    onChange: setPostMeta\n  })));\n};\n\nvar MetadataIdsPanel = function MetadataIdsPanel(props) {\n  var setPostMeta = props.setPostMeta;\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_components_sidebar_panel__WEBPACK_IMPORTED_MODULE_10__.GovPackSidebarPanel, {\n    title: \"Metadata & IDS\",\n    name: \"gov-metadataids-communications\"\n  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Govpack ID\",\n    meta_key: \"govpack_id\",\n    onChange: setPostMeta,\n    placeholder: \"\",\n    disabled: true\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"FEC ID\",\n    meta_key: \"fec_ids\",\n    onChange: setPostMeta,\n    placeholder: \"\",\n    disabled: true\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"US.IO ID\",\n    meta_key: \"usio_id\",\n    onChange: setPostMeta,\n    placeholder: \"\",\n    disabled: true\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Opensecrets ID\",\n    meta_key: \"opensecrets_id\",\n    onChange: setPostMeta,\n    placeholder: \"\",\n    disabled: true\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"District OCDID\",\n    meta_key: \"district_ocd_ic\",\n    onChange: setPostMeta,\n    placeholder: \"\",\n    disabled: true\n  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__.PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(PanelTextControl, {\n    meta: props.meta,\n    label: \"Open States ID\",\n    meta_key: \"openstates_id\",\n    onChange: setPostMeta,\n    placeholder: \"\",\n    disabled: true\n  })));\n};\n\nvar ComposedAboutPanel = withPanel(AboutPanel);\nvar ComposedOfficePanel = withPanel(OfficePanel);\nvar ComposedCommunicationsPanel = withPanel(CommunicationsPanel);\nvar ComposedSocialPanel = withPanel(SocialPanel);\nvar ComposedMetadataIds = withPanel(MetadataIdsPanel);\n\nvar GovPackProfileSidebar = function GovPackProfileSidebar() {\n  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(ComposedAboutPanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(ComposedOfficePanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(ComposedCommunicationsPanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(ComposedSocialPanel, null), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_4__.createElement)(ComposedMetadataIds, null));\n};\n\n(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_6__.registerPlugin)('profile-meta', {\n  icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_13__[\"default\"],\n  render: GovPackProfileSidebar\n});\n\n//# sourceURL=webpack://Govpack/./src/editor/meta/profile.js?");

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

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

/***/ "@wordpress/date":
/*!******************************!*\
  !*** external ["wp","date"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["date"];

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

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* binding */ _extends)\n/* harmony export */ });\nfunction _extends() {\n  _extends = Object.assign || function (target) {\n    for (var i = 1; i < arguments.length; i++) {\n      var source = arguments[i];\n\n      for (var key in source) {\n        if (Object.prototype.hasOwnProperty.call(source, key)) {\n          target[key] = source[key];\n        }\n      }\n    }\n\n    return target;\n  };\n\n  return _extends.apply(this, arguments);\n}\n\n//# sourceURL=webpack://Govpack/./node_modules/@babel/runtime/helpers/esm/extends.js?");

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
/******/ 	var __webpack_exports__ = __webpack_require__("./src/editor/index.js");
/******/ 	var __webpack_export_target__ = window;
/******/ 	for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
/******/ 	if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ 	
/******/ })()
;