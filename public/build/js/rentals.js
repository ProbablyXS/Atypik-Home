(self["webpackChunk"] = self["webpackChunk"] || []).push([["js/rentals"],{

/***/ "./assets/js/rentals.js":
/*!******************************!*\
  !*** ./assets/js/rentals.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
__webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
__webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
__webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
__webpack_require__(/*! core-js/modules/es.array.concat.js */ "./node_modules/core-js/modules/es.array.concat.js");
__webpack_require__(/*! core-js/modules/es.string.ends-with.js */ "./node_modules/core-js/modules/es.string.ends-with.js");
__webpack_require__(/*! core-js/modules/es.array.slice.js */ "./node_modules/core-js/modules/es.array.slice.js");
// Get the form element, checkboxes, and select boxes
var form = document.getElementById('filterForm');
var checkboxes = document.querySelectorAll("input[type=checkbox]");
var selects = form.querySelectorAll("select"); // Select only within the form

// Function to construct the URL based on checkbox and select values
function constructURL() {
  var url = "?";
  checkboxes.forEach(function (cb) {
    var cbName = cb.getAttribute("name");
    var updatedName = cbName.replace(/^rentals_filter_form\[(.*?)\]$/, '$1');
    if (cb.checked) {
      url += "".concat(updatedName, "=1&");
    }
  });
  selects.forEach(function (select) {
    var selectName = select.getAttribute("name");
    var selectValue = select.value;
    var updatedName = selectName.replace(/^rentals_filter_form\[(.*?)\]$/, '$1');
    if (selectValue) {
      url += "".concat(updatedName, "=").concat(selectValue, "&");
    }
  });

  // Remove the trailing '&' character if it exists
  if (url.endsWith("&")) {
    url = url.slice(0, -1);
  }
  return url;
}

// Function to handle form submission
function submitForm() {
  var url = constructURL();

  // Redirect to the updated URL
  window.location.href = url;
}

// Function to load and set the checkbox states from localStorage on page load
function loadCheckboxStates() {
  checkboxes.forEach(function (checkbox) {
    var checkboxName = checkbox.getAttribute("name");
    var storedState = localStorage.getItem("".concat(checkboxName, "CheckboxState"));
    if (storedState === "true") {
      checkbox.checked = true;
    }

    // Add an event listener to each checkbox
    checkbox.addEventListener("change", function (event) {
      // Prevent the default behavior of the checkbox
      event.preventDefault();

      // Store the checkbox state in localStorage
      localStorage.setItem("".concat(checkboxName, "CheckboxState"), checkbox.checked);
      submitForm(); // Submit the form when a checkbox is changed
    });
  });
}

// Function to load and set the select states from localStorage on page load
function loadSelectStates() {
  selects.forEach(function (select) {
    var selectName = select.getAttribute("name");
    var storedValue = localStorage.getItem("".concat(selectName, "SelectState"));
    if (storedValue !== null) {
      select.value = storedValue;
    }

    // Add an event listener to each select box
    select.addEventListener("change", function (event) {
      // Store the select value in localStorage
      localStorage.setItem("".concat(selectName, "SelectState"), select.value);
      submitForm(); // Submit the form when a select box is changed
    });
  });
}

// Call the loadCheckboxStates and loadSelectStates functions on page load
window.addEventListener('load', function () {
  loadCheckboxStates();
  loadSelectStates();
});

// Add a submit event listener to the form
form.addEventListener('submit', function (event) {
  event.preventDefault(); // Prevent the default form submission
  submitForm();
});
document.addEventListener("DOMContentLoaded", function () {
  var btnHamb = document.querySelector(".input-filter");
  btnHamb.addEventListener("click", function () {
    if (form.className === "hide") {
      document.getElementById("filterForm").className = "show";
    } else {
      document.getElementById("filterForm").className = "hide";
    }
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_dom-iterables_js-node_modules_core-js_internals_dom-to-43e662","vendors-node_modules_core-js_modules_es_array_concat_js-node_modules_core-js_modules_es_array-b8c579","vendors-node_modules_core-js_internals_array-iteration_js-node_modules_core-js_internals_func-035c73"], () => (__webpack_exec__("./assets/js/rentals.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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UUFBUSxDQUFDQyxjQUFjLENBQUMsWUFBWSxDQUFDLENBQUNzQyxTQUFTLEdBQUksTUFBTztJQUM5RDtFQUNKLENBQUMsQ0FBQztBQUNOLENBQUMsQ0FBQyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL2Fzc2V0cy9qcy9yZW50YWxzLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIEdldCB0aGUgZm9ybSBlbGVtZW50LCBjaGVja2JveGVzLCBhbmQgc2VsZWN0IGJveGVzXG5jb25zdCBmb3JtID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2ZpbHRlckZvcm0nKTtcbmNvbnN0IGNoZWNrYm94ZXMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiaW5wdXRbdHlwZT1jaGVja2JveF1cIik7XG5jb25zdCBzZWxlY3RzID0gZm9ybS5xdWVyeVNlbGVjdG9yQWxsKFwic2VsZWN0XCIpOyAvLyBTZWxlY3Qgb25seSB3aXRoaW4gdGhlIGZvcm1cblxuLy8gRnVuY3Rpb24gdG8gY29uc3RydWN0IHRoZSBVUkwgYmFzZWQgb24gY2hlY2tib3ggYW5kIHNlbGVjdCB2YWx1ZXNcbmZ1bmN0aW9uIGNvbnN0cnVjdFVSTCgpIHtcbiAgICBsZXQgdXJsID0gXCI/XCI7XG5cbiAgICBjaGVja2JveGVzLmZvckVhY2goY2IgPT4ge1xuICAgICAgICBjb25zdCBjYk5hbWUgPSBjYi5nZXRBdHRyaWJ1dGUoXCJuYW1lXCIpO1xuICAgICAgICBjb25zdCB1cGRhdGVkTmFtZSA9IGNiTmFtZS5yZXBsYWNlKC9ecmVudGFsc19maWx0ZXJfZm9ybVxcWyguKj8pXFxdJC8sICckMScpO1xuICAgICAgICBpZiAoY2IuY2hlY2tlZCkge1xuICAgICAgICAgICAgdXJsICs9IGAke3VwZGF0ZWROYW1lfT0xJmA7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgIHNlbGVjdHMuZm9yRWFjaChzZWxlY3QgPT4ge1xuICAgICAgICBjb25zdCBzZWxlY3ROYW1lID0gc2VsZWN0LmdldEF0dHJpYnV0ZShcIm5hbWVcIik7XG4gICAgICAgIGNvbnN0IHNlbGVjdFZhbHVlID0gc2VsZWN0LnZhbHVlO1xuICAgICAgICBjb25zdCB1cGRhdGVkTmFtZSA9IHNlbGVjdE5hbWUucmVwbGFjZSgvXnJlbnRhbHNfZmlsdGVyX2Zvcm1cXFsoLio/KVxcXSQvLCAnJDEnKTtcbiAgICAgICAgaWYgKHNlbGVjdFZhbHVlKSB7XG4gICAgICAgICAgICB1cmwgKz0gYCR7dXBkYXRlZE5hbWV9PSR7c2VsZWN0VmFsdWV9JmA7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgIC8vIFJlbW92ZSB0aGUgdHJhaWxpbmcgJyYnIGNoYXJhY3RlciBpZiBpdCBleGlzdHNcbiAgICBpZiAodXJsLmVuZHNXaXRoKFwiJlwiKSkge1xuICAgICAgICB1cmwgPSB1cmwuc2xpY2UoMCwgLTEpO1xuICAgIH1cblxuICAgIHJldHVybiB1cmw7XG59XG5cbi8vIEZ1bmN0aW9uIHRvIGhhbmRsZSBmb3JtIHN1Ym1pc3Npb25cbmZ1bmN0aW9uIHN1Ym1pdEZvcm0oKSB7XG4gICAgY29uc3QgdXJsID0gY29uc3RydWN0VVJMKCk7XG5cbiAgICAvLyBSZWRpcmVjdCB0byB0aGUgdXBkYXRlZCBVUkxcbiAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9IHVybDtcbn1cblxuLy8gRnVuY3Rpb24gdG8gbG9hZCBhbmQgc2V0IHRoZSBjaGVja2JveCBzdGF0ZXMgZnJvbSBsb2NhbFN0b3JhZ2Ugb24gcGFnZSBsb2FkXG5mdW5jdGlvbiBsb2FkQ2hlY2tib3hTdGF0ZXMoKSB7XG4gICAgY2hlY2tib3hlcy5mb3JFYWNoKGNoZWNrYm94ID0+IHtcbiAgICAgICAgY29uc3QgY2hlY2tib3hOYW1lID0gY2hlY2tib3guZ2V0QXR0cmlidXRlKFwibmFtZVwiKTtcbiAgICAgICAgY29uc3Qgc3RvcmVkU3RhdGUgPSBsb2NhbFN0b3JhZ2UuZ2V0SXRlbShgJHtjaGVja2JveE5hbWV9Q2hlY2tib3hTdGF0ZWApO1xuICAgICAgICBpZiAoc3RvcmVkU3RhdGUgPT09IFwidHJ1ZVwiKSB7XG4gICAgICAgICAgICBjaGVja2JveC5jaGVja2VkID0gdHJ1ZTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vIEFkZCBhbiBldmVudCBsaXN0ZW5lciB0byBlYWNoIGNoZWNrYm94XG4gICAgICAgIGNoZWNrYm94LmFkZEV2ZW50TGlzdGVuZXIoXCJjaGFuZ2VcIiwgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICAvLyBQcmV2ZW50IHRoZSBkZWZhdWx0IGJlaGF2aW9yIG9mIHRoZSBjaGVja2JveFxuICAgICAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcblxuICAgICAgICAgICAgLy8gU3RvcmUgdGhlIGNoZWNrYm94IHN0YXRlIGluIGxvY2FsU3RvcmFnZVxuICAgICAgICAgICAgbG9jYWxTdG9yYWdlLnNldEl0ZW0oYCR7Y2hlY2tib3hOYW1lfUNoZWNrYm94U3RhdGVgLCBjaGVja2JveC5jaGVja2VkKTtcblxuICAgICAgICAgICAgc3VibWl0Rm9ybSgpOyAvLyBTdWJtaXQgdGhlIGZvcm0gd2hlbiBhIGNoZWNrYm94IGlzIGNoYW5nZWRcbiAgICAgICAgfSk7XG4gICAgfSk7XG59XG5cbi8vIEZ1bmN0aW9uIHRvIGxvYWQgYW5kIHNldCB0aGUgc2VsZWN0IHN0YXRlcyBmcm9tIGxvY2FsU3RvcmFnZSBvbiBwYWdlIGxvYWRcbmZ1bmN0aW9uIGxvYWRTZWxlY3RTdGF0ZXMoKSB7XG4gICAgc2VsZWN0cy5mb3JFYWNoKHNlbGVjdCA9PiB7XG4gICAgICAgIGNvbnN0IHNlbGVjdE5hbWUgPSBzZWxlY3QuZ2V0QXR0cmlidXRlKFwibmFtZVwiKTtcbiAgICAgICAgY29uc3Qgc3RvcmVkVmFsdWUgPSBsb2NhbFN0b3JhZ2UuZ2V0SXRlbShgJHtzZWxlY3ROYW1lfVNlbGVjdFN0YXRlYCk7XG4gICAgICAgIGlmIChzdG9yZWRWYWx1ZSAhPT0gbnVsbCkge1xuICAgICAgICAgICAgc2VsZWN0LnZhbHVlID0gc3RvcmVkVmFsdWU7XG4gICAgICAgIH1cblxuICAgICAgICAvLyBBZGQgYW4gZXZlbnQgbGlzdGVuZXIgdG8gZWFjaCBzZWxlY3QgYm94XG4gICAgICAgIHNlbGVjdC5hZGRFdmVudExpc3RlbmVyKFwiY2hhbmdlXCIsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgLy8gU3RvcmUgdGhlIHNlbGVjdCB2YWx1ZSBpbiBsb2NhbFN0b3JhZ2VcbiAgICAgICAgICAgIGxvY2FsU3RvcmFnZS5zZXRJdGVtKGAke3NlbGVjdE5hbWV9U2VsZWN0U3RhdGVgLCBzZWxlY3QudmFsdWUpO1xuXG4gICAgICAgICAgICBzdWJtaXRGb3JtKCk7IC8vIFN1Ym1pdCB0aGUgZm9ybSB3aGVuIGEgc2VsZWN0IGJveCBpcyBjaGFuZ2VkXG4gICAgICAgIH0pO1xuICAgIH0pO1xufVxuXG4vLyBDYWxsIHRoZSBsb2FkQ2hlY2tib3hTdGF0ZXMgYW5kIGxvYWRTZWxlY3RTdGF0ZXMgZnVuY3Rpb25zIG9uIHBhZ2UgbG9hZFxud2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ2xvYWQnLCBmdW5jdGlvbiAoKSB7XG4gICAgbG9hZENoZWNrYm94U3RhdGVzKCk7XG4gICAgbG9hZFNlbGVjdFN0YXRlcygpO1xufSk7XG5cbi8vIEFkZCBhIHN1Ym1pdCBldmVudCBsaXN0ZW5lciB0byB0aGUgZm9ybVxuZm9ybS5hZGRFdmVudExpc3RlbmVyKCdzdWJtaXQnLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpOyAvLyBQcmV2ZW50IHRoZSBkZWZhdWx0IGZvcm0gc3VibWlzc2lvblxuICAgIHN1Ym1pdEZvcm0oKTtcbn0pO1xuXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKFwiRE9NQ29udGVudExvYWRlZFwiLCBmdW5jdGlvbiAoKSB7XG4gICAgdmFyIGJ0bkhhbWIgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKFwiLmlucHV0LWZpbHRlclwiKTtcblxuICAgIGJ0bkhhbWIuYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIGZ1bmN0aW9uICgpIHtcblxuICAgICAgICBpZiAoZm9ybS5jbGFzc05hbWUgPT09IFwiaGlkZVwiKSB7XG4gICAgICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcImZpbHRlckZvcm1cIikuY2xhc3NOYW1lID0gKFwic2hvd1wiKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwiZmlsdGVyRm9ybVwiKS5jbGFzc05hbWUgPSAoXCJoaWRlXCIpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTsiXSwibmFtZXMiOlsiZm9ybSIsImRvY3VtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJjaGVja2JveGVzIiwicXVlcnlTZWxlY3RvckFsbCIsInNlbGVjdHMiLCJjb25zdHJ1Y3RVUkwiLCJ1cmwiLCJmb3JFYWNoIiwiY2IiLCJjYk5hbWUiLCJnZXRBdHRyaWJ1dGUiLCJ1cGRhdGVkTmFtZSIsInJlcGxhY2UiLCJjaGVja2VkIiwiY29uY2F0Iiwic2VsZWN0Iiwic2VsZWN0TmFtZSIsInNlbGVjdFZhbHVlIiwidmFsdWUiLCJlbmRzV2l0aCIsInNsaWNlIiwic3VibWl0Rm9ybSIsIndpbmRvdyIsImxvY2F0aW9uIiwiaHJlZiIsImxvYWRDaGVja2JveFN0YXRlcyIsImNoZWNrYm94IiwiY2hlY2tib3hOYW1lIiwic3RvcmVkU3RhdGUiLCJsb2NhbFN0b3JhZ2UiLCJnZXRJdGVtIiwiYWRkRXZlbnRMaXN0ZW5lciIsImV2ZW50IiwicHJldmVudERlZmF1bHQiLCJzZXRJdGVtIiwibG9hZFNlbGVjdFN0YXRlcyIsInN0b3JlZFZhbHVlIiwiYnRuSGFtYiIsInF1ZXJ5U2VsZWN0b3IiLCJjbGFzc05hbWUiXSwic291cmNlUm9vdCI6IiJ9