(window.webpackJsonp=window.webpackJsonp||[]).push([["xrpl-connector"],{DxJk:function(t,e,n){"use strict";n.r(e);var o=n("FGIj"),r=n("gHbT"),c=n("k8s9");function i(t){return(i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function a(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function u(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}function s(t,e){return!e||"object"!==i(e)&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function y(t){return(y=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function f(t,e){return(f=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}var p=window.PluginManager,l=function(t){function e(){return a(this,e),s(this,y(e).apply(this,arguments))}var n,o,i;return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&f(t,e)}(e,t),n=e,(o=[{key:"init",value:function(){console.log("Xrpl-Connector XrpPayment - init"),window.DomAccess=r.a,this.client=new c.a,this.checkPaymentButton=r.a.querySelector(document,"#check-payment-button"),this.checkPaymentButton.onclick=this._fetchPaymentData.bind(this),this.checkPaymentButton=r.a.querySelector(document,"#check-payment-button"),this.checkPaymentButton.onclick=this._fetchPaymentData.bind(this)}},{key:"_registerEvents",value:function(){this.checkPaymentButton.onclick=this._fetchPaymentData.bind(this)}},{key:"_fetchPaymentData",value:function(){var t=this.checkPaymentButton.dataset.orderId;this.client.get("/xrpl-connector/check-payment/"+t,this._handlePaymentData.bind(this),"application/json",!0)}},{key:"_handlePaymentData",value:function(t){JSON.parse(t).success}}])&&u(n.prototype,o),i&&u(n,i),e}(o.a);p.register("XrpPayment",l,"[data-xrp-payment-page]")}},[["DxJk","runtime","vendor-node","vendor-shared"]]]);