/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _handleFIlters_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./handleFIlters.js */ "./resources/js/handleFIlters.js");
/* harmony import */ var _handleFIlters_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_handleFIlters_js__WEBPACK_IMPORTED_MODULE_0__);

$(document).ready(function () {
  $('.open-modal-btn').click(function () {
    $('#modalOverlay').css('display', 'flex').fadeIn();
    if ($(this).attr('id') === 'modal-importar-alunos') {
      var formModal = $('#modalOverlay').find('form');
      formModal.attr('action', $(this).data('url'));
    }
  });
  $('#closeModal, #modalOverlay').click(function (e) {
    if (e.target.id === 'modalOverlay' || e.target.id === 'closeModal') {
      $('#modalOverlay').fadeOut();
    }
  });
});
window.modalShow = function modalShow(title, description, type) {
  var fn = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  var modal = new bootstrap.Modal(modalInfo);
  var modalData = {
    type: {
      danger: {
        classButton: 'btn-danger'
      },
      confirm: {
        classButton: 'btn-primary'
      }
    }
  };
  var modalTitle = modalInfo.querySelector('.modal-title');
  var modalBody = modalInfo.querySelector('.modal-body');
  var modalButton = modalInfo.querySelector('#modalConfirm');
  modalButton.addEventListener('click', function (e) {
    modal.hide();
    if (typeof fn == 'function') {
      fn(e);
    }
  });
  var classButtons = Object.keys(modalData.type).map(function (type) {
    return modalData.type[type].classButton;
  });
  modalTitle.innerText = title;
  modalBody.innerText = description;
  classButtons.map(function (classButton) {
    modalButton.classList.remove(classButton);
  });
  modalButton.classList.add(modalData.type[type].classButton);
  modal.show();
};

// Tem filhos
(function () {
  var temFilhos = document.querySelectorAll('input[name="temFilhos"]');
  if (temFilhos) {
    temFilhos.forEach(function (el) {
      if (el.checked && el.value == '0') {
        document.querySelector('#filhosQt').closest('div').style.display = 'none';
      }
    });
    temFilhos.forEach(function (el) {
      return el.addEventListener('change', function (e) {
        console.log(this.value);
        if (this.value == '0') {
          document.querySelector('#filhosQt').closest('div').style.display = 'none';
        } else {
          document.querySelector('#filhosQt').closest('div').style.display = 'block';
        }
      });
    });
  }
})();

/***/ }),

/***/ "./resources/js/handleFIlters.js":
/*!***************************************!*\
  !*** ./resources/js/handleFIlters.js ***!
  \***************************************/
/***/ (() => {

var status_filter = document.getElementById('status');
var nucleo_filter = document.getElementById('nucleo');
var listaEspera_filter = document.getElementById('lista_espera');
var cidade_filter = document.getElementById('cidade');
var date_filter = document.getElementById('date');
var areas_conhecimento_filter = document.getElementsByClassName('areas_conhecimento');
var disciplina_filter = document.getElementsByClassName('disciplina');
var limparFiltrosButton = document.getElementById('limparFiltros');
var handleStatusChange = function handleStatusChange(status) {
  var handleUrlFormated = function handleUrlFormated() {
    var urlToFormate = new URL(window.location.href);
    var shouldFormate = urlToFormate.pathname.includes('/search');
    if (!shouldFormate) {
      urlToFormate.pathname += '/search';
    }
    return urlToFormate;
  };
  var url = handleUrlFormated();
  url.searchParams.set('status', status);
  window.location.href = url.toString();
};
var handleNucleoChange = function handleNucleoChange(nucleo) {
    var handleUrlFormated = function handleUrlFormated() {
        var urlToFormate = new URL(window.location.href);

        if (!urlToFormate.pathname.endsWith('/search')) {
            if (urlToFormate.pathname.endsWith('/')) {
                urlToFormate.pathname += 'search';
            } else {
                urlToFormate.pathname += '/search';
            }
        }

        return urlToFormate;
    };

    var url = handleUrlFormated();
    url.searchParams.set('nucleo', nucleo);
    window.location.href = url.toString();
};
var handleListaEsperaChange = function handleListaEsperaChange(listaEspera) {
  var handleUrlFormated = function handleUrlFormated() {
    var urlToFormate = new URL(window.location.href);
    var shouldFormate = urlToFormate.pathname.includes('/search');
    if (!shouldFormate) {
      urlToFormate.pathname += '/search';
    }
    return urlToFormate;
  };
  var url = handleUrlFormated();
  url.searchParams.set('lista_espera', listaEspera);
  window.location.href = url.toString();
};
var handleCidadeChange = function handleCidadeChange(cidade) {
  var handleUrlFormated = function handleUrlFormated() {
    var urlToFormate = new URL(window.location.href);
    var shouldFormate = urlToFormate.pathname.includes('/search');
    if (!shouldFormate) {
      urlToFormate.pathname += '/search';
    }
    return urlToFormate;
  };
  var url = handleUrlFormated();
  url.searchParams.set('cidade', cidade);
  window.location.href = url.toString();
};
var handleDateChange = function handleDateChange(date) {
  var handleUrlFormated = function handleUrlFormated() {
    var urlToFormate = new URL(window.location.href);
    var shouldFormate = urlToFormate.pathname.includes('/search');
    if (!shouldFormate) {
      urlToFormate.pathname += '/search';
    }
    return urlToFormate;
  };
  var url = handleUrlFormated();
  url.searchParams.set('date', date);
  window.location.href = url.toString();
};
var handleAreasConhecimentoChange = function handleAreasConhecimentoChange(areas_conhecimento) {
  var handleUrlFormated = function handleUrlFormated() {
    var urlToFormate = new URL(window.location.href);
    var shouldFormate = urlToFormate.pathname.includes('/search');
    if (!shouldFormate) {
      urlToFormate.pathname += '/search';
    }
    return urlToFormate;
  };
  var url = handleUrlFormated();
  url.searchParams.set('areas_conhecimento', areas_conhecimento);
  window.location.href = url.toString();
};
var disciplinaChange = function disciplinaChange(disciplina) {
  var handleUrlFormated = function handleUrlFormated() {
    var urlToFormate = new URL(window.location.href);
    var shouldFormate = urlToFormate.pathname.includes('/search');
    if (!shouldFormate) {
      urlToFormate.pathname += '/search';
    }
    return urlToFormate;
  };
  var url = handleUrlFormated();
  url.searchParams.set('disciplina', disciplina);
  window.location.href = url.toString();
};
status_filter ? status_filter.addEventListener('change', function () {
  handleStatusChange(status_filter.value);
}) : null;
nucleo_filter ? nucleo_filter.addEventListener('change', function () {
  console.log('eventlistener on nucleo');
  handleNucleoChange(nucleo_filter.value);
}) : null;
listaEspera_filter ? listaEspera_filter.addEventListener('change', function () {
  handleListaEsperaChange(listaEspera_filter.value);
}) : null;
cidade_filter ? cidade_filter.addEventListener('change', function () {
  handleCidadeChange(cidade_filter.value);
}) : null;
date_filter ? date_filter.addEventListener('change', function () {
  handleDateChange(date_filter.value);
}) : null;
limparFiltrosButton ? limparFiltrosButton.addEventListener('click', function () {
  var url = window.location.origin + window.location.pathname;
  var baseUrl = url.replace(/\/search\/?$/, '');
  window.location.href = baseUrl;
}) : null;
areas_conhecimento_filter ? Array.from(areas_conhecimento_filter).forEach(function (area) {
  area.addEventListener('click', function () {
    handleAreasConhecimentoChange(area.value);
  });
}) : null;
disciplina_filter ? Array.from(disciplina_filter).forEach(function (disciplina) {
  disciplina.addEventListener('click', function () {
    disciplinaChange(disciplina.value);
  });
}) : null;

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;