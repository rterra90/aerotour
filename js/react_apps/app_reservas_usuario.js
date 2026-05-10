"use strict";
(() => {
  var __create = Object.create;
  var __defProp = Object.defineProperty;
  var __getOwnPropDesc = Object.getOwnPropertyDescriptor;
  var __getOwnPropNames = Object.getOwnPropertyNames;
  var __getProtoOf = Object.getPrototypeOf;
  var __hasOwnProp = Object.prototype.hasOwnProperty;
  var __commonJS = (cb, mod) => function __require() {
    return mod || (0, cb[__getOwnPropNames(cb)[0]])((mod = { exports: {} }).exports, mod), mod.exports;
  };
  var __copyProps = (to, from, except, desc) => {
    if (from && typeof from === "object" || typeof from === "function") {
      for (let key of __getOwnPropNames(from))
        if (!__hasOwnProp.call(to, key) && key !== except)
          __defProp(to, key, { get: () => from[key], enumerable: !(desc = __getOwnPropDesc(from, key)) || desc.enumerable });
    }
    return to;
  };
  var __toESM = (mod, isNodeMode, target) => (target = mod != null ? __create(__getProtoOf(mod)) : {}, __copyProps(
    // If the importer is in node compatibility mode or this is not an ESM
    // file that has been converted to a CommonJS file using a Babel-
    // compatible transform (i.e. "__esModule" has not been set), then set
    // "default" to the CommonJS "module.exports" for node compatibility.
    isNodeMode || !mod || !mod.__esModule ? __defProp(target, "default", { value: mod, enumerable: true }) : target,
    mod
  ));

  // node_modules/react-is/cjs/react-is.development.js
  var require_react_is_development = __commonJS({
    "node_modules/react-is/cjs/react-is.development.js"(exports) {
      "use strict";
      if (true) {
        (function() {
          "use strict";
          var hasSymbol = typeof Symbol === "function" && Symbol.for;
          var REACT_ELEMENT_TYPE = hasSymbol ? Symbol.for("react.element") : 60103;
          var REACT_PORTAL_TYPE = hasSymbol ? Symbol.for("react.portal") : 60106;
          var REACT_FRAGMENT_TYPE = hasSymbol ? Symbol.for("react.fragment") : 60107;
          var REACT_STRICT_MODE_TYPE = hasSymbol ? Symbol.for("react.strict_mode") : 60108;
          var REACT_PROFILER_TYPE = hasSymbol ? Symbol.for("react.profiler") : 60114;
          var REACT_PROVIDER_TYPE = hasSymbol ? Symbol.for("react.provider") : 60109;
          var REACT_CONTEXT_TYPE = hasSymbol ? Symbol.for("react.context") : 60110;
          var REACT_ASYNC_MODE_TYPE = hasSymbol ? Symbol.for("react.async_mode") : 60111;
          var REACT_CONCURRENT_MODE_TYPE = hasSymbol ? Symbol.for("react.concurrent_mode") : 60111;
          var REACT_FORWARD_REF_TYPE = hasSymbol ? Symbol.for("react.forward_ref") : 60112;
          var REACT_SUSPENSE_TYPE = hasSymbol ? Symbol.for("react.suspense") : 60113;
          var REACT_SUSPENSE_LIST_TYPE = hasSymbol ? Symbol.for("react.suspense_list") : 60120;
          var REACT_MEMO_TYPE = hasSymbol ? Symbol.for("react.memo") : 60115;
          var REACT_LAZY_TYPE = hasSymbol ? Symbol.for("react.lazy") : 60116;
          var REACT_BLOCK_TYPE = hasSymbol ? Symbol.for("react.block") : 60121;
          var REACT_FUNDAMENTAL_TYPE = hasSymbol ? Symbol.for("react.fundamental") : 60117;
          var REACT_RESPONDER_TYPE = hasSymbol ? Symbol.for("react.responder") : 60118;
          var REACT_SCOPE_TYPE = hasSymbol ? Symbol.for("react.scope") : 60119;
          function isValidElementType(type) {
            return typeof type === "string" || typeof type === "function" || // Note: its typeof might be other than 'symbol' or 'number' if it's a polyfill.
            type === REACT_FRAGMENT_TYPE || type === REACT_CONCURRENT_MODE_TYPE || type === REACT_PROFILER_TYPE || type === REACT_STRICT_MODE_TYPE || type === REACT_SUSPENSE_TYPE || type === REACT_SUSPENSE_LIST_TYPE || typeof type === "object" && type !== null && (type.$$typeof === REACT_LAZY_TYPE || type.$$typeof === REACT_MEMO_TYPE || type.$$typeof === REACT_PROVIDER_TYPE || type.$$typeof === REACT_CONTEXT_TYPE || type.$$typeof === REACT_FORWARD_REF_TYPE || type.$$typeof === REACT_FUNDAMENTAL_TYPE || type.$$typeof === REACT_RESPONDER_TYPE || type.$$typeof === REACT_SCOPE_TYPE || type.$$typeof === REACT_BLOCK_TYPE);
          }
          function typeOf(object) {
            if (typeof object === "object" && object !== null) {
              var $$typeof = object.$$typeof;
              switch ($$typeof) {
                case REACT_ELEMENT_TYPE:
                  var type = object.type;
                  switch (type) {
                    case REACT_ASYNC_MODE_TYPE:
                    case REACT_CONCURRENT_MODE_TYPE:
                    case REACT_FRAGMENT_TYPE:
                    case REACT_PROFILER_TYPE:
                    case REACT_STRICT_MODE_TYPE:
                    case REACT_SUSPENSE_TYPE:
                      return type;
                    default:
                      var $$typeofType = type && type.$$typeof;
                      switch ($$typeofType) {
                        case REACT_CONTEXT_TYPE:
                        case REACT_FORWARD_REF_TYPE:
                        case REACT_LAZY_TYPE:
                        case REACT_MEMO_TYPE:
                        case REACT_PROVIDER_TYPE:
                          return $$typeofType;
                        default:
                          return $$typeof;
                      }
                  }
                case REACT_PORTAL_TYPE:
                  return $$typeof;
              }
            }
            return void 0;
          }
          var AsyncMode = REACT_ASYNC_MODE_TYPE;
          var ConcurrentMode = REACT_CONCURRENT_MODE_TYPE;
          var ContextConsumer = REACT_CONTEXT_TYPE;
          var ContextProvider = REACT_PROVIDER_TYPE;
          var Element = REACT_ELEMENT_TYPE;
          var ForwardRef = REACT_FORWARD_REF_TYPE;
          var Fragment5 = REACT_FRAGMENT_TYPE;
          var Lazy = REACT_LAZY_TYPE;
          var Memo = REACT_MEMO_TYPE;
          var Portal = REACT_PORTAL_TYPE;
          var Profiler = REACT_PROFILER_TYPE;
          var StrictMode = REACT_STRICT_MODE_TYPE;
          var Suspense = REACT_SUSPENSE_TYPE;
          var hasWarnedAboutDeprecatedIsAsyncMode = false;
          function isAsyncMode(object) {
            {
              if (!hasWarnedAboutDeprecatedIsAsyncMode) {
                hasWarnedAboutDeprecatedIsAsyncMode = true;
                console["warn"]("The ReactIs.isAsyncMode() alias has been deprecated, and will be removed in React 17+. Update your code to use ReactIs.isConcurrentMode() instead. It has the exact same API.");
              }
            }
            return isConcurrentMode(object) || typeOf(object) === REACT_ASYNC_MODE_TYPE;
          }
          function isConcurrentMode(object) {
            return typeOf(object) === REACT_CONCURRENT_MODE_TYPE;
          }
          function isContextConsumer(object) {
            return typeOf(object) === REACT_CONTEXT_TYPE;
          }
          function isContextProvider(object) {
            return typeOf(object) === REACT_PROVIDER_TYPE;
          }
          function isElement(object) {
            return typeof object === "object" && object !== null && object.$$typeof === REACT_ELEMENT_TYPE;
          }
          function isForwardRef(object) {
            return typeOf(object) === REACT_FORWARD_REF_TYPE;
          }
          function isFragment(object) {
            return typeOf(object) === REACT_FRAGMENT_TYPE;
          }
          function isLazy(object) {
            return typeOf(object) === REACT_LAZY_TYPE;
          }
          function isMemo(object) {
            return typeOf(object) === REACT_MEMO_TYPE;
          }
          function isPortal(object) {
            return typeOf(object) === REACT_PORTAL_TYPE;
          }
          function isProfiler(object) {
            return typeOf(object) === REACT_PROFILER_TYPE;
          }
          function isStrictMode(object) {
            return typeOf(object) === REACT_STRICT_MODE_TYPE;
          }
          function isSuspense(object) {
            return typeOf(object) === REACT_SUSPENSE_TYPE;
          }
          exports.AsyncMode = AsyncMode;
          exports.ConcurrentMode = ConcurrentMode;
          exports.ContextConsumer = ContextConsumer;
          exports.ContextProvider = ContextProvider;
          exports.Element = Element;
          exports.ForwardRef = ForwardRef;
          exports.Fragment = Fragment5;
          exports.Lazy = Lazy;
          exports.Memo = Memo;
          exports.Portal = Portal;
          exports.Profiler = Profiler;
          exports.StrictMode = StrictMode;
          exports.Suspense = Suspense;
          exports.isAsyncMode = isAsyncMode;
          exports.isConcurrentMode = isConcurrentMode;
          exports.isContextConsumer = isContextConsumer;
          exports.isContextProvider = isContextProvider;
          exports.isElement = isElement;
          exports.isForwardRef = isForwardRef;
          exports.isFragment = isFragment;
          exports.isLazy = isLazy;
          exports.isMemo = isMemo;
          exports.isPortal = isPortal;
          exports.isProfiler = isProfiler;
          exports.isStrictMode = isStrictMode;
          exports.isSuspense = isSuspense;
          exports.isValidElementType = isValidElementType;
          exports.typeOf = typeOf;
        })();
      }
    }
  });

  // node_modules/react-is/index.js
  var require_react_is = __commonJS({
    "node_modules/react-is/index.js"(exports, module) {
      "use strict";
      if (false) {
        module.exports = null;
      } else {
        module.exports = require_react_is_development();
      }
    }
  });

  // node_modules/object-assign/index.js
  var require_object_assign = __commonJS({
    "node_modules/object-assign/index.js"(exports, module) {
      "use strict";
      var getOwnPropertySymbols = Object.getOwnPropertySymbols;
      var hasOwnProperty = Object.prototype.hasOwnProperty;
      var propIsEnumerable = Object.prototype.propertyIsEnumerable;
      function toObject(val) {
        if (val === null || val === void 0) {
          throw new TypeError("Object.assign cannot be called with null or undefined");
        }
        return Object(val);
      }
      function shouldUseNative() {
        try {
          if (!Object.assign) {
            return false;
          }
          var test1 = new String("abc");
          test1[5] = "de";
          if (Object.getOwnPropertyNames(test1)[0] === "5") {
            return false;
          }
          var test2 = {};
          for (var i = 0; i < 10; i++) {
            test2["_" + String.fromCharCode(i)] = i;
          }
          var order2 = Object.getOwnPropertyNames(test2).map(function(n) {
            return test2[n];
          });
          if (order2.join("") !== "0123456789") {
            return false;
          }
          var test3 = {};
          "abcdefghijklmnopqrst".split("").forEach(function(letter) {
            test3[letter] = letter;
          });
          if (Object.keys(Object.assign({}, test3)).join("") !== "abcdefghijklmnopqrst") {
            return false;
          }
          return true;
        } catch (err) {
          return false;
        }
      }
      module.exports = shouldUseNative() ? Object.assign : function(target, source) {
        var from;
        var to = toObject(target);
        var symbols;
        for (var s = 1; s < arguments.length; s++) {
          from = Object(arguments[s]);
          for (var key in from) {
            if (hasOwnProperty.call(from, key)) {
              to[key] = from[key];
            }
          }
          if (getOwnPropertySymbols) {
            symbols = getOwnPropertySymbols(from);
            for (var i = 0; i < symbols.length; i++) {
              if (propIsEnumerable.call(from, symbols[i])) {
                to[symbols[i]] = from[symbols[i]];
              }
            }
          }
        }
        return to;
      };
    }
  });

  // node_modules/prop-types/lib/ReactPropTypesSecret.js
  var require_ReactPropTypesSecret = __commonJS({
    "node_modules/prop-types/lib/ReactPropTypesSecret.js"(exports, module) {
      "use strict";
      var ReactPropTypesSecret = "SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED";
      module.exports = ReactPropTypesSecret;
    }
  });

  // node_modules/prop-types/lib/has.js
  var require_has = __commonJS({
    "node_modules/prop-types/lib/has.js"(exports, module) {
      module.exports = Function.call.bind(Object.prototype.hasOwnProperty);
    }
  });

  // node_modules/prop-types/checkPropTypes.js
  var require_checkPropTypes = __commonJS({
    "node_modules/prop-types/checkPropTypes.js"(exports, module) {
      "use strict";
      var printWarning = function() {
      };
      if (true) {
        ReactPropTypesSecret = require_ReactPropTypesSecret();
        loggedTypeFailures = {};
        has = require_has();
        printWarning = function(text) {
          var message = "Warning: " + text;
          if (typeof console !== "undefined") {
            console.error(message);
          }
          try {
            throw new Error(message);
          } catch (x) {
          }
        };
      }
      var ReactPropTypesSecret;
      var loggedTypeFailures;
      var has;
      function checkPropTypes(typeSpecs, values, location, componentName, getStack) {
        if (true) {
          for (var typeSpecName in typeSpecs) {
            if (has(typeSpecs, typeSpecName)) {
              var error;
              try {
                if (typeof typeSpecs[typeSpecName] !== "function") {
                  var err = Error(
                    (componentName || "React class") + ": " + location + " type `" + typeSpecName + "` is invalid; it must be a function, usually from the `prop-types` package, but received `" + typeof typeSpecs[typeSpecName] + "`.This often happens because of typos such as `PropTypes.function` instead of `PropTypes.func`."
                  );
                  err.name = "Invariant Violation";
                  throw err;
                }
                error = typeSpecs[typeSpecName](values, typeSpecName, componentName, location, null, ReactPropTypesSecret);
              } catch (ex) {
                error = ex;
              }
              if (error && !(error instanceof Error)) {
                printWarning(
                  (componentName || "React class") + ": type specification of " + location + " `" + typeSpecName + "` is invalid; the type checker function must return `null` or an `Error` but returned a " + typeof error + ". You may have forgotten to pass an argument to the type checker creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and shape all require an argument)."
                );
              }
              if (error instanceof Error && !(error.message in loggedTypeFailures)) {
                loggedTypeFailures[error.message] = true;
                var stack = getStack ? getStack() : "";
                printWarning(
                  "Failed " + location + " type: " + error.message + (stack != null ? stack : "")
                );
              }
            }
          }
        }
      }
      checkPropTypes.resetWarningCache = function() {
        if (true) {
          loggedTypeFailures = {};
        }
      };
      module.exports = checkPropTypes;
    }
  });

  // node_modules/prop-types/factoryWithTypeCheckers.js
  var require_factoryWithTypeCheckers = __commonJS({
    "node_modules/prop-types/factoryWithTypeCheckers.js"(exports, module) {
      "use strict";
      var ReactIs = require_react_is();
      var assign = require_object_assign();
      var ReactPropTypesSecret = require_ReactPropTypesSecret();
      var has = require_has();
      var checkPropTypes = require_checkPropTypes();
      var printWarning = function() {
      };
      if (true) {
        printWarning = function(text) {
          var message = "Warning: " + text;
          if (typeof console !== "undefined") {
            console.error(message);
          }
          try {
            throw new Error(message);
          } catch (x) {
          }
        };
      }
      function emptyFunctionThatReturnsNull() {
        return null;
      }
      module.exports = function(isValidElement, throwOnDirectAccess) {
        var ITERATOR_SYMBOL = typeof Symbol === "function" && Symbol.iterator;
        var FAUX_ITERATOR_SYMBOL = "@@iterator";
        function getIteratorFn(maybeIterable) {
          var iteratorFn = maybeIterable && (ITERATOR_SYMBOL && maybeIterable[ITERATOR_SYMBOL] || maybeIterable[FAUX_ITERATOR_SYMBOL]);
          if (typeof iteratorFn === "function") {
            return iteratorFn;
          }
        }
        var ANONYMOUS = "<<anonymous>>";
        var ReactPropTypes = {
          array: createPrimitiveTypeChecker("array"),
          bigint: createPrimitiveTypeChecker("bigint"),
          bool: createPrimitiveTypeChecker("boolean"),
          func: createPrimitiveTypeChecker("function"),
          number: createPrimitiveTypeChecker("number"),
          object: createPrimitiveTypeChecker("object"),
          string: createPrimitiveTypeChecker("string"),
          symbol: createPrimitiveTypeChecker("symbol"),
          any: createAnyTypeChecker(),
          arrayOf: createArrayOfTypeChecker,
          element: createElementTypeChecker(),
          elementType: createElementTypeTypeChecker(),
          instanceOf: createInstanceTypeChecker,
          node: createNodeChecker(),
          objectOf: createObjectOfTypeChecker,
          oneOf: createEnumTypeChecker,
          oneOfType: createUnionTypeChecker,
          shape: createShapeTypeChecker,
          exact: createStrictShapeTypeChecker
        };
        function is(x, y) {
          if (x === y) {
            return x !== 0 || 1 / x === 1 / y;
          } else {
            return x !== x && y !== y;
          }
        }
        function PropTypeError(message, data) {
          this.message = message;
          this.data = data && typeof data === "object" ? data : {};
          this.stack = "";
        }
        PropTypeError.prototype = Error.prototype;
        function createChainableTypeChecker(validate) {
          if (true) {
            var manualPropTypeCallCache = {};
            var manualPropTypeWarningCount = 0;
          }
          function checkType(isRequired, props, propName, componentName, location, propFullName, secret) {
            componentName = componentName || ANONYMOUS;
            propFullName = propFullName || propName;
            if (secret !== ReactPropTypesSecret) {
              if (throwOnDirectAccess) {
                var err = new Error(
                  "Calling PropTypes validators directly is not supported by the `prop-types` package. Use `PropTypes.checkPropTypes()` to call them. Read more at http://fb.me/use-check-prop-types"
                );
                err.name = "Invariant Violation";
                throw err;
              } else if (typeof console !== "undefined") {
                var cacheKey = componentName + ":" + propName;
                if (!manualPropTypeCallCache[cacheKey] && // Avoid spamming the console because they are often not actionable except for lib authors
                manualPropTypeWarningCount < 3) {
                  printWarning(
                    "You are manually calling a React.PropTypes validation function for the `" + propFullName + "` prop on `" + componentName + "`. This is deprecated and will throw in the standalone `prop-types` package. You may be seeing this warning due to a third-party PropTypes library. See https://fb.me/react-warning-dont-call-proptypes for details."
                  );
                  manualPropTypeCallCache[cacheKey] = true;
                  manualPropTypeWarningCount++;
                }
              }
            }
            if (props[propName] == null) {
              if (isRequired) {
                if (props[propName] === null) {
                  return new PropTypeError("The " + location + " `" + propFullName + "` is marked as required " + ("in `" + componentName + "`, but its value is `null`."));
                }
                return new PropTypeError("The " + location + " `" + propFullName + "` is marked as required in " + ("`" + componentName + "`, but its value is `undefined`."));
              }
              return null;
            } else {
              return validate(props, propName, componentName, location, propFullName);
            }
          }
          var chainedCheckType = checkType.bind(null, false);
          chainedCheckType.isRequired = checkType.bind(null, true);
          return chainedCheckType;
        }
        function createPrimitiveTypeChecker(expectedType) {
          function validate(props, propName, componentName, location, propFullName, secret) {
            var propValue = props[propName];
            var propType = getPropType(propValue);
            if (propType !== expectedType) {
              var preciseType = getPreciseType(propValue);
              return new PropTypeError(
                "Invalid " + location + " `" + propFullName + "` of type " + ("`" + preciseType + "` supplied to `" + componentName + "`, expected ") + ("`" + expectedType + "`."),
                { expectedType }
              );
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function createAnyTypeChecker() {
          return createChainableTypeChecker(emptyFunctionThatReturnsNull);
        }
        function createArrayOfTypeChecker(typeChecker) {
          function validate(props, propName, componentName, location, propFullName) {
            if (typeof typeChecker !== "function") {
              return new PropTypeError("Property `" + propFullName + "` of component `" + componentName + "` has invalid PropType notation inside arrayOf.");
            }
            var propValue = props[propName];
            if (!Array.isArray(propValue)) {
              var propType = getPropType(propValue);
              return new PropTypeError("Invalid " + location + " `" + propFullName + "` of type " + ("`" + propType + "` supplied to `" + componentName + "`, expected an array."));
            }
            for (var i = 0; i < propValue.length; i++) {
              var error = typeChecker(propValue, i, componentName, location, propFullName + "[" + i + "]", ReactPropTypesSecret);
              if (error instanceof Error) {
                return error;
              }
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function createElementTypeChecker() {
          function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            if (!isValidElement(propValue)) {
              var propType = getPropType(propValue);
              return new PropTypeError("Invalid " + location + " `" + propFullName + "` of type " + ("`" + propType + "` supplied to `" + componentName + "`, expected a single ReactElement."));
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function createElementTypeTypeChecker() {
          function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            if (!ReactIs.isValidElementType(propValue)) {
              var propType = getPropType(propValue);
              return new PropTypeError("Invalid " + location + " `" + propFullName + "` of type " + ("`" + propType + "` supplied to `" + componentName + "`, expected a single ReactElement type."));
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function createInstanceTypeChecker(expectedClass) {
          function validate(props, propName, componentName, location, propFullName) {
            if (!(props[propName] instanceof expectedClass)) {
              var expectedClassName = expectedClass.name || ANONYMOUS;
              var actualClassName = getClassName(props[propName]);
              return new PropTypeError("Invalid " + location + " `" + propFullName + "` of type " + ("`" + actualClassName + "` supplied to `" + componentName + "`, expected ") + ("instance of `" + expectedClassName + "`."));
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function createEnumTypeChecker(expectedValues) {
          if (!Array.isArray(expectedValues)) {
            if (true) {
              if (arguments.length > 1) {
                printWarning(
                  "Invalid arguments supplied to oneOf, expected an array, got " + arguments.length + " arguments. A common mistake is to write oneOf(x, y, z) instead of oneOf([x, y, z])."
                );
              } else {
                printWarning("Invalid argument supplied to oneOf, expected an array.");
              }
            }
            return emptyFunctionThatReturnsNull;
          }
          function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            for (var i = 0; i < expectedValues.length; i++) {
              if (is(propValue, expectedValues[i])) {
                return null;
              }
            }
            var valuesString = JSON.stringify(expectedValues, function replacer(key, value) {
              var type = getPreciseType(value);
              if (type === "symbol") {
                return String(value);
              }
              return value;
            });
            return new PropTypeError("Invalid " + location + " `" + propFullName + "` of value `" + String(propValue) + "` " + ("supplied to `" + componentName + "`, expected one of " + valuesString + "."));
          }
          return createChainableTypeChecker(validate);
        }
        function createObjectOfTypeChecker(typeChecker) {
          function validate(props, propName, componentName, location, propFullName) {
            if (typeof typeChecker !== "function") {
              return new PropTypeError("Property `" + propFullName + "` of component `" + componentName + "` has invalid PropType notation inside objectOf.");
            }
            var propValue = props[propName];
            var propType = getPropType(propValue);
            if (propType !== "object") {
              return new PropTypeError("Invalid " + location + " `" + propFullName + "` of type " + ("`" + propType + "` supplied to `" + componentName + "`, expected an object."));
            }
            for (var key in propValue) {
              if (has(propValue, key)) {
                var error = typeChecker(propValue, key, componentName, location, propFullName + "." + key, ReactPropTypesSecret);
                if (error instanceof Error) {
                  return error;
                }
              }
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function createUnionTypeChecker(arrayOfTypeCheckers) {
          if (!Array.isArray(arrayOfTypeCheckers)) {
            true ? printWarning("Invalid argument supplied to oneOfType, expected an instance of array.") : void 0;
            return emptyFunctionThatReturnsNull;
          }
          for (var i = 0; i < arrayOfTypeCheckers.length; i++) {
            var checker = arrayOfTypeCheckers[i];
            if (typeof checker !== "function") {
              printWarning(
                "Invalid argument supplied to oneOfType. Expected an array of check functions, but received " + getPostfixForTypeWarning(checker) + " at index " + i + "."
              );
              return emptyFunctionThatReturnsNull;
            }
          }
          function validate(props, propName, componentName, location, propFullName) {
            var expectedTypes = [];
            for (var i2 = 0; i2 < arrayOfTypeCheckers.length; i2++) {
              var checker2 = arrayOfTypeCheckers[i2];
              var checkerResult = checker2(props, propName, componentName, location, propFullName, ReactPropTypesSecret);
              if (checkerResult == null) {
                return null;
              }
              if (checkerResult.data && has(checkerResult.data, "expectedType")) {
                expectedTypes.push(checkerResult.data.expectedType);
              }
            }
            var expectedTypesMessage = expectedTypes.length > 0 ? ", expected one of type [" + expectedTypes.join(", ") + "]" : "";
            return new PropTypeError("Invalid " + location + " `" + propFullName + "` supplied to " + ("`" + componentName + "`" + expectedTypesMessage + "."));
          }
          return createChainableTypeChecker(validate);
        }
        function createNodeChecker() {
          function validate(props, propName, componentName, location, propFullName) {
            if (!isNode(props[propName])) {
              return new PropTypeError("Invalid " + location + " `" + propFullName + "` supplied to " + ("`" + componentName + "`, expected a ReactNode."));
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function invalidValidatorError(componentName, location, propFullName, key, type) {
          return new PropTypeError(
            (componentName || "React class") + ": " + location + " type `" + propFullName + "." + key + "` is invalid; it must be a function, usually from the `prop-types` package, but received `" + type + "`."
          );
        }
        function createShapeTypeChecker(shapeTypes) {
          function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            var propType = getPropType(propValue);
            if (propType !== "object") {
              return new PropTypeError("Invalid " + location + " `" + propFullName + "` of type `" + propType + "` " + ("supplied to `" + componentName + "`, expected `object`."));
            }
            for (var key in shapeTypes) {
              var checker = shapeTypes[key];
              if (typeof checker !== "function") {
                return invalidValidatorError(componentName, location, propFullName, key, getPreciseType(checker));
              }
              var error = checker(propValue, key, componentName, location, propFullName + "." + key, ReactPropTypesSecret);
              if (error) {
                return error;
              }
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function createStrictShapeTypeChecker(shapeTypes) {
          function validate(props, propName, componentName, location, propFullName) {
            var propValue = props[propName];
            var propType = getPropType(propValue);
            if (propType !== "object") {
              return new PropTypeError("Invalid " + location + " `" + propFullName + "` of type `" + propType + "` " + ("supplied to `" + componentName + "`, expected `object`."));
            }
            var allKeys = assign({}, props[propName], shapeTypes);
            for (var key in allKeys) {
              var checker = shapeTypes[key];
              if (has(shapeTypes, key) && typeof checker !== "function") {
                return invalidValidatorError(componentName, location, propFullName, key, getPreciseType(checker));
              }
              if (!checker) {
                return new PropTypeError(
                  "Invalid " + location + " `" + propFullName + "` key `" + key + "` supplied to `" + componentName + "`.\nBad object: " + JSON.stringify(props[propName], null, "  ") + "\nValid keys: " + JSON.stringify(Object.keys(shapeTypes), null, "  ")
                );
              }
              var error = checker(propValue, key, componentName, location, propFullName + "." + key, ReactPropTypesSecret);
              if (error) {
                return error;
              }
            }
            return null;
          }
          return createChainableTypeChecker(validate);
        }
        function isNode(propValue) {
          switch (typeof propValue) {
            case "number":
            case "string":
            case "undefined":
              return true;
            case "boolean":
              return !propValue;
            case "object":
              if (Array.isArray(propValue)) {
                return propValue.every(isNode);
              }
              if (propValue === null || isValidElement(propValue)) {
                return true;
              }
              var iteratorFn = getIteratorFn(propValue);
              if (iteratorFn) {
                var iterator = iteratorFn.call(propValue);
                var step;
                if (iteratorFn !== propValue.entries) {
                  while (!(step = iterator.next()).done) {
                    if (!isNode(step.value)) {
                      return false;
                    }
                  }
                } else {
                  while (!(step = iterator.next()).done) {
                    var entry = step.value;
                    if (entry) {
                      if (!isNode(entry[1])) {
                        return false;
                      }
                    }
                  }
                }
              } else {
                return false;
              }
              return true;
            default:
              return false;
          }
        }
        function isSymbol(propType, propValue) {
          if (propType === "symbol") {
            return true;
          }
          if (!propValue) {
            return false;
          }
          if (propValue["@@toStringTag"] === "Symbol") {
            return true;
          }
          if (typeof Symbol === "function" && propValue instanceof Symbol) {
            return true;
          }
          return false;
        }
        function getPropType(propValue) {
          var propType = typeof propValue;
          if (Array.isArray(propValue)) {
            return "array";
          }
          if (propValue instanceof RegExp) {
            return "object";
          }
          if (isSymbol(propType, propValue)) {
            return "symbol";
          }
          return propType;
        }
        function getPreciseType(propValue) {
          if (typeof propValue === "undefined" || propValue === null) {
            return "" + propValue;
          }
          var propType = getPropType(propValue);
          if (propType === "object") {
            if (propValue instanceof Date) {
              return "date";
            } else if (propValue instanceof RegExp) {
              return "regexp";
            }
          }
          return propType;
        }
        function getPostfixForTypeWarning(value) {
          var type = getPreciseType(value);
          switch (type) {
            case "array":
            case "object":
              return "an " + type;
            case "boolean":
            case "date":
            case "regexp":
              return "a " + type;
            default:
              return type;
          }
        }
        function getClassName(propValue) {
          if (!propValue.constructor || !propValue.constructor.name) {
            return ANONYMOUS;
          }
          return propValue.constructor.name;
        }
        ReactPropTypes.checkPropTypes = checkPropTypes;
        ReactPropTypes.resetWarningCache = checkPropTypes.resetWarningCache;
        ReactPropTypes.PropTypes = ReactPropTypes;
        return ReactPropTypes;
      };
    }
  });

  // node_modules/prop-types/index.js
  var require_prop_types = __commonJS({
    "node_modules/prop-types/index.js"(exports, module) {
      if (true) {
        ReactIs = require_react_is();
        throwOnDirectAccess = true;
        module.exports = require_factoryWithTypeCheckers()(ReactIs.isElement, throwOnDirectAccess);
      } else {
        module.exports = null();
      }
      var ReactIs;
      var throwOnDirectAccess;
    }
  });

  // node_modules/react/cjs/react.development.js
  var require_react_development = __commonJS({
    "node_modules/react/cjs/react.development.js"(exports, module) {
      "use strict";
      if (true) {
        (function() {
          "use strict";
          if (typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ !== "undefined" && typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStart === "function") {
            __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStart(new Error());
          }
          var ReactVersion = "18.3.1";
          var REACT_ELEMENT_TYPE = Symbol.for("react.element");
          var REACT_PORTAL_TYPE = Symbol.for("react.portal");
          var REACT_FRAGMENT_TYPE = Symbol.for("react.fragment");
          var REACT_STRICT_MODE_TYPE = Symbol.for("react.strict_mode");
          var REACT_PROFILER_TYPE = Symbol.for("react.profiler");
          var REACT_PROVIDER_TYPE = Symbol.for("react.provider");
          var REACT_CONTEXT_TYPE = Symbol.for("react.context");
          var REACT_FORWARD_REF_TYPE = Symbol.for("react.forward_ref");
          var REACT_SUSPENSE_TYPE = Symbol.for("react.suspense");
          var REACT_SUSPENSE_LIST_TYPE = Symbol.for("react.suspense_list");
          var REACT_MEMO_TYPE = Symbol.for("react.memo");
          var REACT_LAZY_TYPE = Symbol.for("react.lazy");
          var REACT_OFFSCREEN_TYPE = Symbol.for("react.offscreen");
          var MAYBE_ITERATOR_SYMBOL = Symbol.iterator;
          var FAUX_ITERATOR_SYMBOL = "@@iterator";
          function getIteratorFn(maybeIterable) {
            if (maybeIterable === null || typeof maybeIterable !== "object") {
              return null;
            }
            var maybeIterator = MAYBE_ITERATOR_SYMBOL && maybeIterable[MAYBE_ITERATOR_SYMBOL] || maybeIterable[FAUX_ITERATOR_SYMBOL];
            if (typeof maybeIterator === "function") {
              return maybeIterator;
            }
            return null;
          }
          var ReactCurrentDispatcher = {
            /**
             * @internal
             * @type {ReactComponent}
             */
            current: null
          };
          var ReactCurrentBatchConfig = {
            transition: null
          };
          var ReactCurrentActQueue = {
            current: null,
            // Used to reproduce behavior of `batchedUpdates` in legacy mode.
            isBatchingLegacy: false,
            didScheduleLegacyUpdate: false
          };
          var ReactCurrentOwner = {
            /**
             * @internal
             * @type {ReactComponent}
             */
            current: null
          };
          var ReactDebugCurrentFrame = {};
          var currentExtraStackFrame = null;
          function setExtraStackFrame(stack) {
            {
              currentExtraStackFrame = stack;
            }
          }
          {
            ReactDebugCurrentFrame.setExtraStackFrame = function(stack) {
              {
                currentExtraStackFrame = stack;
              }
            };
            ReactDebugCurrentFrame.getCurrentStack = null;
            ReactDebugCurrentFrame.getStackAddendum = function() {
              var stack = "";
              if (currentExtraStackFrame) {
                stack += currentExtraStackFrame;
              }
              var impl = ReactDebugCurrentFrame.getCurrentStack;
              if (impl) {
                stack += impl() || "";
              }
              return stack;
            };
          }
          var enableScopeAPI = false;
          var enableCacheElement = false;
          var enableTransitionTracing = false;
          var enableLegacyHidden = false;
          var enableDebugTracing = false;
          var ReactSharedInternals = {
            ReactCurrentDispatcher,
            ReactCurrentBatchConfig,
            ReactCurrentOwner
          };
          {
            ReactSharedInternals.ReactDebugCurrentFrame = ReactDebugCurrentFrame;
            ReactSharedInternals.ReactCurrentActQueue = ReactCurrentActQueue;
          }
          function warn(format) {
            {
              {
                for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                  args[_key - 1] = arguments[_key];
                }
                printWarning("warn", format, args);
              }
            }
          }
          function error(format) {
            {
              {
                for (var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
                  args[_key2 - 1] = arguments[_key2];
                }
                printWarning("error", format, args);
              }
            }
          }
          function printWarning(level, format, args) {
            {
              var ReactDebugCurrentFrame2 = ReactSharedInternals.ReactDebugCurrentFrame;
              var stack = ReactDebugCurrentFrame2.getStackAddendum();
              if (stack !== "") {
                format += "%s";
                args = args.concat([stack]);
              }
              var argsWithFormat = args.map(function(item) {
                return String(item);
              });
              argsWithFormat.unshift("Warning: " + format);
              Function.prototype.apply.call(console[level], console, argsWithFormat);
            }
          }
          var didWarnStateUpdateForUnmountedComponent = {};
          function warnNoop(publicInstance, callerName) {
            {
              var _constructor = publicInstance.constructor;
              var componentName = _constructor && (_constructor.displayName || _constructor.name) || "ReactClass";
              var warningKey = componentName + "." + callerName;
              if (didWarnStateUpdateForUnmountedComponent[warningKey]) {
                return;
              }
              error("Can't call %s on a component that is not yet mounted. This is a no-op, but it might indicate a bug in your application. Instead, assign to `this.state` directly or define a `state = {};` class property with the desired state in the %s component.", callerName, componentName);
              didWarnStateUpdateForUnmountedComponent[warningKey] = true;
            }
          }
          var ReactNoopUpdateQueue = {
            /**
             * Checks whether or not this composite component is mounted.
             * @param {ReactClass} publicInstance The instance we want to test.
             * @return {boolean} True if mounted, false otherwise.
             * @protected
             * @final
             */
            isMounted: function(publicInstance) {
              return false;
            },
            /**
             * Forces an update. This should only be invoked when it is known with
             * certainty that we are **not** in a DOM transaction.
             *
             * You may want to call this when you know that some deeper aspect of the
             * component's state has changed but `setState` was not called.
             *
             * This will not invoke `shouldComponentUpdate`, but it will invoke
             * `componentWillUpdate` and `componentDidUpdate`.
             *
             * @param {ReactClass} publicInstance The instance that should rerender.
             * @param {?function} callback Called after component is updated.
             * @param {?string} callerName name of the calling function in the public API.
             * @internal
             */
            enqueueForceUpdate: function(publicInstance, callback, callerName) {
              warnNoop(publicInstance, "forceUpdate");
            },
            /**
             * Replaces all of the state. Always use this or `setState` to mutate state.
             * You should treat `this.state` as immutable.
             *
             * There is no guarantee that `this.state` will be immediately updated, so
             * accessing `this.state` after calling this method may return the old value.
             *
             * @param {ReactClass} publicInstance The instance that should rerender.
             * @param {object} completeState Next state.
             * @param {?function} callback Called after component is updated.
             * @param {?string} callerName name of the calling function in the public API.
             * @internal
             */
            enqueueReplaceState: function(publicInstance, completeState, callback, callerName) {
              warnNoop(publicInstance, "replaceState");
            },
            /**
             * Sets a subset of the state. This only exists because _pendingState is
             * internal. This provides a merging strategy that is not available to deep
             * properties which is confusing. TODO: Expose pendingState or don't use it
             * during the merge.
             *
             * @param {ReactClass} publicInstance The instance that should rerender.
             * @param {object} partialState Next partial state to be merged with state.
             * @param {?function} callback Called after component is updated.
             * @param {?string} Name of the calling function in the public API.
             * @internal
             */
            enqueueSetState: function(publicInstance, partialState, callback, callerName) {
              warnNoop(publicInstance, "setState");
            }
          };
          var assign = Object.assign;
          var emptyObject = {};
          {
            Object.freeze(emptyObject);
          }
          function Component(props, context, updater) {
            this.props = props;
            this.context = context;
            this.refs = emptyObject;
            this.updater = updater || ReactNoopUpdateQueue;
          }
          Component.prototype.isReactComponent = {};
          Component.prototype.setState = function(partialState, callback) {
            if (typeof partialState !== "object" && typeof partialState !== "function" && partialState != null) {
              throw new Error("setState(...): takes an object of state variables to update or a function which returns an object of state variables.");
            }
            this.updater.enqueueSetState(this, partialState, callback, "setState");
          };
          Component.prototype.forceUpdate = function(callback) {
            this.updater.enqueueForceUpdate(this, callback, "forceUpdate");
          };
          {
            var deprecatedAPIs = {
              isMounted: ["isMounted", "Instead, make sure to clean up subscriptions and pending requests in componentWillUnmount to prevent memory leaks."],
              replaceState: ["replaceState", "Refactor your code to use setState instead (see https://github.com/facebook/react/issues/3236)."]
            };
            var defineDeprecationWarning = function(methodName, info) {
              Object.defineProperty(Component.prototype, methodName, {
                get: function() {
                  warn("%s(...) is deprecated in plain JavaScript React classes. %s", info[0], info[1]);
                  return void 0;
                }
              });
            };
            for (var fnName in deprecatedAPIs) {
              if (deprecatedAPIs.hasOwnProperty(fnName)) {
                defineDeprecationWarning(fnName, deprecatedAPIs[fnName]);
              }
            }
          }
          function ComponentDummy() {
          }
          ComponentDummy.prototype = Component.prototype;
          function PureComponent(props, context, updater) {
            this.props = props;
            this.context = context;
            this.refs = emptyObject;
            this.updater = updater || ReactNoopUpdateQueue;
          }
          var pureComponentPrototype = PureComponent.prototype = new ComponentDummy();
          pureComponentPrototype.constructor = PureComponent;
          assign(pureComponentPrototype, Component.prototype);
          pureComponentPrototype.isPureReactComponent = true;
          function createRef() {
            var refObject = {
              current: null
            };
            {
              Object.seal(refObject);
            }
            return refObject;
          }
          var isArrayImpl = Array.isArray;
          function isArray(a) {
            return isArrayImpl(a);
          }
          function typeName(value) {
            {
              var hasToStringTag = typeof Symbol === "function" && Symbol.toStringTag;
              var type = hasToStringTag && value[Symbol.toStringTag] || value.constructor.name || "Object";
              return type;
            }
          }
          function willCoercionThrow(value) {
            {
              try {
                testStringCoercion(value);
                return false;
              } catch (e) {
                return true;
              }
            }
          }
          function testStringCoercion(value) {
            return "" + value;
          }
          function checkKeyStringCoercion(value) {
            {
              if (willCoercionThrow(value)) {
                error("The provided key is an unsupported type %s. This value must be coerced to a string before before using it here.", typeName(value));
                return testStringCoercion(value);
              }
            }
          }
          function getWrappedName(outerType, innerType, wrapperName) {
            var displayName = outerType.displayName;
            if (displayName) {
              return displayName;
            }
            var functionName = innerType.displayName || innerType.name || "";
            return functionName !== "" ? wrapperName + "(" + functionName + ")" : wrapperName;
          }
          function getContextName(type) {
            return type.displayName || "Context";
          }
          function getComponentNameFromType(type) {
            if (type == null) {
              return null;
            }
            {
              if (typeof type.tag === "number") {
                error("Received an unexpected object in getComponentNameFromType(). This is likely a bug in React. Please file an issue.");
              }
            }
            if (typeof type === "function") {
              return type.displayName || type.name || null;
            }
            if (typeof type === "string") {
              return type;
            }
            switch (type) {
              case REACT_FRAGMENT_TYPE:
                return "Fragment";
              case REACT_PORTAL_TYPE:
                return "Portal";
              case REACT_PROFILER_TYPE:
                return "Profiler";
              case REACT_STRICT_MODE_TYPE:
                return "StrictMode";
              case REACT_SUSPENSE_TYPE:
                return "Suspense";
              case REACT_SUSPENSE_LIST_TYPE:
                return "SuspenseList";
            }
            if (typeof type === "object") {
              switch (type.$$typeof) {
                case REACT_CONTEXT_TYPE:
                  var context = type;
                  return getContextName(context) + ".Consumer";
                case REACT_PROVIDER_TYPE:
                  var provider = type;
                  return getContextName(provider._context) + ".Provider";
                case REACT_FORWARD_REF_TYPE:
                  return getWrappedName(type, type.render, "ForwardRef");
                case REACT_MEMO_TYPE:
                  var outerName = type.displayName || null;
                  if (outerName !== null) {
                    return outerName;
                  }
                  return getComponentNameFromType(type.type) || "Memo";
                case REACT_LAZY_TYPE: {
                  var lazyComponent = type;
                  var payload = lazyComponent._payload;
                  var init = lazyComponent._init;
                  try {
                    return getComponentNameFromType(init(payload));
                  } catch (x) {
                    return null;
                  }
                }
              }
            }
            return null;
          }
          var hasOwnProperty = Object.prototype.hasOwnProperty;
          var RESERVED_PROPS = {
            key: true,
            ref: true,
            __self: true,
            __source: true
          };
          var specialPropKeyWarningShown, specialPropRefWarningShown, didWarnAboutStringRefs;
          {
            didWarnAboutStringRefs = {};
          }
          function hasValidRef(config) {
            {
              if (hasOwnProperty.call(config, "ref")) {
                var getter = Object.getOwnPropertyDescriptor(config, "ref").get;
                if (getter && getter.isReactWarning) {
                  return false;
                }
              }
            }
            return config.ref !== void 0;
          }
          function hasValidKey(config) {
            {
              if (hasOwnProperty.call(config, "key")) {
                var getter = Object.getOwnPropertyDescriptor(config, "key").get;
                if (getter && getter.isReactWarning) {
                  return false;
                }
              }
            }
            return config.key !== void 0;
          }
          function defineKeyPropWarningGetter(props, displayName) {
            var warnAboutAccessingKey = function() {
              {
                if (!specialPropKeyWarningShown) {
                  specialPropKeyWarningShown = true;
                  error("%s: `key` is not a prop. Trying to access it will result in `undefined` being returned. If you need to access the same value within the child component, you should pass it as a different prop. (https://reactjs.org/link/special-props)", displayName);
                }
              }
            };
            warnAboutAccessingKey.isReactWarning = true;
            Object.defineProperty(props, "key", {
              get: warnAboutAccessingKey,
              configurable: true
            });
          }
          function defineRefPropWarningGetter(props, displayName) {
            var warnAboutAccessingRef = function() {
              {
                if (!specialPropRefWarningShown) {
                  specialPropRefWarningShown = true;
                  error("%s: `ref` is not a prop. Trying to access it will result in `undefined` being returned. If you need to access the same value within the child component, you should pass it as a different prop. (https://reactjs.org/link/special-props)", displayName);
                }
              }
            };
            warnAboutAccessingRef.isReactWarning = true;
            Object.defineProperty(props, "ref", {
              get: warnAboutAccessingRef,
              configurable: true
            });
          }
          function warnIfStringRefCannotBeAutoConverted(config) {
            {
              if (typeof config.ref === "string" && ReactCurrentOwner.current && config.__self && ReactCurrentOwner.current.stateNode !== config.__self) {
                var componentName = getComponentNameFromType(ReactCurrentOwner.current.type);
                if (!didWarnAboutStringRefs[componentName]) {
                  error('Component "%s" contains the string ref "%s". Support for string refs will be removed in a future major release. This case cannot be automatically converted to an arrow function. We ask you to manually fix this case by using useRef() or createRef() instead. Learn more about using refs safely here: https://reactjs.org/link/strict-mode-string-ref', componentName, config.ref);
                  didWarnAboutStringRefs[componentName] = true;
                }
              }
            }
          }
          var ReactElement = function(type, key, ref, self, source, owner, props) {
            var element = {
              // This tag allows us to uniquely identify this as a React Element
              $$typeof: REACT_ELEMENT_TYPE,
              // Built-in properties that belong on the element
              type,
              key,
              ref,
              props,
              // Record the component responsible for creating this element.
              _owner: owner
            };
            {
              element._store = {};
              Object.defineProperty(element._store, "validated", {
                configurable: false,
                enumerable: false,
                writable: true,
                value: false
              });
              Object.defineProperty(element, "_self", {
                configurable: false,
                enumerable: false,
                writable: false,
                value: self
              });
              Object.defineProperty(element, "_source", {
                configurable: false,
                enumerable: false,
                writable: false,
                value: source
              });
              if (Object.freeze) {
                Object.freeze(element.props);
                Object.freeze(element);
              }
            }
            return element;
          };
          function createElement(type, config, children) {
            var propName;
            var props = {};
            var key = null;
            var ref = null;
            var self = null;
            var source = null;
            if (config != null) {
              if (hasValidRef(config)) {
                ref = config.ref;
                {
                  warnIfStringRefCannotBeAutoConverted(config);
                }
              }
              if (hasValidKey(config)) {
                {
                  checkKeyStringCoercion(config.key);
                }
                key = "" + config.key;
              }
              self = config.__self === void 0 ? null : config.__self;
              source = config.__source === void 0 ? null : config.__source;
              for (propName in config) {
                if (hasOwnProperty.call(config, propName) && !RESERVED_PROPS.hasOwnProperty(propName)) {
                  props[propName] = config[propName];
                }
              }
            }
            var childrenLength = arguments.length - 2;
            if (childrenLength === 1) {
              props.children = children;
            } else if (childrenLength > 1) {
              var childArray = Array(childrenLength);
              for (var i = 0; i < childrenLength; i++) {
                childArray[i] = arguments[i + 2];
              }
              {
                if (Object.freeze) {
                  Object.freeze(childArray);
                }
              }
              props.children = childArray;
            }
            if (type && type.defaultProps) {
              var defaultProps = type.defaultProps;
              for (propName in defaultProps) {
                if (props[propName] === void 0) {
                  props[propName] = defaultProps[propName];
                }
              }
            }
            {
              if (key || ref) {
                var displayName = typeof type === "function" ? type.displayName || type.name || "Unknown" : type;
                if (key) {
                  defineKeyPropWarningGetter(props, displayName);
                }
                if (ref) {
                  defineRefPropWarningGetter(props, displayName);
                }
              }
            }
            return ReactElement(type, key, ref, self, source, ReactCurrentOwner.current, props);
          }
          function cloneAndReplaceKey(oldElement, newKey) {
            var newElement = ReactElement(oldElement.type, newKey, oldElement.ref, oldElement._self, oldElement._source, oldElement._owner, oldElement.props);
            return newElement;
          }
          function cloneElement(element, config, children) {
            if (element === null || element === void 0) {
              throw new Error("React.cloneElement(...): The argument must be a React element, but you passed " + element + ".");
            }
            var propName;
            var props = assign({}, element.props);
            var key = element.key;
            var ref = element.ref;
            var self = element._self;
            var source = element._source;
            var owner = element._owner;
            if (config != null) {
              if (hasValidRef(config)) {
                ref = config.ref;
                owner = ReactCurrentOwner.current;
              }
              if (hasValidKey(config)) {
                {
                  checkKeyStringCoercion(config.key);
                }
                key = "" + config.key;
              }
              var defaultProps;
              if (element.type && element.type.defaultProps) {
                defaultProps = element.type.defaultProps;
              }
              for (propName in config) {
                if (hasOwnProperty.call(config, propName) && !RESERVED_PROPS.hasOwnProperty(propName)) {
                  if (config[propName] === void 0 && defaultProps !== void 0) {
                    props[propName] = defaultProps[propName];
                  } else {
                    props[propName] = config[propName];
                  }
                }
              }
            }
            var childrenLength = arguments.length - 2;
            if (childrenLength === 1) {
              props.children = children;
            } else if (childrenLength > 1) {
              var childArray = Array(childrenLength);
              for (var i = 0; i < childrenLength; i++) {
                childArray[i] = arguments[i + 2];
              }
              props.children = childArray;
            }
            return ReactElement(element.type, key, ref, self, source, owner, props);
          }
          function isValidElement(object) {
            return typeof object === "object" && object !== null && object.$$typeof === REACT_ELEMENT_TYPE;
          }
          var SEPARATOR = ".";
          var SUBSEPARATOR = ":";
          function escape(key) {
            var escapeRegex = /[=:]/g;
            var escaperLookup = {
              "=": "=0",
              ":": "=2"
            };
            var escapedString = key.replace(escapeRegex, function(match) {
              return escaperLookup[match];
            });
            return "$" + escapedString;
          }
          var didWarnAboutMaps = false;
          var userProvidedKeyEscapeRegex = /\/+/g;
          function escapeUserProvidedKey(text) {
            return text.replace(userProvidedKeyEscapeRegex, "$&/");
          }
          function getElementKey(element, index) {
            if (typeof element === "object" && element !== null && element.key != null) {
              {
                checkKeyStringCoercion(element.key);
              }
              return escape("" + element.key);
            }
            return index.toString(36);
          }
          function mapIntoArray(children, array, escapedPrefix, nameSoFar, callback) {
            var type = typeof children;
            if (type === "undefined" || type === "boolean") {
              children = null;
            }
            var invokeCallback = false;
            if (children === null) {
              invokeCallback = true;
            } else {
              switch (type) {
                case "string":
                case "number":
                  invokeCallback = true;
                  break;
                case "object":
                  switch (children.$$typeof) {
                    case REACT_ELEMENT_TYPE:
                    case REACT_PORTAL_TYPE:
                      invokeCallback = true;
                  }
              }
            }
            if (invokeCallback) {
              var _child = children;
              var mappedChild = callback(_child);
              var childKey = nameSoFar === "" ? SEPARATOR + getElementKey(_child, 0) : nameSoFar;
              if (isArray(mappedChild)) {
                var escapedChildKey = "";
                if (childKey != null) {
                  escapedChildKey = escapeUserProvidedKey(childKey) + "/";
                }
                mapIntoArray(mappedChild, array, escapedChildKey, "", function(c) {
                  return c;
                });
              } else if (mappedChild != null) {
                if (isValidElement(mappedChild)) {
                  {
                    if (mappedChild.key && (!_child || _child.key !== mappedChild.key)) {
                      checkKeyStringCoercion(mappedChild.key);
                    }
                  }
                  mappedChild = cloneAndReplaceKey(
                    mappedChild,
                    // Keep both the (mapped) and old keys if they differ, just as
                    // traverseAllChildren used to do for objects as children
                    escapedPrefix + // $FlowFixMe Flow incorrectly thinks React.Portal doesn't have a key
                    (mappedChild.key && (!_child || _child.key !== mappedChild.key) ? (
                      // $FlowFixMe Flow incorrectly thinks existing element's key can be a number
                      // eslint-disable-next-line react-internal/safe-string-coercion
                      escapeUserProvidedKey("" + mappedChild.key) + "/"
                    ) : "") + childKey
                  );
                }
                array.push(mappedChild);
              }
              return 1;
            }
            var child;
            var nextName;
            var subtreeCount = 0;
            var nextNamePrefix = nameSoFar === "" ? SEPARATOR : nameSoFar + SUBSEPARATOR;
            if (isArray(children)) {
              for (var i = 0; i < children.length; i++) {
                child = children[i];
                nextName = nextNamePrefix + getElementKey(child, i);
                subtreeCount += mapIntoArray(child, array, escapedPrefix, nextName, callback);
              }
            } else {
              var iteratorFn = getIteratorFn(children);
              if (typeof iteratorFn === "function") {
                var iterableChildren = children;
                {
                  if (iteratorFn === iterableChildren.entries) {
                    if (!didWarnAboutMaps) {
                      warn("Using Maps as children is not supported. Use an array of keyed ReactElements instead.");
                    }
                    didWarnAboutMaps = true;
                  }
                }
                var iterator = iteratorFn.call(iterableChildren);
                var step;
                var ii = 0;
                while (!(step = iterator.next()).done) {
                  child = step.value;
                  nextName = nextNamePrefix + getElementKey(child, ii++);
                  subtreeCount += mapIntoArray(child, array, escapedPrefix, nextName, callback);
                }
              } else if (type === "object") {
                var childrenString = String(children);
                throw new Error("Objects are not valid as a React child (found: " + (childrenString === "[object Object]" ? "object with keys {" + Object.keys(children).join(", ") + "}" : childrenString) + "). If you meant to render a collection of children, use an array instead.");
              }
            }
            return subtreeCount;
          }
          function mapChildren(children, func, context) {
            if (children == null) {
              return children;
            }
            var result = [];
            var count = 0;
            mapIntoArray(children, result, "", "", function(child) {
              return func.call(context, child, count++);
            });
            return result;
          }
          function countChildren(children) {
            var n = 0;
            mapChildren(children, function() {
              n++;
            });
            return n;
          }
          function forEachChildren(children, forEachFunc, forEachContext) {
            mapChildren(children, function() {
              forEachFunc.apply(this, arguments);
            }, forEachContext);
          }
          function toArray(children) {
            return mapChildren(children, function(child) {
              return child;
            }) || [];
          }
          function onlyChild(children) {
            if (!isValidElement(children)) {
              throw new Error("React.Children.only expected to receive a single React element child.");
            }
            return children;
          }
          function createContext(defaultValue) {
            var context = {
              $$typeof: REACT_CONTEXT_TYPE,
              // As a workaround to support multiple concurrent renderers, we categorize
              // some renderers as primary and others as secondary. We only expect
              // there to be two concurrent renderers at most: React Native (primary) and
              // Fabric (secondary); React DOM (primary) and React ART (secondary).
              // Secondary renderers store their context values on separate fields.
              _currentValue: defaultValue,
              _currentValue2: defaultValue,
              // Used to track how many concurrent renderers this context currently
              // supports within in a single renderer. Such as parallel server rendering.
              _threadCount: 0,
              // These are circular
              Provider: null,
              Consumer: null,
              // Add these to use same hidden class in VM as ServerContext
              _defaultValue: null,
              _globalName: null
            };
            context.Provider = {
              $$typeof: REACT_PROVIDER_TYPE,
              _context: context
            };
            var hasWarnedAboutUsingNestedContextConsumers = false;
            var hasWarnedAboutUsingConsumerProvider = false;
            var hasWarnedAboutDisplayNameOnConsumer = false;
            {
              var Consumer = {
                $$typeof: REACT_CONTEXT_TYPE,
                _context: context
              };
              Object.defineProperties(Consumer, {
                Provider: {
                  get: function() {
                    if (!hasWarnedAboutUsingConsumerProvider) {
                      hasWarnedAboutUsingConsumerProvider = true;
                      error("Rendering <Context.Consumer.Provider> is not supported and will be removed in a future major release. Did you mean to render <Context.Provider> instead?");
                    }
                    return context.Provider;
                  },
                  set: function(_Provider) {
                    context.Provider = _Provider;
                  }
                },
                _currentValue: {
                  get: function() {
                    return context._currentValue;
                  },
                  set: function(_currentValue) {
                    context._currentValue = _currentValue;
                  }
                },
                _currentValue2: {
                  get: function() {
                    return context._currentValue2;
                  },
                  set: function(_currentValue2) {
                    context._currentValue2 = _currentValue2;
                  }
                },
                _threadCount: {
                  get: function() {
                    return context._threadCount;
                  },
                  set: function(_threadCount) {
                    context._threadCount = _threadCount;
                  }
                },
                Consumer: {
                  get: function() {
                    if (!hasWarnedAboutUsingNestedContextConsumers) {
                      hasWarnedAboutUsingNestedContextConsumers = true;
                      error("Rendering <Context.Consumer.Consumer> is not supported and will be removed in a future major release. Did you mean to render <Context.Consumer> instead?");
                    }
                    return context.Consumer;
                  }
                },
                displayName: {
                  get: function() {
                    return context.displayName;
                  },
                  set: function(displayName) {
                    if (!hasWarnedAboutDisplayNameOnConsumer) {
                      warn("Setting `displayName` on Context.Consumer has no effect. You should set it directly on the context with Context.displayName = '%s'.", displayName);
                      hasWarnedAboutDisplayNameOnConsumer = true;
                    }
                  }
                }
              });
              context.Consumer = Consumer;
            }
            {
              context._currentRenderer = null;
              context._currentRenderer2 = null;
            }
            return context;
          }
          var Uninitialized = -1;
          var Pending = 0;
          var Resolved = 1;
          var Rejected = 2;
          function lazyInitializer(payload) {
            if (payload._status === Uninitialized) {
              var ctor = payload._result;
              var thenable = ctor();
              thenable.then(function(moduleObject2) {
                if (payload._status === Pending || payload._status === Uninitialized) {
                  var resolved = payload;
                  resolved._status = Resolved;
                  resolved._result = moduleObject2;
                }
              }, function(error2) {
                if (payload._status === Pending || payload._status === Uninitialized) {
                  var rejected = payload;
                  rejected._status = Rejected;
                  rejected._result = error2;
                }
              });
              if (payload._status === Uninitialized) {
                var pending = payload;
                pending._status = Pending;
                pending._result = thenable;
              }
            }
            if (payload._status === Resolved) {
              var moduleObject = payload._result;
              {
                if (moduleObject === void 0) {
                  error("lazy: Expected the result of a dynamic import() call. Instead received: %s\n\nYour code should look like: \n  const MyComponent = lazy(() => import('./MyComponent'))\n\nDid you accidentally put curly braces around the import?", moduleObject);
                }
              }
              {
                if (!("default" in moduleObject)) {
                  error("lazy: Expected the result of a dynamic import() call. Instead received: %s\n\nYour code should look like: \n  const MyComponent = lazy(() => import('./MyComponent'))", moduleObject);
                }
              }
              return moduleObject.default;
            } else {
              throw payload._result;
            }
          }
          function lazy(ctor) {
            var payload = {
              // We use these fields to store the result.
              _status: Uninitialized,
              _result: ctor
            };
            var lazyType = {
              $$typeof: REACT_LAZY_TYPE,
              _payload: payload,
              _init: lazyInitializer
            };
            {
              var defaultProps;
              var propTypes;
              Object.defineProperties(lazyType, {
                defaultProps: {
                  configurable: true,
                  get: function() {
                    return defaultProps;
                  },
                  set: function(newDefaultProps) {
                    error("React.lazy(...): It is not supported to assign `defaultProps` to a lazy component import. Either specify them where the component is defined, or create a wrapping component around it.");
                    defaultProps = newDefaultProps;
                    Object.defineProperty(lazyType, "defaultProps", {
                      enumerable: true
                    });
                  }
                },
                propTypes: {
                  configurable: true,
                  get: function() {
                    return propTypes;
                  },
                  set: function(newPropTypes) {
                    error("React.lazy(...): It is not supported to assign `propTypes` to a lazy component import. Either specify them where the component is defined, or create a wrapping component around it.");
                    propTypes = newPropTypes;
                    Object.defineProperty(lazyType, "propTypes", {
                      enumerable: true
                    });
                  }
                }
              });
            }
            return lazyType;
          }
          function forwardRef(render) {
            {
              if (render != null && render.$$typeof === REACT_MEMO_TYPE) {
                error("forwardRef requires a render function but received a `memo` component. Instead of forwardRef(memo(...)), use memo(forwardRef(...)).");
              } else if (typeof render !== "function") {
                error("forwardRef requires a render function but was given %s.", render === null ? "null" : typeof render);
              } else {
                if (render.length !== 0 && render.length !== 2) {
                  error("forwardRef render functions accept exactly two parameters: props and ref. %s", render.length === 1 ? "Did you forget to use the ref parameter?" : "Any additional parameter will be undefined.");
                }
              }
              if (render != null) {
                if (render.defaultProps != null || render.propTypes != null) {
                  error("forwardRef render functions do not support propTypes or defaultProps. Did you accidentally pass a React component?");
                }
              }
            }
            var elementType = {
              $$typeof: REACT_FORWARD_REF_TYPE,
              render
            };
            {
              var ownName;
              Object.defineProperty(elementType, "displayName", {
                enumerable: false,
                configurable: true,
                get: function() {
                  return ownName;
                },
                set: function(name) {
                  ownName = name;
                  if (!render.name && !render.displayName) {
                    render.displayName = name;
                  }
                }
              });
            }
            return elementType;
          }
          var REACT_MODULE_REFERENCE;
          {
            REACT_MODULE_REFERENCE = Symbol.for("react.module.reference");
          }
          function isValidElementType(type) {
            if (typeof type === "string" || typeof type === "function") {
              return true;
            }
            if (type === REACT_FRAGMENT_TYPE || type === REACT_PROFILER_TYPE || enableDebugTracing || type === REACT_STRICT_MODE_TYPE || type === REACT_SUSPENSE_TYPE || type === REACT_SUSPENSE_LIST_TYPE || enableLegacyHidden || type === REACT_OFFSCREEN_TYPE || enableScopeAPI || enableCacheElement || enableTransitionTracing) {
              return true;
            }
            if (typeof type === "object" && type !== null) {
              if (type.$$typeof === REACT_LAZY_TYPE || type.$$typeof === REACT_MEMO_TYPE || type.$$typeof === REACT_PROVIDER_TYPE || type.$$typeof === REACT_CONTEXT_TYPE || type.$$typeof === REACT_FORWARD_REF_TYPE || // This needs to include all possible module reference object
              // types supported by any Flight configuration anywhere since
              // we don't know which Flight build this will end up being used
              // with.
              type.$$typeof === REACT_MODULE_REFERENCE || type.getModuleId !== void 0) {
                return true;
              }
            }
            return false;
          }
          function memo(type, compare) {
            {
              if (!isValidElementType(type)) {
                error("memo: The first argument must be a component. Instead received: %s", type === null ? "null" : typeof type);
              }
            }
            var elementType = {
              $$typeof: REACT_MEMO_TYPE,
              type,
              compare: compare === void 0 ? null : compare
            };
            {
              var ownName;
              Object.defineProperty(elementType, "displayName", {
                enumerable: false,
                configurable: true,
                get: function() {
                  return ownName;
                },
                set: function(name) {
                  ownName = name;
                  if (!type.name && !type.displayName) {
                    type.displayName = name;
                  }
                }
              });
            }
            return elementType;
          }
          function resolveDispatcher() {
            var dispatcher = ReactCurrentDispatcher.current;
            {
              if (dispatcher === null) {
                error("Invalid hook call. Hooks can only be called inside of the body of a function component. This could happen for one of the following reasons:\n1. You might have mismatching versions of React and the renderer (such as React DOM)\n2. You might be breaking the Rules of Hooks\n3. You might have more than one copy of React in the same app\nSee https://reactjs.org/link/invalid-hook-call for tips about how to debug and fix this problem.");
              }
            }
            return dispatcher;
          }
          function useContext(Context) {
            var dispatcher = resolveDispatcher();
            {
              if (Context._context !== void 0) {
                var realContext = Context._context;
                if (realContext.Consumer === Context) {
                  error("Calling useContext(Context.Consumer) is not supported, may cause bugs, and will be removed in a future major release. Did you mean to call useContext(Context) instead?");
                } else if (realContext.Provider === Context) {
                  error("Calling useContext(Context.Provider) is not supported. Did you mean to call useContext(Context) instead?");
                }
              }
            }
            return dispatcher.useContext(Context);
          }
          function useState(initialState) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useState(initialState);
          }
          function useReducer(reducer, initialArg, init) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useReducer(reducer, initialArg, init);
          }
          function useRef(initialValue) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useRef(initialValue);
          }
          function useEffect(create, deps) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useEffect(create, deps);
          }
          function useInsertionEffect(create, deps) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useInsertionEffect(create, deps);
          }
          function useLayoutEffect(create, deps) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useLayoutEffect(create, deps);
          }
          function useCallback(callback, deps) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useCallback(callback, deps);
          }
          function useMemo(create, deps) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useMemo(create, deps);
          }
          function useImperativeHandle(ref, create, deps) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useImperativeHandle(ref, create, deps);
          }
          function useDebugValue(value, formatterFn) {
            {
              var dispatcher = resolveDispatcher();
              return dispatcher.useDebugValue(value, formatterFn);
            }
          }
          function useTransition() {
            var dispatcher = resolveDispatcher();
            return dispatcher.useTransition();
          }
          function useDeferredValue(value) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useDeferredValue(value);
          }
          function useId() {
            var dispatcher = resolveDispatcher();
            return dispatcher.useId();
          }
          function useSyncExternalStore(subscribe, getSnapshot, getServerSnapshot) {
            var dispatcher = resolveDispatcher();
            return dispatcher.useSyncExternalStore(subscribe, getSnapshot, getServerSnapshot);
          }
          var disabledDepth = 0;
          var prevLog;
          var prevInfo;
          var prevWarn;
          var prevError;
          var prevGroup;
          var prevGroupCollapsed;
          var prevGroupEnd;
          function disabledLog() {
          }
          disabledLog.__reactDisabledLog = true;
          function disableLogs() {
            {
              if (disabledDepth === 0) {
                prevLog = console.log;
                prevInfo = console.info;
                prevWarn = console.warn;
                prevError = console.error;
                prevGroup = console.group;
                prevGroupCollapsed = console.groupCollapsed;
                prevGroupEnd = console.groupEnd;
                var props = {
                  configurable: true,
                  enumerable: true,
                  value: disabledLog,
                  writable: true
                };
                Object.defineProperties(console, {
                  info: props,
                  log: props,
                  warn: props,
                  error: props,
                  group: props,
                  groupCollapsed: props,
                  groupEnd: props
                });
              }
              disabledDepth++;
            }
          }
          function reenableLogs() {
            {
              disabledDepth--;
              if (disabledDepth === 0) {
                var props = {
                  configurable: true,
                  enumerable: true,
                  writable: true
                };
                Object.defineProperties(console, {
                  log: assign({}, props, {
                    value: prevLog
                  }),
                  info: assign({}, props, {
                    value: prevInfo
                  }),
                  warn: assign({}, props, {
                    value: prevWarn
                  }),
                  error: assign({}, props, {
                    value: prevError
                  }),
                  group: assign({}, props, {
                    value: prevGroup
                  }),
                  groupCollapsed: assign({}, props, {
                    value: prevGroupCollapsed
                  }),
                  groupEnd: assign({}, props, {
                    value: prevGroupEnd
                  })
                });
              }
              if (disabledDepth < 0) {
                error("disabledDepth fell below zero. This is a bug in React. Please file an issue.");
              }
            }
          }
          var ReactCurrentDispatcher$1 = ReactSharedInternals.ReactCurrentDispatcher;
          var prefix;
          function describeBuiltInComponentFrame(name, source, ownerFn) {
            {
              if (prefix === void 0) {
                try {
                  throw Error();
                } catch (x) {
                  var match = x.stack.trim().match(/\n( *(at )?)/);
                  prefix = match && match[1] || "";
                }
              }
              return "\n" + prefix + name;
            }
          }
          var reentry = false;
          var componentFrameCache;
          {
            var PossiblyWeakMap = typeof WeakMap === "function" ? WeakMap : Map;
            componentFrameCache = new PossiblyWeakMap();
          }
          function describeNativeComponentFrame(fn, construct) {
            if (!fn || reentry) {
              return "";
            }
            {
              var frame = componentFrameCache.get(fn);
              if (frame !== void 0) {
                return frame;
              }
            }
            var control;
            reentry = true;
            var previousPrepareStackTrace = Error.prepareStackTrace;
            Error.prepareStackTrace = void 0;
            var previousDispatcher;
            {
              previousDispatcher = ReactCurrentDispatcher$1.current;
              ReactCurrentDispatcher$1.current = null;
              disableLogs();
            }
            try {
              if (construct) {
                var Fake = function() {
                  throw Error();
                };
                Object.defineProperty(Fake.prototype, "props", {
                  set: function() {
                    throw Error();
                  }
                });
                if (typeof Reflect === "object" && Reflect.construct) {
                  try {
                    Reflect.construct(Fake, []);
                  } catch (x) {
                    control = x;
                  }
                  Reflect.construct(fn, [], Fake);
                } else {
                  try {
                    Fake.call();
                  } catch (x) {
                    control = x;
                  }
                  fn.call(Fake.prototype);
                }
              } else {
                try {
                  throw Error();
                } catch (x) {
                  control = x;
                }
                fn();
              }
            } catch (sample) {
              if (sample && control && typeof sample.stack === "string") {
                var sampleLines = sample.stack.split("\n");
                var controlLines = control.stack.split("\n");
                var s = sampleLines.length - 1;
                var c = controlLines.length - 1;
                while (s >= 1 && c >= 0 && sampleLines[s] !== controlLines[c]) {
                  c--;
                }
                for (; s >= 1 && c >= 0; s--, c--) {
                  if (sampleLines[s] !== controlLines[c]) {
                    if (s !== 1 || c !== 1) {
                      do {
                        s--;
                        c--;
                        if (c < 0 || sampleLines[s] !== controlLines[c]) {
                          var _frame = "\n" + sampleLines[s].replace(" at new ", " at ");
                          if (fn.displayName && _frame.includes("<anonymous>")) {
                            _frame = _frame.replace("<anonymous>", fn.displayName);
                          }
                          {
                            if (typeof fn === "function") {
                              componentFrameCache.set(fn, _frame);
                            }
                          }
                          return _frame;
                        }
                      } while (s >= 1 && c >= 0);
                    }
                    break;
                  }
                }
              }
            } finally {
              reentry = false;
              {
                ReactCurrentDispatcher$1.current = previousDispatcher;
                reenableLogs();
              }
              Error.prepareStackTrace = previousPrepareStackTrace;
            }
            var name = fn ? fn.displayName || fn.name : "";
            var syntheticFrame = name ? describeBuiltInComponentFrame(name) : "";
            {
              if (typeof fn === "function") {
                componentFrameCache.set(fn, syntheticFrame);
              }
            }
            return syntheticFrame;
          }
          function describeFunctionComponentFrame(fn, source, ownerFn) {
            {
              return describeNativeComponentFrame(fn, false);
            }
          }
          function shouldConstruct(Component2) {
            var prototype = Component2.prototype;
            return !!(prototype && prototype.isReactComponent);
          }
          function describeUnknownElementTypeFrameInDEV(type, source, ownerFn) {
            if (type == null) {
              return "";
            }
            if (typeof type === "function") {
              {
                return describeNativeComponentFrame(type, shouldConstruct(type));
              }
            }
            if (typeof type === "string") {
              return describeBuiltInComponentFrame(type);
            }
            switch (type) {
              case REACT_SUSPENSE_TYPE:
                return describeBuiltInComponentFrame("Suspense");
              case REACT_SUSPENSE_LIST_TYPE:
                return describeBuiltInComponentFrame("SuspenseList");
            }
            if (typeof type === "object") {
              switch (type.$$typeof) {
                case REACT_FORWARD_REF_TYPE:
                  return describeFunctionComponentFrame(type.render);
                case REACT_MEMO_TYPE:
                  return describeUnknownElementTypeFrameInDEV(type.type, source, ownerFn);
                case REACT_LAZY_TYPE: {
                  var lazyComponent = type;
                  var payload = lazyComponent._payload;
                  var init = lazyComponent._init;
                  try {
                    return describeUnknownElementTypeFrameInDEV(init(payload), source, ownerFn);
                  } catch (x) {
                  }
                }
              }
            }
            return "";
          }
          var loggedTypeFailures = {};
          var ReactDebugCurrentFrame$1 = ReactSharedInternals.ReactDebugCurrentFrame;
          function setCurrentlyValidatingElement(element) {
            {
              if (element) {
                var owner = element._owner;
                var stack = describeUnknownElementTypeFrameInDEV(element.type, element._source, owner ? owner.type : null);
                ReactDebugCurrentFrame$1.setExtraStackFrame(stack);
              } else {
                ReactDebugCurrentFrame$1.setExtraStackFrame(null);
              }
            }
          }
          function checkPropTypes(typeSpecs, values, location, componentName, element) {
            {
              var has = Function.call.bind(hasOwnProperty);
              for (var typeSpecName in typeSpecs) {
                if (has(typeSpecs, typeSpecName)) {
                  var error$1 = void 0;
                  try {
                    if (typeof typeSpecs[typeSpecName] !== "function") {
                      var err = Error((componentName || "React class") + ": " + location + " type `" + typeSpecName + "` is invalid; it must be a function, usually from the `prop-types` package, but received `" + typeof typeSpecs[typeSpecName] + "`.This often happens because of typos such as `PropTypes.function` instead of `PropTypes.func`.");
                      err.name = "Invariant Violation";
                      throw err;
                    }
                    error$1 = typeSpecs[typeSpecName](values, typeSpecName, componentName, location, null, "SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED");
                  } catch (ex) {
                    error$1 = ex;
                  }
                  if (error$1 && !(error$1 instanceof Error)) {
                    setCurrentlyValidatingElement(element);
                    error("%s: type specification of %s `%s` is invalid; the type checker function must return `null` or an `Error` but returned a %s. You may have forgotten to pass an argument to the type checker creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and shape all require an argument).", componentName || "React class", location, typeSpecName, typeof error$1);
                    setCurrentlyValidatingElement(null);
                  }
                  if (error$1 instanceof Error && !(error$1.message in loggedTypeFailures)) {
                    loggedTypeFailures[error$1.message] = true;
                    setCurrentlyValidatingElement(element);
                    error("Failed %s type: %s", location, error$1.message);
                    setCurrentlyValidatingElement(null);
                  }
                }
              }
            }
          }
          function setCurrentlyValidatingElement$1(element) {
            {
              if (element) {
                var owner = element._owner;
                var stack = describeUnknownElementTypeFrameInDEV(element.type, element._source, owner ? owner.type : null);
                setExtraStackFrame(stack);
              } else {
                setExtraStackFrame(null);
              }
            }
          }
          var propTypesMisspellWarningShown;
          {
            propTypesMisspellWarningShown = false;
          }
          function getDeclarationErrorAddendum() {
            if (ReactCurrentOwner.current) {
              var name = getComponentNameFromType(ReactCurrentOwner.current.type);
              if (name) {
                return "\n\nCheck the render method of `" + name + "`.";
              }
            }
            return "";
          }
          function getSourceInfoErrorAddendum(source) {
            if (source !== void 0) {
              var fileName = source.fileName.replace(/^.*[\\\/]/, "");
              var lineNumber = source.lineNumber;
              return "\n\nCheck your code at " + fileName + ":" + lineNumber + ".";
            }
            return "";
          }
          function getSourceInfoErrorAddendumForProps(elementProps) {
            if (elementProps !== null && elementProps !== void 0) {
              return getSourceInfoErrorAddendum(elementProps.__source);
            }
            return "";
          }
          var ownerHasKeyUseWarning = {};
          function getCurrentComponentErrorInfo(parentType) {
            var info = getDeclarationErrorAddendum();
            if (!info) {
              var parentName = typeof parentType === "string" ? parentType : parentType.displayName || parentType.name;
              if (parentName) {
                info = "\n\nCheck the top-level render call using <" + parentName + ">.";
              }
            }
            return info;
          }
          function validateExplicitKey(element, parentType) {
            if (!element._store || element._store.validated || element.key != null) {
              return;
            }
            element._store.validated = true;
            var currentComponentErrorInfo = getCurrentComponentErrorInfo(parentType);
            if (ownerHasKeyUseWarning[currentComponentErrorInfo]) {
              return;
            }
            ownerHasKeyUseWarning[currentComponentErrorInfo] = true;
            var childOwner = "";
            if (element && element._owner && element._owner !== ReactCurrentOwner.current) {
              childOwner = " It was passed a child from " + getComponentNameFromType(element._owner.type) + ".";
            }
            {
              setCurrentlyValidatingElement$1(element);
              error('Each child in a list should have a unique "key" prop.%s%s See https://reactjs.org/link/warning-keys for more information.', currentComponentErrorInfo, childOwner);
              setCurrentlyValidatingElement$1(null);
            }
          }
          function validateChildKeys(node, parentType) {
            if (typeof node !== "object") {
              return;
            }
            if (isArray(node)) {
              for (var i = 0; i < node.length; i++) {
                var child = node[i];
                if (isValidElement(child)) {
                  validateExplicitKey(child, parentType);
                }
              }
            } else if (isValidElement(node)) {
              if (node._store) {
                node._store.validated = true;
              }
            } else if (node) {
              var iteratorFn = getIteratorFn(node);
              if (typeof iteratorFn === "function") {
                if (iteratorFn !== node.entries) {
                  var iterator = iteratorFn.call(node);
                  var step;
                  while (!(step = iterator.next()).done) {
                    if (isValidElement(step.value)) {
                      validateExplicitKey(step.value, parentType);
                    }
                  }
                }
              }
            }
          }
          function validatePropTypes(element) {
            {
              var type = element.type;
              if (type === null || type === void 0 || typeof type === "string") {
                return;
              }
              var propTypes;
              if (typeof type === "function") {
                propTypes = type.propTypes;
              } else if (typeof type === "object" && (type.$$typeof === REACT_FORWARD_REF_TYPE || // Note: Memo only checks outer props here.
              // Inner props are checked in the reconciler.
              type.$$typeof === REACT_MEMO_TYPE)) {
                propTypes = type.propTypes;
              } else {
                return;
              }
              if (propTypes) {
                var name = getComponentNameFromType(type);
                checkPropTypes(propTypes, element.props, "prop", name, element);
              } else if (type.PropTypes !== void 0 && !propTypesMisspellWarningShown) {
                propTypesMisspellWarningShown = true;
                var _name = getComponentNameFromType(type);
                error("Component %s declared `PropTypes` instead of `propTypes`. Did you misspell the property assignment?", _name || "Unknown");
              }
              if (typeof type.getDefaultProps === "function" && !type.getDefaultProps.isReactClassApproved) {
                error("getDefaultProps is only used on classic React.createClass definitions. Use a static property named `defaultProps` instead.");
              }
            }
          }
          function validateFragmentProps(fragment) {
            {
              var keys = Object.keys(fragment.props);
              for (var i = 0; i < keys.length; i++) {
                var key = keys[i];
                if (key !== "children" && key !== "key") {
                  setCurrentlyValidatingElement$1(fragment);
                  error("Invalid prop `%s` supplied to `React.Fragment`. React.Fragment can only have `key` and `children` props.", key);
                  setCurrentlyValidatingElement$1(null);
                  break;
                }
              }
              if (fragment.ref !== null) {
                setCurrentlyValidatingElement$1(fragment);
                error("Invalid attribute `ref` supplied to `React.Fragment`.");
                setCurrentlyValidatingElement$1(null);
              }
            }
          }
          function createElementWithValidation(type, props, children) {
            var validType = isValidElementType(type);
            if (!validType) {
              var info = "";
              if (type === void 0 || typeof type === "object" && type !== null && Object.keys(type).length === 0) {
                info += " You likely forgot to export your component from the file it's defined in, or you might have mixed up default and named imports.";
              }
              var sourceInfo = getSourceInfoErrorAddendumForProps(props);
              if (sourceInfo) {
                info += sourceInfo;
              } else {
                info += getDeclarationErrorAddendum();
              }
              var typeString;
              if (type === null) {
                typeString = "null";
              } else if (isArray(type)) {
                typeString = "array";
              } else if (type !== void 0 && type.$$typeof === REACT_ELEMENT_TYPE) {
                typeString = "<" + (getComponentNameFromType(type.type) || "Unknown") + " />";
                info = " Did you accidentally export a JSX literal instead of a component?";
              } else {
                typeString = typeof type;
              }
              {
                error("React.createElement: type is invalid -- expected a string (for built-in components) or a class/function (for composite components) but got: %s.%s", typeString, info);
              }
            }
            var element = createElement.apply(this, arguments);
            if (element == null) {
              return element;
            }
            if (validType) {
              for (var i = 2; i < arguments.length; i++) {
                validateChildKeys(arguments[i], type);
              }
            }
            if (type === REACT_FRAGMENT_TYPE) {
              validateFragmentProps(element);
            } else {
              validatePropTypes(element);
            }
            return element;
          }
          var didWarnAboutDeprecatedCreateFactory = false;
          function createFactoryWithValidation(type) {
            var validatedFactory = createElementWithValidation.bind(null, type);
            validatedFactory.type = type;
            {
              if (!didWarnAboutDeprecatedCreateFactory) {
                didWarnAboutDeprecatedCreateFactory = true;
                warn("React.createFactory() is deprecated and will be removed in a future major release. Consider using JSX or use React.createElement() directly instead.");
              }
              Object.defineProperty(validatedFactory, "type", {
                enumerable: false,
                get: function() {
                  warn("Factory.type is deprecated. Access the class directly before passing it to createFactory.");
                  Object.defineProperty(this, "type", {
                    value: type
                  });
                  return type;
                }
              });
            }
            return validatedFactory;
          }
          function cloneElementWithValidation(element, props, children) {
            var newElement = cloneElement.apply(this, arguments);
            for (var i = 2; i < arguments.length; i++) {
              validateChildKeys(arguments[i], newElement.type);
            }
            validatePropTypes(newElement);
            return newElement;
          }
          function startTransition(scope, options) {
            var prevTransition = ReactCurrentBatchConfig.transition;
            ReactCurrentBatchConfig.transition = {};
            var currentTransition = ReactCurrentBatchConfig.transition;
            {
              ReactCurrentBatchConfig.transition._updatedFibers = /* @__PURE__ */ new Set();
            }
            try {
              scope();
            } finally {
              ReactCurrentBatchConfig.transition = prevTransition;
              {
                if (prevTransition === null && currentTransition._updatedFibers) {
                  var updatedFibersCount = currentTransition._updatedFibers.size;
                  if (updatedFibersCount > 10) {
                    warn("Detected a large number of updates inside startTransition. If this is due to a subscription please re-write it to use React provided hooks. Otherwise concurrent mode guarantees are off the table.");
                  }
                  currentTransition._updatedFibers.clear();
                }
              }
            }
          }
          var didWarnAboutMessageChannel = false;
          var enqueueTaskImpl = null;
          function enqueueTask(task) {
            if (enqueueTaskImpl === null) {
              try {
                var requireString = ("require" + Math.random()).slice(0, 7);
                var nodeRequire = module && module[requireString];
                enqueueTaskImpl = nodeRequire.call(module, "timers").setImmediate;
              } catch (_err) {
                enqueueTaskImpl = function(callback) {
                  {
                    if (didWarnAboutMessageChannel === false) {
                      didWarnAboutMessageChannel = true;
                      if (typeof MessageChannel === "undefined") {
                        error("This browser does not have a MessageChannel implementation, so enqueuing tasks via await act(async () => ...) will fail. Please file an issue at https://github.com/facebook/react/issues if you encounter this warning.");
                      }
                    }
                  }
                  var channel = new MessageChannel();
                  channel.port1.onmessage = callback;
                  channel.port2.postMessage(void 0);
                };
              }
            }
            return enqueueTaskImpl(task);
          }
          var actScopeDepth = 0;
          var didWarnNoAwaitAct = false;
          function act(callback) {
            {
              var prevActScopeDepth = actScopeDepth;
              actScopeDepth++;
              if (ReactCurrentActQueue.current === null) {
                ReactCurrentActQueue.current = [];
              }
              var prevIsBatchingLegacy = ReactCurrentActQueue.isBatchingLegacy;
              var result;
              try {
                ReactCurrentActQueue.isBatchingLegacy = true;
                result = callback();
                if (!prevIsBatchingLegacy && ReactCurrentActQueue.didScheduleLegacyUpdate) {
                  var queue = ReactCurrentActQueue.current;
                  if (queue !== null) {
                    ReactCurrentActQueue.didScheduleLegacyUpdate = false;
                    flushActQueue(queue);
                  }
                }
              } catch (error2) {
                popActScope(prevActScopeDepth);
                throw error2;
              } finally {
                ReactCurrentActQueue.isBatchingLegacy = prevIsBatchingLegacy;
              }
              if (result !== null && typeof result === "object" && typeof result.then === "function") {
                var thenableResult = result;
                var wasAwaited = false;
                var thenable = {
                  then: function(resolve, reject) {
                    wasAwaited = true;
                    thenableResult.then(function(returnValue2) {
                      popActScope(prevActScopeDepth);
                      if (actScopeDepth === 0) {
                        recursivelyFlushAsyncActWork(returnValue2, resolve, reject);
                      } else {
                        resolve(returnValue2);
                      }
                    }, function(error2) {
                      popActScope(prevActScopeDepth);
                      reject(error2);
                    });
                  }
                };
                {
                  if (!didWarnNoAwaitAct && typeof Promise !== "undefined") {
                    Promise.resolve().then(function() {
                    }).then(function() {
                      if (!wasAwaited) {
                        didWarnNoAwaitAct = true;
                        error("You called act(async () => ...) without await. This could lead to unexpected testing behaviour, interleaving multiple act calls and mixing their scopes. You should - await act(async () => ...);");
                      }
                    });
                  }
                }
                return thenable;
              } else {
                var returnValue = result;
                popActScope(prevActScopeDepth);
                if (actScopeDepth === 0) {
                  var _queue = ReactCurrentActQueue.current;
                  if (_queue !== null) {
                    flushActQueue(_queue);
                    ReactCurrentActQueue.current = null;
                  }
                  var _thenable = {
                    then: function(resolve, reject) {
                      if (ReactCurrentActQueue.current === null) {
                        ReactCurrentActQueue.current = [];
                        recursivelyFlushAsyncActWork(returnValue, resolve, reject);
                      } else {
                        resolve(returnValue);
                      }
                    }
                  };
                  return _thenable;
                } else {
                  var _thenable2 = {
                    then: function(resolve, reject) {
                      resolve(returnValue);
                    }
                  };
                  return _thenable2;
                }
              }
            }
          }
          function popActScope(prevActScopeDepth) {
            {
              if (prevActScopeDepth !== actScopeDepth - 1) {
                error("You seem to have overlapping act() calls, this is not supported. Be sure to await previous act() calls before making a new one. ");
              }
              actScopeDepth = prevActScopeDepth;
            }
          }
          function recursivelyFlushAsyncActWork(returnValue, resolve, reject) {
            {
              var queue = ReactCurrentActQueue.current;
              if (queue !== null) {
                try {
                  flushActQueue(queue);
                  enqueueTask(function() {
                    if (queue.length === 0) {
                      ReactCurrentActQueue.current = null;
                      resolve(returnValue);
                    } else {
                      recursivelyFlushAsyncActWork(returnValue, resolve, reject);
                    }
                  });
                } catch (error2) {
                  reject(error2);
                }
              } else {
                resolve(returnValue);
              }
            }
          }
          var isFlushing = false;
          function flushActQueue(queue) {
            {
              if (!isFlushing) {
                isFlushing = true;
                var i = 0;
                try {
                  for (; i < queue.length; i++) {
                    var callback = queue[i];
                    do {
                      callback = callback(true);
                    } while (callback !== null);
                  }
                  queue.length = 0;
                } catch (error2) {
                  queue = queue.slice(i + 1);
                  throw error2;
                } finally {
                  isFlushing = false;
                }
              }
            }
          }
          var createElement$1 = createElementWithValidation;
          var cloneElement$1 = cloneElementWithValidation;
          var createFactory = createFactoryWithValidation;
          var Children = {
            map: mapChildren,
            forEach: forEachChildren,
            count: countChildren,
            toArray,
            only: onlyChild
          };
          exports.Children = Children;
          exports.Component = Component;
          exports.Fragment = REACT_FRAGMENT_TYPE;
          exports.Profiler = REACT_PROFILER_TYPE;
          exports.PureComponent = PureComponent;
          exports.StrictMode = REACT_STRICT_MODE_TYPE;
          exports.Suspense = REACT_SUSPENSE_TYPE;
          exports.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED = ReactSharedInternals;
          exports.act = act;
          exports.cloneElement = cloneElement$1;
          exports.createContext = createContext;
          exports.createElement = createElement$1;
          exports.createFactory = createFactory;
          exports.createRef = createRef;
          exports.forwardRef = forwardRef;
          exports.isValidElement = isValidElement;
          exports.lazy = lazy;
          exports.memo = memo;
          exports.startTransition = startTransition;
          exports.unstable_act = act;
          exports.useCallback = useCallback;
          exports.useContext = useContext;
          exports.useDebugValue = useDebugValue;
          exports.useDeferredValue = useDeferredValue;
          exports.useEffect = useEffect;
          exports.useId = useId;
          exports.useImperativeHandle = useImperativeHandle;
          exports.useInsertionEffect = useInsertionEffect;
          exports.useLayoutEffect = useLayoutEffect;
          exports.useMemo = useMemo;
          exports.useReducer = useReducer;
          exports.useRef = useRef;
          exports.useState = useState;
          exports.useSyncExternalStore = useSyncExternalStore;
          exports.useTransition = useTransition;
          exports.version = ReactVersion;
          if (typeof __REACT_DEVTOOLS_GLOBAL_HOOK__ !== "undefined" && typeof __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStop === "function") {
            __REACT_DEVTOOLS_GLOBAL_HOOK__.registerInternalModuleStop(new Error());
          }
        })();
      }
    }
  });

  // node_modules/react/index.js
  var require_react = __commonJS({
    "node_modules/react/index.js"(exports, module) {
      "use strict";
      if (false) {
        module.exports = null;
      } else {
        module.exports = require_react_development();
      }
    }
  });

  // node_modules/react/cjs/react-jsx-runtime.development.js
  var require_react_jsx_runtime_development = __commonJS({
    "node_modules/react/cjs/react-jsx-runtime.development.js"(exports) {
      "use strict";
      if (true) {
        (function() {
          "use strict";
          var React2 = require_react();
          var REACT_ELEMENT_TYPE = Symbol.for("react.element");
          var REACT_PORTAL_TYPE = Symbol.for("react.portal");
          var REACT_FRAGMENT_TYPE = Symbol.for("react.fragment");
          var REACT_STRICT_MODE_TYPE = Symbol.for("react.strict_mode");
          var REACT_PROFILER_TYPE = Symbol.for("react.profiler");
          var REACT_PROVIDER_TYPE = Symbol.for("react.provider");
          var REACT_CONTEXT_TYPE = Symbol.for("react.context");
          var REACT_FORWARD_REF_TYPE = Symbol.for("react.forward_ref");
          var REACT_SUSPENSE_TYPE = Symbol.for("react.suspense");
          var REACT_SUSPENSE_LIST_TYPE = Symbol.for("react.suspense_list");
          var REACT_MEMO_TYPE = Symbol.for("react.memo");
          var REACT_LAZY_TYPE = Symbol.for("react.lazy");
          var REACT_OFFSCREEN_TYPE = Symbol.for("react.offscreen");
          var MAYBE_ITERATOR_SYMBOL = Symbol.iterator;
          var FAUX_ITERATOR_SYMBOL = "@@iterator";
          function getIteratorFn(maybeIterable) {
            if (maybeIterable === null || typeof maybeIterable !== "object") {
              return null;
            }
            var maybeIterator = MAYBE_ITERATOR_SYMBOL && maybeIterable[MAYBE_ITERATOR_SYMBOL] || maybeIterable[FAUX_ITERATOR_SYMBOL];
            if (typeof maybeIterator === "function") {
              return maybeIterator;
            }
            return null;
          }
          var ReactSharedInternals = React2.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED;
          function error(format) {
            {
              {
                for (var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
                  args[_key2 - 1] = arguments[_key2];
                }
                printWarning("error", format, args);
              }
            }
          }
          function printWarning(level, format, args) {
            {
              var ReactDebugCurrentFrame2 = ReactSharedInternals.ReactDebugCurrentFrame;
              var stack = ReactDebugCurrentFrame2.getStackAddendum();
              if (stack !== "") {
                format += "%s";
                args = args.concat([stack]);
              }
              var argsWithFormat = args.map(function(item) {
                return String(item);
              });
              argsWithFormat.unshift("Warning: " + format);
              Function.prototype.apply.call(console[level], console, argsWithFormat);
            }
          }
          var enableScopeAPI = false;
          var enableCacheElement = false;
          var enableTransitionTracing = false;
          var enableLegacyHidden = false;
          var enableDebugTracing = false;
          var REACT_MODULE_REFERENCE;
          {
            REACT_MODULE_REFERENCE = Symbol.for("react.module.reference");
          }
          function isValidElementType(type) {
            if (typeof type === "string" || typeof type === "function") {
              return true;
            }
            if (type === REACT_FRAGMENT_TYPE || type === REACT_PROFILER_TYPE || enableDebugTracing || type === REACT_STRICT_MODE_TYPE || type === REACT_SUSPENSE_TYPE || type === REACT_SUSPENSE_LIST_TYPE || enableLegacyHidden || type === REACT_OFFSCREEN_TYPE || enableScopeAPI || enableCacheElement || enableTransitionTracing) {
              return true;
            }
            if (typeof type === "object" && type !== null) {
              if (type.$$typeof === REACT_LAZY_TYPE || type.$$typeof === REACT_MEMO_TYPE || type.$$typeof === REACT_PROVIDER_TYPE || type.$$typeof === REACT_CONTEXT_TYPE || type.$$typeof === REACT_FORWARD_REF_TYPE || // This needs to include all possible module reference object
              // types supported by any Flight configuration anywhere since
              // we don't know which Flight build this will end up being used
              // with.
              type.$$typeof === REACT_MODULE_REFERENCE || type.getModuleId !== void 0) {
                return true;
              }
            }
            return false;
          }
          function getWrappedName(outerType, innerType, wrapperName) {
            var displayName = outerType.displayName;
            if (displayName) {
              return displayName;
            }
            var functionName = innerType.displayName || innerType.name || "";
            return functionName !== "" ? wrapperName + "(" + functionName + ")" : wrapperName;
          }
          function getContextName(type) {
            return type.displayName || "Context";
          }
          function getComponentNameFromType(type) {
            if (type == null) {
              return null;
            }
            {
              if (typeof type.tag === "number") {
                error("Received an unexpected object in getComponentNameFromType(). This is likely a bug in React. Please file an issue.");
              }
            }
            if (typeof type === "function") {
              return type.displayName || type.name || null;
            }
            if (typeof type === "string") {
              return type;
            }
            switch (type) {
              case REACT_FRAGMENT_TYPE:
                return "Fragment";
              case REACT_PORTAL_TYPE:
                return "Portal";
              case REACT_PROFILER_TYPE:
                return "Profiler";
              case REACT_STRICT_MODE_TYPE:
                return "StrictMode";
              case REACT_SUSPENSE_TYPE:
                return "Suspense";
              case REACT_SUSPENSE_LIST_TYPE:
                return "SuspenseList";
            }
            if (typeof type === "object") {
              switch (type.$$typeof) {
                case REACT_CONTEXT_TYPE:
                  var context = type;
                  return getContextName(context) + ".Consumer";
                case REACT_PROVIDER_TYPE:
                  var provider = type;
                  return getContextName(provider._context) + ".Provider";
                case REACT_FORWARD_REF_TYPE:
                  return getWrappedName(type, type.render, "ForwardRef");
                case REACT_MEMO_TYPE:
                  var outerName = type.displayName || null;
                  if (outerName !== null) {
                    return outerName;
                  }
                  return getComponentNameFromType(type.type) || "Memo";
                case REACT_LAZY_TYPE: {
                  var lazyComponent = type;
                  var payload = lazyComponent._payload;
                  var init = lazyComponent._init;
                  try {
                    return getComponentNameFromType(init(payload));
                  } catch (x) {
                    return null;
                  }
                }
              }
            }
            return null;
          }
          var assign = Object.assign;
          var disabledDepth = 0;
          var prevLog;
          var prevInfo;
          var prevWarn;
          var prevError;
          var prevGroup;
          var prevGroupCollapsed;
          var prevGroupEnd;
          function disabledLog() {
          }
          disabledLog.__reactDisabledLog = true;
          function disableLogs() {
            {
              if (disabledDepth === 0) {
                prevLog = console.log;
                prevInfo = console.info;
                prevWarn = console.warn;
                prevError = console.error;
                prevGroup = console.group;
                prevGroupCollapsed = console.groupCollapsed;
                prevGroupEnd = console.groupEnd;
                var props = {
                  configurable: true,
                  enumerable: true,
                  value: disabledLog,
                  writable: true
                };
                Object.defineProperties(console, {
                  info: props,
                  log: props,
                  warn: props,
                  error: props,
                  group: props,
                  groupCollapsed: props,
                  groupEnd: props
                });
              }
              disabledDepth++;
            }
          }
          function reenableLogs() {
            {
              disabledDepth--;
              if (disabledDepth === 0) {
                var props = {
                  configurable: true,
                  enumerable: true,
                  writable: true
                };
                Object.defineProperties(console, {
                  log: assign({}, props, {
                    value: prevLog
                  }),
                  info: assign({}, props, {
                    value: prevInfo
                  }),
                  warn: assign({}, props, {
                    value: prevWarn
                  }),
                  error: assign({}, props, {
                    value: prevError
                  }),
                  group: assign({}, props, {
                    value: prevGroup
                  }),
                  groupCollapsed: assign({}, props, {
                    value: prevGroupCollapsed
                  }),
                  groupEnd: assign({}, props, {
                    value: prevGroupEnd
                  })
                });
              }
              if (disabledDepth < 0) {
                error("disabledDepth fell below zero. This is a bug in React. Please file an issue.");
              }
            }
          }
          var ReactCurrentDispatcher = ReactSharedInternals.ReactCurrentDispatcher;
          var prefix;
          function describeBuiltInComponentFrame(name, source, ownerFn) {
            {
              if (prefix === void 0) {
                try {
                  throw Error();
                } catch (x) {
                  var match = x.stack.trim().match(/\n( *(at )?)/);
                  prefix = match && match[1] || "";
                }
              }
              return "\n" + prefix + name;
            }
          }
          var reentry = false;
          var componentFrameCache;
          {
            var PossiblyWeakMap = typeof WeakMap === "function" ? WeakMap : Map;
            componentFrameCache = new PossiblyWeakMap();
          }
          function describeNativeComponentFrame(fn, construct) {
            if (!fn || reentry) {
              return "";
            }
            {
              var frame = componentFrameCache.get(fn);
              if (frame !== void 0) {
                return frame;
              }
            }
            var control;
            reentry = true;
            var previousPrepareStackTrace = Error.prepareStackTrace;
            Error.prepareStackTrace = void 0;
            var previousDispatcher;
            {
              previousDispatcher = ReactCurrentDispatcher.current;
              ReactCurrentDispatcher.current = null;
              disableLogs();
            }
            try {
              if (construct) {
                var Fake = function() {
                  throw Error();
                };
                Object.defineProperty(Fake.prototype, "props", {
                  set: function() {
                    throw Error();
                  }
                });
                if (typeof Reflect === "object" && Reflect.construct) {
                  try {
                    Reflect.construct(Fake, []);
                  } catch (x) {
                    control = x;
                  }
                  Reflect.construct(fn, [], Fake);
                } else {
                  try {
                    Fake.call();
                  } catch (x) {
                    control = x;
                  }
                  fn.call(Fake.prototype);
                }
              } else {
                try {
                  throw Error();
                } catch (x) {
                  control = x;
                }
                fn();
              }
            } catch (sample) {
              if (sample && control && typeof sample.stack === "string") {
                var sampleLines = sample.stack.split("\n");
                var controlLines = control.stack.split("\n");
                var s = sampleLines.length - 1;
                var c = controlLines.length - 1;
                while (s >= 1 && c >= 0 && sampleLines[s] !== controlLines[c]) {
                  c--;
                }
                for (; s >= 1 && c >= 0; s--, c--) {
                  if (sampleLines[s] !== controlLines[c]) {
                    if (s !== 1 || c !== 1) {
                      do {
                        s--;
                        c--;
                        if (c < 0 || sampleLines[s] !== controlLines[c]) {
                          var _frame = "\n" + sampleLines[s].replace(" at new ", " at ");
                          if (fn.displayName && _frame.includes("<anonymous>")) {
                            _frame = _frame.replace("<anonymous>", fn.displayName);
                          }
                          {
                            if (typeof fn === "function") {
                              componentFrameCache.set(fn, _frame);
                            }
                          }
                          return _frame;
                        }
                      } while (s >= 1 && c >= 0);
                    }
                    break;
                  }
                }
              }
            } finally {
              reentry = false;
              {
                ReactCurrentDispatcher.current = previousDispatcher;
                reenableLogs();
              }
              Error.prepareStackTrace = previousPrepareStackTrace;
            }
            var name = fn ? fn.displayName || fn.name : "";
            var syntheticFrame = name ? describeBuiltInComponentFrame(name) : "";
            {
              if (typeof fn === "function") {
                componentFrameCache.set(fn, syntheticFrame);
              }
            }
            return syntheticFrame;
          }
          function describeFunctionComponentFrame(fn, source, ownerFn) {
            {
              return describeNativeComponentFrame(fn, false);
            }
          }
          function shouldConstruct(Component) {
            var prototype = Component.prototype;
            return !!(prototype && prototype.isReactComponent);
          }
          function describeUnknownElementTypeFrameInDEV(type, source, ownerFn) {
            if (type == null) {
              return "";
            }
            if (typeof type === "function") {
              {
                return describeNativeComponentFrame(type, shouldConstruct(type));
              }
            }
            if (typeof type === "string") {
              return describeBuiltInComponentFrame(type);
            }
            switch (type) {
              case REACT_SUSPENSE_TYPE:
                return describeBuiltInComponentFrame("Suspense");
              case REACT_SUSPENSE_LIST_TYPE:
                return describeBuiltInComponentFrame("SuspenseList");
            }
            if (typeof type === "object") {
              switch (type.$$typeof) {
                case REACT_FORWARD_REF_TYPE:
                  return describeFunctionComponentFrame(type.render);
                case REACT_MEMO_TYPE:
                  return describeUnknownElementTypeFrameInDEV(type.type, source, ownerFn);
                case REACT_LAZY_TYPE: {
                  var lazyComponent = type;
                  var payload = lazyComponent._payload;
                  var init = lazyComponent._init;
                  try {
                    return describeUnknownElementTypeFrameInDEV(init(payload), source, ownerFn);
                  } catch (x) {
                  }
                }
              }
            }
            return "";
          }
          var hasOwnProperty = Object.prototype.hasOwnProperty;
          var loggedTypeFailures = {};
          var ReactDebugCurrentFrame = ReactSharedInternals.ReactDebugCurrentFrame;
          function setCurrentlyValidatingElement(element) {
            {
              if (element) {
                var owner = element._owner;
                var stack = describeUnknownElementTypeFrameInDEV(element.type, element._source, owner ? owner.type : null);
                ReactDebugCurrentFrame.setExtraStackFrame(stack);
              } else {
                ReactDebugCurrentFrame.setExtraStackFrame(null);
              }
            }
          }
          function checkPropTypes(typeSpecs, values, location, componentName, element) {
            {
              var has = Function.call.bind(hasOwnProperty);
              for (var typeSpecName in typeSpecs) {
                if (has(typeSpecs, typeSpecName)) {
                  var error$1 = void 0;
                  try {
                    if (typeof typeSpecs[typeSpecName] !== "function") {
                      var err = Error((componentName || "React class") + ": " + location + " type `" + typeSpecName + "` is invalid; it must be a function, usually from the `prop-types` package, but received `" + typeof typeSpecs[typeSpecName] + "`.This often happens because of typos such as `PropTypes.function` instead of `PropTypes.func`.");
                      err.name = "Invariant Violation";
                      throw err;
                    }
                    error$1 = typeSpecs[typeSpecName](values, typeSpecName, componentName, location, null, "SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED");
                  } catch (ex) {
                    error$1 = ex;
                  }
                  if (error$1 && !(error$1 instanceof Error)) {
                    setCurrentlyValidatingElement(element);
                    error("%s: type specification of %s `%s` is invalid; the type checker function must return `null` or an `Error` but returned a %s. You may have forgotten to pass an argument to the type checker creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and shape all require an argument).", componentName || "React class", location, typeSpecName, typeof error$1);
                    setCurrentlyValidatingElement(null);
                  }
                  if (error$1 instanceof Error && !(error$1.message in loggedTypeFailures)) {
                    loggedTypeFailures[error$1.message] = true;
                    setCurrentlyValidatingElement(element);
                    error("Failed %s type: %s", location, error$1.message);
                    setCurrentlyValidatingElement(null);
                  }
                }
              }
            }
          }
          var isArrayImpl = Array.isArray;
          function isArray(a) {
            return isArrayImpl(a);
          }
          function typeName(value) {
            {
              var hasToStringTag = typeof Symbol === "function" && Symbol.toStringTag;
              var type = hasToStringTag && value[Symbol.toStringTag] || value.constructor.name || "Object";
              return type;
            }
          }
          function willCoercionThrow(value) {
            {
              try {
                testStringCoercion(value);
                return false;
              } catch (e) {
                return true;
              }
            }
          }
          function testStringCoercion(value) {
            return "" + value;
          }
          function checkKeyStringCoercion(value) {
            {
              if (willCoercionThrow(value)) {
                error("The provided key is an unsupported type %s. This value must be coerced to a string before before using it here.", typeName(value));
                return testStringCoercion(value);
              }
            }
          }
          var ReactCurrentOwner = ReactSharedInternals.ReactCurrentOwner;
          var RESERVED_PROPS = {
            key: true,
            ref: true,
            __self: true,
            __source: true
          };
          var specialPropKeyWarningShown;
          var specialPropRefWarningShown;
          var didWarnAboutStringRefs;
          {
            didWarnAboutStringRefs = {};
          }
          function hasValidRef(config) {
            {
              if (hasOwnProperty.call(config, "ref")) {
                var getter = Object.getOwnPropertyDescriptor(config, "ref").get;
                if (getter && getter.isReactWarning) {
                  return false;
                }
              }
            }
            return config.ref !== void 0;
          }
          function hasValidKey(config) {
            {
              if (hasOwnProperty.call(config, "key")) {
                var getter = Object.getOwnPropertyDescriptor(config, "key").get;
                if (getter && getter.isReactWarning) {
                  return false;
                }
              }
            }
            return config.key !== void 0;
          }
          function warnIfStringRefCannotBeAutoConverted(config, self) {
            {
              if (typeof config.ref === "string" && ReactCurrentOwner.current && self && ReactCurrentOwner.current.stateNode !== self) {
                var componentName = getComponentNameFromType(ReactCurrentOwner.current.type);
                if (!didWarnAboutStringRefs[componentName]) {
                  error('Component "%s" contains the string ref "%s". Support for string refs will be removed in a future major release. This case cannot be automatically converted to an arrow function. We ask you to manually fix this case by using useRef() or createRef() instead. Learn more about using refs safely here: https://reactjs.org/link/strict-mode-string-ref', getComponentNameFromType(ReactCurrentOwner.current.type), config.ref);
                  didWarnAboutStringRefs[componentName] = true;
                }
              }
            }
          }
          function defineKeyPropWarningGetter(props, displayName) {
            {
              var warnAboutAccessingKey = function() {
                if (!specialPropKeyWarningShown) {
                  specialPropKeyWarningShown = true;
                  error("%s: `key` is not a prop. Trying to access it will result in `undefined` being returned. If you need to access the same value within the child component, you should pass it as a different prop. (https://reactjs.org/link/special-props)", displayName);
                }
              };
              warnAboutAccessingKey.isReactWarning = true;
              Object.defineProperty(props, "key", {
                get: warnAboutAccessingKey,
                configurable: true
              });
            }
          }
          function defineRefPropWarningGetter(props, displayName) {
            {
              var warnAboutAccessingRef = function() {
                if (!specialPropRefWarningShown) {
                  specialPropRefWarningShown = true;
                  error("%s: `ref` is not a prop. Trying to access it will result in `undefined` being returned. If you need to access the same value within the child component, you should pass it as a different prop. (https://reactjs.org/link/special-props)", displayName);
                }
              };
              warnAboutAccessingRef.isReactWarning = true;
              Object.defineProperty(props, "ref", {
                get: warnAboutAccessingRef,
                configurable: true
              });
            }
          }
          var ReactElement = function(type, key, ref, self, source, owner, props) {
            var element = {
              // This tag allows us to uniquely identify this as a React Element
              $$typeof: REACT_ELEMENT_TYPE,
              // Built-in properties that belong on the element
              type,
              key,
              ref,
              props,
              // Record the component responsible for creating this element.
              _owner: owner
            };
            {
              element._store = {};
              Object.defineProperty(element._store, "validated", {
                configurable: false,
                enumerable: false,
                writable: true,
                value: false
              });
              Object.defineProperty(element, "_self", {
                configurable: false,
                enumerable: false,
                writable: false,
                value: self
              });
              Object.defineProperty(element, "_source", {
                configurable: false,
                enumerable: false,
                writable: false,
                value: source
              });
              if (Object.freeze) {
                Object.freeze(element.props);
                Object.freeze(element);
              }
            }
            return element;
          };
          function jsxDEV(type, config, maybeKey, source, self) {
            {
              var propName;
              var props = {};
              var key = null;
              var ref = null;
              if (maybeKey !== void 0) {
                {
                  checkKeyStringCoercion(maybeKey);
                }
                key = "" + maybeKey;
              }
              if (hasValidKey(config)) {
                {
                  checkKeyStringCoercion(config.key);
                }
                key = "" + config.key;
              }
              if (hasValidRef(config)) {
                ref = config.ref;
                warnIfStringRefCannotBeAutoConverted(config, self);
              }
              for (propName in config) {
                if (hasOwnProperty.call(config, propName) && !RESERVED_PROPS.hasOwnProperty(propName)) {
                  props[propName] = config[propName];
                }
              }
              if (type && type.defaultProps) {
                var defaultProps = type.defaultProps;
                for (propName in defaultProps) {
                  if (props[propName] === void 0) {
                    props[propName] = defaultProps[propName];
                  }
                }
              }
              if (key || ref) {
                var displayName = typeof type === "function" ? type.displayName || type.name || "Unknown" : type;
                if (key) {
                  defineKeyPropWarningGetter(props, displayName);
                }
                if (ref) {
                  defineRefPropWarningGetter(props, displayName);
                }
              }
              return ReactElement(type, key, ref, self, source, ReactCurrentOwner.current, props);
            }
          }
          var ReactCurrentOwner$1 = ReactSharedInternals.ReactCurrentOwner;
          var ReactDebugCurrentFrame$1 = ReactSharedInternals.ReactDebugCurrentFrame;
          function setCurrentlyValidatingElement$1(element) {
            {
              if (element) {
                var owner = element._owner;
                var stack = describeUnknownElementTypeFrameInDEV(element.type, element._source, owner ? owner.type : null);
                ReactDebugCurrentFrame$1.setExtraStackFrame(stack);
              } else {
                ReactDebugCurrentFrame$1.setExtraStackFrame(null);
              }
            }
          }
          var propTypesMisspellWarningShown;
          {
            propTypesMisspellWarningShown = false;
          }
          function isValidElement(object) {
            {
              return typeof object === "object" && object !== null && object.$$typeof === REACT_ELEMENT_TYPE;
            }
          }
          function getDeclarationErrorAddendum() {
            {
              if (ReactCurrentOwner$1.current) {
                var name = getComponentNameFromType(ReactCurrentOwner$1.current.type);
                if (name) {
                  return "\n\nCheck the render method of `" + name + "`.";
                }
              }
              return "";
            }
          }
          function getSourceInfoErrorAddendum(source) {
            {
              if (source !== void 0) {
                var fileName = source.fileName.replace(/^.*[\\\/]/, "");
                var lineNumber = source.lineNumber;
                return "\n\nCheck your code at " + fileName + ":" + lineNumber + ".";
              }
              return "";
            }
          }
          var ownerHasKeyUseWarning = {};
          function getCurrentComponentErrorInfo(parentType) {
            {
              var info = getDeclarationErrorAddendum();
              if (!info) {
                var parentName = typeof parentType === "string" ? parentType : parentType.displayName || parentType.name;
                if (parentName) {
                  info = "\n\nCheck the top-level render call using <" + parentName + ">.";
                }
              }
              return info;
            }
          }
          function validateExplicitKey(element, parentType) {
            {
              if (!element._store || element._store.validated || element.key != null) {
                return;
              }
              element._store.validated = true;
              var currentComponentErrorInfo = getCurrentComponentErrorInfo(parentType);
              if (ownerHasKeyUseWarning[currentComponentErrorInfo]) {
                return;
              }
              ownerHasKeyUseWarning[currentComponentErrorInfo] = true;
              var childOwner = "";
              if (element && element._owner && element._owner !== ReactCurrentOwner$1.current) {
                childOwner = " It was passed a child from " + getComponentNameFromType(element._owner.type) + ".";
              }
              setCurrentlyValidatingElement$1(element);
              error('Each child in a list should have a unique "key" prop.%s%s See https://reactjs.org/link/warning-keys for more information.', currentComponentErrorInfo, childOwner);
              setCurrentlyValidatingElement$1(null);
            }
          }
          function validateChildKeys(node, parentType) {
            {
              if (typeof node !== "object") {
                return;
              }
              if (isArray(node)) {
                for (var i = 0; i < node.length; i++) {
                  var child = node[i];
                  if (isValidElement(child)) {
                    validateExplicitKey(child, parentType);
                  }
                }
              } else if (isValidElement(node)) {
                if (node._store) {
                  node._store.validated = true;
                }
              } else if (node) {
                var iteratorFn = getIteratorFn(node);
                if (typeof iteratorFn === "function") {
                  if (iteratorFn !== node.entries) {
                    var iterator = iteratorFn.call(node);
                    var step;
                    while (!(step = iterator.next()).done) {
                      if (isValidElement(step.value)) {
                        validateExplicitKey(step.value, parentType);
                      }
                    }
                  }
                }
              }
            }
          }
          function validatePropTypes(element) {
            {
              var type = element.type;
              if (type === null || type === void 0 || typeof type === "string") {
                return;
              }
              var propTypes;
              if (typeof type === "function") {
                propTypes = type.propTypes;
              } else if (typeof type === "object" && (type.$$typeof === REACT_FORWARD_REF_TYPE || // Note: Memo only checks outer props here.
              // Inner props are checked in the reconciler.
              type.$$typeof === REACT_MEMO_TYPE)) {
                propTypes = type.propTypes;
              } else {
                return;
              }
              if (propTypes) {
                var name = getComponentNameFromType(type);
                checkPropTypes(propTypes, element.props, "prop", name, element);
              } else if (type.PropTypes !== void 0 && !propTypesMisspellWarningShown) {
                propTypesMisspellWarningShown = true;
                var _name = getComponentNameFromType(type);
                error("Component %s declared `PropTypes` instead of `propTypes`. Did you misspell the property assignment?", _name || "Unknown");
              }
              if (typeof type.getDefaultProps === "function" && !type.getDefaultProps.isReactClassApproved) {
                error("getDefaultProps is only used on classic React.createClass definitions. Use a static property named `defaultProps` instead.");
              }
            }
          }
          function validateFragmentProps(fragment) {
            {
              var keys = Object.keys(fragment.props);
              for (var i = 0; i < keys.length; i++) {
                var key = keys[i];
                if (key !== "children" && key !== "key") {
                  setCurrentlyValidatingElement$1(fragment);
                  error("Invalid prop `%s` supplied to `React.Fragment`. React.Fragment can only have `key` and `children` props.", key);
                  setCurrentlyValidatingElement$1(null);
                  break;
                }
              }
              if (fragment.ref !== null) {
                setCurrentlyValidatingElement$1(fragment);
                error("Invalid attribute `ref` supplied to `React.Fragment`.");
                setCurrentlyValidatingElement$1(null);
              }
            }
          }
          var didWarnAboutKeySpread = {};
          function jsxWithValidation(type, props, key, isStaticChildren, source, self) {
            {
              var validType = isValidElementType(type);
              if (!validType) {
                var info = "";
                if (type === void 0 || typeof type === "object" && type !== null && Object.keys(type).length === 0) {
                  info += " You likely forgot to export your component from the file it's defined in, or you might have mixed up default and named imports.";
                }
                var sourceInfo = getSourceInfoErrorAddendum(source);
                if (sourceInfo) {
                  info += sourceInfo;
                } else {
                  info += getDeclarationErrorAddendum();
                }
                var typeString;
                if (type === null) {
                  typeString = "null";
                } else if (isArray(type)) {
                  typeString = "array";
                } else if (type !== void 0 && type.$$typeof === REACT_ELEMENT_TYPE) {
                  typeString = "<" + (getComponentNameFromType(type.type) || "Unknown") + " />";
                  info = " Did you accidentally export a JSX literal instead of a component?";
                } else {
                  typeString = typeof type;
                }
                error("React.jsx: type is invalid -- expected a string (for built-in components) or a class/function (for composite components) but got: %s.%s", typeString, info);
              }
              var element = jsxDEV(type, props, key, source, self);
              if (element == null) {
                return element;
              }
              if (validType) {
                var children = props.children;
                if (children !== void 0) {
                  if (isStaticChildren) {
                    if (isArray(children)) {
                      for (var i = 0; i < children.length; i++) {
                        validateChildKeys(children[i], type);
                      }
                      if (Object.freeze) {
                        Object.freeze(children);
                      }
                    } else {
                      error("React.jsx: Static children should always be an array. You are likely explicitly calling React.jsxs or React.jsxDEV. Use the Babel transform instead.");
                    }
                  } else {
                    validateChildKeys(children, type);
                  }
                }
              }
              {
                if (hasOwnProperty.call(props, "key")) {
                  var componentName = getComponentNameFromType(type);
                  var keys = Object.keys(props).filter(function(k) {
                    return k !== "key";
                  });
                  var beforeExample = keys.length > 0 ? "{key: someKey, " + keys.join(": ..., ") + ": ...}" : "{key: someKey}";
                  if (!didWarnAboutKeySpread[componentName + beforeExample]) {
                    var afterExample = keys.length > 0 ? "{" + keys.join(": ..., ") + ": ...}" : "{}";
                    error('A props object containing a "key" prop is being spread into JSX:\n  let props = %s;\n  <%s {...props} />\nReact keys must be passed directly to JSX without using spread:\n  let props = %s;\n  <%s key={someKey} {...props} />', beforeExample, componentName, afterExample, componentName);
                    didWarnAboutKeySpread[componentName + beforeExample] = true;
                  }
                }
              }
              if (type === REACT_FRAGMENT_TYPE) {
                validateFragmentProps(element);
              } else {
                validatePropTypes(element);
              }
              return element;
            }
          }
          function jsxWithValidationStatic(type, props, key) {
            {
              return jsxWithValidation(type, props, key, true);
            }
          }
          function jsxWithValidationDynamic(type, props, key) {
            {
              return jsxWithValidation(type, props, key, false);
            }
          }
          var jsx9 = jsxWithValidationDynamic;
          var jsxs9 = jsxWithValidationStatic;
          exports.Fragment = REACT_FRAGMENT_TYPE;
          exports.jsx = jsx9;
          exports.jsxs = jsxs9;
        })();
      }
    }
  });

  // node_modules/react/jsx-runtime.js
  var require_jsx_runtime = __commonJS({
    "node_modules/react/jsx-runtime.js"(exports, module) {
      "use strict";
      if (false) {
        module.exports = null;
      } else {
        module.exports = require_react_jsx_runtime_development();
      }
    }
  });

  // src/AppReservas/DatesModal.jsx
  var import_prop_types = __toESM(require_prop_types());

  // src/Utilities.jsx
  function convertDate(inputDate, action) {
    function detectFormat(dateStr) {
      if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr))
        return "ISO";
      if (/^\d{2}\/\d{2}\/\d{4}$/.test(dateStr))
        return "DMY";
      return "UNKNOWN";
    }
    function dmyToIso(dmy) {
      const [day, month, year] = dmy.split("/");
      return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    }
    function isoToDmy(iso) {
      const [year, month, day] = iso.split("-");
      return `${day.padStart(2, "0")}/${month.padStart(2, "0")}/${year}`;
    }
    const format = detectFormat(inputDate);
    if (format === "UNKNOWN") {
      throw new Error(
        'Formato de data n\xE3o reconhecido. Use "dd/mm/aaaa" ou "aaaa-mm-dd".'
      );
    }
    switch (action.toLowerCase()) {
      case "iso":
        return format === "ISO" ? inputDate : dmyToIso(inputDate);
      case "dmy":
        return format === "DMY" ? inputDate : isoToDmy(inputDate);
      case "dateobject": {
        const isoDate = format === "ISO" ? inputDate : dmyToIso(inputDate);
        return new Date(isoDate);
      }
      default:
        throw new Error(
          `A\xE7\xE3o "${action}" n\xE3o reconhecida. Use "iso", "dmy" ou "dateObject".`
        );
    }
  }
  function dataTrintaDiasAntes(data_excursao_iso) {
    const dataEvento = new Date(data_excursao_iso);
    const dataLimite = new Date(dataEvento);
    dataLimite.setDate(dataEvento.getDate() - 30);
    const dataLimiteDesconto = dataLimite.toISOString().split("T")[0];
    return dataLimiteDesconto;
  }
  function dataTemDescontoHoje(data_excursao_iso) {
    const agora = /* @__PURE__ */ new Date();
    const diffEmMs = new Date(data_excursao_iso) - agora;
    const diffEmDias = diffEmMs / (1e3 * 60 * 60 * 24);
    return diffEmDias > 29;
  }

  // src/AppReservas/DatesModal.jsx
  var import_jsx_runtime = __toESM(require_jsx_runtime());
  var DatesModal = ({
    setDateModalOpen,
    availableDates,
    selectedDates,
    toggleDate,
    getVarIdByDate,
    getAvailabilityById,
    passageiros,
    setDataLimiteDesconto,
    dataLimiteDesconto
  }) => {
    const [preData, setPreData] = React.useState([]);
    const [visible, setVisible] = React.useState(false);
    const [initial, setInitial] = React.useState(false);
    const preDataRef = React.useRef(preData);
    const saveBtnRef = React.useRef();
    function closeDateModal(_save) {
      const hasUpdatedData = preDataRef.current.toString() != initial.toString();
      if (_save && hasUpdatedData) {
        if (preDataRef.current.length > 0) {
          toggleDate(preDataRef.current);
        } else
          toggleDate("", "");
      } else
        setVisible(false);
      setTimeout(() => {
        setDateModalOpen(false);
      }, 300);
    }
    function changeCheckbox(_dateObj, _element) {
      setPreData(() => {
        const dataJaSelecionada = preData.some(
          (_item) => _item[0] == _dateObj.dia
        );
        if (dataJaSelecionada) {
          setDataLimiteDesconto((prev) => {
            const arr = Array.isArray(prev) ? [...prev] : [];
            const prev_index = arr.indexOf(_dateObj.desconto_antecipado_val);
            if (prev_index !== -1)
              arr.splice(prev_index, 1);
            arr.sort((a, b) => new Date(b) - new Date(a));
            return arr;
          });
          return preData.filter((_item) => _item[0] !== _dateObj.dia);
        } else {
          if (_dateObj.disponiveis < passageiros.length) {
            window.alert(
              "Vagas insuficientes nessa data para o n\xFAmero de passageiros informados."
            );
            _element.setAttribute("checked", "false");
            console.log("aviso de vagas insuficientes");
            return preData;
          }
          setDataLimiteDesconto((prev) => {
            const arr = Array.isArray(prev) ? [...prev] : [];
            const novaData = _dateObj.desconto_antecipado_val;
            if (novaData && !arr.includes(novaData) && _dateObj.desconto_antecipado === true) {
              arr.push(novaData);
            }
            arr.sort((a, b) => new Date(b) - new Date(a));
            return arr;
          });
          return [
            ...preData,
            [_dateObj.dia, getVarIdByDate(_dateObj.dia), _dateObj.disponiveis]
          ];
        }
      });
    }
    React.useEffect(() => {
      preDataRef.current = preData;
      if (preData.length < 1)
        saveBtnRef.current.setAttribute("disabled", "");
      else
        saveBtnRef.current.removeAttribute("disabled");
    }, [preData]);
    React.useEffect(() => {
      setVisible(true);
      setDataLimiteDesconto([]);
      if (selectedDates.length > 0) {
        const mapped = selectedDates.map((date) => [
          date,
          getVarIdByDate(date),
          getAvailabilityById(getVarIdByDate(date))
        ]);
        selectedDates.forEach((date) => {
          if (dataTemDescontoHoje(convertDate(date, "iso"))) {
            setDataLimiteDesconto((_prev) => [
              dataTrintaDiasAntes(convertDate(date, "iso")),
              ..._prev
            ]);
          }
        });
        setPreData((prev) => {
          if (!initial)
            setInitial(() => [...prev, ...mapped]);
          return [...prev, ...mapped];
        });
      }
    }, []);
    return /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
      "div",
      {
        className: `modal-overlay ${visible ? "show" : ""}`,
        onClick: () => closeDateModal(false),
        children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
          "div",
          {
            className: `modal-content ${visible ? "show" : ""}`,
            "data-modal": "dates",
            onClick: (e) => e.stopPropagation(),
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("h3", { children: "Selecionar Datas" }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                "form",
                {
                  className: `date-list${availableDates.length > 1 ? " many" : ""}`,
                  children: availableDates.map((dateObj) => /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
                    "label",
                    {
                      className: dateObj.encerrado || dateObj.disponiveis === 0 ? "disabled" : "",
                      "data-ultimas": dateObj.disponiveis < 10 ? "true" : "false",
                      "data-ultimas-vagas": dateObj.disponiveis < 10 ? dateObj.disponiveis + " vagas restantes" : "false",
                      "data-esgotado": dateObj.disponiveis === 0 ? "true" : "false",
                      "data-desconto-antecipado": dateObj.desconto_antecipado,
                      children: [
                        dateObj.encerrado || dateObj.disponiveis === 0 ? /* @__PURE__ */ (0, import_jsx_runtime.jsx)("input", { type: "checkbox", disabled: true }) : /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                          "input",
                          {
                            type: "checkbox",
                            checked: preData.some((_item) => _item[0] == dateObj.dia),
                            onChange: ({ target }) => changeCheckbox(dateObj, target)
                          }
                        ),
                        /* @__PURE__ */ (0, import_jsx_runtime.jsx)("span", { children: dateObj.dia === "31/12/2026" ? "A definir..." : dateObj.dia })
                      ]
                    },
                    dateObj.dia
                  ))
                }
              ),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { className: "desconto-data-limite", children: dataLimiteDesconto.length > 0 && preData.length > 0 ? /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("p", { children: [
                "5% off v\xE1lido at\xE9 ",
                convertDate(dataLimiteDesconto[0], "dmy"),
                " para a data selecionada"
              ] }) : null }),
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("div", { className: "modal-buttons", children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
                "button",
                {
                  type: "button",
                  className: "saveBtn",
                  ref: saveBtnRef,
                  onClick: () => closeDateModal(true),
                  children: "Salvar"
                }
              ) })
            ]
          }
        )
      }
    );
  };
  var DatesModal_default = DatesModal;
  DatesModal.propTypes = {
    setDateModalOpen: import_prop_types.default.func.isRequired,
    availableDates: import_prop_types.default.array.isRequired,
    selectedDates: import_prop_types.default.array.isRequired,
    passageiros: import_prop_types.default.array.isRequired,
    toggleDate: import_prop_types.default.func.isRequired,
    getVarIdByDate: import_prop_types.default.func.isRequired,
    getAvailabilityById: import_prop_types.default.func.isRequired,
    setDataLimiteDesconto: import_prop_types.default.func.isRequired,
    dataLimiteDesconto: import_prop_types.default.array.isRequired
  };

  // src/AppReservas/EmbarqueModal.jsx
  var import_prop_types2 = __toESM(require_prop_types());
  var import_jsx_runtime2 = __toESM(require_jsx_runtime());
  var EmbarquesModal = ({
    setEmbarqueModalOpen,
    toggleEmbarque,
    embarques,
    embarque,
    selectedDates,
    variacoes,
    getVarIdByDate,
    setHorario,
    variacoesSelecionadas,
    setPrecoUnitario,
    setTaxa,
    estadoDestino,
    cidadesDiaAnterior
  }) => {
    const [visible, setVisible] = React.useState(false);
    const [embarquesNoPeriodo, setEmbarquesNoPeriodo] = React.useState([]);
    const [preEmbarque, setPreEmbarque] = React.useState([]);
    const [horariosDisponiveis, setHorariosDisponiveis] = React.useState([]);
    const [disponibilidadeParcial, setDisponibilidadeParcial] = React.useState(
      []
    );
    const embarqueForm = React.useRef();
    const priceContainerRef = React.useRef();
    const saveBtnRef = React.useRef();
    function closeEmbarqueModal(_save) {
      if (_save && preEmbarque.length > 0)
        toggleEmbarque(preEmbarque[0].embarqueId);
      setVisible(false);
      setTimeout(() => {
        setEmbarqueModalOpen(false);
      }, 300);
    }
    function arrayToString(lista) {
      if (lista.length === 0)
        return "";
      if (lista.length === 1)
        return lista[0];
      if (lista.length === 2)
        return `${lista[0]} e ${lista[1]}`;
      const todasMenosUltima = lista.slice(0, -1).join(" , ");
      const ultima = lista[lista.length - 1];
      return `${todasMenosUltima} e ${ultima}`;
    }
    React.useEffect(() => {
      setVisible(true);
      const embarquesPeriodo = [];
      embarques.forEach((_embarque) => {
        let _emb_obj = { embID: _embarque.embarqueId, variacoes: [] };
        selectedDates.forEach((_date) => {
          variacoes.forEach((_var) => {
            if (_var.attributes.attribute_dia == _date) {
              _emb_obj.variacoes.push({
                varID: _var.variation_id,
                varData: _date,
                disp: []
              });
            }
          });
        });
        _embarque.horarios.forEach((_horario) => {
          _horario.disponibilidade.forEach((_disp) => {
            if (selectedDates.includes(_disp.disp_dia)) {
              _emb_obj.variacoes.forEach((_variacao) => {
                if (_variacao.varID == getVarIdByDate(_disp.disp_dia)) {
                  _variacao.disp.push({
                    horario: _horario.horario,
                    status: _disp.status
                  });
                }
              });
            }
          });
        });
        embarquesPeriodo.push(_emb_obj);
      });
      embarquesPeriodo.forEach((_e) => {
        let _total_horarios = 0;
        let _total_indisp = 0;
        _e.variacoes.forEach((_var) => {
          _var.disp.forEach((_hor) => {
            _total_horarios = _total_horarios + 1;
            if (_hor.status === "indisponivel") {
              _total_indisp = _total_indisp + 1;
            }
          });
        });
        if (_total_horarios === _total_indisp) {
          let opcoesDom = embarqueForm.current.querySelectorAll("select option");
          opcoesDom.forEach((_op) => {
            if (_op.value == _e.embID) {
              _op.innerText = _op.innerText + " - (indispon\xEDvel)";
              _op.setAttribute("disabled", "");
            }
          });
        }
      });
      setEmbarquesNoPeriodo(embarquesPeriodo);
      if (embarque && embarque.length > 0) {
        if (embarqueForm.current) {
          embarqueForm.current.querySelector("select").value = embarque[0].embarqueId;
        }
        setPreEmbarque([embarque[0]]);
      } else {
        embarqueForm.current.querySelector("select").value = "";
        setPreEmbarque([]);
      }
    }, []);
    React.useEffect(() => {
      setDisponibilidadeParcial([]);
      setHorariosDisponiveis([]);
      if (preEmbarque.length > 0) {
        let _horariosDisp = [];
        const selectedEmbarque = embarquesNoPeriodo.find(
          (_embarque) => _embarque.embID == preEmbarque[0].embarqueId
        );
        selectedEmbarque.variacoes.forEach((_variacao) => {
          let _indisponiveis = _variacao.disp.filter((_disp) => {
            if (!_horariosDisp.includes(_disp.horario))
              _horariosDisp.push(_disp.horario);
            return _disp.status === "indisponivel";
          });
          if (_indisponiveis.length > 0) {
            _indisponiveis = _indisponiveis.map((_ind) => {
              _ind.dia = _variacao.varData;
              _ind.varID = _variacao.varID;
              return _ind;
            });
            setDisponibilidadeParcial((_val) => [..._val, ..._indisponiveis]);
          }
        });
        let _array_horarios = Array.from(new Set(_horariosDisp));
        setHorariosDisponiveis(_array_horarios);
        if (_array_horarios.length === 1)
          setHorario(_array_horarios[0]);
        if (variacoesSelecionadas.length > 0) {
          const _precos = variacoesSelecionadas.map((_varId) => {
            const varObj = variacoes.filter((_v) => _v.variation_id == _varId)[0];
            return varObj.display_regular_price;
          });
          const uniquePrecos = Array.from(new Set(_precos));
          const taxaEmb = embarques.filter(
            (emb) => emb.embarqueId == preEmbarque[0].embarqueId
          )[0]?.taxa || 0;
          setTaxa(+taxaEmb);
          if (uniquePrecos.length === 1) {
            const modalPriceElement = priceContainerRef.current.querySelector("span");
            modalPriceElement.innerText = +uniquePrecos[0] + taxaEmb;
            setPrecoUnitario(+uniquePrecos[0] + taxaEmb);
          } else
            setPrecoUnitario("varios");
        } else {
          window.alert("Nenhuma data selecionada");
          closeEmbarqueModal(false);
        }
        saveBtnRef.current.removeAttribute("disabled");
      } else {
        saveBtnRef.current.setAttribute("disabled", "");
      }
    }, [preEmbarque]);
    React.useEffect(() => {
      if (disponibilidadeParcial.length > 0) {
        saveBtnRef.current.setAttribute("disabled", "");
      }
    }, [disponibilidadeParcial]);
    return /* @__PURE__ */ (0, import_jsx_runtime2.jsx)(
      "div",
      {
        className: `modal-overlay ${visible ? "show" : ""}`,
        onClick: () => closeEmbarqueModal(false),
        children: /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)(
          "div",
          {
            className: `modal-content ${visible ? "show" : ""}`,
            "data-modal": "embarque",
            onClick: (e) => e.stopPropagation(),
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("h3", { children: "Selecione seu embarque" }),
              /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("form", { className: "embarque-list", ref: embarqueForm, children: [
                /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)(
                  "select",
                  {
                    onChange: (e) => setPreEmbarque(() => {
                      return [
                        embarques.find((_emb) => _emb.embarqueId == e.target.value)
                      ];
                    }),
                    children: [
                      /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("option", { className: "select-placeholder", disabled: true, value: "", children: "Selecione..." }),
                      embarques.map(({ embarqueId, nome }) => {
                        return /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("option", { value: embarqueId, children: nome }, embarqueId);
                      })
                    ]
                  }
                ),
                /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)(
                  "section",
                  {
                    className: "embarque-details",
                    "aria-labelledby": "embarque-heading",
                    children: [
                      preEmbarque.length === 0 ? /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("div", { className: "placeholder-container", children: "Selecione um local de embarque para ver os hor\xE1rios dispon\xEDveis e endere\xE7o detalhado." }) : null,
                      disponibilidadeParcial.length > 0 ? /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("div", { className: "alerta-reserva disponibilidade-parcial", children: [
                        "Ops. O embarque selecionado n\xE3o est\xE1 dispon\xEDvel em",
                        " ",
                        arrayToString(disponibilidadeParcial.map((_v) => _v.dia)),
                        "."
                      ] }) : null,
                      disponibilidadeParcial.length === 0 && preEmbarque.length > 0 ? /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)(import_jsx_runtime2.Fragment, { children: [
                        /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("h2", { id: "embarque-heading", className: "visually-hidden", children: "Detalhes do embarque" }),
                        /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("div", { className: "embarque-details-inner", children: [
                          /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("div", { className: "horarios", children: [
                            horariosDisponiveis.length === 1 && /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)(import_jsx_runtime2.Fragment, { children: [
                              /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("h3", { className: "title", children: "Hor\xE1rio de embarque" }),
                              /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("span", { className: "horario-single d-block text-center", children: [
                                horariosDisponiveis[0],
                                estadoDestino === "rj" && preEmbarque[0] && cidadesDiaAnterior.includes(preEmbarque[0].nome.split(" - ")[0]) ? /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("span", { className: "aviso-dia-anterior", children: "do dia anterior" }) : null
                              ] })
                            ] }),
                            horariosDisponiveis.length > 1 && /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)(import_jsx_runtime2.Fragment, { children: [
                              /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("p", { className: "title", children: "Selecione o hor\xE1rio" }),
                              /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("div", { className: "multi-radios", children: [
                                /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("label", { className: "horario-opcao", children: [
                                  /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("input", { type: "radio", name: "horario", value: "08:00" }),
                                  /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("span", { children: "08:00" })
                                ] }),
                                /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("label", { className: "horario-opcao", children: [
                                  /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("input", { type: "radio", name: "horario", value: "10:30" }),
                                  /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("span", { children: "10:30" })
                                ] })
                              ] })
                            ] })
                          ] }),
                          /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("div", { className: "localizacao", children: [
                            /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("h3", { className: "title my-2 mb-0", children: "Local de embarque" }),
                            /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("p", { className: "info", children: [
                              /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("strong", { children: "Endere\xE7o:" }),
                              " ",
                              preEmbarque[0].endereco
                            ] }),
                            /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("p", { className: "info", children: [
                              /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("strong", { children: "Refer\xEAncia:" }),
                              " ",
                              preEmbarque[0].obs
                            ] }),
                            /* @__PURE__ */ (0, import_jsx_runtime2.jsx)(
                              "a",
                              {
                                href: preEmbarque[0].link_mapa,
                                target: "_blank",
                                rel: "noreferrer",
                                children: "Ver no Google Maps"
                              }
                            )
                          ] }),
                          /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("p", { className: "price", ref: priceContainerRef, children: [
                            /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("strong", { children: "Valor:" }),
                            " R$ ",
                            /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("span", { children: "120,00" }),
                            " ",
                            /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("i", { children: "por passageiro" })
                          ] })
                        ] })
                      ] }) : null
                    ]
                  }
                ),
                /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("div", { className: "modal-buttons", children: /* @__PURE__ */ (0, import_jsx_runtime2.jsx)(
                  "button",
                  {
                    type: "button",
                    className: "saveBtn",
                    ref: saveBtnRef,
                    onClick: () => closeEmbarqueModal(true),
                    children: "Salvar"
                  }
                ) })
              ] })
            ]
          }
        )
      }
    );
  };
  var EmbarqueModal_default = EmbarquesModal;
  EmbarquesModal.propTypes = {
    setEmbarqueModalOpen: import_prop_types2.default.func.isRequired,
    toggleEmbarque: import_prop_types2.default.func.isRequired,
    embarques: import_prop_types2.default.array.isRequired,
    embarque: import_prop_types2.default.array,
    selectedDates: import_prop_types2.default.array.isRequired,
    variacoes: import_prop_types2.default.array.isRequired,
    variacoesSelecionadas: import_prop_types2.default.array.isRequired,
    getVarIdByDate: import_prop_types2.default.func.isRequired,
    setHorario: import_prop_types2.default.func.isRequired,
    setPrecoUnitario: import_prop_types2.default.func.isRequired,
    setTaxa: import_prop_types2.default.func.isRequired,
    estadoDestino: import_prop_types2.default.string.isRequired,
    cidadesDiaAnterior: import_prop_types2.default.array.isRequired
  };

  // src/AppReservas/PaxModal.jsx
  var import_prop_types4 = __toESM(require_prop_types());

  // src/AppReservas/CustomSelectPaxModal.jsx
  var import_prop_types3 = __toESM(require_prop_types());
  var import_jsx_runtime3 = __toESM(require_jsx_runtime());
  var CustomSelectPaxModal = ({ setFormData, tripType }) => {
    const [isOpen, setIsOpen] = React.useState(false);
    const [selected, setSelected] = React.useState(null);
    const listRef = React.useRef(null);
    const buttonRef = React.useRef(null);
    const optionsData = [
      { value: "ida-e-volta", label: "Ida e volta" },
      { value: "ida", label: "Apenas ida" },
      { value: "volta", label: "Apenas volta" }
    ];
    const handleSelect = (option) => {
      setSelected(option);
      setIsOpen(false);
      if (onChange)
        onChange(option.value);
    };
    const handleKeyDown = (e) => {
      if (e.key === "Escape")
        setIsOpen(false);
      if (e.key === "ArrowDown" || e.key === "ArrowUp") {
        e.preventDefault();
        const items = listRef.current?.querySelectorAll('[role="option"]');
        const currentIndex = Array.from(items).findIndex(
          (item) => item === document.activeElement
        );
        const nextIndex = e.key === "ArrowDown" ? Math.min(currentIndex + 1, items.length - 1) : Math.max(currentIndex - 1, 0);
        items[nextIndex]?.focus();
      }
      if (e.key === "Enter" && document.activeElement.getAttribute("role") === "option") {
        const value = document.activeElement.getAttribute("data-value");
        const label = document.activeElement.textContent;
        handleSelect({ value, label });
      }
    };
    React.useEffect(() => {
      const initialOption = optionsData.filter(
        (_op) => _op.value === tripType
      )[0];
      if (initialOption)
        setSelected(initialOption);
      else
        setSelected(optionsData[0]);
      const handleClickOutside = (e) => {
        if (buttonRef.current && listRef.current) {
          if (!buttonRef.current.contains(e.target) && !listRef.current.contains(e.target)) {
            setIsOpen(false);
          }
        }
      };
      document.addEventListener("mousedown", handleClickOutside);
      return () => document.removeEventListener("mousedown", handleClickOutside);
    }, [tripType]);
    const onChange = (_value) => {
      setFormData((_current) => {
        return { ..._current, tripType: _value };
      });
    };
    return /* @__PURE__ */ (0, import_jsx_runtime3.jsxs)("div", { className: "custom-select", children: [
      /* @__PURE__ */ (0, import_jsx_runtime3.jsx)(
        "button",
        {
          ref: buttonRef,
          "aria-haspopup": "listbox",
          "aria-expanded": isOpen,
          "aria-labelledby": "custom-select-label",
          onClick: (e) => {
            e.preventDefault();
            setIsOpen((prev) => !prev);
          },
          onKeyDown: handleKeyDown,
          className: "selected",
          children: selected ? selected.label : "Selecione uma op\xE7\xE3o"
        }
      ),
      isOpen && /* @__PURE__ */ (0, import_jsx_runtime3.jsx)(
        "ul",
        {
          ref: listRef,
          role: "listbox",
          tabIndex: "-1",
          "aria-activedescendant": selected?.value,
          className: "options",
          children: optionsData.map((option) => /* @__PURE__ */ (0, import_jsx_runtime3.jsx)(
            "li",
            {
              role: "option",
              "data-value": option.value,
              tabIndex: "0",
              "aria-selected": selected?.value === option.value,
              onClick: () => handleSelect(option),
              onKeyDown: handleKeyDown,
              children: option.label
            },
            option.value
          ))
        }
      )
    ] });
  };
  CustomSelectPaxModal.propTypes = {
    setFormData: import_prop_types3.default.func,
    tripType: import_prop_types3.default.string
  };
  var CustomSelectPaxModal_default = CustomSelectPaxModal;

  // src/Hooks/useValidations.jsx
  var useValidations = () => {
    function validarCPF(cpf) {
      var cpfRegex = /^(?:(\d{3}).(\d{3}).(\d{3})-(\d{2}))$/;
      if (!cpfRegex.test(cpf)) {
        return false;
      }
      var numeros = cpf.match(/\d/g).map(Number);
      var soma = numeros.reduce((acc, cur, idx) => {
        if (idx < 9) {
          return acc + cur * (10 - idx);
        }
        return acc;
      }, 0);
      var resto = soma * 10 % 11;
      if (resto === 10 || resto === 11) {
        resto = 0;
      }
      if (resto !== numeros[9]) {
        return false;
      }
      soma = numeros.reduce((acc, cur, idx) => {
        if (idx < 10) {
          return acc + cur * (11 - idx);
        }
        return acc;
      }, 0);
      resto = soma * 10 % 11;
      if (resto === 10 || resto === 11) {
        resto = 0;
      }
      if (resto !== numeros[10]) {
        return false;
      }
      return true;
    }
    function validarMaioridade(dataNascimento, dataEvento) {
      const [ano1, mes1, dia1] = dataNascimento.split("-").map(Number);
      const [ano2, mes2, dia2] = dataEvento.split("-").map(Number);
      const data1 = new Date(ano1, mes1 - 1, dia1);
      const data2 = new Date(ano2, mes2 - 1, dia2);
      const dataLimite = new Date(data1);
      dataLimite.setFullYear(dataLimite.getFullYear() + 18);
      return data2 >= dataLimite;
    }
    return {
      validarCPF,
      validarMaioridade
    };
  };
  var useValidations_default = useValidations;

  // src/AppReservas/InputMasks.js
  var cpfMask = (value) => {
    return value.replace(/\D/g, "").replace(/(\d{3})(\d)/, "$1.$2").replace(/(\d{3})(\d)/, "$1.$2").replace(/(\d{3})(\d{1,2})/, "$1-$2").replace(/(-\d{2})\d+?$/, "$1");
  };
  var celularMask = (value) => {
    if (!value)
      return "";
    value = value.replace(/\D/g, "");
    value = value.replace(/(\d{2})(\d)/, "($1) $2");
    value = value.replace(/(\d)(\d{4})$/, "$1-$2");
    return value;
  };
  var dataMask = (data) => {
    if (!data)
      return "";
    const [ano, mes, dia] = data.split("-");
    return `${dia}/${mes}/${ano}`;
  };
  var formatarDataISO = (data) => {
    if (!data)
      return "";
    const [dia, mes, ano] = data.split("/");
    return `${ano}-${mes}-${dia}`;
  };
  var isDataISO = (str) => /^\d{4}-\d{2}-\d{2}$/.test(str);
  var nomeValido = (str) => {
    if (!str || typeof str !== "string")
      return false;
    const palavras = str.trim().split(/\s+/).filter((p) => p.length > 1 || p.toLowerCase() === "e");
    return palavras.length >= 2;
  };

  // src/AppReservas/PaxModal.jsx
  var import_jsx_runtime4 = __toESM(require_jsx_runtime());
  var PaxModal = ({
    setPaxModalOpen,
    paxModalOpen,
    selectedDates,
    convertDate: convertDate2,
    setPassageiros,
    passageiros,
    variacoesSelecionadas,
    embarqueId
  }) => {
    const [formMode, setFormMode] = React.useState("");
    const [formData, setFormData] = React.useState({
      nome_completo: "",
      role: "",
      cpf: "",
      celular: "",
      data_nascimento: "",
      tripType: "ida-e-volta"
    });
    const [paxMenor, setPaxMenor] = React.useState(false);
    const [formErrors, setFormErrors] = React.useState([]);
    const { validarCPF, validarMaioridade } = useValidations_default();
    const [visible, setVisible] = React.useState(false);
    const [useAccountData, setUseAccountData] = React.useState(false);
    const { userData } = window.singleProductData;
    const currentSessionId = window.singleProductData?.session_id || "anon_lead";
    const canShowAutofill = React.useMemo(() => {
      if (!userData || !userData.cpf)
        return false;
      return !passageiros.some((pax) => pax.cpf === cpfMask(userData.cpf));
    }, [userData, passageiros]);
    function handleAutofillChange(e) {
      const checked = e.target.checked;
      setUseAccountData(checked);
      if (checked && userData) {
        setFormData((prev) => ({
          ...prev,
          nome_completo: userData.nome_completo || "",
          cpf: cpfMask(userData.cpf) || "",
          celular: celularMask(userData.celular) || "",
          data_nascimento: userData.data_nascimento || ""
        }));
        setFormErrors(() => {
          const errors = [];
          if (!userData.nome_completo || !nomeValido(userData.nome_completo))
            errors.push("nome_completo");
          if (!userData.cpf || !validarCPF(cpfMask(userData.cpf)))
            errors.push("cpf");
          if (!userData.celular || celularMask(userData.celular).length < 14)
            errors.push("celular");
          if (!userData.data_nascimento || !isDataISO(formatarDataISO(userData.data_nascimento)))
            errors.push("data_nascimento");
          return errors;
        });
      } else {
        setFormData((prev) => ({
          ...prev,
          nome_completo: "",
          cpf: "",
          celular: "",
          data_nascimento: ""
        }));
        setFormErrors(["nome_completo", "cpf", "celular", "data_nascimento"]);
      }
    }
    function closePaxModal() {
      setVisible(false);
      setTimeout(() => {
        setPaxModalOpen(false);
      }, 300);
    }
    function inputChange({ target }) {
      const valueLength = target.value.length;
      switch (target.name) {
        case "cpf": {
          if (cpfMask(target.value).length == 14) {
            const cpfValido = validarCPF(cpfMask(target.value));
            target.classList.remove("input-attention");
            if (cpfValido)
              target.classList.remove("input-error");
            else
              target.classList.add("input-error");
            atualizarErros(target.name, !cpfValido);
          } else if (valueLength < 14) {
            target.classList.remove("input-error");
            atualizarErros(target.name, true);
          }
          setFormData({ ...formData, cpf: cpfMask(target.value) });
          break;
        }
        case "celular": {
          const celValido = celularMask(target.value).length == 14 || celularMask(target.value).length == 15;
          target.classList.remove("input-error");
          if (celValido)
            target.classList.remove("input-attention");
          else if (valueLength < 14)
            target.classList.remove("input-error");
          atualizarErros(target.name, !celValido);
          setFormData({ ...formData, celular: celularMask(target.value) });
          break;
        }
        case "data_nascimento": {
          const dataFormatadaDMY = applyMask(target.value, "data");
          atualizarErros(target.name, dataFormatadaDMY.length !== 10);
          setFormData({ ...formData, data_nascimento: dataFormatadaDMY });
          break;
        }
        default:
          break;
      }
    }
    function inputBlur({ target }) {
      let valueLength = target.value.length;
      switch (target.name) {
        case "cpf": {
          const cpfIncompleto = valueLength < 14 && valueLength > 0;
          const cpfEmpty = valueLength == 0;
          if (cpfIncompleto)
            target.classList.add("input-attention");
          else if (valueLength == 14 || cpfEmpty) {
            if (target.classList.contains("input-attention")) {
              target.classList.remove("input-attention");
            }
          }
          break;
        }
        case "nome_completo": {
          const valor = target.value.trim();
          const palavras = valor.split(/\s+/);
          const isEmpty = valor.length === 0;
          const isInvalido = !isEmpty && palavras.length < 2;
          target.classList.toggle("input-error", isInvalido);
          atualizarErros(target.name, isEmpty || isInvalido);
          break;
        }
        case "celular": {
          if (valueLength < 14 && valueLength > 0) {
            target.classList.add("input-attention");
          } else {
            target.classList.remove("input-attention");
          }
          break;
        }
        case "data_nascimento": {
          if (target.value !== "") {
            if (selectedDates.some(
              (_eventDate) => validarMaioridade(
                target.value,
                convertDate2(_eventDate, "ISO")
              ) == false
            )) {
              setPaxMenor(true);
            } else
              setPaxMenor(false);
          }
          break;
        }
        default:
          break;
      }
    }
    function atualizarErros(campo, key) {
      setFormErrors((errosAtuais) => {
        if (key) {
          return errosAtuais.includes(campo) ? errosAtuais : [...errosAtuais, campo];
        } else {
          return errosAtuais.filter((erro) => erro !== campo);
        }
      });
    }
    const syncLeadWithServer = async (paxData) => {
      try {
        const rootUrl = window.themeLinks.siteUrl;
        const response = await fetch(`${rootUrl}/wp-json/aerotour/v1/save-lead`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            ...paxData,
            variation_id: variacoesSelecionadas,
            // ID da excursão atual
            embarque: embarqueId,
            // Ponto de embarque selecionado
            session_id: currentSessionId
            // Um ID único para esta navegação
          })
        });
        const data = await response.json();
        console.log(data);
      } catch (error) {
        console.error("Erro ao salvar lead:", error);
      }
    };
    function savePax(_mode) {
      if (formErrors.length === 0) {
        if (_mode == "add") {
          setPassageiros((_current) => {
            const paxJaExiste = _current.some(
              (_pax) => _pax.cpf === formData.cpf && formData.cpf !== ""
            );
            if (paxJaExiste) {
              alert("J\xE1 existe um passageiro com este CPF.");
              return _current;
            }
            syncLeadWithServer(formData);
            setPaxModalOpen(false);
            return [..._current, { ...formData, data_nascimento: formatarDataISO(formData.data_nascimento) }];
          });
        } else if (_mode == "edit") {
          const _index = paxModalOpen[3];
          setPassageiros((_current) => {
            const cpfJaExiste = _current.some(
              (_pax, _i) => _pax.cpf === formData.cpf && formData.cpf !== "" && _i != _index
            );
            if (cpfJaExiste) {
              alert("J\xE1 existe um passageiro com este CPF.");
              return _current;
            } else {
              setPaxModalOpen(false);
              return _current.map((_pax, _i) => {
                const _dn = isDataISO(formData.data_nascimento) ? formData.data_nascimento : formatarDataISO(formData.data_nascimento);
                if (_i === _index)
                  return { ...formData, data_nascimento: _dn };
                else
                  return _pax;
              });
            }
          });
        }
      }
    }
    React.useEffect(() => {
      if (paxModalOpen[0] == true) {
        setVisible(true);
        let _mode = paxModalOpen[1];
        setFormMode(_mode);
        if (_mode === "add") {
          setFormErrors(["nome_completo", "cpf", "celular", "data_nascimento"]);
        } else if (_mode === "edit") {
          const currentPaxData = paxModalOpen[2];
          setFormData(currentPaxData);
        }
      }
    }, [paxModalOpen]);
    return /* @__PURE__ */ (0, import_jsx_runtime4.jsx)(
      "div",
      {
        className: `modal-overlay ${visible ? "show" : ""}`,
        onClick: closePaxModal,
        children: /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)(
          "div",
          {
            className: `modal-content ${visible ? "show" : "hide"}`,
            onClick: (e) => e.stopPropagation(),
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime4.jsx)("button", { className: "modal-close", onClick: closePaxModal, children: "\u2716" }),
              /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)("h3", { children: [
                formMode === "edit" ? "Editar " : "Adicionar ",
                " passageiro"
              ] }),
              /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)(
                "form",
                {
                  id: "paxForm",
                  onSubmit: (e) => {
                    e.preventDefault();
                    savePax(formMode);
                  },
                  children: [
                    canShowAutofill && /* @__PURE__ */ (0, import_jsx_runtime4.jsx)("div", { className: "autofill-container mt-2", children: /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)("label", { className: "modern-checkbox-label", children: [
                      /* @__PURE__ */ (0, import_jsx_runtime4.jsx)(
                        "input",
                        {
                          type: "checkbox",
                          checked: useAccountData,
                          onChange: handleAutofillChange
                        }
                      ),
                      /* @__PURE__ */ (0, import_jsx_runtime4.jsx)("span", { className: "checkbox-custom" }),
                      /* @__PURE__ */ (0, import_jsx_runtime4.jsx)("span", { className: "label-text", children: "Usar meus dados de cadastro" })
                    ] }) }),
                    /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)("label", { children: [
                      "Nome:",
                      /* @__PURE__ */ (0, import_jsx_runtime4.jsx)(
                        "input",
                        {
                          type: "text",
                          name: "nome_completo",
                          value: formData.nome_completo,
                          onChange: (e) => setFormData({ ...formData, nome_completo: e.target.value }),
                          onBlur: inputBlur
                        }
                      )
                    ] }),
                    /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)("label", { children: [
                      "CPF:",
                      /* @__PURE__ */ (0, import_jsx_runtime4.jsx)(
                        "input",
                        {
                          type: "text",
                          name: "cpf",
                          maxLength: "14",
                          value: formData.cpf,
                          onBlur: inputBlur,
                          onChange: inputChange
                        }
                      )
                    ] }),
                    /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)("label", { children: [
                      "Celular (WhatsApp):",
                      /* @__PURE__ */ (0, import_jsx_runtime4.jsx)(
                        "input",
                        {
                          maxLength: "15",
                          type: "text",
                          name: "celular",
                          value: formData.celular,
                          onBlur: inputBlur,
                          onChange: inputChange
                        }
                      )
                    ] }),
                    /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)("label", { children: [
                      "Data de nascimento:",
                      /* @__PURE__ */ (0, import_jsx_runtime4.jsx)(
                        "input",
                        {
                          type: "text",
                          name: "data_nascimento",
                          maxLength: "10",
                          value: isDataISO(formData.data_nascimento) ? dataMask(formData.data_nascimento) : formData.data_nascimento,
                          onChange: inputChange,
                          onBlur: inputBlur
                        }
                      )
                    ] }),
                    /* @__PURE__ */ (0, import_jsx_runtime4.jsxs)("div", { className: "modal-buttons", children: [
                      /* @__PURE__ */ (0, import_jsx_runtime4.jsx)(
                        CustomSelectPaxModal_default,
                        {
                          setFormData,
                          tripType: formData.tripType
                        }
                      ),
                      formErrors.length > 0 ? /* @__PURE__ */ (0, import_jsx_runtime4.jsx)("button", { type: "submit", className: "saveBtn", disabled: true, children: "Salvar" }) : /* @__PURE__ */ (0, import_jsx_runtime4.jsx)("button", { type: "submit", className: "saveBtn", children: "Salvar" })
                    ] })
                  ]
                }
              )
            ]
          }
        )
      }
    );
  };
  PaxModal.propTypes = {
    setPaxModalOpen: import_prop_types4.default.func.isRequired,
    setPassageiros: import_prop_types4.default.func.isRequired,
    paxModalOpen: import_prop_types4.default.array.isRequired,
    selectedDates: import_prop_types4.default.array.isRequired,
    passageiros: import_prop_types4.default.array.isRequired,
    convertDate: import_prop_types4.default.func.isRequired,
    variacoesSelecionadas: import_prop_types4.default.array.isRequired,
    embarqueId: import_prop_types4.default.number
  };
  var PaxModal_default = PaxModal;

  // src/AppReservas/PaxCard.jsx
  var import_prop_types5 = __toESM(require_prop_types());
  var import_jsx_runtime5 = __toESM(require_jsx_runtime());
  var PaxCard = ({ pax, index, setPassageiros, openPaxModal }) => {
    const cardRef = React.useRef(null);
    function removePax() {
      const card = cardRef.current;
      if (window.confirm("Remover passageiro?")) {
        if (card) {
          card.classList.add("removing");
          setTimeout(() => {
            setPassageiros((_current) => {
              return _current.filter((_pax, _i) => _i != index);
            });
          }, 500);
        }
      }
    }
    React.useEffect(() => {
      const card = cardRef.current;
      if (card) {
        const timeout = setTimeout(() => {
          card.classList.add("highlight");
          setTimeout(() => {
            card.classList.remove("highlight");
          }, 900);
        }, 250);
        return () => clearTimeout(timeout);
      }
    }, []);
    return /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("article", { className: "passenger-card", ref: cardRef, children: [
      /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("div", { className: "avatar", children: /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(
        "svg",
        {
          xmlns: "http://www.w3.org/2000/svg",
          viewBox: "0 0 24 24",
          fill: "currentColor",
          children: /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(
            "path",
            {
              d: "M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 \r\n          1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 \r\n          1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
            }
          )
        }
      ) }),
      /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { className: "info", children: [
        /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { className: "top-row", children: [
          /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("div", { className: "name", tabIndex: "0", children: /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("p", { className: "my-0", "data-fullname": pax.nome_completo, children: pax.nome_completo }) }),
            /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("div", { className: "meta", children: pax.tripType == "ida-e-volta" ? "Ida e volta" : "Apenas " + pax.tripType })
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { className: "pill", children: [
            "Passageiro #",
            index + 1
          ] })
        ] }),
        /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("div", { style: { marginTop: "12px" }, children: /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("dl", { children: [
          /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("dt", { children: "CPF" }),
            /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("dd", { children: pax.cpf })
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("dt", { children: "Contato" }),
            /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("dd", { children: pax.celular })
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { children: [
            /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("dt", { children: "Nasc." }),
            /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("dd", { children: convertDate(pax.data_nascimento, "DMY") })
          ] })
        ] }) })
      ] }),
      /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(
        "button",
        {
          className: "edit-pencil",
          onClick: () => openPaxModal("edit", pax, index),
          children: "\u270F\uFE0F"
        }
      ),
      /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("button", { className: "remove-pencil", onClick: removePax, children: "\u{1F5D1}\uFE0F" })
    ] });
  };
  PaxCard.propTypes = {
    pax: import_prop_types5.default.object,
    index: import_prop_types5.default.number,
    setPassageiros: import_prop_types5.default.func.isRequired,
    openPaxModal: import_prop_types5.default.func.isRequired
  };
  var PaxCard_default = PaxCard;

  // src/AppReservas/AvisosModal.jsx
  var import_prop_types6 = __toESM(require_prop_types());
  var import_jsx_runtime6 = __toESM(require_jsx_runtime());
  var AvisosModal = ({
    alertType,
    setAvisosModalOpen,
    openDateModal,
    openEmbarqueModal
  }) => {
    const [visible, setVisible] = React.useState(false);
    function closeAvisosModal(_action) {
      setVisible(false);
      setTimeout(() => {
        if (_action === "goto-datas") {
          openDateModal(true);
        } else if (_action === "goto-embarques") {
          openEmbarqueModal(true);
        }
        setAvisosModalOpen(false);
      }, 300);
    }
    React.useEffect(() => {
      setVisible(true);
    }, []);
    return /* @__PURE__ */ (0, import_jsx_runtime6.jsx)(
      "div",
      {
        className: `modal-overlay ${visible ? "show" : ""}`,
        onClick: closeAvisosModal,
        children: /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)(
          "div",
          {
            className: `modal-content ${visible ? "show" : "hide"}`,
            onClick: (e) => e.stopPropagation(),
            children: [
              /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("h3", { children: "Aviso" }),
              /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)(
                "div",
                {
                  className: "modal-warning",
                  role: "alertdialog",
                  "aria-labelledby": "modal-warning-title",
                  "aria-describedby": "modal-warning-desc",
                  children: [
                    alertType == "sem-data-selecionada" && /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)(import_jsx_runtime6.Fragment, { children: [
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("h2", { id: "modal-warning-title", className: "visually-hidden", children: "Aviso de sele\xE7\xE3o de datas" }),
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("p", { id: "modal-warning-desc", className: "warning-message", children: "Selecione primeiro a(s) data(s) da excurs\xE3o." }),
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)("div", { className: "warning-actions", children: [
                        /* @__PURE__ */ (0, import_jsx_runtime6.jsx)(
                          "button",
                          {
                            type: "button",
                            className: "btn-primary",
                            onClick: () => closeAvisosModal("goto-datas"),
                            children: "Ir para sele\xE7\xE3o de datas"
                          }
                        ),
                        /* @__PURE__ */ (0, import_jsx_runtime6.jsx)(
                          "button",
                          {
                            type: "button",
                            className: "btn-secondary",
                            onClick: () => closeAvisosModal("cancel"),
                            children: "Cancelar"
                          }
                        )
                      ] })
                    ] }),
                    alertType == "sem-embarque-selecionado" && /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)(import_jsx_runtime6.Fragment, { children: [
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("h2", { id: "modal-warning-title", className: "visually-hidden", children: "Aviso de sele\xE7\xE3o de embarque" }),
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)(
                        "p",
                        {
                          id: "modal-warning-desc",
                          className: "warning-message",
                          onClick: () => closeAvisosModal("goto-embarques"),
                          children: "Selecione primeiro o seu ponto de embarque."
                        }
                      ),
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)("div", { className: "warning-actions", children: [
                        /* @__PURE__ */ (0, import_jsx_runtime6.jsx)(
                          "button",
                          {
                            type: "button",
                            className: "btn-primary",
                            onClick: () => closeAvisosModal("goto-embarques"),
                            children: "Ir para sele\xE7\xE3o de embarque"
                          }
                        ),
                        /* @__PURE__ */ (0, import_jsx_runtime6.jsx)(
                          "button",
                          {
                            type: "button",
                            className: "btn-secondary",
                            onClick: () => closeAvisosModal("cancel"),
                            children: "Cancelar"
                          }
                        )
                      ] })
                    ] }),
                    alertType == "max-vagas-atingido" && /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)("div", { className: "error-container", role: "alert", "aria-live": "assertive", children: [
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("div", { className: "error-icon", children: "\u26A0\uFE0F" }),
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("p", { className: "error-message", children: "N\xFAmero m\xE1ximo de vagas dispon\xEDveis atingido..." }),
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)(
                        "button",
                        {
                          className: "close-button",
                          type: "button",
                          onClick: () => closeAvisosModal("cancel"),
                          children: "Fechar"
                        }
                      )
                    ] }),
                    alertType == "ja-adicionado-carrinho" && /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)("div", { className: "error-container", role: "alert", "aria-live": "assertive", children: [
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("div", { className: "error-icon", children: "\u26A0\uFE0F" }),
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsxs)("p", { className: "error-message", children: [
                        "J\xE1 existe uma reserva para essa excurs\xE3o no carrinho.",
                        " ",
                        /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("span", { className: "d-block", children: /* @__PURE__ */ (0, import_jsx_runtime6.jsx)("a", { href: themeLinks.siteUrl + "/carrinho", className: "close-button d-block mt-3", children: "Ir ao carrinho" }) })
                      ] }),
                      /* @__PURE__ */ (0, import_jsx_runtime6.jsx)(
                        "button",
                        {
                          className: "close-button",
                          type: "button",
                          onClick: () => closeAvisosModal("cancel"),
                          children: "Fechar"
                        }
                      )
                    ] })
                  ]
                }
              )
            ]
          }
        )
      }
    );
  };
  AvisosModal.propTypes = {
    alertType: import_prop_types6.default.string.isRequired,
    setAvisosModalOpen: import_prop_types6.default.func.isRequired,
    openEmbarqueModal: import_prop_types6.default.func.isRequired,
    openDateModal: import_prop_types6.default.func.isRequired
  };
  var AvisosModal_default = AvisosModal;

  // src/AppReservas/PrecoReservas.jsx
  var import_prop_types7 = __toESM(require_prop_types());
  var import_jsx_runtime7 = __toESM(require_jsx_runtime());
  var PrecoReservas = ({
    passageiros,
    selectedDates,
    precoUnitario,
    totalCost,
    discountCost,
    dataLimiteDesconto
  }) => {
    return /* @__PURE__ */ (0, import_jsx_runtime7.jsx)(import_jsx_runtime7.Fragment, { children: passageiros.length > 0 && precoUnitario > 0 ? /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "passenger-card total-reservation", children: [
      /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "coluna-esquerda", children: [
        selectedDates.length == 1 && passageiros.length == 1 ? /* @__PURE__ */ (0, import_jsx_runtime7.jsx)("div", { className: "item", children: "Valor:" }) : null,
        selectedDates.length == 1 && passageiros.length > 1 ? /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)(import_jsx_runtime7.Fragment, { children: [
          /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "item small-info", children: [
            "Valor unit.: R$",
            precoUnitario,
            ",00"
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "item small-info", children: [
            "Passageiros: ",
            passageiros.length
          ] })
        ] }) : null,
        selectedDates.length > 1 && passageiros.length == 1 ? /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)(import_jsx_runtime7.Fragment, { children: [
          /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "item small-info", children: [
            "Valor unit.: R$",
            precoUnitario,
            ",00"
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "item small-info", children: [
            "Dias: ",
            selectedDates.length
          ] })
        ] }) : null,
        selectedDates.length > 1 && passageiros.length > 1 ? /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)(import_jsx_runtime7.Fragment, { children: [
          /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "item small-info", children: [
            "Valor unit.: R$",
            precoUnitario,
            ",00"
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "item small-info", children: [
            "Passageiros: ",
            passageiros.length
          ] }),
          /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "item small-info", children: [
            "Dias: ",
            selectedDates.length
          ] })
        ] }) : null
      ] }),
      /* @__PURE__ */ (0, import_jsx_runtime7.jsx)("div", { className: "coluna-direita", children: discountCost ? /* @__PURE__ */ (0, import_jsx_runtime7.jsx)(import_jsx_runtime7.Fragment, { children: /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)(
        "div",
        {
          className: "discount-price-container",
          onClick: () => {
            const descontoAntModal = new Modal(
              "generalModal",
              ".modal-content-body"
            );
            descontoAntModal.open("desconto_antecipado", {
              data_limite: convertDate(dataLimiteDesconto[0], "dmy")
            });
          },
          children: [
            /* @__PURE__ */ (0, import_jsx_runtime7.jsx)("div", { className: "total", children: "Total" }),
            /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)("div", { className: "total values-comp", children: [
              /* @__PURE__ */ (0, import_jsx_runtime7.jsx)("span", { className: "original-price", children: totalCost }),
              /* @__PURE__ */ (0, import_jsx_runtime7.jsx)("span", { children: discountCost })
            ] })
          ]
        }
      ) }) : /* @__PURE__ */ (0, import_jsx_runtime7.jsxs)(import_jsx_runtime7.Fragment, { children: [
        passageiros.length > 1 || selectedDates.length > 1 ? /* @__PURE__ */ (0, import_jsx_runtime7.jsx)("div", { className: "total", children: "Total" }) : null,
        /* @__PURE__ */ (0, import_jsx_runtime7.jsx)("div", { className: "total", children: totalCost })
      ] }) })
    ] }) : null });
  };
  PrecoReservas.propTypes = {
    passageiros: import_prop_types7.default.array.isRequired,
    selectedDates: import_prop_types7.default.array.isRequired,
    precoUnitario: import_prop_types7.default.number.isRequired,
    totalCost: import_prop_types7.default.string.isRequired,
    dataLimiteDesconto: import_prop_types7.default.string.isRequired,
    discountCost: import_prop_types7.default.oneOfType([import_prop_types7.default.string, import_prop_types7.default.bool]).isRequired
  };
  var PrecoReservas_default = PrecoReservas;

  // src/AppReservas/AppReservas.jsx
  var import_jsx_runtime8 = __toESM(require_jsx_runtime());
  function AppReservas() {
    const { variacoes, embarques, productId, estadoDestino } = window.singleProductData;
    const { ajaxUrl, cartUrl } = window.themeLinks;
    const [availableDates, setAvailableDates] = React.useState([]);
    const [selectedDates, setSelectedDates] = React.useState([]);
    const [variacoesSelecionadas, setVariacoesSelecionadas] = React.useState([]);
    const [dateModalOpen, setDateModalOpen] = React.useState(false);
    const [embarqueModalOpen, setEmbarqueModalOpen] = React.useState(false);
    const [paxModalOpen, setPaxModalOpen] = React.useState(false);
    const [avisosModalOpen, setAvisosModalOpen] = React.useState(false);
    const [embarque, setEmbarque] = React.useState([]);
    const [horario, setHorario] = React.useState(null);
    const [maxVagas, setMaxVagas] = React.useState(null);
    const [passageiros, setPassageiros] = React.useState([]);
    const [precoUnitario, setPrecoUnitario] = React.useState(0);
    const [taxa, setTaxa] = React.useState(0);
    const [loading, setLoading] = React.useState(false);
    const [excursaoEncerrada, setExcursaoEncerrada] = React.useState(false);
    const [totalCost, setTotalCost] = React.useState("R$ 0,00");
    const [discountCost, setDiscountCost] = React.useState(false);
    const [dataLimiteDesconto, setDataLimiteDesconto] = React.useState([]);
    const botaoContinuarRef = React.useRef();
    const dataBoxRef = React.useRef();
    const embarqueBoxRef = React.useRef();
    const cidadesDiaAnterior = ["Campinas", "Limeira", "Americana", "Sumar\xE9", "Itu", "Salto", "Indaiatuba"];
    function calculaValorTotal() {
      const total = precoUnitario * passageiros.length * selectedDates.length;
      const formatar = (valor) => valor.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
        minimumFractionDigits: 2
      });
      setTotalCost(formatar(total));
      if (!total)
        return setDiscountCost(false);
      const temDesconto = selectedDates.some(
        (data) => availableDates.find((d) => d.dia === data && d.desconto_antecipado)
      );
      if (total > 0) {
        setDiscountCost(temDesconto ? formatar(total * 0.95) : false);
      } else {
        setDiscountCost(false);
      }
    }
    React.useEffect(() => {
      const temData = selectedDates.length > 0;
      const temEmbarque = embarque.length > 0;
      const temHorario = horario && horario.length > 0;
      const temPassageiros = passageiros.length > 0;
      if (temData && temEmbarque && temHorario && temPassageiros) {
        botaoContinuarRef.current.removeAttribute("disabled");
      } else {
        botaoContinuarRef.current.setAttribute("disabled", "");
      }
      calculaValorTotal();
    }, [selectedDates, embarque, horario, passageiros]);
    React.useEffect(() => {
      if (loading) {
        botaoContinuarRef.current.setAttribute("disabled", "");
        botaoContinuarRef.current.innerHTML = '<span class="loadingElement my-0"></span>';
        return;
      } else {
        botaoContinuarRef.current.innerHTML = "Continuar";
        botaoContinuarRef.current.removeAttribute("disabled");
      }
    }, [loading]);
    React.useEffect(() => {
      if (variacoes.length == 1) {
        if (variacoes[0].encerrar_vendas)
          setExcursaoEncerrada(true);
        else {
          const singleVarId = variacoes[0].variation_id;
          const dataPayload = [
            variacoes[0].attributes.attribute_dia,
            singleVarId,
            getAvailabilityById(singleVarId)
          ];
          toggleDate([dataPayload]);
        }
      } else if (variacoes.length > 1) {
        const todasEncerradas = variacoes.every(
          (variacao) => variacao.encerrar_vendas
        );
        if (todasEncerradas)
          setExcursaoEncerrada(true);
      }
      variacoes.map((variacao) => {
        let _dia = variacao.attributes.attribute_dia;
        let _dia_iso = convertDate(_dia, "iso");
        let _disponiveis = getAvailabilityById(variacao.variation_id);
        let _i = 0;
        setAvailableDates((_previous) => {
          const dataLimiteDesconto2 = dataTrintaDiasAntes(_dia_iso);
          const temDescontoAntecipado = dataTemDescontoHoje(_dia_iso);
          if (variacoes.length === 1 && _i === 0) {
            setDataLimiteDesconto([dataLimiteDesconto2]);
          }
          _i++;
          _previous.push({
            dia: _dia,
            disponiveis: _disponiveis,
            encerrado: variacao.encerrar_vendas,
            variacao: variacao.variation_id,
            desconto_antecipado: temDescontoAntecipado,
            desconto_antecipado_val: dataLimiteDesconto2
          });
          return _previous;
        });
      });
    }, []);
    function submitToCart(index = 0) {
      if (!loading)
        setLoading(true);
      if (index >= selectedDates.length) {
        botaoContinuarRef.current.innerHTML = "Redirecionando para o carrinho...";
        window.location.href = cartUrl;
        return;
      }
      const submitQty = passageiros.length;
      const submitTaxa = taxa;
      const submitEmbarque = embarque ? embarque[0].embarqueId : null;
      const submitHorario = horario;
      const submitPax = passageiros.length > 0 ? JSON.stringify(passageiros) : null;
      const _date = selectedDates[index];
      const submitVarId = getVarIdByDate(_date);
      const lastSelectedDate = selectedDates[selectedDates.length - 1];
      const hasDiscount = discountCost ? convertDate(lastSelectedDate, "iso") : false;
      $.ajax({
        type: "POST",
        url: ajaxUrl,
        dataType: "json",
        // importante para interpretar resposta WooCommerce
        data: {
          action: "add_variation_to_cart",
          product_id: productId,
          variation_id: submitVarId,
          quantity: submitQty,
          taxa: submitTaxa,
          embarque: submitEmbarque,
          horario: submitHorario,
          passageiros: submitPax,
          desconto_antecipado: hasDiscount
        },
        success: function(response) {
          if (response.error) {
            setLoading(false);
            setAvisosModalOpen("ja-adicionado-carrinho");
            return;
          }
          submitToCart(index + 1);
        },
        error: function(xhr, status, error) {
          console.error("Erro AJAX:", error);
          setLoading(false);
        }
      });
    }
    function openDateModal() {
      setDateModalOpen(true);
    }
    function openEmbarqueModal() {
      if (selectedDates.length > 0)
        setEmbarqueModalOpen(true);
      else
        setAvisosModalOpen("sem-data-selecionada");
    }
    function openPaxModal(mode = "add", paxData = null, index = null) {
      if (selectedDates.length < 1) {
        setAvisosModalOpen("sem-data-selecionada");
        return;
      } else if (embarque.length < 1) {
        setAvisosModalOpen("sem-embarque-selecionado");
        return;
      } else {
        if (maxVagas <= passageiros.length)
          setAvisosModalOpen("max-vagas-atingido");
        else
          setPaxModalOpen([true, mode, paxData, index]);
      }
    }
    const getVarIdByDate = (date_str) => {
      const foundVar = variacoes.find(
        (_var) => _var.attributes.attribute_dia == date_str
      );
      return foundVar ? foundVar.variation_id : void 0;
    };
    const getAvailabilityById = (_id) => {
      const _var = variacoes.filter((_v) => _v.variation_id == _id)[0];
      const _payload = _var.availability_html;
      const _html = new DOMParser().parseFromString(_payload, "text/html");
      return _html.querySelector("p")?.textContent || 0;
    };
    const toggleDate = (dataPayload) => {
      setSelectedDates([]);
      setVariacoesSelecionadas([]);
      setEmbarque([]);
      setPrecoUnitario(0);
      if (!dataPayload || dataPayload.length === 0) {
        return;
      } else if (dataPayload.length > 0) {
        const arrayDatas = dataPayload.map((_payload) => _payload[0]);
        const sorted = arrayDatas.sort(
          (a, b) => convertDate(a, "dateobject") - convertDate(b, "dateobject")
        );
        setSelectedDates(sorted);
        const arrayVarIds = dataPayload.map((_payload) => _payload[1]);
        setVariacoesSelecionadas(() => arrayVarIds);
        const vagasPorDia = dataPayload.map((_payload) => +_payload[2]);
        setMaxVagas(Math.min(...vagasPorDia));
      }
    };
    const toggleEmbarque = (embId) => {
      embarques.forEach((_emb) => {
        if (_emb.embarqueId == embId) {
          setEmbarque([_emb]);
        }
      });
    };
    return /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(import_jsx_runtime8.Fragment, { children: /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)("div", { id: "newReservasContainer", children: [
      /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("p", { className: "main-title", children: "Fa\xE7a aqui sua reserva" }),
      !excursaoEncerrada ? /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)(import_jsx_runtime8.Fragment, { children: [
        /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("p", { className: "section-title", children: "Data e local de embarque" }),
        /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)("div", { className: "grid-row", children: [
          /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)(
            "div",
            {
              className: "grid-item clickable grid-dates",
              "data-fill": selectedDates.length < 1 ? "false" : "true",
              onClick: openDateModal,
              ref: dataBoxRef,
              children: [
                /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "icon", children: /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)(
                  "svg",
                  {
                    xmlns: "http://www.w3.org/2000/svg",
                    className: "bi bi-calendar2-event",
                    viewBox: "0 0 16 16",
                    children: [
                      /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("path", { d: "M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" }),
                      /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("path", { d: "M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" }),
                      /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("path", { d: "M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z" })
                    ]
                  }
                ) }),
                /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "text", children: selectedDates.length === 0 ? /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)("span", { className: "empty-text-placeholder", children: [
                  "Selecionar",
                  /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("br", {}),
                  " data..."
                ] }) : /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)(import_jsx_runtime8.Fragment, { children: [
                  /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)("span", { className: "box-title", children: [
                    selectedDates.length > 1 ? "Datas selecionadas" : "Data selecionada",
                    ":",
                    " "
                  ] }),
                  /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("ul", { className: selectedDates.length > 1 ? "multi" : "", children: selectedDates.map((d, i) => /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("li", { children: d === "31/12/2026" ? "A definir..." : d }, i)) })
                ] }) }),
                /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "edit-icon", children: "\u270F\uFE0F" })
              ]
            }
          ),
          /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)(
            "div",
            {
              className: "grid-item clickable grid-embarque",
              "data-fill": embarque.length < 1 ? "false" : "true",
              onClick: openEmbarqueModal,
              ref: embarqueBoxRef,
              children: [
                /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)("div", { className: "sub-embarque d-flex", children: [
                  /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "icon", children: /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(
                    "svg",
                    {
                      xmlns: "http://www.w3.org/2000/svg",
                      className: "bi bi-geo-alt-fill",
                      viewBox: "0 0 16 16",
                      children: /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("path", { d: "M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" })
                    }
                  ) }),
                  /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "text", children: embarque.length === 0 ? /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)("span", { className: "empty-text-placeholder", children: [
                    "Selecionar ",
                    /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("br", {}),
                    "embarque..."
                  ] }) : /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)(import_jsx_runtime8.Fragment, { children: [
                    /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("span", { className: "box-title", children: "Embarque" }),
                    /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("span", { children: embarque && embarque[0].nome })
                  ] }) })
                ] }),
                embarque.length > 0 && /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(import_jsx_runtime8.Fragment, { children: /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)("div", { className: "sub-horario d-flex mt-2", children: [
                  /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "icon", children: "\u{1F559}" }),
                  /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("span", { children: horario ? horario : "--:--" }),
                  /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "text", children: " " })
                ] }) }),
                /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "edit-icon", children: "\u270F\uFE0F" })
              ]
            }
          )
        ] }),
        /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("p", { className: "section-title", children: "Passageiros" }),
        /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)("div", { className: "passenger-list", children: [
          passageiros.length > 0 ? /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(import_jsx_runtime8.Fragment, { children: passageiros.map((_pax, index) => {
            return /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(
              PaxCard_default,
              {
                pax: _pax,
                index,
                setPassageiros,
                openPaxModal
              },
              _pax.cpf
            );
          }) }) : /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(import_jsx_runtime8.Fragment, { children: /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "placeholder-container mt-1", children: 'Nenhum passageiro adicionado. Clique em "Adicionar novo passageiro" para come\xE7ar.' }) }),
          /* @__PURE__ */ (0, import_jsx_runtime8.jsxs)(
            "div",
            {
              className: "passenger-card add-passenger",
              onClick: () => openPaxModal("add"),
              children: [
                /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "avatar", children: "\u2795" }),
                /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "info", children: /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "top-row", children: /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "name", children: "Adicionar novo passageiro" }) }) })
              ]
            }
          )
        ] }),
        /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(
          PrecoReservas_default,
          {
            passageiros,
            selectedDates,
            precoUnitario,
            totalCost,
            discountCost,
            dataLimiteDesconto
          }
        ),
        /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(
          "button",
          {
            id: "reservasContinuar",
            ref: botaoContinuarRef,
            className: "main-btn single_add_to_cart_button",
            onClick: () => submitToCart(),
            children: "Continuar"
          }
        ),
        embarqueModalOpen && /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(
          EmbarqueModal_default,
          {
            setEmbarqueModalOpen,
            toggleEmbarque,
            embarques,
            embarque,
            setEmbarque,
            selectedDates,
            variacoes,
            getVarIdByDate,
            setHorario,
            variacoesSelecionadas,
            setPrecoUnitario,
            setTaxa,
            estadoDestino,
            cidadesDiaAnterior
          }
        ),
        dateModalOpen && /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(
          DatesModal_default,
          {
            setDateModalOpen,
            availableDates,
            selectedDates,
            toggleDate,
            getVarIdByDate,
            getAvailabilityById,
            passageiros,
            dataLimiteDesconto,
            setDataLimiteDesconto
          }
        ),
        paxModalOpen != false && /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(
          PaxModal_default,
          {
            setPaxModalOpen,
            paxModalOpen,
            selectedDates,
            passageiros,
            setPassageiros,
            convertDate,
            variacoesSelecionadas,
            embarqueId: embarque[0].embarqueId
          }
        ),
        avisosModalOpen && /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(
          AvisosModal_default,
          {
            alertType: avisosModalOpen,
            setAvisosModalOpen,
            openDateModal,
            openEmbarqueModal
          }
        )
      ] }) : /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(import_jsx_runtime8.Fragment, { children: /* @__PURE__ */ (0, import_jsx_runtime8.jsx)("div", { className: "mensagem-encerrada", children: "Reservas encerradas para essa excurs\xE3o." }) })
    ] }) });
  }
  AppReservas.propTypes = {};
  addEventListener("DOMContentLoaded", () => {
    const reservas_app_root = document.getElementById("reserva_app");
    if (reservas_app_root) {
      ReactDOM.createRoot(reservas_app_root).render(
        /* @__PURE__ */ (0, import_jsx_runtime8.jsx)(AppReservas, {})
      );
    }
  });
})();
/*! Bundled license information:

react-is/cjs/react-is.development.js:
  (** @license React v16.13.1
   * react-is.development.js
   *
   * Copyright (c) Facebook, Inc. and its affiliates.
   *
   * This source code is licensed under the MIT license found in the
   * LICENSE file in the root directory of this source tree.
   *)

object-assign/index.js:
  (*
  object-assign
  (c) Sindre Sorhus
  @license MIT
  *)

react/cjs/react.development.js:
  (**
   * @license React
   * react.development.js
   *
   * Copyright (c) Facebook, Inc. and its affiliates.
   *
   * This source code is licensed under the MIT license found in the
   * LICENSE file in the root directory of this source tree.
   *)

react/cjs/react-jsx-runtime.development.js:
  (**
   * @license React
   * react-jsx-runtime.development.js
   *
   * Copyright (c) Facebook, Inc. and its affiliates.
   *
   * This source code is licensed under the MIT license found in the
   * LICENSE file in the root directory of this source tree.
   *)
*/
