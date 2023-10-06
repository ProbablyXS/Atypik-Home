(self["webpackChunk"] = self["webpackChunk"] || []).push([["js/account/new_hosting"],{

/***/ "./assets/js/account/new_hosting.js":
/*!******************************************!*\
  !*** ./assets/js/account/new_hosting.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.array.slice.js */ "./node_modules/core-js/modules/es.array.slice.js");
__webpack_require__(/*! core-js/modules/es.error.to-string.js */ "./node_modules/core-js/modules/es.error.to-string.js");
__webpack_require__(/*! core-js/modules/es.date.to-string.js */ "./node_modules/core-js/modules/es.date.to-string.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
__webpack_require__(/*! core-js/modules/es.regexp.to-string.js */ "./node_modules/core-js/modules/es.regexp.to-string.js");
__webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
__webpack_require__(/*! core-js/modules/es.array.from.js */ "./node_modules/core-js/modules/es.array.from.js");
__webpack_require__(/*! core-js/modules/es.string.iterator.js */ "./node_modules/core-js/modules/es.string.iterator.js");
__webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
__webpack_require__(/*! core-js/modules/es.regexp.test.js */ "./node_modules/core-js/modules/es.regexp.test.js");
__webpack_require__(/*! core-js/modules/es.symbol.js */ "./node_modules/core-js/modules/es.symbol.js");
__webpack_require__(/*! core-js/modules/es.symbol.description.js */ "./node_modules/core-js/modules/es.symbol.description.js");
__webpack_require__(/*! core-js/modules/es.symbol.iterator.js */ "./node_modules/core-js/modules/es.symbol.iterator.js");
__webpack_require__(/*! core-js/modules/es.array.iterator.js */ "./node_modules/core-js/modules/es.array.iterator.js");
__webpack_require__(/*! core-js/modules/web.dom-collections.iterator.js */ "./node_modules/core-js/modules/web.dom-collections.iterator.js");
__webpack_require__(/*! core-js/modules/es.array.is-array.js */ "./node_modules/core-js/modules/es.array.is-array.js");
__webpack_require__(/*! core-js/modules/es.error.cause.js */ "./node_modules/core-js/modules/es.error.cause.js");
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
// Get the image container and file input elements
var imageContainer = document.getElementById('new_hosting_form_imageFilesBtn');
var imageFilesInput = document.querySelector('.edit_form_account_info_image_file'); // Assuming you have a class for the image file input

// Add a click event listener to the image container
imageContainer.addEventListener('click', function () {
  // Trigger a click on the hidden file input
  imageFilesInput.click();
});

// Add an event listener to the file input to handle file selection
imageFilesInput.addEventListener('change', function (event) {
  // Get the container where you want to display the selected images
  var imageListContainer = document.getElementById('image-container');

  // Clear the existing images in the container
  imageListContainer.innerHTML = '';

  // Loop through all selected files
  var _iterator = _createForOfIteratorHelper(event.target.files),
    _step;
  try {
    var _loop = function _loop() {
        var file = _step.value;
        if (event.target.files.length > 8) {
          window.confirm("Vous ne pouvez pas dépasser 8 images");
          return {
            v: void 0
          };
        }
        if (file) {
          var reader = new FileReader();
          reader.onload = function (e) {
            // Create an image element for each selected file
            var imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            if (event.target.files.length == 1) {
              imageListContainer.classList.add('center-single-image');
              imageListContainer.classList.remove('center-double-image');
            } else if (event.target.files.length == 2) {
              imageListContainer.classList.remove('center-single-image');
              imageListContainer.classList.add('center-double-image');
            } else {
              imageListContainer.classList.remove('center-single-image');
              imageListContainer.classList.remove('center-double-image');
            }
            if (event.target.files[0] == file) {
              imgElement.classList.add('favorite');
            }
            imgElement.classList.add('selected-image'); // Add a class for styling, if needed

            // Append the image to the image list container
            imageListContainer.appendChild(imgElement);
          };
          reader.readAsDataURL(file);
        }
      },
      _ret;
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      _ret = _loop();
      if (_ret) return _ret.v;
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_dom-iterables_js-node_modules_core-js_internals_dom-to-43e662","vendors-node_modules_core-js_internals_create-property_js-node_modules_core-js_modules_es_str-d1bad0","vendors-node_modules_core-js_internals_array-slice-simple_js-node_modules_core-js_internals_d-d5e6c2","vendors-node_modules_core-js_internals_array-method-has-species-support_js-node_modules_core--88015a","vendors-node_modules_core-js_modules_es_array_from_js-node_modules_core-js_modules_es_array_i-51bfa1"], () => (__webpack_exec__("./assets/js/account/new_hosting.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QXRDRCxLQUFBekIsU0FBQSxDQUFBMEIsQ0FBQSxNQUFBdEIsS0FBQSxHQUFBSixTQUFBLENBQUEyQixDQUFBLElBQUFDLElBQUE7TUFBQUgsSUFBQSxHQUFBcEIsS0FBQTtNQUFBLElBQUFvQixJQUFBLFNBQUFBLElBQUEsQ0FBQWQsQ0FBQTtJQUFBO0VBc0NDLFNBQUFrQixHQUFBO0lBQUE3QixTQUFBLENBQUFlLENBQUEsQ0FBQWMsR0FBQTtFQUFBO0lBQUE3QixTQUFBLENBQUE4QixDQUFBO0VBQUE7QUFDSCxDQUFDLENBQUMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYWNjb3VudC9uZXdfaG9zdGluZy5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyBHZXQgdGhlIGltYWdlIGNvbnRhaW5lciBhbmQgZmlsZSBpbnB1dCBlbGVtZW50c1xuY29uc3QgaW1hZ2VDb250YWluZXIgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbmV3X2hvc3RpbmdfZm9ybV9pbWFnZUZpbGVzQnRuJyk7XG5jb25zdCBpbWFnZUZpbGVzSW5wdXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZWRpdF9mb3JtX2FjY291bnRfaW5mb19pbWFnZV9maWxlJyk7IC8vIEFzc3VtaW5nIHlvdSBoYXZlIGEgY2xhc3MgZm9yIHRoZSBpbWFnZSBmaWxlIGlucHV0XG5cbi8vIEFkZCBhIGNsaWNrIGV2ZW50IGxpc3RlbmVyIHRvIHRoZSBpbWFnZSBjb250YWluZXJcbmltYWdlQ29udGFpbmVyLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKCkgPT4ge1xuICAvLyBUcmlnZ2VyIGEgY2xpY2sgb24gdGhlIGhpZGRlbiBmaWxlIGlucHV0XG4gIGltYWdlRmlsZXNJbnB1dC5jbGljaygpO1xufSk7XG5cbi8vIEFkZCBhbiBldmVudCBsaXN0ZW5lciB0byB0aGUgZmlsZSBpbnB1dCB0byBoYW5kbGUgZmlsZSBzZWxlY3Rpb25cbmltYWdlRmlsZXNJbnB1dC5hZGRFdmVudExpc3RlbmVyKCdjaGFuZ2UnLCAoZXZlbnQpID0+IHtcbiAgLy8gR2V0IHRoZSBjb250YWluZXIgd2hlcmUgeW91IHdhbnQgdG8gZGlzcGxheSB0aGUgc2VsZWN0ZWQgaW1hZ2VzXG4gIGNvbnN0IGltYWdlTGlzdENvbnRhaW5lciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdpbWFnZS1jb250YWluZXInKTtcblxuICAvLyBDbGVhciB0aGUgZXhpc3RpbmcgaW1hZ2VzIGluIHRoZSBjb250YWluZXJcbiAgaW1hZ2VMaXN0Q29udGFpbmVyLmlubmVySFRNTCA9ICcnO1xuXG4gIC8vIExvb3AgdGhyb3VnaCBhbGwgc2VsZWN0ZWQgZmlsZXNcbiAgZm9yIChjb25zdCBmaWxlIG9mIGV2ZW50LnRhcmdldC5maWxlcykge1xuXG4gICAgaWYgKGV2ZW50LnRhcmdldC5maWxlcy5sZW5ndGggPiA4KSB7XG4gICAgICB3aW5kb3cuY29uZmlybShcIlZvdXMgbmUgcG91dmV6IHBhcyBkw6lwYXNzZXIgOCBpbWFnZXNcIik7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgaWYgKGZpbGUpIHtcblxuICAgICAgY29uc3QgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcbiAgICAgIHJlYWRlci5vbmxvYWQgPSAoZSkgPT4ge1xuICAgICAgICAvLyBDcmVhdGUgYW4gaW1hZ2UgZWxlbWVudCBmb3IgZWFjaCBzZWxlY3RlZCBmaWxlXG4gICAgICAgIGNvbnN0IGltZ0VsZW1lbnQgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdpbWcnKTtcbiAgICAgICAgaW1nRWxlbWVudC5zcmMgPSBlLnRhcmdldC5yZXN1bHQ7XG5cbiAgICAgICAgaWYgKGV2ZW50LnRhcmdldC5maWxlcy5sZW5ndGggPT0gMSkge1xuICAgICAgICAgIGltYWdlTGlzdENvbnRhaW5lci5jbGFzc0xpc3QuYWRkKCdjZW50ZXItc2luZ2xlLWltYWdlJyk7XG4gICAgICAgICAgaW1hZ2VMaXN0Q29udGFpbmVyLmNsYXNzTGlzdC5yZW1vdmUoJ2NlbnRlci1kb3VibGUtaW1hZ2UnKTtcbiAgICAgICAgfSBlbHNlIGlmIChldmVudC50YXJnZXQuZmlsZXMubGVuZ3RoID09IDIpIHtcbiAgICAgICAgICBpbWFnZUxpc3RDb250YWluZXIuY2xhc3NMaXN0LnJlbW92ZSgnY2VudGVyLXNpbmdsZS1pbWFnZScpO1xuICAgICAgICAgIGltYWdlTGlzdENvbnRhaW5lci5jbGFzc0xpc3QuYWRkKCdjZW50ZXItZG91YmxlLWltYWdlJyk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgaW1hZ2VMaXN0Q29udGFpbmVyLmNsYXNzTGlzdC5yZW1vdmUoJ2NlbnRlci1zaW5nbGUtaW1hZ2UnKTtcbiAgICAgICAgICBpbWFnZUxpc3RDb250YWluZXIuY2xhc3NMaXN0LnJlbW92ZSgnY2VudGVyLWRvdWJsZS1pbWFnZScpO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYgKGV2ZW50LnRhcmdldC5maWxlc1swXSA9PSBmaWxlKSB7XG4gICAgICAgICAgaW1nRWxlbWVudC5jbGFzc0xpc3QuYWRkKCdmYXZvcml0ZScpO1xuICAgICAgICB9XG5cbiAgICAgICAgaW1nRWxlbWVudC5jbGFzc0xpc3QuYWRkKCdzZWxlY3RlZC1pbWFnZScpOyAvLyBBZGQgYSBjbGFzcyBmb3Igc3R5bGluZywgaWYgbmVlZGVkXG5cbiAgICAgICAgLy8gQXBwZW5kIHRoZSBpbWFnZSB0byB0aGUgaW1hZ2UgbGlzdCBjb250YWluZXJcbiAgICAgICAgaW1hZ2VMaXN0Q29udGFpbmVyLmFwcGVuZENoaWxkKGltZ0VsZW1lbnQpO1xuXG4gICAgICB9O1xuICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoZmlsZSk7XG4gICAgfVxuICB9XG59KTsiXSwibmFtZXMiOlsiaW1hZ2VDb250YWluZXIiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwiaW1hZ2VGaWxlc0lucHV0IiwicXVlcnlTZWxlY3RvciIsImFkZEV2ZW50TGlzdGVuZXIiLCJjbGljayIsImV2ZW50IiwiaW1hZ2VMaXN0Q29udGFpbmVyIiwiaW5uZXJIVE1MIiwiX2l0ZXJhdG9yIiwiX2NyZWF0ZUZvck9mSXRlcmF0b3JIZWxwZXIiLCJ0YXJnZXQiLCJmaWxlcyIsIl9zdGVwIiwiX2xvb3AiLCJmaWxlIiwidmFsdWUiLCJsZW5ndGgiLCJ3aW5kb3ciLCJjb25maXJtIiwidiIsInJlYWRlciIsIkZpbGVSZWFkZXIiLCJvbmxvYWQiLCJlIiwiaW1nRWxlbWVudCIsImNyZWF0ZUVsZW1lbnQiLCJzcmMiLCJyZXN1bHQiLCJjbGFzc0xpc3QiLCJhZGQiLCJyZW1vdmUiLCJhcHBlbmRDaGlsZCIsInJlYWRBc0RhdGFVUkwiLCJfcmV0IiwicyIsIm4iLCJkb25lIiwiZXJyIiwiZiJdLCJzb3VyY2VSb290IjoiIn0=