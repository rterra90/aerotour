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
          var Fragment2 = REACT_FRAGMENT_TYPE;
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
          exports.Fragment = Fragment2;
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
      function toObject(val2) {
        if (val2 === null || val2 === void 0) {
          throw new TypeError("Object.assign cannot be called with null or undefined");
        }
        return Object(val2);
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
              var keys2 = Object.keys(fragment.props);
              for (var i = 0; i < keys2.length; i++) {
                var key = keys2[i];
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
              var keys2 = Object.keys(fragment.props);
              for (var i = 0; i < keys2.length; i++) {
                var key = keys2[i];
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
                  var keys2 = Object.keys(props).filter(function(k) {
                    return k !== "key";
                  });
                  var beforeExample = keys2.length > 0 ? "{key: someKey, " + keys2.join(": ..., ") + ": ...}" : "{key: someKey}";
                  if (!didWarnAboutKeySpread[componentName + beforeExample]) {
                    var afterExample = keys2.length > 0 ? "{" + keys2.join(": ..., ") + ": ...}" : "{}";
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
          var jsx6 = jsxWithValidationDynamic;
          var jsxs4 = jsxWithValidationStatic;
          exports.Fragment = REACT_FRAGMENT_TYPE;
          exports.jsx = jsx6;
          exports.jsxs = jsxs4;
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

  // src/Hooks/useAdminAjax.jsx
  var useAdminAjax = (adminAjaxUrl) => {
    function adminFetch(data, ajaxType = "GET", ajaxSuccess) {
      jQuery(function($2) {
        $2.ajax({
          url: adminAjaxUrl,
          type: ajaxType,
          data,
          success: async function(response) {
            ajaxSuccess(response.data);
          },
          error: function(error) {
            console.log("response error:  " + error);
          }
        });
      });
    }
    function get_reservas(setReservas, setExcDetails) {
      function success(data) {
        setReservas(data[0].reverse());
        setExcDetails(data[1]);
      }
      adminFetch({ action: "get_reservas" }, "GET", success);
    }
    function update_reserva(res_id, _action, updateReservaDom) {
      const postData = {
        action: "update_reserva",
        to: _action,
        res_id
      };
      adminFetch(postData, "POST", (data) => {
        console.log("success, chama updateReservaDom");
        updateReservaDom(data[0], res_id);
      });
    }
    return {
      get_reservas,
      update_reserva
    };
  };
  var useAdminAjax_default = useAdminAjax;

  // src/AppReservasAdmin/SelectLiveSearch.jsx
  var import_prop_types = __toESM(require_prop_types());
  var import_jsx_runtime = __toESM(require_jsx_runtime());
  var SelectLiveSearch = ({ srcArray, setFilter, filter }) => {
    const [status, setStatus] = React.useState("pr\xF3ximas");
    const selectFormRef = React.useRef();
    React.useEffect(() => {
      if (srcArray) {
        let createCustomDropdown2 = function(dropdown) {
          const options = dropdown.querySelectorAll("option");
          const optionsArr = Array.prototype.slice.call(options);
          const customDropdown = document.createElement("div");
          customDropdown.classList.add("live-search-dropdown");
          dropdown.insertAdjacentElement("afterend", customDropdown);
          const selected = document.createElement("div");
          selected.classList.add("dropdown-select");
          selected.textContent = optionsArr[0].textContent;
          customDropdown.appendChild(selected);
          const menu = document.createElement("div");
          menu.classList.add("dropdown-menu");
          customDropdown.appendChild(menu);
          selected.addEventListener("click", toggleDropdown2.bind(menu));
          const search = document.createElement("input");
          search.placeholder = "Search...";
          search.type = "text";
          search.classList.add("dropdown-menu-search");
          menu.appendChild(search);
          const menuInnerWrapper = document.createElement("div");
          menuInnerWrapper.classList.add("dropdown-menu-inner");
          menu.appendChild(menuInnerWrapper);
          optionsArr.forEach((option) => {
            const item = document.createElement("div");
            item.addEventListener("click", ({ target }) => {
              const _filter = target.dataset.varId == "undefined" ? 0 : +target.dataset.varId;
              setFilter(_filter);
            });
            item.classList.add("dropdown-menu-item");
            item.dataset.value = option.value;
            item.dataset.varId = option.dataset.varId;
            item.dataset.dia = option.dataset.dia;
            item.textContent = option.textContent;
            menuInnerWrapper.appendChild(item);
            item.addEventListener(
              "click",
              setSelected2.bind(item, selected, dropdown, menu)
            );
          });
          menuInnerWrapper.querySelector("div").classList.add("selected");
          search.addEventListener(
            "input",
            filterItems2.bind(search, optionsArr, menu)
          );
          document.addEventListener(
            "click",
            closeIfClickedOutside2.bind(customDropdown, menu)
          );
          dropdown.style.display = "none";
        }, toggleDropdown2 = function() {
          if (this.offsetHeight === 0) {
            this.style.display = "block";
            this.querySelector("input.dropdown-menu-search").focus();
          } else {
            this.style.display = "none";
            this.querySelector("input").focus();
          }
        }, setSelected2 = function(selected, dropdown, menu) {
          const value = this.dataset.value;
          const label = this.textContent;
          selected.textContent = label;
          dropdown.value = value;
          menu.style.display = "none";
          menu.querySelector("input").value = "";
          menu.querySelectorAll("div").forEach((div) => {
            if (div.classList.contains("is-select")) {
              div.classList.remove("is-select");
            }
            if (div.offsetParent === null) {
              div.style.display = "block";
            }
          });
          this.classList.add("is-select");
        }, filterItems2 = function(itemsArr, menu) {
          const customOptions = menu.querySelectorAll(".dropdown-menu-inner div");
          const value = this.value.toLowerCase();
          const filteredItems = itemsArr.filter(
            (item) => item.value.toLowerCase().includes(value)
          );
          const indexesArr = filteredItems.map((item) => itemsArr.indexOf(item));
          itemsArr.forEach((option) => {
            if (!indexesArr.includes(itemsArr.indexOf(option))) {
              customOptions[itemsArr.indexOf(option)].style.display = "none";
            } else {
              if (customOptions[itemsArr.indexOf(option)].offsetParent === null) {
                customOptions[itemsArr.indexOf(option)].style.display = "block";
              }
            }
          });
        }, closeIfClickedOutside2 = function(menu, e) {
          if (e.target.closest(".live-search-dropdown") === null && e.target !== this && menu.offsetParent !== null) {
            menu.style.display = "none";
          }
        };
        var createCustomDropdown = createCustomDropdown2, toggleDropdown = toggleDropdown2, setSelected = setSelected2, filterItems = filterItems2, closeIfClickedOutside = closeIfClickedOutside2;
        const form = document.querySelector(".live-search-form");
        const dropdowns = document.querySelectorAll(".live-search-dropdown");
        if (dropdowns.length > 0) {
          dropdowns.forEach((dropdown) => {
            createCustomDropdown2(dropdown);
          });
        }
        if (form !== null) {
          form.addEventListener("submit", (e) => {
            e.preventDefault();
          });
        }
      }
    }, [srcArray]);
    const sortedData = srcArray.sort((a, b) => {
      const dateA = new Date(a[1].split("/").reverse().join("/"));
      const dateB = new Date(b[1].split("/").reverse().join("/"));
      return dateA - dateB;
    });
    function alternaProxPass(proxOuPass) {
      const currentTimestamp = /* @__PURE__ */ new Date();
      const allOptions = selectFormRef.current.querySelectorAll(
        ".dropdown-menu-item"
      );
      allOptions.forEach((_option) => {
        const _diaStr = _option.dataset.dia;
        const _diaTimestamp = new Date(
          _diaStr.split("/").reverse().join("/")
        ).getTime();
        if (_diaTimestamp + 172800 < currentTimestamp) {
          if (proxOuPass === "pr\xF3ximas")
            _option.style.display = "none";
          else
            _option.style.display = "block";
        } else if (_diaTimestamp > currentTimestamp) {
          if (proxOuPass === "passadas")
            _option.style.display = "none";
          else
            _option.style.display = "block";
        }
      });
      setStatus(proxOuPass);
    }
    React.useEffect(() => {
      alternaProxPass(status);
    }, [filter]);
    return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(import_jsx_runtime.Fragment, { children: [
      /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
        "form",
        {
          ref: selectFormRef,
          name: "countries",
          className: "live-search-form",
          id: "form",
          children: /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { className: "form-group", children: [
            /* @__PURE__ */ (0, import_jsx_runtime.jsx)("span", { className: "form-arrow", children: /* @__PURE__ */ (0, import_jsx_runtime.jsx)("i", { className: "bx bx-chevron-down" }) }),
            /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("select", { name: "country", id: "country", className: "live-search-dropdown", children: [
              /* @__PURE__ */ (0, import_jsx_runtime.jsx)("option", { disabled: true, children: "Filtre por excurs\xE3o..." }),
              sortedData ? sortedData.map((item) => {
                return /* @__PURE__ */ (0, import_jsx_runtime.jsxs)(
                  "option",
                  {
                    value: item[0],
                    "data-dia": item[1],
                    "data-var-id": item[2],
                    children: [
                      item[0],
                      " - ",
                      item[1]
                    ]
                  },
                  item[2]
                );
              }) : null
            ] })
          ] })
        }
      ),
      /* @__PURE__ */ (0, import_jsx_runtime.jsxs)("div", { className: "selec-prox-pass", children: [
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
          "span",
          {
            className: status === "pr\xF3ximas" ? "ativo" : "",
            onClick: ({ currentTarget }) => alternaProxPass(currentTarget.innerText),
            children: "pr\xF3ximas"
          }
        ),
        " ",
        "|",
        " ",
        /* @__PURE__ */ (0, import_jsx_runtime.jsx)(
          "span",
          {
            className: status === "passadas" ? "ativo" : "",
            onClick: ({ currentTarget }) => alternaProxPass(currentTarget.innerText),
            children: "passadas"
          }
        )
      ] })
    ] });
  };
  SelectLiveSearch.propTypes = {
    srcArray: import_prop_types.default.array.isRequired,
    setFilter: import_prop_types.default.func.isRequired,
    filter: import_prop_types.default.number.isRequired
  };
  var SelectLiveSearch_default = SelectLiveSearch;

  // src/AppReservasAdmin/ItemReserva.jsx
  var import_prop_types2 = __toESM(require_prop_types());
  var import_jsx_runtime2 = __toESM(require_jsx_runtime());
  var ItemReserva = ({ reserva, excDetails, adminAjax, setToast }) => {
    const [currentReserva, setCurrentReserva] = React.useState(reserva);
    const orderLink = `${theme_links.adminUrl}post.php?post=${reserva.order_id}&action=edit`;
    const dia = excDetails["id_" + reserva.variation_id] ? excDetails["id_" + reserva.variation_id][1] : "";
    const rotaDaViagem = () => {
      if (reserva.rota === "2")
        return "\u27A1";
      if (reserva.rota === "3")
        return "\u2B05";
      return "";
    };
    function getAncestorByTag(element, tagName) {
      let ancestor = element;
      tagName = tagName.toLowerCase();
      while (ancestor) {
        if (ancestor.tagName.toLowerCase() === tagName)
          return ancestor;
        ancestor = ancestor.parentElement;
      }
      return null;
    }
    async function copyToClipboard(textToCopy) {
      try {
        await navigator.clipboard.writeText(textToCopy);
      } catch (err) {
        console.error("Falha ao copiar: ", err);
      }
    }
    function _closeMenu() {
      const _menu = document.querySelectorAll(".menu-reserva");
      _menu.forEach((_m) => {
        _m.parentElement.classList.remove("menu-ativo");
        document.body.classList.remove("tem-menu-ativo");
        document.body.removeEventListener("click", closeOptionsMenu);
        _m.remove();
      });
    }
    function updateReservaDom(reservaAtualizada, idReserva) {
      const domElement = document.querySelector(
        `tr[data-reserva-id="${idReserva}"]`
      );
      if (domElement) {
        setCurrentReserva(reservaAtualizada);
        if (reservaAtualizada.status === "cancel")
          domElement.classList.add("reserva-cancelada");
        else {
          domElement.classList.remove("reserva-cancelada");
        }
        ;
        _closeMenu();
        setToast("Reserva atualizada com sucesso");
      } else {
        console.log("Elemento DOM da reserva n\xE3o encontrado.");
      }
    }
    function closeOptionsMenu({ target }) {
      if (document.body.classList.contains("tem-menu-ativo")) {
        const targetMenu = document.querySelector("tr .menu-reserva");
        if (targetMenu && !target.classList.contains("menu-reserva-component"))
          _closeMenu();
        else {
          switch (target.dataset.opcao) {
            case "Cancelar reserva":
              target.parentElement.classList.add("loading");
              adminAjax.update_reserva(reserva.ID, "cancelar", updateReservaDom);
              break;
            case "Reativar reserva":
              target.parentElement.classList.add("loading");
              adminAjax.update_reserva(reserva.ID, "reativar", updateReservaDom);
              break;
            case "Copiar dados":
              copyToClipboard(
                getAncestorByTag(target, "tr").childNodes[2].innerText + " \u2014 " + getAncestorByTag(target, "tr").childNodes[3].innerText + " \u2014 " + getAncestorByTag(target, "tr").childNodes[4].innerText
              );
              _closeMenu();
              setToast("Dados copiados com sucesso");
              break;
            default:
              console.log(target.dataset.opcao);
              break;
          }
        }
      }
    }
    function openOptionsMenu({ clientX, currentTarget }) {
      const xInicial = currentTarget.getBoundingClientRect().x;
      const posX = clientX - xInicial;
      if (!document.body.classList.contains("tem-menu-ativo")) {
        currentTarget.classList.add("menu-ativo");
        let menuElement = document.createElement("div");
        menuElement.classList.add("menu-reserva", "menu-reserva-component");
        menuElement.appendChild(document.createElement("ul"));
        const opcoes = [
          "Copiar dados",
          "Ver pedido",
          "Alterar embarque",
          "Cancelar reserva",
          "Reativar reserva"
        ];
        const menuOption = (_op) => {
          const _element = document.createElement("li");
          _element.dataset.opcao = _op;
          _element.innerText = _op;
          _element.classList.add("menu-reserva-component");
          menuElement.querySelector("ul").appendChild(_element);
        };
        opcoes.forEach((_opcao) => {
          switch (_opcao) {
            case "Reativar reserva":
              if (currentReserva.status === "cancel")
                menuOption(_opcao);
              break;
            case "Cancelar reserva":
              if (currentReserva.status !== "cancel")
                menuOption(_opcao);
              break;
            default:
              menuOption(_opcao);
          }
        });
        if (posX < currentTarget.offsetWidth * 0.75)
          menuElement.style.left = `${posX + 6}px`;
        else
          menuElement.style.right = `${currentTarget.offsetWidth - posX + 6}px`;
        currentTarget.appendChild(menuElement);
        setTimeout(() => {
          document.body.addEventListener("click", closeOptionsMenu);
          document.body.classList.add("tem-menu-ativo");
        }, 80);
      }
    }
    return /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("tr", { onClick: openOptionsMenu, "data-reserva-id": reserva.ID, className: reserva.status === "cancel" ? "reserva-cancelada" : "", children: [
      /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("td", { "data-coluna": "order-id", children: /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("a", { href: orderLink, children: reserva.order_id }) }),
      /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("td", { "data-coluna": "excursao", children: [
        excDetails["id_" + reserva.variation_id] ? excDetails["id_" + reserva.variation_id][0] : "",
        " ",
        "- ",
        dia.substring(0, 5)
      ] }),
      /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("td", { "data-coluna": "nome-completo", children: reserva.p_nome }),
      /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("td", { "data-coluna": "cpf", children: reserva.p_cpf }),
      /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("td", { "data-coluna": "telefone", children: reserva.p_telefone }),
      /* @__PURE__ */ (0, import_jsx_runtime2.jsxs)("td", { "data-coluna": "embarque", children: [
        reserva.embarque,
        /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("span", { children: rotaDaViagem() })
      ] }),
      /* @__PURE__ */ (0, import_jsx_runtime2.jsx)("td", { "data-coluna": "horario", children: reserva.horario.slice(0, -3) })
    ] });
  };
  ItemReserva.propTypes = {
    reserva: import_prop_types2.default.object.isRequired,
    excDetails: import_prop_types2.default.object.isRequired,
    adminAjax: import_prop_types2.default.object.isRequired,
    setToast: import_prop_types2.default.func
  };
  var ItemReserva_default = ItemReserva;

  // src/AppReservasAdmin/AppReservasAdmin.jsx
  var import_prop_types5 = __toESM(require_prop_types());

  // src/AppReservasAdmin/Toast.jsx
  var import_prop_types3 = __toESM(require_prop_types());
  var import_jsx_runtime3 = __toESM(require_jsx_runtime());
  var Toast = ({ message, setToast }) => {
    React.useEffect(() => {
      setTimeout(() => {
        setToast(false);
      }, 3e3);
    }, []);
    return /* @__PURE__ */ (0, import_jsx_runtime3.jsx)("span", { className: "toast", children: message });
  };
  Toast.propTypes = {
    message: import_prop_types3.default.string.isRequired,
    setToast: import_prop_types3.default.func
  };
  var Toast_default = Toast;

  // node_modules/xlsx/xlsx.mjs
  var XLSX = {};
  XLSX.version = "0.20.3";
  var current_codepage = 1200;
  var current_ansi = 1252;
  var $cptable;
  var VALID_ANSI = [874, 932, 936, 949, 950, 1250, 1251, 1252, 1253, 1254, 1255, 1256, 1257, 1258, 1e4];
  var CS2CP = {
    0: 1252,
    /* ANSI */
    1: 65001,
    /* DEFAULT */
    2: 65001,
    /* SYMBOL */
    77: 1e4,
    /* MAC */
    128: 932,
    /* SHIFTJIS */
    129: 949,
    /* HANGUL */
    130: 1361,
    /* JOHAB */
    134: 936,
    /* GB2312 */
    136: 950,
    /* CHINESEBIG5 */
    161: 1253,
    /* GREEK */
    162: 1254,
    /* TURKISH */
    163: 1258,
    /* VIETNAMESE */
    177: 1255,
    /* HEBREW */
    178: 1256,
    /* ARABIC */
    186: 1257,
    /* BALTIC */
    204: 1251,
    /* RUSSIAN */
    222: 874,
    /* THAI */
    238: 1250,
    /* EASTEUROPE */
    255: 1252,
    /* OEM */
    69: 6969
    /* MISC */
  };
  var set_ansi = function(cp) {
    if (VALID_ANSI.indexOf(cp) == -1)
      return;
    current_ansi = CS2CP[0] = cp;
  };
  function reset_ansi() {
    set_ansi(1252);
  }
  var set_cp = function(cp) {
    current_codepage = cp;
    set_ansi(cp);
  };
  function reset_cp() {
    set_cp(1200);
    reset_ansi();
  }
  var _getchar = function _gc1(x) {
    return String.fromCharCode(x);
  };
  var DENSE = null;
  var Base64_map = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
  function Base64_encode(input) {
    var o = "";
    var c1 = 0, c2 = 0, c3 = 0, e1 = 0, e2 = 0, e3 = 0, e4 = 0;
    for (var i = 0; i < input.length; ) {
      c1 = input.charCodeAt(i++);
      e1 = c1 >> 2;
      c2 = input.charCodeAt(i++);
      e2 = (c1 & 3) << 4 | c2 >> 4;
      c3 = input.charCodeAt(i++);
      e3 = (c2 & 15) << 2 | c3 >> 6;
      e4 = c3 & 63;
      if (isNaN(c2)) {
        e3 = e4 = 64;
      } else if (isNaN(c3)) {
        e4 = 64;
      }
      o += Base64_map.charAt(e1) + Base64_map.charAt(e2) + Base64_map.charAt(e3) + Base64_map.charAt(e4);
    }
    return o;
  }
  function Base64_encode_arr(input) {
    var o = "";
    var c1 = 0, c2 = 0, c3 = 0, e1 = 0, e2 = 0, e3 = 0, e4 = 0;
    for (var i = 0; i < input.length; ) {
      c1 = input[i++];
      e1 = c1 >> 2;
      c2 = input[i++];
      e2 = (c1 & 3) << 4 | c2 >> 4;
      c3 = input[i++];
      e3 = (c2 & 15) << 2 | c3 >> 6;
      e4 = c3 & 63;
      if (isNaN(c2)) {
        e3 = e4 = 64;
      } else if (isNaN(c3)) {
        e4 = 64;
      }
      o += Base64_map.charAt(e1) + Base64_map.charAt(e2) + Base64_map.charAt(e3) + Base64_map.charAt(e4);
    }
    return o;
  }
  function Base64_decode(input) {
    var o = "";
    var c1 = 0, c2 = 0, c3 = 0, e1 = 0, e2 = 0, e3 = 0, e4 = 0;
    if (input.slice(0, 5) == "data:") {
      var i = input.slice(0, 1024).indexOf(";base64,");
      if (i > -1)
        input = input.slice(i + 8);
    }
    input = input.replace(/[^\w\+\/\=]/g, "");
    for (var i = 0; i < input.length; ) {
      e1 = Base64_map.indexOf(input.charAt(i++));
      e2 = Base64_map.indexOf(input.charAt(i++));
      c1 = e1 << 2 | e2 >> 4;
      o += String.fromCharCode(c1);
      e3 = Base64_map.indexOf(input.charAt(i++));
      c2 = (e2 & 15) << 4 | e3 >> 2;
      if (e3 !== 64) {
        o += String.fromCharCode(c2);
      }
      e4 = Base64_map.indexOf(input.charAt(i++));
      c3 = (e3 & 3) << 6 | e4;
      if (e4 !== 64) {
        o += String.fromCharCode(c3);
      }
    }
    return o;
  }
  var has_buf = /* @__PURE__ */ function() {
    return typeof Buffer !== "undefined" && typeof process !== "undefined" && typeof process.versions !== "undefined" && !!process.versions.node;
  }();
  var Buffer_from = /* @__PURE__ */ function() {
    if (typeof Buffer !== "undefined") {
      var nbfs = !Buffer.from;
      if (!nbfs)
        try {
          Buffer.from("foo", "utf8");
        } catch (e) {
          nbfs = true;
        }
      return nbfs ? function(buf, enc) {
        return enc ? new Buffer(buf, enc) : new Buffer(buf);
      } : Buffer.from.bind(Buffer);
    }
    return function() {
    };
  }();
  var buf_utf16le = /* @__PURE__ */ function() {
    if (typeof Buffer === "undefined")
      return false;
    var x = Buffer_from([65, 0]);
    if (!x)
      return false;
    var o = x.toString("utf16le");
    return o.length == 1;
  }();
  function new_raw_buf(len) {
    if (has_buf)
      return Buffer.alloc ? Buffer.alloc(len) : new Buffer(len);
    return typeof Uint8Array != "undefined" ? new Uint8Array(len) : new Array(len);
  }
  function new_unsafe_buf(len) {
    if (has_buf)
      return Buffer.allocUnsafe ? Buffer.allocUnsafe(len) : new Buffer(len);
    return typeof Uint8Array != "undefined" ? new Uint8Array(len) : new Array(len);
  }
  var s2a = function s2a2(s) {
    if (has_buf)
      return Buffer_from(s, "binary");
    return s.split("").map(function(x) {
      return x.charCodeAt(0) & 255;
    });
  };
  function s2ab(s) {
    if (typeof ArrayBuffer === "undefined")
      return s2a(s);
    var buf = new ArrayBuffer(s.length), view = new Uint8Array(buf);
    for (var i = 0; i != s.length; ++i)
      view[i] = s.charCodeAt(i) & 255;
    return buf;
  }
  function a2s(data) {
    if (Array.isArray(data))
      return data.map(function(c) {
        return String.fromCharCode(c);
      }).join("");
    var o = [];
    for (var i = 0; i < data.length; ++i)
      o[i] = String.fromCharCode(data[i]);
    return o.join("");
  }
  function a2u(data) {
    if (typeof Uint8Array === "undefined")
      throw new Error("Unsupported");
    return new Uint8Array(data);
  }
  var bconcat = has_buf ? function(bufs) {
    return Buffer.concat(bufs.map(function(buf) {
      return Buffer.isBuffer(buf) ? buf : Buffer_from(buf);
    }));
  } : function(bufs) {
    if (typeof Uint8Array !== "undefined") {
      var i = 0, maxlen = 0;
      for (i = 0; i < bufs.length; ++i)
        maxlen += bufs[i].length;
      var o = new Uint8Array(maxlen);
      var len = 0;
      for (i = 0, maxlen = 0; i < bufs.length; maxlen += len, ++i) {
        len = bufs[i].length;
        if (bufs[i] instanceof Uint8Array)
          o.set(bufs[i], maxlen);
        else if (typeof bufs[i] == "string")
          o.set(new Uint8Array(s2a(bufs[i])), maxlen);
        else
          o.set(new Uint8Array(bufs[i]), maxlen);
      }
      return o;
    }
    return [].concat.apply([], bufs.map(function(buf) {
      return Array.isArray(buf) ? buf : [].slice.call(buf);
    }));
  };
  function utf8decode(content) {
    var out = [], widx = 0, L = content.length + 250;
    var o = new_raw_buf(content.length + 255);
    for (var ridx = 0; ridx < content.length; ++ridx) {
      var c = content.charCodeAt(ridx);
      if (c < 128)
        o[widx++] = c;
      else if (c < 2048) {
        o[widx++] = 192 | c >> 6 & 31;
        o[widx++] = 128 | c & 63;
      } else if (c >= 55296 && c < 57344) {
        c = (c & 1023) + 64;
        var d = content.charCodeAt(++ridx) & 1023;
        o[widx++] = 240 | c >> 8 & 7;
        o[widx++] = 128 | c >> 2 & 63;
        o[widx++] = 128 | d >> 6 & 15 | (c & 3) << 4;
        o[widx++] = 128 | d & 63;
      } else {
        o[widx++] = 224 | c >> 12 & 15;
        o[widx++] = 128 | c >> 6 & 63;
        o[widx++] = 128 | c & 63;
      }
      if (widx > L) {
        out.push(o.slice(0, widx));
        widx = 0;
        o = new_raw_buf(65535);
        L = 65530;
      }
    }
    out.push(o.slice(0, widx));
    return bconcat(out);
  }
  var chr0 = /\u0000/g;
  var chr1 = /[\u0001-\u0006]/g;
  function _strrev(x) {
    var o = "", i = x.length - 1;
    while (i >= 0)
      o += x.charAt(i--);
    return o;
  }
  function pad0(v, d) {
    var t = "" + v;
    return t.length >= d ? t : fill("0", d - t.length) + t;
  }
  function pad_(v, d) {
    var t = "" + v;
    return t.length >= d ? t : fill(" ", d - t.length) + t;
  }
  function rpad_(v, d) {
    var t = "" + v;
    return t.length >= d ? t : t + fill(" ", d - t.length);
  }
  function pad0r1(v, d) {
    var t = "" + Math.round(v);
    return t.length >= d ? t : fill("0", d - t.length) + t;
  }
  function pad0r2(v, d) {
    var t = "" + v;
    return t.length >= d ? t : fill("0", d - t.length) + t;
  }
  var p2_32 = /* @__PURE__ */ Math.pow(2, 32);
  function pad0r(v, d) {
    if (v > p2_32 || v < -p2_32)
      return pad0r1(v, d);
    var i = Math.round(v);
    return pad0r2(i, d);
  }
  function SSF_isgeneral(s, i) {
    i = i || 0;
    return s.length >= 7 + i && (s.charCodeAt(i) | 32) === 103 && (s.charCodeAt(i + 1) | 32) === 101 && (s.charCodeAt(i + 2) | 32) === 110 && (s.charCodeAt(i + 3) | 32) === 101 && (s.charCodeAt(i + 4) | 32) === 114 && (s.charCodeAt(i + 5) | 32) === 97 && (s.charCodeAt(i + 6) | 32) === 108;
  }
  var days = [
    ["Sun", "Sunday"],
    ["Mon", "Monday"],
    ["Tue", "Tuesday"],
    ["Wed", "Wednesday"],
    ["Thu", "Thursday"],
    ["Fri", "Friday"],
    ["Sat", "Saturday"]
  ];
  var months = [
    ["J", "Jan", "January"],
    ["F", "Feb", "February"],
    ["M", "Mar", "March"],
    ["A", "Apr", "April"],
    ["M", "May", "May"],
    ["J", "Jun", "June"],
    ["J", "Jul", "July"],
    ["A", "Aug", "August"],
    ["S", "Sep", "September"],
    ["O", "Oct", "October"],
    ["N", "Nov", "November"],
    ["D", "Dec", "December"]
  ];
  function SSF_init_table(t) {
    if (!t)
      t = {};
    t[0] = "General";
    t[1] = "0";
    t[2] = "0.00";
    t[3] = "#,##0";
    t[4] = "#,##0.00";
    t[9] = "0%";
    t[10] = "0.00%";
    t[11] = "0.00E+00";
    t[12] = "# ?/?";
    t[13] = "# ??/??";
    t[14] = "m/d/yy";
    t[15] = "d-mmm-yy";
    t[16] = "d-mmm";
    t[17] = "mmm-yy";
    t[18] = "h:mm AM/PM";
    t[19] = "h:mm:ss AM/PM";
    t[20] = "h:mm";
    t[21] = "h:mm:ss";
    t[22] = "m/d/yy h:mm";
    t[37] = "#,##0 ;(#,##0)";
    t[38] = "#,##0 ;[Red](#,##0)";
    t[39] = "#,##0.00;(#,##0.00)";
    t[40] = "#,##0.00;[Red](#,##0.00)";
    t[45] = "mm:ss";
    t[46] = "[h]:mm:ss";
    t[47] = "mmss.0";
    t[48] = "##0.0E+0";
    t[49] = "@";
    t[56] = '"\u4E0A\u5348/\u4E0B\u5348 "hh"\u6642"mm"\u5206"ss"\u79D2 "';
    return t;
  }
  var table_fmt = {
    0: "General",
    1: "0",
    2: "0.00",
    3: "#,##0",
    4: "#,##0.00",
    9: "0%",
    10: "0.00%",
    11: "0.00E+00",
    12: "# ?/?",
    13: "# ??/??",
    14: "m/d/yy",
    15: "d-mmm-yy",
    16: "d-mmm",
    17: "mmm-yy",
    18: "h:mm AM/PM",
    19: "h:mm:ss AM/PM",
    20: "h:mm",
    21: "h:mm:ss",
    22: "m/d/yy h:mm",
    37: "#,##0 ;(#,##0)",
    38: "#,##0 ;[Red](#,##0)",
    39: "#,##0.00;(#,##0.00)",
    40: "#,##0.00;[Red](#,##0.00)",
    45: "mm:ss",
    46: "[h]:mm:ss",
    47: "mmss.0",
    48: "##0.0E+0",
    49: "@",
    56: '"\u4E0A\u5348/\u4E0B\u5348 "hh"\u6642"mm"\u5206"ss"\u79D2 "'
  };
  var SSF_default_map = {
    5: 37,
    6: 38,
    7: 39,
    8: 40,
    //  5 -> 37 ...  8 -> 40
    23: 0,
    24: 0,
    25: 0,
    26: 0,
    // 23 ->  0 ... 26 ->  0
    27: 14,
    28: 14,
    29: 14,
    30: 14,
    31: 14,
    // 27 -> 14 ... 31 -> 14
    50: 14,
    51: 14,
    52: 14,
    53: 14,
    54: 14,
    // 50 -> 14 ... 58 -> 14
    55: 14,
    56: 14,
    57: 14,
    58: 14,
    59: 1,
    60: 2,
    61: 3,
    62: 4,
    // 59 ->  1 ... 62 ->  4
    67: 9,
    68: 10,
    // 67 ->  9 ... 68 -> 10
    69: 12,
    70: 13,
    71: 14,
    // 69 -> 12 ... 71 -> 14
    72: 14,
    73: 15,
    74: 16,
    75: 17,
    // 72 -> 14 ... 75 -> 17
    76: 20,
    77: 21,
    78: 22,
    // 76 -> 20 ... 78 -> 22
    79: 45,
    80: 46,
    81: 47,
    // 79 -> 45 ... 81 -> 47
    82: 0
    // 82 ->  0 ... 65536 -> 0 (omitted)
  };
  var SSF_default_str = {
    //  5 -- Currency,   0 decimal, black negative
    5: '"$"#,##0_);\\("$"#,##0\\)',
    63: '"$"#,##0_);\\("$"#,##0\\)',
    //  6 -- Currency,   0 decimal, red   negative
    6: '"$"#,##0_);[Red]\\("$"#,##0\\)',
    64: '"$"#,##0_);[Red]\\("$"#,##0\\)',
    //  7 -- Currency,   2 decimal, black negative
    7: '"$"#,##0.00_);\\("$"#,##0.00\\)',
    65: '"$"#,##0.00_);\\("$"#,##0.00\\)',
    //  8 -- Currency,   2 decimal, red   negative
    8: '"$"#,##0.00_);[Red]\\("$"#,##0.00\\)',
    66: '"$"#,##0.00_);[Red]\\("$"#,##0.00\\)',
    // 41 -- Accounting, 0 decimal, No Symbol
    41: '_(* #,##0_);_(* \\(#,##0\\);_(* "-"_);_(@_)',
    // 42 -- Accounting, 0 decimal, $  Symbol
    42: '_("$"* #,##0_);_("$"* \\(#,##0\\);_("$"* "-"_);_(@_)',
    // 43 -- Accounting, 2 decimal, No Symbol
    43: '_(* #,##0.00_);_(* \\(#,##0.00\\);_(* "-"??_);_(@_)',
    // 44 -- Accounting, 2 decimal, $  Symbol
    44: '_("$"* #,##0.00_);_("$"* \\(#,##0.00\\);_("$"* "-"??_);_(@_)'
  };
  function SSF_frac(x, D, mixed) {
    var sgn = x < 0 ? -1 : 1;
    var B = x * sgn;
    var P_2 = 0, P_1 = 1, P = 0;
    var Q_2 = 1, Q_1 = 0, Q = 0;
    var A = Math.floor(B);
    while (Q_1 < D) {
      A = Math.floor(B);
      P = A * P_1 + P_2;
      Q = A * Q_1 + Q_2;
      if (B - A < 5e-8)
        break;
      B = 1 / (B - A);
      P_2 = P_1;
      P_1 = P;
      Q_2 = Q_1;
      Q_1 = Q;
    }
    if (Q > D) {
      if (Q_1 > D) {
        Q = Q_2;
        P = P_2;
      } else {
        Q = Q_1;
        P = P_1;
      }
    }
    if (!mixed)
      return [0, sgn * P, Q];
    var q = Math.floor(sgn * P / Q);
    return [q, sgn * P - q * Q, Q];
  }
  function SSF_normalize_xl_unsafe(v) {
    var s = v.toPrecision(16);
    if (s.indexOf("e") > -1) {
      var m = s.slice(0, s.indexOf("e"));
      m = m.indexOf(".") > -1 ? m.slice(0, m.slice(0, 2) == "0." ? 17 : 16) : m.slice(0, 15) + fill("0", m.length - 15);
      return m + s.slice(s.indexOf("e"));
    }
    var n = s.indexOf(".") > -1 ? s.slice(0, s.slice(0, 2) == "0." ? 17 : 16) : s.slice(0, 15) + fill("0", s.length - 15);
    return Number(n);
  }
  function SSF_parse_date_code(v, opts, b2) {
    if (v > 2958465 || v < 0)
      return null;
    v = SSF_normalize_xl_unsafe(v);
    var date = v | 0, time = Math.floor(86400 * (v - date)), dow = 0;
    var dout = [];
    var out = { D: date, T: time, u: 86400 * (v - date) - time, y: 0, m: 0, d: 0, H: 0, M: 0, S: 0, q: 0 };
    if (Math.abs(out.u) < 1e-6)
      out.u = 0;
    if (opts && opts.date1904)
      date += 1462;
    if (out.u > 0.9999) {
      out.u = 0;
      if (++time == 86400) {
        out.T = time = 0;
        ++date;
        ++out.D;
      }
    }
    if (date === 60) {
      dout = b2 ? [1317, 10, 29] : [1900, 2, 29];
      dow = 3;
    } else if (date === 0) {
      dout = b2 ? [1317, 8, 29] : [1900, 1, 0];
      dow = 6;
    } else {
      if (date > 60)
        --date;
      var d = new Date(1900, 0, 1);
      d.setDate(d.getDate() + date - 1);
      dout = [d.getFullYear(), d.getMonth() + 1, d.getDate()];
      dow = d.getDay();
      if (date < 60)
        dow = (dow + 6) % 7;
      if (b2)
        dow = SSF_fix_hijri(d, dout);
    }
    out.y = dout[0];
    out.m = dout[1];
    out.d = dout[2];
    out.S = time % 60;
    time = Math.floor(time / 60);
    out.M = time % 60;
    time = Math.floor(time / 60);
    out.H = time;
    out.q = dow;
    return out;
  }
  function SSF_strip_decimal(o) {
    return o.indexOf(".") == -1 ? o : o.replace(/(?:\.0*|(\.\d*[1-9])0+)$/, "$1");
  }
  function SSF_normalize_exp(o) {
    if (o.indexOf("E") == -1)
      return o;
    return o.replace(/(?:\.0*|(\.\d*[1-9])0+)[Ee]/, "$1E").replace(/(E[+-])(\d)$/, "$10$2");
  }
  function SSF_small_exp(v) {
    var w = v < 0 ? 12 : 11;
    var o = SSF_strip_decimal(v.toFixed(12));
    if (o.length <= w)
      return o;
    o = v.toPrecision(10);
    if (o.length <= w)
      return o;
    return v.toExponential(5);
  }
  function SSF_large_exp(v) {
    var o = SSF_strip_decimal(v.toFixed(11));
    return o.length > (v < 0 ? 12 : 11) || o === "0" || o === "-0" ? v.toPrecision(6) : o;
  }
  function SSF_general_num(v) {
    if (!isFinite(v))
      return isNaN(v) ? "#NUM!" : "#DIV/0!";
    var V = Math.floor(Math.log(Math.abs(v)) * Math.LOG10E), o;
    if (V >= -4 && V <= -1)
      o = v.toPrecision(10 + V);
    else if (Math.abs(V) <= 9)
      o = SSF_small_exp(v);
    else if (V === 10)
      o = v.toFixed(10).substr(0, 12);
    else
      o = SSF_large_exp(v);
    return SSF_strip_decimal(SSF_normalize_exp(o.toUpperCase()));
  }
  function SSF_general(v, opts) {
    switch (typeof v) {
      case "string":
        return v;
      case "boolean":
        return v ? "TRUE" : "FALSE";
      case "number":
        return (v | 0) === v ? v.toString(10) : SSF_general_num(v);
      case "undefined":
        return "";
      case "object":
        if (v == null)
          return "";
        if (v instanceof Date)
          return SSF_format(14, datenum(v, opts && opts.date1904), opts);
    }
    throw new Error("unsupported value in General format: " + v);
  }
  function SSF_fix_hijri(date, o) {
    o[0] -= 581;
    var dow = date.getDay();
    if (date < 60)
      dow = (dow + 6) % 7;
    return dow;
  }
  function SSF_write_date(type, fmt, val2, ss0) {
    var o = "", ss = 0, tt = 0, y = val2.y, out, outl = 0;
    switch (type) {
      case 98:
        y = val2.y + 543;
      case 121:
        switch (fmt.length) {
          case 1:
          case 2:
            out = y % 100;
            outl = 2;
            break;
          default:
            out = y % 1e4;
            outl = 4;
            break;
        }
        break;
      case 109:
        switch (fmt.length) {
          case 1:
          case 2:
            out = val2.m;
            outl = fmt.length;
            break;
          case 3:
            return months[val2.m - 1][1];
          case 5:
            return months[val2.m - 1][0];
          default:
            return months[val2.m - 1][2];
        }
        break;
      case 100:
        switch (fmt.length) {
          case 1:
          case 2:
            out = val2.d;
            outl = fmt.length;
            break;
          case 3:
            return days[val2.q][0];
          default:
            return days[val2.q][1];
        }
        break;
      case 104:
        switch (fmt.length) {
          case 1:
          case 2:
            out = 1 + (val2.H + 11) % 12;
            outl = fmt.length;
            break;
          default:
            throw "bad hour format: " + fmt;
        }
        break;
      case 72:
        switch (fmt.length) {
          case 1:
          case 2:
            out = val2.H;
            outl = fmt.length;
            break;
          default:
            throw "bad hour format: " + fmt;
        }
        break;
      case 77:
        switch (fmt.length) {
          case 1:
          case 2:
            out = val2.M;
            outl = fmt.length;
            break;
          default:
            throw "bad minute format: " + fmt;
        }
        break;
      case 115:
        if (fmt != "s" && fmt != "ss" && fmt != ".0" && fmt != ".00" && fmt != ".000")
          throw "bad second format: " + fmt;
        if (val2.u === 0 && (fmt == "s" || fmt == "ss"))
          return pad0(val2.S, fmt.length);
        if (ss0 >= 2)
          tt = ss0 === 3 ? 1e3 : 100;
        else
          tt = ss0 === 1 ? 10 : 1;
        ss = Math.round(tt * (val2.S + val2.u));
        if (ss >= 60 * tt)
          ss = 0;
        if (fmt === "s")
          return ss === 0 ? "0" : "" + ss / tt;
        o = pad0(ss, 2 + ss0);
        if (fmt === "ss")
          return o.substr(0, 2);
        return "." + o.substr(2, fmt.length - 1);
      case 90:
        switch (fmt) {
          case "[h]":
          case "[hh]":
            out = val2.D * 24 + val2.H;
            break;
          case "[m]":
          case "[mm]":
            out = (val2.D * 24 + val2.H) * 60 + val2.M;
            break;
          case "[s]":
          case "[ss]":
            out = ((val2.D * 24 + val2.H) * 60 + val2.M) * 60 + (ss0 == 0 ? Math.round(val2.S + val2.u) : val2.S);
            break;
          default:
            throw "bad abstime format: " + fmt;
        }
        outl = fmt.length === 3 ? 1 : 2;
        break;
      case 101:
        out = y;
        outl = 1;
        break;
    }
    var outstr = outl > 0 ? pad0(out, outl) : "";
    return outstr;
  }
  function commaify(s) {
    var w = 3;
    if (s.length <= w)
      return s;
    var j = s.length % w, o = s.substr(0, j);
    for (; j != s.length; j += w)
      o += (o.length > 0 ? "," : "") + s.substr(j, w);
    return o;
  }
  var pct1 = /%/g;
  function write_num_pct(type, fmt, val2) {
    var sfmt = fmt.replace(pct1, ""), mul = fmt.length - sfmt.length;
    return write_num(type, sfmt, val2 * Math.pow(10, 2 * mul)) + fill("%", mul);
  }
  function write_num_cm(type, fmt, val2) {
    var idx = fmt.length - 1;
    while (fmt.charCodeAt(idx - 1) === 44)
      --idx;
    return write_num(type, fmt.substr(0, idx), val2 / Math.pow(10, 3 * (fmt.length - idx)));
  }
  function write_num_exp(fmt, val2) {
    var o;
    var idx = fmt.indexOf("E") - fmt.indexOf(".") - 1;
    if (fmt.match(/^#+0.0E\+0$/)) {
      if (val2 == 0)
        return "0.0E+0";
      else if (val2 < 0)
        return "-" + write_num_exp(fmt, -val2);
      var period = fmt.indexOf(".");
      if (period === -1)
        period = fmt.indexOf("E");
      var ee = Math.floor(Math.log(val2) * Math.LOG10E) % period;
      if (ee < 0)
        ee += period;
      o = (val2 / Math.pow(10, ee)).toPrecision(idx + 1 + (period + ee) % period);
      if (o.indexOf("e") === -1) {
        var fakee = Math.floor(Math.log(val2) * Math.LOG10E);
        if (o.indexOf(".") === -1)
          o = o.charAt(0) + "." + o.substr(1) + "E+" + (fakee - o.length + ee);
        else
          o += "E+" + (fakee - ee);
        while (o.substr(0, 2) === "0.") {
          o = o.charAt(0) + o.substr(2, period) + "." + o.substr(2 + period);
          o = o.replace(/^0+([1-9])/, "$1").replace(/^0+\./, "0.");
        }
        o = o.replace(/\+-/, "-");
      }
      o = o.replace(/^([+-]?)(\d*)\.(\d*)[Ee]/, function($$, $1, $2, $3) {
        return $1 + $2 + $3.substr(0, (period + ee) % period) + "." + $3.substr(ee) + "E";
      });
    } else
      o = val2.toExponential(idx);
    if (fmt.match(/E\+00$/) && o.match(/e[+-]\d$/))
      o = o.substr(0, o.length - 1) + "0" + o.charAt(o.length - 1);
    if (fmt.match(/E\-/) && o.match(/e\+/))
      o = o.replace(/e\+/, "e");
    return o.replace("e", "E");
  }
  var frac1 = /# (\?+)( ?)\/( ?)(\d+)/;
  function write_num_f1(r, aval, sign) {
    var den = parseInt(r[4], 10), rr = Math.round(aval * den), base = Math.floor(rr / den);
    var myn = rr - base * den, myd = den;
    return sign + (base === 0 ? "" : "" + base) + " " + (myn === 0 ? fill(" ", r[1].length + 1 + r[4].length) : pad_(myn, r[1].length) + r[2] + "/" + r[3] + pad0(myd, r[4].length));
  }
  function write_num_f2(r, aval, sign) {
    return sign + (aval === 0 ? "" : "" + aval) + fill(" ", r[1].length + 2 + r[4].length);
  }
  var dec1 = /^#*0*\.([0#]+)/;
  var closeparen = /\)[^)]*[0#]/;
  var phone = /\(###\) ###\\?-####/;
  function hashq(str) {
    var o = "", cc;
    for (var i = 0; i != str.length; ++i)
      switch (cc = str.charCodeAt(i)) {
        case 35:
          break;
        case 63:
          o += " ";
          break;
        case 48:
          o += "0";
          break;
        default:
          o += String.fromCharCode(cc);
      }
    return o;
  }
  function rnd(val2, d) {
    var dd = Math.pow(10, d);
    return "" + Math.round(val2 * dd) / dd;
  }
  function dec(val2, d) {
    var _frac = val2 - Math.floor(val2), dd = Math.pow(10, d);
    if (d < ("" + Math.round(_frac * dd)).length)
      return 0;
    return Math.round(_frac * dd);
  }
  function carry(val2, d) {
    if (d < ("" + Math.round((val2 - Math.floor(val2)) * Math.pow(10, d))).length) {
      return 1;
    }
    return 0;
  }
  function flr(val2) {
    if (val2 < 2147483647 && val2 > -2147483648)
      return "" + (val2 >= 0 ? val2 | 0 : val2 - 1 | 0);
    return "" + Math.floor(val2);
  }
  function write_num_flt(type, fmt, val2) {
    if (type.charCodeAt(0) === 40 && !fmt.match(closeparen)) {
      var ffmt = fmt.replace(/\( */, "").replace(/ \)/, "").replace(/\)/, "");
      if (val2 >= 0)
        return write_num_flt("n", ffmt, val2);
      return "(" + write_num_flt("n", ffmt, -val2) + ")";
    }
    if (fmt.charCodeAt(fmt.length - 1) === 44)
      return write_num_cm(type, fmt, val2);
    if (fmt.indexOf("%") !== -1)
      return write_num_pct(type, fmt, val2);
    if (fmt.indexOf("E") !== -1)
      return write_num_exp(fmt, val2);
    if (fmt.charCodeAt(0) === 36)
      return "$" + write_num_flt(type, fmt.substr(fmt.charAt(1) == " " ? 2 : 1), val2);
    var o;
    var r, ri, ff, aval = Math.abs(val2), sign = val2 < 0 ? "-" : "";
    if (fmt.match(/^00+$/))
      return sign + pad0r(aval, fmt.length);
    if (fmt.match(/^[#?]+$/)) {
      o = pad0r(val2, 0);
      if (o === "0")
        o = "";
      return o.length > fmt.length ? o : hashq(fmt.substr(0, fmt.length - o.length)) + o;
    }
    if (r = fmt.match(frac1))
      return write_num_f1(r, aval, sign);
    if (fmt.match(/^#+0+$/))
      return sign + pad0r(aval, fmt.length - fmt.indexOf("0"));
    if (r = fmt.match(dec1)) {
      o = rnd(val2, r[1].length).replace(/^([^\.]+)$/, "$1." + hashq(r[1])).replace(/\.$/, "." + hashq(r[1])).replace(/\.(\d*)$/, function($$, $1) {
        return "." + $1 + fill("0", hashq(
          /*::(*/
          r[1]
        ).length - $1.length);
      });
      return fmt.indexOf("0.") !== -1 ? o : o.replace(/^0\./, ".");
    }
    fmt = fmt.replace(/^#+([0.])/, "$1");
    if (r = fmt.match(/^(0*)\.(#*)$/)) {
      return sign + rnd(aval, r[2].length).replace(/\.(\d*[1-9])0*$/, ".$1").replace(/^(-?\d*)$/, "$1.").replace(/^0\./, r[1].length ? "0." : ".");
    }
    if (r = fmt.match(/^#{1,3},##0(\.?)$/))
      return sign + commaify(pad0r(aval, 0));
    if (r = fmt.match(/^#,##0\.([#0]*0)$/)) {
      return val2 < 0 ? "-" + write_num_flt(type, fmt, -val2) : commaify("" + (Math.floor(val2) + carry(val2, r[1].length))) + "." + pad0(dec(val2, r[1].length), r[1].length);
    }
    if (r = fmt.match(/^#,#*,#0/))
      return write_num_flt(type, fmt.replace(/^#,#*,/, ""), val2);
    if (r = fmt.match(/^([0#]+)(\\?-([0#]+))+$/)) {
      o = _strrev(write_num_flt(type, fmt.replace(/[\\-]/g, ""), val2));
      ri = 0;
      return _strrev(_strrev(fmt.replace(/\\/g, "")).replace(/[0#]/g, function(x2) {
        return ri < o.length ? o.charAt(ri++) : x2 === "0" ? "0" : "";
      }));
    }
    if (fmt.match(phone)) {
      o = write_num_flt(type, "##########", val2);
      return "(" + o.substr(0, 3) + ") " + o.substr(3, 3) + "-" + o.substr(6);
    }
    var oa = "";
    if (r = fmt.match(/^([#0?]+)( ?)\/( ?)([#0?]+)/)) {
      ri = Math.min(
        /*::String(*/
        r[4].length,
        7
      );
      ff = SSF_frac(aval, Math.pow(10, ri) - 1, false);
      o = "" + sign;
      oa = write_num(
        "n",
        /*::String(*/
        r[1],
        ff[1]
      );
      if (oa.charAt(oa.length - 1) == " ")
        oa = oa.substr(0, oa.length - 1) + "0";
      o += oa + /*::String(*/
      r[2] + "/" + /*::String(*/
      r[3];
      oa = rpad_(ff[2], ri);
      if (oa.length < r[4].length)
        oa = hashq(r[4].substr(r[4].length - oa.length)) + oa;
      o += oa;
      return o;
    }
    if (r = fmt.match(/^# ([#0?]+)( ?)\/( ?)([#0?]+)/)) {
      ri = Math.min(Math.max(r[1].length, r[4].length), 7);
      ff = SSF_frac(aval, Math.pow(10, ri) - 1, true);
      return sign + (ff[0] || (ff[1] ? "" : "0")) + " " + (ff[1] ? pad_(ff[1], ri) + r[2] + "/" + r[3] + rpad_(ff[2], ri) : fill(" ", 2 * ri + 1 + r[2].length + r[3].length));
    }
    if (r = fmt.match(/^[#0?]+$/)) {
      o = pad0r(val2, 0);
      if (fmt.length <= o.length)
        return o;
      return hashq(fmt.substr(0, fmt.length - o.length)) + o;
    }
    if (r = fmt.match(/^([#0?]+)\.([#0]+)$/)) {
      o = "" + val2.toFixed(Math.min(r[2].length, 10)).replace(/([^0])0+$/, "$1");
      ri = o.indexOf(".");
      var lres = fmt.indexOf(".") - ri, rres = fmt.length - o.length - lres;
      return hashq(fmt.substr(0, lres) + o + fmt.substr(fmt.length - rres));
    }
    if (r = fmt.match(/^00,000\.([#0]*0)$/)) {
      ri = dec(val2, r[1].length);
      return val2 < 0 ? "-" + write_num_flt(type, fmt, -val2) : commaify(flr(val2)).replace(/^\d,\d{3}$/, "0$&").replace(/^\d*$/, function($$) {
        return "00," + ($$.length < 3 ? pad0(0, 3 - $$.length) : "") + $$;
      }) + "." + pad0(ri, r[1].length);
    }
    switch (fmt) {
      case "###,##0.00":
        return write_num_flt(type, "#,##0.00", val2);
      case "###,###":
      case "##,###":
      case "#,###":
        var x = commaify(pad0r(aval, 0));
        return x !== "0" ? sign + x : "";
      case "###,###.00":
        return write_num_flt(type, "###,##0.00", val2).replace(/^0\./, ".");
      case "#,###.00":
        return write_num_flt(type, "#,##0.00", val2).replace(/^0\./, ".");
      default:
    }
    throw new Error("unsupported format |" + fmt + "|");
  }
  function write_num_cm2(type, fmt, val2) {
    var idx = fmt.length - 1;
    while (fmt.charCodeAt(idx - 1) === 44)
      --idx;
    return write_num(type, fmt.substr(0, idx), val2 / Math.pow(10, 3 * (fmt.length - idx)));
  }
  function write_num_pct2(type, fmt, val2) {
    var sfmt = fmt.replace(pct1, ""), mul = fmt.length - sfmt.length;
    return write_num(type, sfmt, val2 * Math.pow(10, 2 * mul)) + fill("%", mul);
  }
  function write_num_exp2(fmt, val2) {
    var o;
    var idx = fmt.indexOf("E") - fmt.indexOf(".") - 1;
    if (fmt.match(/^#+0.0E\+0$/)) {
      if (val2 == 0)
        return "0.0E+0";
      else if (val2 < 0)
        return "-" + write_num_exp2(fmt, -val2);
      var period = fmt.indexOf(".");
      if (period === -1)
        period = fmt.indexOf("E");
      var ee = Math.floor(Math.log(val2) * Math.LOG10E) % period;
      if (ee < 0)
        ee += period;
      o = (val2 / Math.pow(10, ee)).toPrecision(idx + 1 + (period + ee) % period);
      if (!o.match(/[Ee]/)) {
        var fakee = Math.floor(Math.log(val2) * Math.LOG10E);
        if (o.indexOf(".") === -1)
          o = o.charAt(0) + "." + o.substr(1) + "E+" + (fakee - o.length + ee);
        else
          o += "E+" + (fakee - ee);
        o = o.replace(/\+-/, "-");
      }
      o = o.replace(/^([+-]?)(\d*)\.(\d*)[Ee]/, function($$, $1, $2, $3) {
        return $1 + $2 + $3.substr(0, (period + ee) % period) + "." + $3.substr(ee) + "E";
      });
    } else
      o = val2.toExponential(idx);
    if (fmt.match(/E\+00$/) && o.match(/e[+-]\d$/))
      o = o.substr(0, o.length - 1) + "0" + o.charAt(o.length - 1);
    if (fmt.match(/E\-/) && o.match(/e\+/))
      o = o.replace(/e\+/, "e");
    return o.replace("e", "E");
  }
  function write_num_int(type, fmt, val2) {
    if (type.charCodeAt(0) === 40 && !fmt.match(closeparen)) {
      var ffmt = fmt.replace(/\( */, "").replace(/ \)/, "").replace(/\)/, "");
      if (val2 >= 0)
        return write_num_int("n", ffmt, val2);
      return "(" + write_num_int("n", ffmt, -val2) + ")";
    }
    if (fmt.charCodeAt(fmt.length - 1) === 44)
      return write_num_cm2(type, fmt, val2);
    if (fmt.indexOf("%") !== -1)
      return write_num_pct2(type, fmt, val2);
    if (fmt.indexOf("E") !== -1)
      return write_num_exp2(fmt, val2);
    if (fmt.charCodeAt(0) === 36)
      return "$" + write_num_int(type, fmt.substr(fmt.charAt(1) == " " ? 2 : 1), val2);
    var o;
    var r, ri, ff, aval = Math.abs(val2), sign = val2 < 0 ? "-" : "";
    if (fmt.match(/^00+$/))
      return sign + pad0(aval, fmt.length);
    if (fmt.match(/^[#?]+$/)) {
      o = "" + val2;
      if (val2 === 0)
        o = "";
      return o.length > fmt.length ? o : hashq(fmt.substr(0, fmt.length - o.length)) + o;
    }
    if (r = fmt.match(frac1))
      return write_num_f2(r, aval, sign);
    if (fmt.match(/^#+0+$/))
      return sign + pad0(aval, fmt.length - fmt.indexOf("0"));
    if (r = fmt.match(dec1)) {
      o = ("" + val2).replace(/^([^\.]+)$/, "$1." + hashq(r[1])).replace(/\.$/, "." + hashq(r[1]));
      o = o.replace(/\.(\d*)$/, function($$, $1) {
        return "." + $1 + fill("0", hashq(r[1]).length - $1.length);
      });
      return fmt.indexOf("0.") !== -1 ? o : o.replace(/^0\./, ".");
    }
    fmt = fmt.replace(/^#+([0.])/, "$1");
    if (r = fmt.match(/^(0*)\.(#*)$/)) {
      return sign + ("" + aval).replace(/\.(\d*[1-9])0*$/, ".$1").replace(/^(-?\d*)$/, "$1.").replace(/^0\./, r[1].length ? "0." : ".");
    }
    if (r = fmt.match(/^#{1,3},##0(\.?)$/))
      return sign + commaify("" + aval);
    if (r = fmt.match(/^#,##0\.([#0]*0)$/)) {
      return val2 < 0 ? "-" + write_num_int(type, fmt, -val2) : commaify("" + val2) + "." + fill("0", r[1].length);
    }
    if (r = fmt.match(/^#,#*,#0/))
      return write_num_int(type, fmt.replace(/^#,#*,/, ""), val2);
    if (r = fmt.match(/^([0#]+)(\\?-([0#]+))+$/)) {
      o = _strrev(write_num_int(type, fmt.replace(/[\\-]/g, ""), val2));
      ri = 0;
      return _strrev(_strrev(fmt.replace(/\\/g, "")).replace(/[0#]/g, function(x2) {
        return ri < o.length ? o.charAt(ri++) : x2 === "0" ? "0" : "";
      }));
    }
    if (fmt.match(phone)) {
      o = write_num_int(type, "##########", val2);
      return "(" + o.substr(0, 3) + ") " + o.substr(3, 3) + "-" + o.substr(6);
    }
    var oa = "";
    if (r = fmt.match(/^([#0?]+)( ?)\/( ?)([#0?]+)/)) {
      ri = Math.min(
        /*::String(*/
        r[4].length,
        7
      );
      ff = SSF_frac(aval, Math.pow(10, ri) - 1, false);
      o = "" + sign;
      oa = write_num(
        "n",
        /*::String(*/
        r[1],
        ff[1]
      );
      if (oa.charAt(oa.length - 1) == " ")
        oa = oa.substr(0, oa.length - 1) + "0";
      o += oa + /*::String(*/
      r[2] + "/" + /*::String(*/
      r[3];
      oa = rpad_(ff[2], ri);
      if (oa.length < r[4].length)
        oa = hashq(r[4].substr(r[4].length - oa.length)) + oa;
      o += oa;
      return o;
    }
    if (r = fmt.match(/^# ([#0?]+)( ?)\/( ?)([#0?]+)/)) {
      ri = Math.min(Math.max(r[1].length, r[4].length), 7);
      ff = SSF_frac(aval, Math.pow(10, ri) - 1, true);
      return sign + (ff[0] || (ff[1] ? "" : "0")) + " " + (ff[1] ? pad_(ff[1], ri) + r[2] + "/" + r[3] + rpad_(ff[2], ri) : fill(" ", 2 * ri + 1 + r[2].length + r[3].length));
    }
    if (r = fmt.match(/^[#0?]+$/)) {
      o = "" + val2;
      if (fmt.length <= o.length)
        return o;
      return hashq(fmt.substr(0, fmt.length - o.length)) + o;
    }
    if (r = fmt.match(/^([#0]+)\.([#0]+)$/)) {
      o = "" + val2.toFixed(Math.min(r[2].length, 10)).replace(/([^0])0+$/, "$1");
      ri = o.indexOf(".");
      var lres = fmt.indexOf(".") - ri, rres = fmt.length - o.length - lres;
      return hashq(fmt.substr(0, lres) + o + fmt.substr(fmt.length - rres));
    }
    if (r = fmt.match(/^00,000\.([#0]*0)$/)) {
      return val2 < 0 ? "-" + write_num_int(type, fmt, -val2) : commaify("" + val2).replace(/^\d,\d{3}$/, "0$&").replace(/^\d*$/, function($$) {
        return "00," + ($$.length < 3 ? pad0(0, 3 - $$.length) : "") + $$;
      }) + "." + pad0(0, r[1].length);
    }
    switch (fmt) {
      case "###,###":
      case "##,###":
      case "#,###":
        var x = commaify("" + aval);
        return x !== "0" ? sign + x : "";
      default:
        if (fmt.match(/\.[0#?]*$/))
          return write_num_int(type, fmt.slice(0, fmt.lastIndexOf(".")), val2) + hashq(fmt.slice(fmt.lastIndexOf(".")));
    }
    throw new Error("unsupported format |" + fmt + "|");
  }
  function write_num(type, fmt, val2) {
    return (val2 | 0) === val2 ? write_num_int(type, fmt, val2) : write_num_flt(type, fmt, val2);
  }
  function SSF_split_fmt(fmt) {
    var out = [];
    var in_str = false;
    for (var i = 0, j = 0; i < fmt.length; ++i)
      switch (
        /*cc=*/
        fmt.charCodeAt(i)
      ) {
        case 34:
          in_str = !in_str;
          break;
        case 95:
        case 42:
        case 92:
          ++i;
          break;
        case 59:
          out[out.length] = fmt.substr(j, i - j);
          j = i + 1;
      }
    out[out.length] = fmt.substr(j);
    if (in_str === true)
      throw new Error("Format |" + fmt + "| unterminated string ");
    return out;
  }
  var SSF_abstime = /\[[HhMmSs\u0E0A\u0E19\u0E17]*\]/;
  function fmt_is_date(fmt) {
    var i = 0, c = "", o = "";
    while (i < fmt.length) {
      switch (c = fmt.charAt(i)) {
        case "G":
          if (SSF_isgeneral(fmt, i))
            i += 6;
          i++;
          break;
        case '"':
          for (
            ;
            /*cc=*/
            fmt.charCodeAt(++i) !== 34 && i < fmt.length;
          ) {
          }
          ++i;
          break;
        case "\\":
          i += 2;
          break;
        case "_":
          i += 2;
          break;
        case "@":
          ++i;
          break;
        case "B":
        case "b":
          if (fmt.charAt(i + 1) === "1" || fmt.charAt(i + 1) === "2")
            return true;
        case "M":
        case "D":
        case "Y":
        case "H":
        case "S":
        case "E":
        case "m":
        case "d":
        case "y":
        case "h":
        case "s":
        case "e":
        case "g":
          return true;
        case "A":
        case "a":
        case "\u4E0A":
          if (fmt.substr(i, 3).toUpperCase() === "A/P")
            return true;
          if (fmt.substr(i, 5).toUpperCase() === "AM/PM")
            return true;
          if (fmt.substr(i, 5).toUpperCase() === "\u4E0A\u5348/\u4E0B\u5348")
            return true;
          ++i;
          break;
        case "[":
          o = c;
          while (fmt.charAt(i++) !== "]" && i < fmt.length)
            o += fmt.charAt(i);
          if (o.match(SSF_abstime))
            return true;
          break;
        case ".":
        case "0":
        case "#":
          while (i < fmt.length && ("0#?.,E+-%".indexOf(c = fmt.charAt(++i)) > -1 || c == "\\" && fmt.charAt(i + 1) == "-" && "0#".indexOf(fmt.charAt(i + 2)) > -1)) {
          }
          break;
        case "?":
          while (fmt.charAt(++i) === c) {
          }
          break;
        case "*":
          ++i;
          if (fmt.charAt(i) == " " || fmt.charAt(i) == "*")
            ++i;
          break;
        case "(":
        case ")":
          ++i;
          break;
        case "1":
        case "2":
        case "3":
        case "4":
        case "5":
        case "6":
        case "7":
        case "8":
        case "9":
          while (i < fmt.length && "0123456789".indexOf(fmt.charAt(++i)) > -1) {
          }
          break;
        case " ":
          ++i;
          break;
        default:
          ++i;
          break;
      }
    }
    return false;
  }
  function eval_fmt(fmt, v, opts, flen) {
    var out = [], o = "", i = 0, c = "", lst = "t", dt, j, cc;
    var hr = "H";
    while (i < fmt.length) {
      switch (c = fmt.charAt(i)) {
        case "G":
          if (!SSF_isgeneral(fmt, i))
            throw new Error("unrecognized character " + c + " in " + fmt);
          out[out.length] = { t: "G", v: "General" };
          i += 7;
          break;
        case '"':
          for (o = ""; (cc = fmt.charCodeAt(++i)) !== 34 && i < fmt.length; )
            o += String.fromCharCode(cc);
          out[out.length] = { t: "t", v: o };
          ++i;
          break;
        case "\\":
          var w = fmt.charAt(++i), t = w === "(" || w === ")" ? w : "t";
          out[out.length] = { t, v: w };
          ++i;
          break;
        case "_":
          out[out.length] = { t: "t", v: " " };
          i += 2;
          break;
        case "@":
          out[out.length] = { t: "T", v };
          ++i;
          break;
        case "B":
        case "b":
          if (fmt.charAt(i + 1) === "1" || fmt.charAt(i + 1) === "2") {
            if (dt == null) {
              dt = SSF_parse_date_code(v, opts, fmt.charAt(i + 1) === "2");
              if (dt == null)
                return "";
            }
            out[out.length] = { t: "X", v: fmt.substr(i, 2) };
            lst = c;
            i += 2;
            break;
          }
        case "M":
        case "D":
        case "Y":
        case "H":
        case "S":
        case "E":
          c = c.toLowerCase();
        case "m":
        case "d":
        case "y":
        case "h":
        case "s":
        case "e":
        case "g":
          if (v < 0)
            return "";
          if (dt == null) {
            dt = SSF_parse_date_code(v, opts);
            if (dt == null)
              return "";
          }
          o = c;
          while (++i < fmt.length && fmt.charAt(i).toLowerCase() === c)
            o += c;
          if (c === "m" && lst.toLowerCase() === "h")
            c = "M";
          if (c === "h")
            c = hr;
          out[out.length] = { t: c, v: o };
          lst = c;
          break;
        case "A":
        case "a":
        case "\u4E0A":
          var q = { t: c, v: c };
          if (dt == null)
            dt = SSF_parse_date_code(v, opts);
          if (fmt.substr(i, 3).toUpperCase() === "A/P") {
            if (dt != null)
              q.v = dt.H >= 12 ? fmt.charAt(i + 2) : c;
            q.t = "T";
            hr = "h";
            i += 3;
          } else if (fmt.substr(i, 5).toUpperCase() === "AM/PM") {
            if (dt != null)
              q.v = dt.H >= 12 ? "PM" : "AM";
            q.t = "T";
            i += 5;
            hr = "h";
          } else if (fmt.substr(i, 5).toUpperCase() === "\u4E0A\u5348/\u4E0B\u5348") {
            if (dt != null)
              q.v = dt.H >= 12 ? "\u4E0B\u5348" : "\u4E0A\u5348";
            q.t = "T";
            i += 5;
            hr = "h";
          } else {
            q.t = "t";
            ++i;
          }
          if (dt == null && q.t === "T")
            return "";
          out[out.length] = q;
          lst = c;
          break;
        case "[":
          o = c;
          while (fmt.charAt(i++) !== "]" && i < fmt.length)
            o += fmt.charAt(i);
          if (o.slice(-1) !== "]")
            throw 'unterminated "[" block: |' + o + "|";
          if (o.match(SSF_abstime)) {
            if (dt == null) {
              dt = SSF_parse_date_code(v, opts);
              if (dt == null)
                return "";
            }
            out[out.length] = { t: "Z", v: o.toLowerCase() };
            lst = o.charAt(1);
          } else if (o.indexOf("$") > -1) {
            o = (o.match(/\$([^-\[\]]*)/) || [])[1] || "$";
            if (!fmt_is_date(fmt))
              out[out.length] = { t: "t", v: o };
          }
          break;
        case ".":
          if (dt != null) {
            o = c;
            while (++i < fmt.length && (c = fmt.charAt(i)) === "0")
              o += c;
            out[out.length] = { t: "s", v: o };
            break;
          }
        case "0":
        case "#":
          o = c;
          while (++i < fmt.length && "0#?.,E+-%".indexOf(c = fmt.charAt(i)) > -1)
            o += c;
          out[out.length] = { t: "n", v: o };
          break;
        case "?":
          o = c;
          while (fmt.charAt(++i) === c)
            o += c;
          out[out.length] = { t: c, v: o };
          lst = c;
          break;
        case "*":
          ++i;
          if (fmt.charAt(i) == " " || fmt.charAt(i) == "*")
            ++i;
          break;
        case "(":
        case ")":
          out[out.length] = { t: flen === 1 ? "t" : c, v: c };
          ++i;
          break;
        case "1":
        case "2":
        case "3":
        case "4":
        case "5":
        case "6":
        case "7":
        case "8":
        case "9":
          o = c;
          while (i < fmt.length && "0123456789".indexOf(fmt.charAt(++i)) > -1)
            o += fmt.charAt(i);
          out[out.length] = { t: "D", v: o };
          break;
        case " ":
          out[out.length] = { t: c, v: c };
          ++i;
          break;
        case "$":
          out[out.length] = { t: "t", v: "$" };
          ++i;
          break;
        default:
          if (",$-+/():!^&'~{}<>=\u20ACacfijklopqrtuvwxzP".indexOf(c) === -1)
            throw new Error("unrecognized character " + c + " in " + fmt);
          out[out.length] = { t: "t", v: c };
          ++i;
          break;
      }
    }
    var bt = 0, ss0 = 0, ssm;
    for (i = out.length - 1, lst = "t"; i >= 0; --i) {
      switch (out[i].t) {
        case "h":
        case "H":
          out[i].t = hr;
          lst = "h";
          if (bt < 1)
            bt = 1;
          break;
        case "s":
          if (ssm = out[i].v.match(/\.0+$/)) {
            ss0 = Math.max(ss0, ssm[0].length - 1);
            bt = 4;
          }
          if (bt < 3)
            bt = 3;
        case "d":
        case "y":
        case "e":
          lst = out[i].t;
          break;
        case "M":
          lst = out[i].t;
          if (bt < 2)
            bt = 2;
          break;
        case "m":
          if (lst === "s") {
            out[i].t = "M";
            if (bt < 2)
              bt = 2;
          }
          break;
        case "X":
          break;
        case "Z":
          if (bt < 1 && out[i].v.match(/[Hh]/))
            bt = 1;
          if (bt < 2 && out[i].v.match(/[Mm]/))
            bt = 2;
          if (bt < 3 && out[i].v.match(/[Ss]/))
            bt = 3;
      }
    }
    var _dt;
    switch (bt) {
      case 0:
        break;
      case 1:
      case 2:
      case 3:
        if (dt.u >= 0.5) {
          dt.u = 0;
          ++dt.S;
        }
        if (dt.S >= 60) {
          dt.S = 0;
          ++dt.M;
        }
        if (dt.M >= 60) {
          dt.M = 0;
          ++dt.H;
        }
        if (dt.H >= 24) {
          dt.H = 0;
          ++dt.D;
          _dt = SSF_parse_date_code(dt.D);
          _dt.u = dt.u;
          _dt.S = dt.S;
          _dt.M = dt.M;
          _dt.H = dt.H;
          dt = _dt;
        }
        break;
      case 4:
        switch (ss0) {
          case 1:
            dt.u = Math.round(dt.u * 10) / 10;
            break;
          case 2:
            dt.u = Math.round(dt.u * 100) / 100;
            break;
          case 3:
            dt.u = Math.round(dt.u * 1e3) / 1e3;
            break;
        }
        if (dt.u >= 1) {
          dt.u = 0;
          ++dt.S;
        }
        if (dt.S >= 60) {
          dt.S = 0;
          ++dt.M;
        }
        if (dt.M >= 60) {
          dt.M = 0;
          ++dt.H;
        }
        if (dt.H >= 24) {
          dt.H = 0;
          ++dt.D;
          _dt = SSF_parse_date_code(dt.D);
          _dt.u = dt.u;
          _dt.S = dt.S;
          _dt.M = dt.M;
          _dt.H = dt.H;
          dt = _dt;
        }
        break;
    }
    var nstr = "", jj;
    for (i = 0; i < out.length; ++i) {
      switch (out[i].t) {
        case "t":
        case "T":
        case " ":
        case "D":
          break;
        case "X":
          out[i].v = "";
          out[i].t = ";";
          break;
        case "d":
        case "m":
        case "y":
        case "h":
        case "H":
        case "M":
        case "s":
        case "e":
        case "b":
        case "Z":
          out[i].v = SSF_write_date(out[i].t.charCodeAt(0), out[i].v, dt, ss0);
          out[i].t = "t";
          break;
        case "n":
        case "?":
          jj = i + 1;
          while (out[jj] != null && ((c = out[jj].t) === "?" || c === "D" || (c === " " || c === "t") && out[jj + 1] != null && (out[jj + 1].t === "?" || out[jj + 1].t === "t" && out[jj + 1].v === "/") || out[i].t === "(" && (c === " " || c === "n" || c === ")") || c === "t" && (out[jj].v === "/" || out[jj].v === " " && out[jj + 1] != null && out[jj + 1].t == "?"))) {
            out[i].v += out[jj].v;
            out[jj] = { v: "", t: ";" };
            ++jj;
          }
          nstr += out[i].v;
          i = jj - 1;
          break;
        case "G":
          out[i].t = "t";
          out[i].v = SSF_general(v, opts);
          break;
      }
    }
    var vv = "", myv, ostr;
    if (nstr.length > 0) {
      if (nstr.charCodeAt(0) == 40) {
        myv = v < 0 && nstr.charCodeAt(0) === 45 ? -v : v;
        ostr = write_num("n", nstr, myv);
      } else {
        myv = v < 0 && flen > 1 ? -v : v;
        ostr = write_num("n", nstr, myv);
        if (myv < 0 && out[0] && out[0].t == "t") {
          ostr = ostr.substr(1);
          out[0].v = "-" + out[0].v;
        }
      }
      jj = ostr.length - 1;
      var decpt = out.length;
      for (i = 0; i < out.length; ++i)
        if (out[i] != null && out[i].t != "t" && out[i].v.indexOf(".") > -1) {
          decpt = i;
          break;
        }
      var lasti = out.length;
      if (decpt === out.length && ostr.indexOf("E") === -1) {
        for (i = out.length - 1; i >= 0; --i) {
          if (out[i] == null || "n?".indexOf(out[i].t) === -1)
            continue;
          if (jj >= out[i].v.length - 1) {
            jj -= out[i].v.length;
            out[i].v = ostr.substr(jj + 1, out[i].v.length);
          } else if (jj < 0)
            out[i].v = "";
          else {
            out[i].v = ostr.substr(0, jj + 1);
            jj = -1;
          }
          out[i].t = "t";
          lasti = i;
        }
        if (jj >= 0 && lasti < out.length)
          out[lasti].v = ostr.substr(0, jj + 1) + out[lasti].v;
      } else if (decpt !== out.length && ostr.indexOf("E") === -1) {
        jj = ostr.indexOf(".") - 1;
        for (i = decpt; i >= 0; --i) {
          if (out[i] == null || "n?".indexOf(out[i].t) === -1)
            continue;
          j = out[i].v.indexOf(".") > -1 && i === decpt ? out[i].v.indexOf(".") - 1 : out[i].v.length - 1;
          vv = out[i].v.substr(j + 1);
          for (; j >= 0; --j) {
            if (jj >= 0 && (out[i].v.charAt(j) === "0" || out[i].v.charAt(j) === "#"))
              vv = ostr.charAt(jj--) + vv;
          }
          out[i].v = vv;
          out[i].t = "t";
          lasti = i;
        }
        if (jj >= 0 && lasti < out.length)
          out[lasti].v = ostr.substr(0, jj + 1) + out[lasti].v;
        jj = ostr.indexOf(".") + 1;
        for (i = decpt; i < out.length; ++i) {
          if (out[i] == null || "n?(".indexOf(out[i].t) === -1 && i !== decpt)
            continue;
          j = out[i].v.indexOf(".") > -1 && i === decpt ? out[i].v.indexOf(".") + 1 : 0;
          vv = out[i].v.substr(0, j);
          for (; j < out[i].v.length; ++j) {
            if (jj < ostr.length)
              vv += ostr.charAt(jj++);
          }
          out[i].v = vv;
          out[i].t = "t";
          lasti = i;
        }
      }
    }
    for (i = 0; i < out.length; ++i)
      if (out[i] != null && "n?".indexOf(out[i].t) > -1) {
        myv = flen > 1 && v < 0 && i > 0 && out[i - 1].v === "-" ? -v : v;
        out[i].v = write_num(out[i].t, out[i].v, myv);
        out[i].t = "t";
      }
    var retval = "";
    for (i = 0; i !== out.length; ++i)
      if (out[i] != null)
        retval += out[i].v;
    return retval;
  }
  var cfregex2 = /\[(=|>[=]?|<[>=]?)(-?\d+(?:\.\d*)?)\]/;
  function chkcond(v, rr) {
    if (rr == null)
      return false;
    var thresh = parseFloat(rr[2]);
    switch (rr[1]) {
      case "=":
        if (v == thresh)
          return true;
        break;
      case ">":
        if (v > thresh)
          return true;
        break;
      case "<":
        if (v < thresh)
          return true;
        break;
      case "<>":
        if (v != thresh)
          return true;
        break;
      case ">=":
        if (v >= thresh)
          return true;
        break;
      case "<=":
        if (v <= thresh)
          return true;
        break;
    }
    return false;
  }
  function choose_fmt(f, v) {
    var fmt = SSF_split_fmt(f);
    var l = fmt.length, lat = fmt[l - 1].indexOf("@");
    if (l < 4 && lat > -1)
      --l;
    if (fmt.length > 4)
      throw new Error("cannot find right format for |" + fmt.join("|") + "|");
    if (typeof v !== "number")
      return [4, fmt.length === 4 || lat > -1 ? fmt[fmt.length - 1] : "@"];
    if (typeof v === "number" && !isFinite(v))
      v = 0;
    switch (fmt.length) {
      case 1:
        fmt = lat > -1 ? ["General", "General", "General", fmt[0]] : [fmt[0], fmt[0], fmt[0], "@"];
        break;
      case 2:
        fmt = lat > -1 ? [fmt[0], fmt[0], fmt[0], fmt[1]] : [fmt[0], fmt[1], fmt[0], "@"];
        break;
      case 3:
        fmt = lat > -1 ? [fmt[0], fmt[1], fmt[0], fmt[2]] : [fmt[0], fmt[1], fmt[2], "@"];
        break;
      case 4:
        break;
    }
    var ff = v > 0 ? fmt[0] : v < 0 ? fmt[1] : fmt[2];
    if (fmt[0].indexOf("[") === -1 && fmt[1].indexOf("[") === -1)
      return [l, ff];
    if (fmt[0].match(/\[[=<>]/) != null || fmt[1].match(/\[[=<>]/) != null) {
      var m1 = fmt[0].match(cfregex2);
      var m2 = fmt[1].match(cfregex2);
      return chkcond(v, m1) ? [l, fmt[0]] : chkcond(v, m2) ? [l, fmt[1]] : [l, fmt[m1 != null && m2 != null ? 2 : 1]];
    }
    return [l, ff];
  }
  function SSF_format(fmt, v, o) {
    if (o == null)
      o = {};
    var sfmt = "";
    switch (typeof fmt) {
      case "string":
        if (fmt == "m/d/yy" && o.dateNF)
          sfmt = o.dateNF;
        else
          sfmt = fmt;
        break;
      case "number":
        if (fmt == 14 && o.dateNF)
          sfmt = o.dateNF;
        else
          sfmt = (o.table != null ? o.table : table_fmt)[fmt];
        if (sfmt == null)
          sfmt = o.table && o.table[SSF_default_map[fmt]] || table_fmt[SSF_default_map[fmt]];
        if (sfmt == null)
          sfmt = SSF_default_str[fmt] || "General";
        break;
    }
    if (SSF_isgeneral(sfmt, 0))
      return SSF_general(v, o);
    if (v instanceof Date)
      v = datenum(v, o.date1904);
    var f = choose_fmt(sfmt, v);
    if (SSF_isgeneral(f[1]))
      return SSF_general(v, o);
    if (v === true)
      v = "TRUE";
    else if (v === false)
      v = "FALSE";
    else if (v === "" || v == null)
      return "";
    else if (isNaN(v) && f[1].indexOf("0") > -1)
      return "#NUM!";
    else if (!isFinite(v) && f[1].indexOf("0") > -1)
      return "#DIV/0!";
    return eval_fmt(f[1], v, o, f[0]);
  }
  function SSF_load(fmt, idx) {
    if (typeof idx != "number") {
      idx = +idx || -1;
      for (var i = 0; i < 392; ++i) {
        if (table_fmt[i] == void 0) {
          if (idx < 0)
            idx = i;
          continue;
        }
        if (table_fmt[i] == fmt) {
          idx = i;
          break;
        }
      }
      if (idx < 0)
        idx = 391;
    }
    table_fmt[idx] = fmt;
    return idx;
  }
  function SSF_load_table(tbl) {
    for (var i = 0; i != 392; ++i)
      if (tbl[i] !== void 0)
        SSF_load(tbl[i], i);
  }
  function make_ssf() {
    table_fmt = SSF_init_table();
  }
  var bad_formats = {
    "d.m": "d\\.m"
    // Issue #2571 Google Sheets writes invalid format 'd.m', correct format is 'd"."m' or 'd\\.m'
  };
  function SSF__load(fmt, idx) {
    return SSF_load(bad_formats[fmt] || fmt, idx);
  }
  var CRC32 = /* @__PURE__ */ function() {
    var CRC322 = {};
    CRC322.version = "1.2.0";
    function signed_crc_table() {
      var c = 0, table = new Array(256);
      for (var n = 0; n != 256; ++n) {
        c = n;
        c = c & 1 ? -306674912 ^ c >>> 1 : c >>> 1;
        c = c & 1 ? -306674912 ^ c >>> 1 : c >>> 1;
        c = c & 1 ? -306674912 ^ c >>> 1 : c >>> 1;
        c = c & 1 ? -306674912 ^ c >>> 1 : c >>> 1;
        c = c & 1 ? -306674912 ^ c >>> 1 : c >>> 1;
        c = c & 1 ? -306674912 ^ c >>> 1 : c >>> 1;
        c = c & 1 ? -306674912 ^ c >>> 1 : c >>> 1;
        c = c & 1 ? -306674912 ^ c >>> 1 : c >>> 1;
        table[n] = c;
      }
      return typeof Int32Array !== "undefined" ? new Int32Array(table) : table;
    }
    var T0 = signed_crc_table();
    function slice_by_16_tables(T) {
      var c = 0, v = 0, n = 0, table = typeof Int32Array !== "undefined" ? new Int32Array(4096) : new Array(4096);
      for (n = 0; n != 256; ++n)
        table[n] = T[n];
      for (n = 0; n != 256; ++n) {
        v = T[n];
        for (c = 256 + n; c < 4096; c += 256)
          v = table[c] = v >>> 8 ^ T[v & 255];
      }
      var out = [];
      for (n = 1; n != 16; ++n)
        out[n - 1] = typeof Int32Array !== "undefined" && typeof table.subarray == "function" ? table.subarray(n * 256, n * 256 + 256) : table.slice(n * 256, n * 256 + 256);
      return out;
    }
    var TT = slice_by_16_tables(T0);
    var T1 = TT[0], T2 = TT[1], T3 = TT[2], T4 = TT[3], T5 = TT[4];
    var T6 = TT[5], T7 = TT[6], T8 = TT[7], T9 = TT[8], Ta = TT[9];
    var Tb = TT[10], Tc = TT[11], Td = TT[12], Te = TT[13], Tf = TT[14];
    function crc32_bstr(bstr, seed) {
      var C = seed ^ -1;
      for (var i = 0, L = bstr.length; i < L; )
        C = C >>> 8 ^ T0[(C ^ bstr.charCodeAt(i++)) & 255];
      return ~C;
    }
    function crc32_buf(B, seed) {
      var C = seed ^ -1, L = B.length - 15, i = 0;
      for (; i < L; )
        C = Tf[B[i++] ^ C & 255] ^ Te[B[i++] ^ C >> 8 & 255] ^ Td[B[i++] ^ C >> 16 & 255] ^ Tc[B[i++] ^ C >>> 24] ^ Tb[B[i++]] ^ Ta[B[i++]] ^ T9[B[i++]] ^ T8[B[i++]] ^ T7[B[i++]] ^ T6[B[i++]] ^ T5[B[i++]] ^ T4[B[i++]] ^ T3[B[i++]] ^ T2[B[i++]] ^ T1[B[i++]] ^ T0[B[i++]];
      L += 15;
      while (i < L)
        C = C >>> 8 ^ T0[(C ^ B[i++]) & 255];
      return ~C;
    }
    function crc32_str(str, seed) {
      var C = seed ^ -1;
      for (var i = 0, L = str.length, c = 0, d = 0; i < L; ) {
        c = str.charCodeAt(i++);
        if (c < 128) {
          C = C >>> 8 ^ T0[(C ^ c) & 255];
        } else if (c < 2048) {
          C = C >>> 8 ^ T0[(C ^ (192 | c >> 6 & 31)) & 255];
          C = C >>> 8 ^ T0[(C ^ (128 | c & 63)) & 255];
        } else if (c >= 55296 && c < 57344) {
          c = (c & 1023) + 64;
          d = str.charCodeAt(i++) & 1023;
          C = C >>> 8 ^ T0[(C ^ (240 | c >> 8 & 7)) & 255];
          C = C >>> 8 ^ T0[(C ^ (128 | c >> 2 & 63)) & 255];
          C = C >>> 8 ^ T0[(C ^ (128 | d >> 6 & 15 | (c & 3) << 4)) & 255];
          C = C >>> 8 ^ T0[(C ^ (128 | d & 63)) & 255];
        } else {
          C = C >>> 8 ^ T0[(C ^ (224 | c >> 12 & 15)) & 255];
          C = C >>> 8 ^ T0[(C ^ (128 | c >> 6 & 63)) & 255];
          C = C >>> 8 ^ T0[(C ^ (128 | c & 63)) & 255];
        }
      }
      return ~C;
    }
    CRC322.table = T0;
    CRC322.bstr = crc32_bstr;
    CRC322.buf = crc32_buf;
    CRC322.str = crc32_str;
    return CRC322;
  }();
  var CFB = /* @__PURE__ */ function _CFB() {
    var exports = (
      /*::(*/
      {}
    );
    exports.version = "1.2.2";
    function namecmp(l, r) {
      var L = l.split("/"), R = r.split("/");
      for (var i2 = 0, c = 0, Z = Math.min(L.length, R.length); i2 < Z; ++i2) {
        if (c = L[i2].length - R[i2].length)
          return c;
        if (L[i2] != R[i2])
          return L[i2] < R[i2] ? -1 : 1;
      }
      return L.length - R.length;
    }
    function dirname(p) {
      if (p.charAt(p.length - 1) == "/")
        return p.slice(0, -1).indexOf("/") === -1 ? p : dirname(p.slice(0, -1));
      var c = p.lastIndexOf("/");
      return c === -1 ? p : p.slice(0, c + 1);
    }
    function filename(p) {
      if (p.charAt(p.length - 1) == "/")
        return filename(p.slice(0, -1));
      var c = p.lastIndexOf("/");
      return c === -1 ? p : p.slice(c + 1);
    }
    function write_dos_date(buf, date) {
      if (typeof date === "string")
        date = new Date(date);
      var hms = date.getHours();
      hms = hms << 6 | date.getMinutes();
      hms = hms << 5 | date.getSeconds() >>> 1;
      buf.write_shift(2, hms);
      var ymd = date.getFullYear() - 1980;
      ymd = ymd << 4 | date.getMonth() + 1;
      ymd = ymd << 5 | date.getDate();
      buf.write_shift(2, ymd);
    }
    function parse_dos_date(buf) {
      var hms = buf.read_shift(2) & 65535;
      var ymd = buf.read_shift(2) & 65535;
      var val2 = /* @__PURE__ */ new Date();
      var d = ymd & 31;
      ymd >>>= 5;
      var m = ymd & 15;
      ymd >>>= 4;
      val2.setMilliseconds(0);
      val2.setFullYear(ymd + 1980);
      val2.setMonth(m - 1);
      val2.setDate(d);
      var S = hms & 31;
      hms >>>= 5;
      var M = hms & 63;
      hms >>>= 6;
      val2.setHours(hms);
      val2.setMinutes(M);
      val2.setSeconds(S << 1);
      return val2;
    }
    function parse_extra_field(blob) {
      prep_blob(blob, 0);
      var o = (
        /*::(*/
        {}
      );
      var flags = 0;
      while (blob.l <= blob.length - 4) {
        var type = blob.read_shift(2);
        var sz = blob.read_shift(2), tgt = blob.l + sz;
        var p = {};
        switch (type) {
          case 21589:
            {
              flags = blob.read_shift(1);
              if (flags & 1)
                p.mtime = blob.read_shift(4);
              if (sz > 5) {
                if (flags & 2)
                  p.atime = blob.read_shift(4);
                if (flags & 4)
                  p.ctime = blob.read_shift(4);
              }
              if (p.mtime)
                p.mt = new Date(p.mtime * 1e3);
            }
            break;
          case 1:
            {
              var sz1 = blob.read_shift(4), sz2 = blob.read_shift(4);
              p.usz = sz2 * Math.pow(2, 32) + sz1;
              sz1 = blob.read_shift(4);
              sz2 = blob.read_shift(4);
              p.csz = sz2 * Math.pow(2, 32) + sz1;
            }
            break;
        }
        blob.l = tgt;
        o[type] = p;
      }
      return o;
    }
    var fs;
    function get_fs() {
      return fs || (fs = _fs);
    }
    function parse(file, options) {
      if (file[0] == 80 && file[1] == 75)
        return parse_zip(file, options);
      if ((file[0] | 32) == 109 && (file[1] | 32) == 105)
        return parse_mad(file, options);
      if (file.length < 512)
        throw new Error("CFB file size " + file.length + " < 512");
      var mver = 3;
      var ssz = 512;
      var nmfs = 0;
      var difat_sec_cnt = 0;
      var dir_start = 0;
      var minifat_start = 0;
      var difat_start = 0;
      var fat_addrs = [];
      var blob = (
        /*::(*/
        file.slice(0, 512)
      );
      prep_blob(blob, 0);
      var mv = check_get_mver(blob);
      mver = mv[0];
      switch (mver) {
        case 3:
          ssz = 512;
          break;
        case 4:
          ssz = 4096;
          break;
        case 0:
          if (mv[1] == 0)
            return parse_zip(file, options);
        default:
          throw new Error("Major Version: Expected 3 or 4 saw " + mver);
      }
      if (ssz !== 512) {
        blob = /*::(*/
        file.slice(0, ssz);
        prep_blob(
          blob,
          28
          /* blob.l */
        );
      }
      var header = file.slice(0, ssz);
      check_shifts(blob, mver);
      var dir_cnt = blob.read_shift(4, "i");
      if (mver === 3 && dir_cnt !== 0)
        throw new Error("# Directory Sectors: Expected 0 saw " + dir_cnt);
      blob.l += 4;
      dir_start = blob.read_shift(4, "i");
      blob.l += 4;
      blob.chk("00100000", "Mini Stream Cutoff Size: ");
      minifat_start = blob.read_shift(4, "i");
      nmfs = blob.read_shift(4, "i");
      difat_start = blob.read_shift(4, "i");
      difat_sec_cnt = blob.read_shift(4, "i");
      for (var q2 = -1, j = 0; j < 109; ++j) {
        q2 = blob.read_shift(4, "i");
        if (q2 < 0)
          break;
        fat_addrs[j] = q2;
      }
      var sectors = sectorify(file, ssz);
      sleuth_fat(difat_start, difat_sec_cnt, sectors, ssz, fat_addrs);
      var sector_list = make_sector_list(sectors, dir_start, fat_addrs, ssz);
      if (dir_start < sector_list.length)
        sector_list[dir_start].name = "!Directory";
      if (nmfs > 0 && minifat_start !== ENDOFCHAIN)
        sector_list[minifat_start].name = "!MiniFAT";
      sector_list[fat_addrs[0]].name = "!FAT";
      sector_list.fat_addrs = fat_addrs;
      sector_list.ssz = ssz;
      var files = {}, Paths = [], FileIndex = [], FullPaths = [];
      read_directory(dir_start, sector_list, sectors, Paths, nmfs, files, FileIndex, minifat_start);
      build_full_paths(FileIndex, FullPaths, Paths);
      Paths.shift();
      var o = {
        FileIndex,
        FullPaths
      };
      if (options && options.raw)
        o.raw = { header, sectors };
      return o;
    }
    function check_get_mver(blob) {
      if (blob[blob.l] == 80 && blob[blob.l + 1] == 75)
        return [0, 0];
      blob.chk(HEADER_SIGNATURE, "Header Signature: ");
      blob.l += 16;
      var mver = blob.read_shift(2, "u");
      return [blob.read_shift(2, "u"), mver];
    }
    function check_shifts(blob, mver) {
      var shift = 9;
      blob.l += 2;
      switch (shift = blob.read_shift(2)) {
        case 9:
          if (mver != 3)
            throw new Error("Sector Shift: Expected 9 saw " + shift);
          break;
        case 12:
          if (mver != 4)
            throw new Error("Sector Shift: Expected 12 saw " + shift);
          break;
        default:
          throw new Error("Sector Shift: Expected 9 or 12 saw " + shift);
      }
      blob.chk("0600", "Mini Sector Shift: ");
      blob.chk("000000000000", "Reserved: ");
    }
    function sectorify(file, ssz) {
      var nsectors = Math.ceil(file.length / ssz) - 1;
      var sectors = [];
      for (var i2 = 1; i2 < nsectors; ++i2)
        sectors[i2 - 1] = file.slice(i2 * ssz, (i2 + 1) * ssz);
      sectors[nsectors - 1] = file.slice(nsectors * ssz);
      return sectors;
    }
    function build_full_paths(FI, FP, Paths) {
      var i2 = 0, L = 0, R = 0, C = 0, j = 0, pl = Paths.length;
      var dad = [], q2 = [];
      for (; i2 < pl; ++i2) {
        dad[i2] = q2[i2] = i2;
        FP[i2] = Paths[i2];
      }
      for (; j < q2.length; ++j) {
        i2 = q2[j];
        L = FI[i2].L;
        R = FI[i2].R;
        C = FI[i2].C;
        if (dad[i2] === i2) {
          if (L !== -1 && dad[L] !== L)
            dad[i2] = dad[L];
          if (R !== -1 && dad[R] !== R)
            dad[i2] = dad[R];
        }
        if (C !== -1)
          dad[C] = i2;
        if (L !== -1 && i2 != dad[i2]) {
          dad[L] = dad[i2];
          if (q2.lastIndexOf(L) < j)
            q2.push(L);
        }
        if (R !== -1 && i2 != dad[i2]) {
          dad[R] = dad[i2];
          if (q2.lastIndexOf(R) < j)
            q2.push(R);
        }
      }
      for (i2 = 1; i2 < pl; ++i2)
        if (dad[i2] === i2) {
          if (R !== -1 && dad[R] !== R)
            dad[i2] = dad[R];
          else if (L !== -1 && dad[L] !== L)
            dad[i2] = dad[L];
        }
      for (i2 = 1; i2 < pl; ++i2) {
        if (FI[i2].type === 0)
          continue;
        j = i2;
        if (j != dad[j])
          do {
            j = dad[j];
            FP[i2] = FP[j] + "/" + FP[i2];
          } while (j !== 0 && -1 !== dad[j] && j != dad[j]);
        dad[i2] = -1;
      }
      FP[0] += "/";
      for (i2 = 1; i2 < pl; ++i2) {
        if (FI[i2].type !== 2)
          FP[i2] += "/";
      }
    }
    function get_mfat_entry(entry, payload, mini) {
      var start = entry.start, size = entry.size;
      var o = [];
      var idx = start;
      while (mini && size > 0 && idx >= 0) {
        o.push(payload.slice(idx * MSSZ, idx * MSSZ + MSSZ));
        size -= MSSZ;
        idx = __readInt32LE(mini, idx * 4);
      }
      if (o.length === 0)
        return new_buf(0);
      return bconcat(o).slice(0, entry.size);
    }
    function sleuth_fat(idx, cnt, sectors, ssz, fat_addrs) {
      var q2 = ENDOFCHAIN;
      if (idx === ENDOFCHAIN) {
        if (cnt !== 0)
          throw new Error("DIFAT chain shorter than expected");
      } else if (idx !== -1) {
        var sector = sectors[idx], m = (ssz >>> 2) - 1;
        if (!sector)
          return;
        for (var i2 = 0; i2 < m; ++i2) {
          if ((q2 = __readInt32LE(sector, i2 * 4)) === ENDOFCHAIN)
            break;
          fat_addrs.push(q2);
        }
        if (cnt >= 1)
          sleuth_fat(__readInt32LE(sector, ssz - 4), cnt - 1, sectors, ssz, fat_addrs);
      }
    }
    function get_sector_list(sectors, start, fat_addrs, ssz, chkd) {
      var buf = [], buf_chain = [];
      if (!chkd)
        chkd = [];
      var modulus = ssz - 1, j = 0, jj = 0;
      for (j = start; j >= 0; ) {
        chkd[j] = true;
        buf[buf.length] = j;
        buf_chain.push(sectors[j]);
        var addr = fat_addrs[Math.floor(j * 4 / ssz)];
        jj = j * 4 & modulus;
        if (ssz < 4 + jj)
          throw new Error("FAT boundary crossed: " + j + " 4 " + ssz);
        if (!sectors[addr])
          break;
        j = __readInt32LE(sectors[addr], jj);
      }
      return { nodes: buf, data: __toBuffer([buf_chain]) };
    }
    function make_sector_list(sectors, dir_start, fat_addrs, ssz) {
      var sl = sectors.length, sector_list = [];
      var chkd = [], buf = [], buf_chain = [];
      var modulus = ssz - 1, i2 = 0, j = 0, k = 0, jj = 0;
      for (i2 = 0; i2 < sl; ++i2) {
        buf = [];
        k = i2 + dir_start;
        if (k >= sl)
          k -= sl;
        if (chkd[k])
          continue;
        buf_chain = [];
        var seen = [];
        for (j = k; j >= 0; ) {
          seen[j] = true;
          chkd[j] = true;
          buf[buf.length] = j;
          buf_chain.push(sectors[j]);
          var addr = fat_addrs[Math.floor(j * 4 / ssz)];
          jj = j * 4 & modulus;
          if (ssz < 4 + jj)
            throw new Error("FAT boundary crossed: " + j + " 4 " + ssz);
          if (!sectors[addr])
            break;
          j = __readInt32LE(sectors[addr], jj);
          if (seen[j])
            break;
        }
        sector_list[k] = { nodes: buf, data: __toBuffer([buf_chain]) };
      }
      return sector_list;
    }
    function read_directory(dir_start, sector_list, sectors, Paths, nmfs, files, FileIndex, mini) {
      var minifat_store = 0, pl = Paths.length ? 2 : 0;
      var sector = sector_list[dir_start].data;
      var i2 = 0, namelen = 0, name;
      for (; i2 < sector.length; i2 += 128) {
        var blob = (
          /*::(*/
          sector.slice(i2, i2 + 128)
        );
        prep_blob(blob, 64);
        namelen = blob.read_shift(2);
        name = __utf16le(blob, 0, namelen - pl);
        Paths.push(name);
        var o = {
          name,
          type: blob.read_shift(1),
          color: blob.read_shift(1),
          L: blob.read_shift(4, "i"),
          R: blob.read_shift(4, "i"),
          C: blob.read_shift(4, "i"),
          clsid: blob.read_shift(16),
          state: blob.read_shift(4, "i"),
          start: 0,
          size: 0
        };
        var ctime = blob.read_shift(2) + blob.read_shift(2) + blob.read_shift(2) + blob.read_shift(2);
        if (ctime !== 0)
          o.ct = read_date(blob, blob.l - 8);
        var mtime = blob.read_shift(2) + blob.read_shift(2) + blob.read_shift(2) + blob.read_shift(2);
        if (mtime !== 0)
          o.mt = read_date(blob, blob.l - 8);
        o.start = blob.read_shift(4, "i");
        o.size = blob.read_shift(4, "i");
        if (o.size < 0 && o.start < 0) {
          o.size = o.type = 0;
          o.start = ENDOFCHAIN;
          o.name = "";
        }
        if (o.type === 5) {
          minifat_store = o.start;
          if (nmfs > 0 && minifat_store !== ENDOFCHAIN)
            sector_list[minifat_store].name = "!StreamData";
        } else if (o.size >= 4096) {
          o.storage = "fat";
          if (sector_list[o.start] === void 0)
            sector_list[o.start] = get_sector_list(sectors, o.start, sector_list.fat_addrs, sector_list.ssz);
          sector_list[o.start].name = o.name;
          o.content = sector_list[o.start].data.slice(0, o.size);
        } else {
          o.storage = "minifat";
          if (o.size < 0)
            o.size = 0;
          else if (minifat_store !== ENDOFCHAIN && o.start !== ENDOFCHAIN && sector_list[minifat_store]) {
            o.content = get_mfat_entry(o, sector_list[minifat_store].data, (sector_list[mini] || {}).data);
          }
        }
        if (o.content)
          prep_blob(o.content, 0);
        files[name] = o;
        FileIndex.push(o);
      }
    }
    function read_date(blob, offset) {
      return new Date((__readUInt32LE(blob, offset + 4) / 1e7 * Math.pow(2, 32) + __readUInt32LE(blob, offset) / 1e7 - 11644473600) * 1e3);
    }
    function read_file(filename2, options) {
      get_fs();
      return parse(fs.readFileSync(filename2), options);
    }
    function read(blob, options) {
      var type = options && options.type;
      if (!type) {
        if (has_buf && Buffer.isBuffer(blob))
          type = "buffer";
      }
      switch (type || "base64") {
        case "file":
          return read_file(blob, options);
        case "base64":
          return parse(s2a(Base64_decode(blob)), options);
        case "binary":
          return parse(s2a(blob), options);
      }
      return parse(
        /*::typeof blob == 'string' ? new Buffer(blob, 'utf-8') : */
        blob,
        options
      );
    }
    function init_cfb(cfb, opts) {
      var o = opts || {}, root = o.root || "Root Entry";
      if (!cfb.FullPaths)
        cfb.FullPaths = [];
      if (!cfb.FileIndex)
        cfb.FileIndex = [];
      if (cfb.FullPaths.length !== cfb.FileIndex.length)
        throw new Error("inconsistent CFB structure");
      if (cfb.FullPaths.length === 0) {
        cfb.FullPaths[0] = root + "/";
        cfb.FileIndex[0] = { name: root, type: 5 };
      }
      if (o.CLSID)
        cfb.FileIndex[0].clsid = o.CLSID;
      seed_cfb(cfb);
    }
    function seed_cfb(cfb) {
      var nm = "Sh33tJ5";
      if (CFB.find(cfb, "/" + nm))
        return;
      var p = new_buf(4);
      p[0] = 55;
      p[1] = p[3] = 50;
      p[2] = 54;
      cfb.FileIndex.push({ name: nm, type: 2, content: p, size: 4, L: 69, R: 69, C: 69 });
      cfb.FullPaths.push(cfb.FullPaths[0] + nm);
      rebuild_cfb(cfb);
    }
    function rebuild_cfb(cfb, f) {
      init_cfb(cfb);
      var gc = false, s = false;
      for (var i2 = cfb.FullPaths.length - 1; i2 >= 0; --i2) {
        var _file = cfb.FileIndex[i2];
        switch (_file.type) {
          case 0:
            if (s)
              gc = true;
            else {
              cfb.FileIndex.pop();
              cfb.FullPaths.pop();
            }
            break;
          case 1:
          case 2:
          case 5:
            s = true;
            if (isNaN(_file.R * _file.L * _file.C))
              gc = true;
            if (_file.R > -1 && _file.L > -1 && _file.R == _file.L)
              gc = true;
            break;
          default:
            gc = true;
            break;
        }
      }
      if (!gc && !f)
        return;
      var now = new Date(1987, 1, 19), j = 0;
      var fullPaths = Object.create ? /* @__PURE__ */ Object.create(null) : {};
      var data = [];
      for (i2 = 0; i2 < cfb.FullPaths.length; ++i2) {
        fullPaths[cfb.FullPaths[i2]] = true;
        if (cfb.FileIndex[i2].type === 0)
          continue;
        data.push([cfb.FullPaths[i2], cfb.FileIndex[i2]]);
      }
      for (i2 = 0; i2 < data.length; ++i2) {
        var dad = dirname(data[i2][0]);
        s = fullPaths[dad];
        while (!s) {
          while (dirname(dad) && !fullPaths[dirname(dad)])
            dad = dirname(dad);
          data.push([dad, {
            name: filename(dad).replace("/", ""),
            type: 1,
            clsid: HEADER_CLSID,
            ct: now,
            mt: now,
            content: null
          }]);
          fullPaths[dad] = true;
          dad = dirname(data[i2][0]);
          s = fullPaths[dad];
        }
      }
      data.sort(function(x, y) {
        return namecmp(x[0], y[0]);
      });
      cfb.FullPaths = [];
      cfb.FileIndex = [];
      for (i2 = 0; i2 < data.length; ++i2) {
        cfb.FullPaths[i2] = data[i2][0];
        cfb.FileIndex[i2] = data[i2][1];
      }
      for (i2 = 0; i2 < data.length; ++i2) {
        var elt = cfb.FileIndex[i2];
        var nm = cfb.FullPaths[i2];
        elt.name = filename(nm).replace("/", "");
        elt.L = elt.R = elt.C = -(elt.color = 1);
        elt.size = elt.content ? elt.content.length : 0;
        elt.start = 0;
        elt.clsid = elt.clsid || HEADER_CLSID;
        if (i2 === 0) {
          elt.C = data.length > 1 ? 1 : -1;
          elt.size = 0;
          elt.type = 5;
        } else if (nm.slice(-1) == "/") {
          for (j = i2 + 1; j < data.length; ++j)
            if (dirname(cfb.FullPaths[j]) == nm)
              break;
          elt.C = j >= data.length ? -1 : j;
          for (j = i2 + 1; j < data.length; ++j)
            if (dirname(cfb.FullPaths[j]) == dirname(nm))
              break;
          elt.R = j >= data.length ? -1 : j;
          elt.type = 1;
        } else {
          if (dirname(cfb.FullPaths[i2 + 1] || "") == dirname(nm))
            elt.R = i2 + 1;
          elt.type = 2;
        }
      }
    }
    function _write(cfb, options) {
      var _opts = options || {};
      if (_opts.fileType == "mad")
        return write_mad(cfb, _opts);
      rebuild_cfb(cfb);
      switch (_opts.fileType) {
        case "zip":
          return write_zip(cfb, _opts);
      }
      var L = function(cfb2) {
        var mini_size = 0, fat_size = 0;
        for (var i3 = 0; i3 < cfb2.FileIndex.length; ++i3) {
          var file2 = cfb2.FileIndex[i3];
          if (!file2.content)
            continue;
          var flen2 = file2.content.length;
          if (flen2 > 0) {
            if (flen2 < 4096)
              mini_size += flen2 + 63 >> 6;
            else
              fat_size += flen2 + 511 >> 9;
          }
        }
        var dir_cnt = cfb2.FullPaths.length + 3 >> 2;
        var mini_cnt = mini_size + 7 >> 3;
        var mfat_cnt = mini_size + 127 >> 7;
        var fat_base = mini_cnt + fat_size + dir_cnt + mfat_cnt;
        var fat_cnt = fat_base + 127 >> 7;
        var difat_cnt = fat_cnt <= 109 ? 0 : Math.ceil((fat_cnt - 109) / 127);
        while (fat_base + fat_cnt + difat_cnt + 127 >> 7 > fat_cnt)
          difat_cnt = ++fat_cnt <= 109 ? 0 : Math.ceil((fat_cnt - 109) / 127);
        var L2 = [1, difat_cnt, fat_cnt, mfat_cnt, dir_cnt, fat_size, mini_size, 0];
        cfb2.FileIndex[0].size = mini_size << 6;
        L2[7] = (cfb2.FileIndex[0].start = L2[0] + L2[1] + L2[2] + L2[3] + L2[4] + L2[5]) + (L2[6] + 7 >> 3);
        return L2;
      }(cfb);
      var o = new_buf(L[7] << 9);
      var i2 = 0, T = 0;
      {
        for (i2 = 0; i2 < 8; ++i2)
          o.write_shift(1, HEADER_SIG[i2]);
        for (i2 = 0; i2 < 8; ++i2)
          o.write_shift(2, 0);
        o.write_shift(2, 62);
        o.write_shift(2, 3);
        o.write_shift(2, 65534);
        o.write_shift(2, 9);
        o.write_shift(2, 6);
        for (i2 = 0; i2 < 3; ++i2)
          o.write_shift(2, 0);
        o.write_shift(4, 0);
        o.write_shift(4, L[2]);
        o.write_shift(4, L[0] + L[1] + L[2] + L[3] - 1);
        o.write_shift(4, 0);
        o.write_shift(4, 1 << 12);
        o.write_shift(4, L[3] ? L[0] + L[1] + L[2] - 1 : ENDOFCHAIN);
        o.write_shift(4, L[3]);
        o.write_shift(-4, L[1] ? L[0] - 1 : ENDOFCHAIN);
        o.write_shift(4, L[1]);
        for (i2 = 0; i2 < 109; ++i2)
          o.write_shift(-4, i2 < L[2] ? L[1] + i2 : -1);
      }
      if (L[1]) {
        for (T = 0; T < L[1]; ++T) {
          for (; i2 < 236 + T * 127; ++i2)
            o.write_shift(-4, i2 < L[2] ? L[1] + i2 : -1);
          o.write_shift(-4, T === L[1] - 1 ? ENDOFCHAIN : T + 1);
        }
      }
      var chainit = function(w) {
        for (T += w; i2 < T - 1; ++i2)
          o.write_shift(-4, i2 + 1);
        if (w) {
          ++i2;
          o.write_shift(-4, ENDOFCHAIN);
        }
      };
      T = i2 = 0;
      for (T += L[1]; i2 < T; ++i2)
        o.write_shift(-4, consts.DIFSECT);
      for (T += L[2]; i2 < T; ++i2)
        o.write_shift(-4, consts.FATSECT);
      chainit(L[3]);
      chainit(L[4]);
      var j = 0, flen = 0;
      var file = cfb.FileIndex[0];
      for (; j < cfb.FileIndex.length; ++j) {
        file = cfb.FileIndex[j];
        if (!file.content)
          continue;
        flen = file.content.length;
        if (flen < 4096)
          continue;
        file.start = T;
        chainit(flen + 511 >> 9);
      }
      chainit(L[6] + 7 >> 3);
      while (o.l & 511)
        o.write_shift(-4, consts.ENDOFCHAIN);
      T = i2 = 0;
      for (j = 0; j < cfb.FileIndex.length; ++j) {
        file = cfb.FileIndex[j];
        if (!file.content)
          continue;
        flen = file.content.length;
        if (!flen || flen >= 4096)
          continue;
        file.start = T;
        chainit(flen + 63 >> 6);
      }
      while (o.l & 511)
        o.write_shift(-4, consts.ENDOFCHAIN);
      for (i2 = 0; i2 < L[4] << 2; ++i2) {
        var nm = cfb.FullPaths[i2];
        if (!nm || nm.length === 0) {
          for (j = 0; j < 17; ++j)
            o.write_shift(4, 0);
          for (j = 0; j < 3; ++j)
            o.write_shift(4, -1);
          for (j = 0; j < 12; ++j)
            o.write_shift(4, 0);
          continue;
        }
        file = cfb.FileIndex[i2];
        if (i2 === 0)
          file.start = file.size ? file.start - 1 : ENDOFCHAIN;
        var _nm = i2 === 0 && _opts.root || file.name;
        if (_nm.length > 31) {
          console.error("Name " + _nm + " will be truncated to " + _nm.slice(0, 31));
          _nm = _nm.slice(0, 31);
        }
        flen = 2 * (_nm.length + 1);
        o.write_shift(64, _nm, "utf16le");
        o.write_shift(2, flen);
        o.write_shift(1, file.type);
        o.write_shift(1, file.color);
        o.write_shift(-4, file.L);
        o.write_shift(-4, file.R);
        o.write_shift(-4, file.C);
        if (!file.clsid)
          for (j = 0; j < 4; ++j)
            o.write_shift(4, 0);
        else
          o.write_shift(16, file.clsid, "hex");
        o.write_shift(4, file.state || 0);
        o.write_shift(4, 0);
        o.write_shift(4, 0);
        o.write_shift(4, 0);
        o.write_shift(4, 0);
        o.write_shift(4, file.start);
        o.write_shift(4, file.size);
        o.write_shift(4, 0);
      }
      for (i2 = 1; i2 < cfb.FileIndex.length; ++i2) {
        file = cfb.FileIndex[i2];
        if (file.size >= 4096) {
          o.l = file.start + 1 << 9;
          if (has_buf && Buffer.isBuffer(file.content)) {
            file.content.copy(o, o.l, 0, file.size);
            o.l += file.size + 511 & -512;
          } else {
            for (j = 0; j < file.size; ++j)
              o.write_shift(1, file.content[j]);
            for (; j & 511; ++j)
              o.write_shift(1, 0);
          }
        }
      }
      for (i2 = 1; i2 < cfb.FileIndex.length; ++i2) {
        file = cfb.FileIndex[i2];
        if (file.size > 0 && file.size < 4096) {
          if (has_buf && Buffer.isBuffer(file.content)) {
            file.content.copy(o, o.l, 0, file.size);
            o.l += file.size + 63 & -64;
          } else {
            for (j = 0; j < file.size; ++j)
              o.write_shift(1, file.content[j]);
            for (; j & 63; ++j)
              o.write_shift(1, 0);
          }
        }
      }
      if (has_buf) {
        o.l = o.length;
      } else {
        while (o.l < o.length)
          o.write_shift(1, 0);
      }
      return o;
    }
    function find(cfb, path) {
      var UCFullPaths = cfb.FullPaths.map(function(x) {
        return x.toUpperCase();
      });
      var UCPaths = UCFullPaths.map(function(x) {
        var y = x.split("/");
        return y[y.length - (x.slice(-1) == "/" ? 2 : 1)];
      });
      var k = false;
      if (path.charCodeAt(0) === 47) {
        k = true;
        path = UCFullPaths[0].slice(0, -1) + path;
      } else
        k = path.indexOf("/") !== -1;
      var UCPath = path.toUpperCase();
      var w = k === true ? UCFullPaths.indexOf(UCPath) : UCPaths.indexOf(UCPath);
      if (w !== -1)
        return cfb.FileIndex[w];
      var m = !UCPath.match(chr1);
      UCPath = UCPath.replace(chr0, "");
      if (m)
        UCPath = UCPath.replace(chr1, "!");
      for (w = 0; w < UCFullPaths.length; ++w) {
        if ((m ? UCFullPaths[w].replace(chr1, "!") : UCFullPaths[w]).replace(chr0, "") == UCPath)
          return cfb.FileIndex[w];
        if ((m ? UCPaths[w].replace(chr1, "!") : UCPaths[w]).replace(chr0, "") == UCPath)
          return cfb.FileIndex[w];
      }
      return null;
    }
    var MSSZ = 64;
    var ENDOFCHAIN = -2;
    var HEADER_SIGNATURE = "d0cf11e0a1b11ae1";
    var HEADER_SIG = [208, 207, 17, 224, 161, 177, 26, 225];
    var HEADER_CLSID = "00000000000000000000000000000000";
    var consts = {
      /* 2.1 Compund File Sector Numbers and Types */
      MAXREGSECT: -6,
      DIFSECT: -4,
      FATSECT: -3,
      ENDOFCHAIN,
      FREESECT: -1,
      /* 2.2 Compound File Header */
      HEADER_SIGNATURE,
      HEADER_MINOR_VERSION: "3e00",
      MAXREGSID: -6,
      NOSTREAM: -1,
      HEADER_CLSID,
      /* 2.6.1 Compound File Directory Entry */
      EntryTypes: ["unknown", "storage", "stream", "lockbytes", "property", "root"]
    };
    function write_file(cfb, filename2, options) {
      get_fs();
      var o = _write(cfb, options);
      fs.writeFileSync(filename2, o);
    }
    function a2s2(o) {
      var out = new Array(o.length);
      for (var i2 = 0; i2 < o.length; ++i2)
        out[i2] = String.fromCharCode(o[i2]);
      return out.join("");
    }
    function write(cfb, options) {
      var o = _write(cfb, options);
      switch (options && options.type || "buffer") {
        case "file":
          get_fs();
          fs.writeFileSync(options.filename, o);
          return o;
        case "binary":
          return typeof o == "string" ? o : a2s2(o);
        case "base64":
          return Base64_encode(typeof o == "string" ? o : a2s2(o));
        case "buffer":
          if (has_buf)
            return Buffer.isBuffer(o) ? o : Buffer_from(o);
        case "array":
          return typeof o == "string" ? s2a(o) : o;
      }
      return o;
    }
    var _zlib;
    function use_zlib(zlib) {
      try {
        var InflateRaw = zlib.InflateRaw;
        var InflRaw = new InflateRaw();
        InflRaw._processChunk(new Uint8Array([3, 0]), InflRaw._finishFlushFlag);
        if (InflRaw.bytesRead)
          _zlib = zlib;
        else
          throw new Error("zlib does not expose bytesRead");
      } catch (e) {
        console.error("cannot use native zlib: " + (e.message || e));
      }
    }
    function _inflateRawSync(payload, usz) {
      if (!_zlib)
        return _inflate(payload, usz);
      var InflateRaw = _zlib.InflateRaw;
      var InflRaw = new InflateRaw();
      var out = InflRaw._processChunk(payload.slice(payload.l), InflRaw._finishFlushFlag);
      payload.l += InflRaw.bytesRead;
      return out;
    }
    function _deflateRawSync(payload) {
      return _zlib ? _zlib.deflateRawSync(payload) : _deflate(payload);
    }
    var CLEN_ORDER = [16, 17, 18, 0, 8, 7, 9, 6, 10, 5, 11, 4, 12, 3, 13, 2, 14, 1, 15];
    var LEN_LN = [3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 15, 17, 19, 23, 27, 31, 35, 43, 51, 59, 67, 83, 99, 115, 131, 163, 195, 227, 258];
    var DST_LN = [1, 2, 3, 4, 5, 7, 9, 13, 17, 25, 33, 49, 65, 97, 129, 193, 257, 385, 513, 769, 1025, 1537, 2049, 3073, 4097, 6145, 8193, 12289, 16385, 24577];
    function bit_swap_8(n) {
      var t = (n << 1 | n << 11) & 139536 | (n << 5 | n << 15) & 558144;
      return (t >> 16 | t >> 8 | t) & 255;
    }
    var use_typed_arrays = typeof Uint8Array !== "undefined";
    var bitswap8 = use_typed_arrays ? new Uint8Array(1 << 8) : [];
    for (var q = 0; q < 1 << 8; ++q)
      bitswap8[q] = bit_swap_8(q);
    function bit_swap_n(n, b) {
      var rev = bitswap8[n & 255];
      if (b <= 8)
        return rev >>> 8 - b;
      rev = rev << 8 | bitswap8[n >> 8 & 255];
      if (b <= 16)
        return rev >>> 16 - b;
      rev = rev << 8 | bitswap8[n >> 16 & 255];
      return rev >>> 24 - b;
    }
    function read_bits_2(buf, bl) {
      var w = bl & 7, h = bl >>> 3;
      return (buf[h] | (w <= 6 ? 0 : buf[h + 1] << 8)) >>> w & 3;
    }
    function read_bits_3(buf, bl) {
      var w = bl & 7, h = bl >>> 3;
      return (buf[h] | (w <= 5 ? 0 : buf[h + 1] << 8)) >>> w & 7;
    }
    function read_bits_4(buf, bl) {
      var w = bl & 7, h = bl >>> 3;
      return (buf[h] | (w <= 4 ? 0 : buf[h + 1] << 8)) >>> w & 15;
    }
    function read_bits_5(buf, bl) {
      var w = bl & 7, h = bl >>> 3;
      return (buf[h] | (w <= 3 ? 0 : buf[h + 1] << 8)) >>> w & 31;
    }
    function read_bits_7(buf, bl) {
      var w = bl & 7, h = bl >>> 3;
      return (buf[h] | (w <= 1 ? 0 : buf[h + 1] << 8)) >>> w & 127;
    }
    function read_bits_n(buf, bl, n) {
      var w = bl & 7, h = bl >>> 3, f = (1 << n) - 1;
      var v = buf[h] >>> w;
      if (n < 8 - w)
        return v & f;
      v |= buf[h + 1] << 8 - w;
      if (n < 16 - w)
        return v & f;
      v |= buf[h + 2] << 16 - w;
      if (n < 24 - w)
        return v & f;
      v |= buf[h + 3] << 24 - w;
      return v & f;
    }
    function write_bits_3(buf, bl, v) {
      var w = bl & 7, h = bl >>> 3;
      if (w <= 5)
        buf[h] |= (v & 7) << w;
      else {
        buf[h] |= v << w & 255;
        buf[h + 1] = (v & 7) >> 8 - w;
      }
      return bl + 3;
    }
    function write_bits_1(buf, bl, v) {
      var w = bl & 7, h = bl >>> 3;
      v = (v & 1) << w;
      buf[h] |= v;
      return bl + 1;
    }
    function write_bits_8(buf, bl, v) {
      var w = bl & 7, h = bl >>> 3;
      v <<= w;
      buf[h] |= v & 255;
      v >>>= 8;
      buf[h + 1] = v;
      return bl + 8;
    }
    function write_bits_16(buf, bl, v) {
      var w = bl & 7, h = bl >>> 3;
      v <<= w;
      buf[h] |= v & 255;
      v >>>= 8;
      buf[h + 1] = v & 255;
      buf[h + 2] = v >>> 8;
      return bl + 16;
    }
    function realloc(b, sz) {
      var L = b.length, M = 2 * L > sz ? 2 * L : sz + 5, i2 = 0;
      if (L >= sz)
        return b;
      if (has_buf) {
        var o = new_unsafe_buf(M);
        if (b.copy)
          b.copy(o);
        else
          for (; i2 < b.length; ++i2)
            o[i2] = b[i2];
        return o;
      } else if (use_typed_arrays) {
        var a = new Uint8Array(M);
        if (a.set)
          a.set(b);
        else
          for (; i2 < L; ++i2)
            a[i2] = b[i2];
        return a;
      }
      b.length = M;
      return b;
    }
    function zero_fill_array(n) {
      var o = new Array(n);
      for (var i2 = 0; i2 < n; ++i2)
        o[i2] = 0;
      return o;
    }
    function build_tree(clens, cmap, MAX) {
      var maxlen = 1, w = 0, i2 = 0, j = 0, ccode = 0, L = clens.length;
      var bl_count = use_typed_arrays ? new Uint16Array(32) : zero_fill_array(32);
      for (i2 = 0; i2 < 32; ++i2)
        bl_count[i2] = 0;
      for (i2 = L; i2 < MAX; ++i2)
        clens[i2] = 0;
      L = clens.length;
      var ctree = use_typed_arrays ? new Uint16Array(L) : zero_fill_array(L);
      for (i2 = 0; i2 < L; ++i2) {
        bl_count[w = clens[i2]]++;
        if (maxlen < w)
          maxlen = w;
        ctree[i2] = 0;
      }
      bl_count[0] = 0;
      for (i2 = 1; i2 <= maxlen; ++i2)
        bl_count[i2 + 16] = ccode = ccode + bl_count[i2 - 1] << 1;
      for (i2 = 0; i2 < L; ++i2) {
        ccode = clens[i2];
        if (ccode != 0)
          ctree[i2] = bl_count[ccode + 16]++;
      }
      var cleni = 0;
      for (i2 = 0; i2 < L; ++i2) {
        cleni = clens[i2];
        if (cleni != 0) {
          ccode = bit_swap_n(ctree[i2], maxlen) >> maxlen - cleni;
          for (j = (1 << maxlen + 4 - cleni) - 1; j >= 0; --j)
            cmap[ccode | j << cleni] = cleni & 15 | i2 << 4;
        }
      }
      return maxlen;
    }
    var fix_lmap = use_typed_arrays ? new Uint16Array(512) : zero_fill_array(512);
    var fix_dmap = use_typed_arrays ? new Uint16Array(32) : zero_fill_array(32);
    if (!use_typed_arrays) {
      for (var i = 0; i < 512; ++i)
        fix_lmap[i] = 0;
      for (i = 0; i < 32; ++i)
        fix_dmap[i] = 0;
    }
    (function() {
      var dlens = [];
      var i2 = 0;
      for (; i2 < 32; i2++)
        dlens.push(5);
      build_tree(dlens, fix_dmap, 32);
      var clens = [];
      i2 = 0;
      for (; i2 <= 143; i2++)
        clens.push(8);
      for (; i2 <= 255; i2++)
        clens.push(9);
      for (; i2 <= 279; i2++)
        clens.push(7);
      for (; i2 <= 287; i2++)
        clens.push(8);
      build_tree(clens, fix_lmap, 288);
    })();
    var _deflateRaw = /* @__PURE__ */ function _deflateRawIIFE() {
      var DST_LN_RE = use_typed_arrays ? new Uint8Array(32768) : [];
      var j = 0, k = 0;
      for (; j < DST_LN.length - 1; ++j) {
        for (; k < DST_LN[j + 1]; ++k)
          DST_LN_RE[k] = j;
      }
      for (; k < 32768; ++k)
        DST_LN_RE[k] = 29;
      var LEN_LN_RE = use_typed_arrays ? new Uint8Array(259) : [];
      for (j = 0, k = 0; j < LEN_LN.length - 1; ++j) {
        for (; k < LEN_LN[j + 1]; ++k)
          LEN_LN_RE[k] = j;
      }
      function write_stored(data, out) {
        var boff = 0;
        while (boff < data.length) {
          var L = Math.min(65535, data.length - boff);
          var h = boff + L == data.length;
          out.write_shift(1, +h);
          out.write_shift(2, L);
          out.write_shift(2, ~L & 65535);
          while (L-- > 0)
            out[out.l++] = data[boff++];
        }
        return out.l;
      }
      function write_huff_fixed(data, out) {
        var bl = 0;
        var boff = 0;
        var addrs = use_typed_arrays ? new Uint16Array(32768) : [];
        while (boff < data.length) {
          var L = (
            /* data.length - boff; */
            Math.min(65535, data.length - boff)
          );
          if (L < 10) {
            bl = write_bits_3(out, bl, +!!(boff + L == data.length));
            if (bl & 7)
              bl += 8 - (bl & 7);
            out.l = bl / 8 | 0;
            out.write_shift(2, L);
            out.write_shift(2, ~L & 65535);
            while (L-- > 0)
              out[out.l++] = data[boff++];
            bl = out.l * 8;
            continue;
          }
          bl = write_bits_3(out, bl, +!!(boff + L == data.length) + 2);
          var hash = 0;
          while (L-- > 0) {
            var d = data[boff];
            hash = (hash << 5 ^ d) & 32767;
            var match = -1, mlen = 0;
            if (match = addrs[hash]) {
              match |= boff & ~32767;
              if (match > boff)
                match -= 32768;
              if (match < boff)
                while (data[match + mlen] == data[boff + mlen] && mlen < 250)
                  ++mlen;
            }
            if (mlen > 2) {
              d = LEN_LN_RE[mlen];
              if (d <= 22)
                bl = write_bits_8(out, bl, bitswap8[d + 1] >> 1) - 1;
              else {
                write_bits_8(out, bl, 3);
                bl += 5;
                write_bits_8(out, bl, bitswap8[d - 23] >> 5);
                bl += 3;
              }
              var len_eb = d < 8 ? 0 : d - 4 >> 2;
              if (len_eb > 0) {
                write_bits_16(out, bl, mlen - LEN_LN[d]);
                bl += len_eb;
              }
              d = DST_LN_RE[boff - match];
              bl = write_bits_8(out, bl, bitswap8[d] >> 3);
              bl -= 3;
              var dst_eb = d < 4 ? 0 : d - 2 >> 1;
              if (dst_eb > 0) {
                write_bits_16(out, bl, boff - match - DST_LN[d]);
                bl += dst_eb;
              }
              for (var q2 = 0; q2 < mlen; ++q2) {
                addrs[hash] = boff & 32767;
                hash = (hash << 5 ^ data[boff]) & 32767;
                ++boff;
              }
              L -= mlen - 1;
            } else {
              if (d <= 143)
                d = d + 48;
              else
                bl = write_bits_1(out, bl, 1);
              bl = write_bits_8(out, bl, bitswap8[d]);
              addrs[hash] = boff & 32767;
              ++boff;
            }
          }
          bl = write_bits_8(out, bl, 0) - 1;
        }
        out.l = (bl + 7) / 8 | 0;
        return out.l;
      }
      return function _deflateRaw2(data, out) {
        if (data.length < 8)
          return write_stored(data, out);
        return write_huff_fixed(data, out);
      };
    }();
    function _deflate(data) {
      var buf = new_buf(50 + Math.floor(data.length * 1.1));
      var off = _deflateRaw(data, buf);
      return buf.slice(0, off);
    }
    var dyn_lmap = use_typed_arrays ? new Uint16Array(32768) : zero_fill_array(32768);
    var dyn_dmap = use_typed_arrays ? new Uint16Array(32768) : zero_fill_array(32768);
    var dyn_cmap = use_typed_arrays ? new Uint16Array(128) : zero_fill_array(128);
    var dyn_len_1 = 1, dyn_len_2 = 1;
    function dyn(data, boff) {
      var _HLIT = read_bits_5(data, boff) + 257;
      boff += 5;
      var _HDIST = read_bits_5(data, boff) + 1;
      boff += 5;
      var _HCLEN = read_bits_4(data, boff) + 4;
      boff += 4;
      var w = 0;
      var clens = use_typed_arrays ? new Uint8Array(19) : zero_fill_array(19);
      var ctree = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      var maxlen = 1;
      var bl_count = use_typed_arrays ? new Uint8Array(8) : zero_fill_array(8);
      var next_code = use_typed_arrays ? new Uint8Array(8) : zero_fill_array(8);
      var L = clens.length;
      for (var i2 = 0; i2 < _HCLEN; ++i2) {
        clens[CLEN_ORDER[i2]] = w = read_bits_3(data, boff);
        if (maxlen < w)
          maxlen = w;
        bl_count[w]++;
        boff += 3;
      }
      var ccode = 0;
      bl_count[0] = 0;
      for (i2 = 1; i2 <= maxlen; ++i2)
        next_code[i2] = ccode = ccode + bl_count[i2 - 1] << 1;
      for (i2 = 0; i2 < L; ++i2)
        if ((ccode = clens[i2]) != 0)
          ctree[i2] = next_code[ccode]++;
      var cleni = 0;
      for (i2 = 0; i2 < L; ++i2) {
        cleni = clens[i2];
        if (cleni != 0) {
          ccode = bitswap8[ctree[i2]] >> 8 - cleni;
          for (var j = (1 << 7 - cleni) - 1; j >= 0; --j)
            dyn_cmap[ccode | j << cleni] = cleni & 7 | i2 << 3;
        }
      }
      var hcodes = [];
      maxlen = 1;
      for (; hcodes.length < _HLIT + _HDIST; ) {
        ccode = dyn_cmap[read_bits_7(data, boff)];
        boff += ccode & 7;
        switch (ccode >>>= 3) {
          case 16:
            w = 3 + read_bits_2(data, boff);
            boff += 2;
            ccode = hcodes[hcodes.length - 1];
            while (w-- > 0)
              hcodes.push(ccode);
            break;
          case 17:
            w = 3 + read_bits_3(data, boff);
            boff += 3;
            while (w-- > 0)
              hcodes.push(0);
            break;
          case 18:
            w = 11 + read_bits_7(data, boff);
            boff += 7;
            while (w-- > 0)
              hcodes.push(0);
            break;
          default:
            hcodes.push(ccode);
            if (maxlen < ccode)
              maxlen = ccode;
            break;
        }
      }
      var h1 = hcodes.slice(0, _HLIT), h2 = hcodes.slice(_HLIT);
      for (i2 = _HLIT; i2 < 286; ++i2)
        h1[i2] = 0;
      for (i2 = _HDIST; i2 < 30; ++i2)
        h2[i2] = 0;
      dyn_len_1 = build_tree(h1, dyn_lmap, 286);
      dyn_len_2 = build_tree(h2, dyn_dmap, 30);
      return boff;
    }
    function inflate(data, usz) {
      if (data[0] == 3 && !(data[1] & 3)) {
        return [new_raw_buf(usz), 2];
      }
      var boff = 0;
      var header = 0;
      var outbuf = new_unsafe_buf(usz ? usz : 1 << 18);
      var woff = 0;
      var OL = outbuf.length >>> 0;
      var max_len_1 = 0, max_len_2 = 0;
      while ((header & 1) == 0) {
        header = read_bits_3(data, boff);
        boff += 3;
        if (header >>> 1 == 0) {
          if (boff & 7)
            boff += 8 - (boff & 7);
          var sz = data[boff >>> 3] | data[(boff >>> 3) + 1] << 8;
          boff += 32;
          if (sz > 0) {
            if (!usz && OL < woff + sz) {
              outbuf = realloc(outbuf, woff + sz);
              OL = outbuf.length;
            }
            while (sz-- > 0) {
              outbuf[woff++] = data[boff >>> 3];
              boff += 8;
            }
          }
          continue;
        } else if (header >> 1 == 1) {
          max_len_1 = 9;
          max_len_2 = 5;
        } else {
          boff = dyn(data, boff);
          max_len_1 = dyn_len_1;
          max_len_2 = dyn_len_2;
        }
        for (; ; ) {
          if (!usz && OL < woff + 32767) {
            outbuf = realloc(outbuf, woff + 32767);
            OL = outbuf.length;
          }
          var bits = read_bits_n(data, boff, max_len_1);
          var code = header >>> 1 == 1 ? fix_lmap[bits] : dyn_lmap[bits];
          boff += code & 15;
          code >>>= 4;
          if ((code >>> 8 & 255) === 0)
            outbuf[woff++] = code;
          else if (code == 256)
            break;
          else {
            code -= 257;
            var len_eb = code < 8 ? 0 : code - 4 >> 2;
            if (len_eb > 5)
              len_eb = 0;
            var tgt = woff + LEN_LN[code];
            if (len_eb > 0) {
              tgt += read_bits_n(data, boff, len_eb);
              boff += len_eb;
            }
            bits = read_bits_n(data, boff, max_len_2);
            code = header >>> 1 == 1 ? fix_dmap[bits] : dyn_dmap[bits];
            boff += code & 15;
            code >>>= 4;
            var dst_eb = code < 4 ? 0 : code - 2 >> 1;
            var dst = DST_LN[code];
            if (dst_eb > 0) {
              dst += read_bits_n(data, boff, dst_eb);
              boff += dst_eb;
            }
            if (!usz && OL < tgt) {
              outbuf = realloc(outbuf, tgt + 100);
              OL = outbuf.length;
            }
            while (woff < tgt) {
              outbuf[woff] = outbuf[woff - dst];
              ++woff;
            }
          }
        }
      }
      if (usz)
        return [outbuf, boff + 7 >>> 3];
      return [outbuf.slice(0, woff), boff + 7 >>> 3];
    }
    function _inflate(payload, usz) {
      var data = payload.slice(payload.l || 0);
      var out = inflate(data, usz);
      payload.l += out[1];
      return out[0];
    }
    function warn_or_throw(wrn, msg) {
      if (wrn) {
        if (typeof console !== "undefined")
          console.error(msg);
      } else
        throw new Error(msg);
    }
    function parse_zip(file, options) {
      var blob = (
        /*::(*/
        file
      );
      prep_blob(blob, 0);
      var FileIndex = [], FullPaths = [];
      var o = {
        FileIndex,
        FullPaths
      };
      init_cfb(o, { root: options.root });
      var i2 = blob.length - 4;
      while ((blob[i2] != 80 || blob[i2 + 1] != 75 || blob[i2 + 2] != 5 || blob[i2 + 3] != 6) && i2 >= 0)
        --i2;
      blob.l = i2 + 4;
      blob.l += 4;
      var fcnt = blob.read_shift(2);
      blob.l += 6;
      var start_cd = blob.read_shift(4);
      blob.l = start_cd;
      for (i2 = 0; i2 < fcnt; ++i2) {
        blob.l += 20;
        var csz = blob.read_shift(4);
        var usz = blob.read_shift(4);
        var namelen = blob.read_shift(2);
        var efsz = blob.read_shift(2);
        var fcsz = blob.read_shift(2);
        blob.l += 8;
        var offset = blob.read_shift(4);
        var EF = parse_extra_field(
          /*::(*/
          blob.slice(blob.l + namelen, blob.l + namelen + efsz)
          /*:: :any)*/
        );
        blob.l += namelen + efsz + fcsz;
        var L = blob.l;
        blob.l = offset + 4;
        if (EF && EF[1]) {
          if ((EF[1] || {}).usz)
            usz = EF[1].usz;
          if ((EF[1] || {}).csz)
            csz = EF[1].csz;
        }
        parse_local_file(blob, csz, usz, o, EF);
        blob.l = L;
      }
      return o;
    }
    function parse_local_file(blob, csz, usz, o, EF) {
      blob.l += 2;
      var flags = blob.read_shift(2);
      var meth = blob.read_shift(2);
      var date = parse_dos_date(blob);
      if (flags & 8257)
        throw new Error("Unsupported ZIP encryption");
      var crc32 = blob.read_shift(4);
      var _csz = blob.read_shift(4);
      var _usz = blob.read_shift(4);
      var namelen = blob.read_shift(2);
      var efsz = blob.read_shift(2);
      var name = "";
      for (var i2 = 0; i2 < namelen; ++i2)
        name += String.fromCharCode(blob[blob.l++]);
      if (efsz) {
        var ef = parse_extra_field(
          /*::(*/
          blob.slice(blob.l, blob.l + efsz)
          /*:: :any)*/
        );
        if ((ef[21589] || {}).mt)
          date = ef[21589].mt;
        if ((ef[1] || {}).usz)
          _usz = ef[1].usz;
        if ((ef[1] || {}).csz)
          _csz = ef[1].csz;
        if (EF) {
          if ((EF[21589] || {}).mt)
            date = EF[21589].mt;
          if ((EF[1] || {}).usz)
            _usz = EF[1].usz;
          if ((EF[1] || {}).csz)
            _csz = EF[1].csz;
        }
      }
      blob.l += efsz;
      var data = blob.slice(blob.l, blob.l + _csz);
      switch (meth) {
        case 8:
          data = _inflateRawSync(blob, _usz);
          break;
        case 0:
          blob.l += _csz;
          break;
        default:
          throw new Error("Unsupported ZIP Compression method " + meth);
      }
      var wrn = false;
      if (flags & 8) {
        crc32 = blob.read_shift(4);
        if (crc32 == 134695760) {
          crc32 = blob.read_shift(4);
          wrn = true;
        }
        _csz = blob.read_shift(4);
        _usz = blob.read_shift(4);
      }
      if (_csz != csz)
        warn_or_throw(wrn, "Bad compressed size: " + csz + " != " + _csz);
      if (_usz != usz)
        warn_or_throw(wrn, "Bad uncompressed size: " + usz + " != " + _usz);
      cfb_add(o, name, data, { unsafe: true, mt: date });
    }
    function write_zip(cfb, options) {
      var _opts = options || {};
      var out = [], cdirs = [];
      var o = new_buf(1);
      var method = _opts.compression ? 8 : 0, flags = 0;
      var desc = false;
      if (desc)
        flags |= 8;
      var i2 = 0, j = 0;
      var start_cd = 0, fcnt = 0;
      var root = cfb.FullPaths[0], fp = root, fi = cfb.FileIndex[0];
      var crcs = [];
      var sz_cd = 0;
      for (i2 = 1; i2 < cfb.FullPaths.length; ++i2) {
        fp = cfb.FullPaths[i2].slice(root.length);
        fi = cfb.FileIndex[i2];
        if (!fi.size || !fi.content || Array.isArray(fi.content) && fi.content.length == 0 || fp == "Sh33tJ5")
          continue;
        var start = start_cd;
        var namebuf = new_buf(fp.length);
        for (j = 0; j < fp.length; ++j)
          namebuf.write_shift(1, fp.charCodeAt(j) & 127);
        namebuf = namebuf.slice(0, namebuf.l);
        crcs[fcnt] = typeof fi.content == "string" ? CRC32.bstr(fi.content, 0) : CRC32.buf(
          /*::((*/
          fi.content,
          0
        );
        var outbuf = typeof fi.content == "string" ? s2a(fi.content) : fi.content;
        if (method == 8)
          outbuf = _deflateRawSync(outbuf);
        o = new_buf(30);
        o.write_shift(4, 67324752);
        o.write_shift(2, 20);
        o.write_shift(2, flags);
        o.write_shift(2, method);
        if (fi.mt)
          write_dos_date(o, fi.mt);
        else
          o.write_shift(4, 0);
        o.write_shift(-4, flags & 8 ? 0 : crcs[fcnt]);
        o.write_shift(4, flags & 8 ? 0 : outbuf.length);
        o.write_shift(4, flags & 8 ? 0 : (
          /*::(*/
          fi.content.length
        ));
        o.write_shift(2, namebuf.length);
        o.write_shift(2, 0);
        start_cd += o.length;
        out.push(o);
        start_cd += namebuf.length;
        out.push(namebuf);
        start_cd += outbuf.length;
        out.push(outbuf);
        if (flags & 8) {
          o = new_buf(12);
          o.write_shift(-4, crcs[fcnt]);
          o.write_shift(4, outbuf.length);
          o.write_shift(
            4,
            /*::(*/
            fi.content.length
          );
          start_cd += o.l;
          out.push(o);
        }
        o = new_buf(46);
        o.write_shift(4, 33639248);
        o.write_shift(2, 0);
        o.write_shift(2, 20);
        o.write_shift(2, flags);
        o.write_shift(2, method);
        o.write_shift(4, 0);
        o.write_shift(-4, crcs[fcnt]);
        o.write_shift(4, outbuf.length);
        o.write_shift(
          4,
          /*::(*/
          fi.content.length
        );
        o.write_shift(2, namebuf.length);
        o.write_shift(2, 0);
        o.write_shift(2, 0);
        o.write_shift(2, 0);
        o.write_shift(2, 0);
        o.write_shift(4, 0);
        o.write_shift(4, start);
        sz_cd += o.l;
        cdirs.push(o);
        sz_cd += namebuf.length;
        cdirs.push(namebuf);
        ++fcnt;
      }
      o = new_buf(22);
      o.write_shift(4, 101010256);
      o.write_shift(2, 0);
      o.write_shift(2, 0);
      o.write_shift(2, fcnt);
      o.write_shift(2, fcnt);
      o.write_shift(4, sz_cd);
      o.write_shift(4, start_cd);
      o.write_shift(2, 0);
      return bconcat([bconcat(out), bconcat(cdirs), o]);
    }
    var ContentTypeMap = {
      "htm": "text/html",
      "xml": "text/xml",
      "gif": "image/gif",
      "jpg": "image/jpeg",
      "png": "image/png",
      "mso": "application/x-mso",
      "thmx": "application/vnd.ms-officetheme",
      "sh33tj5": "application/octet-stream"
    };
    function get_content_type(fi, fp) {
      if (fi.ctype)
        return fi.ctype;
      var ext = fi.name || "", m = ext.match(/\.([^\.]+)$/);
      if (m && ContentTypeMap[m[1]])
        return ContentTypeMap[m[1]];
      if (fp) {
        m = (ext = fp).match(/[\.\\]([^\.\\])+$/);
        if (m && ContentTypeMap[m[1]])
          return ContentTypeMap[m[1]];
      }
      return "application/octet-stream";
    }
    function write_base64_76(bstr) {
      var data = Base64_encode(bstr);
      var o = [];
      for (var i2 = 0; i2 < data.length; i2 += 76)
        o.push(data.slice(i2, i2 + 76));
      return o.join("\r\n") + "\r\n";
    }
    function write_quoted_printable(text) {
      var encoded = text.replace(/[\x00-\x08\x0B\x0C\x0E-\x1F\x7E-\xFF=]/g, function(c) {
        var w = c.charCodeAt(0).toString(16).toUpperCase();
        return "=" + (w.length == 1 ? "0" + w : w);
      });
      encoded = encoded.replace(/ $/mg, "=20").replace(/\t$/mg, "=09");
      if (encoded.charAt(0) == "\n")
        encoded = "=0D" + encoded.slice(1);
      encoded = encoded.replace(/\r(?!\n)/mg, "=0D").replace(/\n\n/mg, "\n=0A").replace(/([^\r\n])\n/mg, "$1=0A");
      var o = [], split = encoded.split("\r\n");
      for (var si = 0; si < split.length; ++si) {
        var str = split[si];
        if (str.length == 0) {
          o.push("");
          continue;
        }
        for (var i2 = 0; i2 < str.length; ) {
          var end = 76;
          var tmp = str.slice(i2, i2 + end);
          if (tmp.charAt(end - 1) == "=")
            end--;
          else if (tmp.charAt(end - 2) == "=")
            end -= 2;
          else if (tmp.charAt(end - 3) == "=")
            end -= 3;
          tmp = str.slice(i2, i2 + end);
          i2 += end;
          if (i2 < str.length)
            tmp += "=";
          o.push(tmp);
        }
      }
      return o.join("\r\n");
    }
    function parse_quoted_printable(data) {
      var o = [];
      for (var di = 0; di < data.length; ++di) {
        var line = data[di];
        while (di <= data.length && line.charAt(line.length - 1) == "=")
          line = line.slice(0, line.length - 1) + data[++di];
        o.push(line);
      }
      for (var oi = 0; oi < o.length; ++oi)
        o[oi] = o[oi].replace(/[=][0-9A-Fa-f]{2}/g, function($$) {
          return String.fromCharCode(parseInt($$.slice(1), 16));
        });
      return s2a(o.join("\r\n"));
    }
    function parse_mime(cfb, data, root) {
      var fname = "", cte = "", ctype = "", fdata;
      var di = 0;
      for (; di < 10; ++di) {
        var line = data[di];
        if (!line || line.match(/^\s*$/))
          break;
        var m = line.match(/^([^:]*?):\s*([^\s].*)$/);
        if (m)
          switch (m[1].toLowerCase()) {
            case "content-location":
              fname = m[2].trim();
              break;
            case "content-type":
              ctype = m[2].trim();
              break;
            case "content-transfer-encoding":
              cte = m[2].trim();
              break;
          }
      }
      ++di;
      switch (cte.toLowerCase()) {
        case "base64":
          fdata = s2a(Base64_decode(data.slice(di).join("")));
          break;
        case "quoted-printable":
          fdata = parse_quoted_printable(data.slice(di));
          break;
        default:
          throw new Error("Unsupported Content-Transfer-Encoding " + cte);
      }
      var file = cfb_add(cfb, fname.slice(root.length), fdata, { unsafe: true });
      if (ctype)
        file.ctype = ctype;
    }
    function parse_mad(file, options) {
      if (a2s2(file.slice(0, 13)).toLowerCase() != "mime-version:")
        throw new Error("Unsupported MAD header");
      var root = options && options.root || "";
      var data = (has_buf && Buffer.isBuffer(file) ? file.toString("binary") : a2s2(file)).split("\r\n");
      var di = 0, row = "";
      for (di = 0; di < data.length; ++di) {
        row = data[di];
        if (!/^Content-Location:/i.test(row))
          continue;
        row = row.slice(row.indexOf("file"));
        if (!root)
          root = row.slice(0, row.lastIndexOf("/") + 1);
        if (row.slice(0, root.length) == root)
          continue;
        while (root.length > 0) {
          root = root.slice(0, root.length - 1);
          root = root.slice(0, root.lastIndexOf("/") + 1);
          if (row.slice(0, root.length) == root)
            break;
        }
      }
      var mboundary = (data[1] || "").match(/boundary="(.*?)"/);
      if (!mboundary)
        throw new Error("MAD cannot find boundary");
      var boundary = "--" + (mboundary[1] || "");
      var FileIndex = [], FullPaths = [];
      var o = {
        FileIndex,
        FullPaths
      };
      init_cfb(o);
      var start_di, fcnt = 0;
      for (di = 0; di < data.length; ++di) {
        var line = data[di];
        if (line !== boundary && line !== boundary + "--")
          continue;
        if (fcnt++)
          parse_mime(o, data.slice(start_di, di), root);
        start_di = di;
      }
      return o;
    }
    function write_mad(cfb, options) {
      var opts = options || {};
      var boundary = opts.boundary || "SheetJS";
      boundary = "------=" + boundary;
      var out = [
        "MIME-Version: 1.0",
        'Content-Type: multipart/related; boundary="' + boundary.slice(2) + '"',
        "",
        "",
        ""
      ];
      var root = cfb.FullPaths[0], fp = root, fi = cfb.FileIndex[0];
      for (var i2 = 1; i2 < cfb.FullPaths.length; ++i2) {
        fp = cfb.FullPaths[i2].slice(root.length);
        fi = cfb.FileIndex[i2];
        if (!fi.size || !fi.content || fp == "Sh33tJ5")
          continue;
        fp = fp.replace(/[\x00-\x08\x0B\x0C\x0E-\x1F\x7E-\xFF]/g, function(c) {
          return "_x" + c.charCodeAt(0).toString(16) + "_";
        }).replace(/[\u0080-\uFFFF]/g, function(u) {
          return "_u" + u.charCodeAt(0).toString(16) + "_";
        });
        var ca = fi.content;
        var cstr = has_buf && Buffer.isBuffer(ca) ? ca.toString("binary") : a2s2(ca);
        var dispcnt = 0, L = Math.min(1024, cstr.length), cc = 0;
        for (var csl = 0; csl <= L; ++csl)
          if ((cc = cstr.charCodeAt(csl)) >= 32 && cc < 128)
            ++dispcnt;
        var qp = dispcnt >= L * 4 / 5;
        out.push(boundary);
        out.push("Content-Location: " + (opts.root || "file:///C:/SheetJS/") + fp);
        out.push("Content-Transfer-Encoding: " + (qp ? "quoted-printable" : "base64"));
        out.push("Content-Type: " + get_content_type(fi, fp));
        out.push("");
        out.push(qp ? write_quoted_printable(cstr) : write_base64_76(cstr));
      }
      out.push(boundary + "--\r\n");
      return out.join("\r\n");
    }
    function cfb_new(opts) {
      var o = {};
      init_cfb(o, opts);
      return o;
    }
    function cfb_add(cfb, name, content, opts) {
      var unsafe = opts && opts.unsafe;
      if (!unsafe)
        init_cfb(cfb);
      var file = !unsafe && CFB.find(cfb, name);
      if (!file) {
        var fpath = cfb.FullPaths[0];
        if (name.slice(0, fpath.length) == fpath)
          fpath = name;
        else {
          if (fpath.slice(-1) != "/")
            fpath += "/";
          fpath = (fpath + name).replace("//", "/");
        }
        file = { name: filename(name), type: 2 };
        cfb.FileIndex.push(file);
        cfb.FullPaths.push(fpath);
        if (!unsafe)
          CFB.utils.cfb_gc(cfb);
      }
      file.content = content;
      file.size = content ? content.length : 0;
      if (opts) {
        if (opts.CLSID)
          file.clsid = opts.CLSID;
        if (opts.mt)
          file.mt = opts.mt;
        if (opts.ct)
          file.ct = opts.ct;
      }
      return file;
    }
    function cfb_del(cfb, name) {
      init_cfb(cfb);
      var file = CFB.find(cfb, name);
      if (file) {
        for (var j = 0; j < cfb.FileIndex.length; ++j)
          if (cfb.FileIndex[j] == file) {
            cfb.FileIndex.splice(j, 1);
            cfb.FullPaths.splice(j, 1);
            return true;
          }
      }
      return false;
    }
    function cfb_mov(cfb, old_name, new_name) {
      init_cfb(cfb);
      var file = CFB.find(cfb, old_name);
      if (file) {
        for (var j = 0; j < cfb.FileIndex.length; ++j)
          if (cfb.FileIndex[j] == file) {
            cfb.FileIndex[j].name = filename(new_name);
            cfb.FullPaths[j] = new_name;
            return true;
          }
      }
      return false;
    }
    function cfb_gc(cfb) {
      rebuild_cfb(cfb, true);
    }
    exports.find = find;
    exports.read = read;
    exports.parse = parse;
    exports.write = write;
    exports.writeFile = write_file;
    exports.utils = {
      cfb_new,
      cfb_add,
      cfb_del,
      cfb_mov,
      cfb_gc,
      ReadShift,
      CheckField,
      prep_blob,
      bconcat,
      use_zlib,
      _deflateRaw: _deflate,
      _inflateRaw: _inflate,
      consts
    };
    return exports;
  }();
  var _fs;
  function blobify(data) {
    if (typeof data === "string")
      return s2ab(data);
    if (Array.isArray(data))
      return a2u(data);
    return data;
  }
  function write_dl(fname, payload, enc) {
    if (typeof _fs !== "undefined" && _fs.writeFileSync)
      return enc ? _fs.writeFileSync(fname, payload, enc) : _fs.writeFileSync(fname, payload);
    if (typeof Deno !== "undefined") {
      if (enc && typeof payload == "string")
        switch (enc) {
          case "utf8":
            payload = new TextEncoder(enc).encode(payload);
            break;
          case "binary":
            payload = s2ab(payload);
            break;
          default:
            throw new Error("Unsupported encoding " + enc);
        }
      return Deno.writeFileSync(fname, payload);
    }
    var data = enc == "utf8" ? utf8write(payload) : payload;
    if (typeof IE_SaveFile !== "undefined")
      return IE_SaveFile(data, fname);
    if (typeof Blob !== "undefined") {
      var blob = new Blob([blobify(data)], { type: "application/octet-stream" });
      if (typeof navigator !== "undefined" && navigator.msSaveBlob)
        return navigator.msSaveBlob(blob, fname);
      if (typeof saveAs !== "undefined")
        return saveAs(blob, fname);
      if (typeof URL !== "undefined" && typeof document !== "undefined" && document.createElement && URL.createObjectURL) {
        var url = URL.createObjectURL(blob);
        if (typeof chrome === "object" && typeof (chrome.downloads || {}).download == "function") {
          if (URL.revokeObjectURL && typeof setTimeout !== "undefined")
            setTimeout(function() {
              URL.revokeObjectURL(url);
            }, 6e4);
          return chrome.downloads.download({ url, filename: fname, saveAs: true });
        }
        var a = document.createElement("a");
        if (a.download != null) {
          a.download = fname;
          a.href = url;
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          if (URL.revokeObjectURL && typeof setTimeout !== "undefined")
            setTimeout(function() {
              URL.revokeObjectURL(url);
            }, 6e4);
          return url;
        }
      } else if (typeof URL !== "undefined" && !URL.createObjectURL && typeof chrome === "object") {
        var b64 = "data:application/octet-stream;base64," + Base64_encode_arr(new Uint8Array(blobify(data)));
        return chrome.downloads.download({ url: b64, filename: fname, saveAs: true });
      }
    }
    if (typeof $ !== "undefined" && typeof File !== "undefined" && typeof Folder !== "undefined")
      try {
        var out = File(fname);
        out.open("w");
        out.encoding = "binary";
        if (Array.isArray(payload))
          payload = a2s(payload);
        out.write(payload);
        out.close();
        return payload;
      } catch (e) {
        if (!e.message || e.message.indexOf("onstruct") == -1)
          throw e;
      }
    throw new Error("cannot save file " + fname);
  }
  function keys(o) {
    var ks = Object.keys(o), o2 = [];
    for (var i = 0; i < ks.length; ++i)
      if (Object.prototype.hasOwnProperty.call(o, ks[i]))
        o2.push(ks[i]);
    return o2;
  }
  function evert(obj) {
    var o = [], K = keys(obj);
    for (var i = 0; i !== K.length; ++i)
      o[obj[K[i]]] = K[i];
    return o;
  }
  function evert_num(obj) {
    var o = [], K = keys(obj);
    for (var i = 0; i !== K.length; ++i)
      o[obj[K[i]]] = parseInt(K[i], 10);
    return o;
  }
  function evert_arr(obj) {
    var o = [], K = keys(obj);
    for (var i = 0; i !== K.length; ++i) {
      if (o[obj[K[i]]] == null)
        o[obj[K[i]]] = [];
      o[obj[K[i]]].push(K[i]);
    }
    return o;
  }
  var dnthresh = /* @__PURE__ */ Date.UTC(1899, 11, 30, 0, 0, 0);
  var dnthresh1 = /* @__PURE__ */ Date.UTC(1899, 11, 31, 0, 0, 0);
  var dnthresh2 = /* @__PURE__ */ Date.UTC(1904, 0, 1, 0, 0, 0);
  function datenum(v, date1904) {
    var epoch = /* @__PURE__ */ v.getTime();
    var res = (epoch - dnthresh) / (24 * 60 * 60 * 1e3);
    if (date1904) {
      res -= 1462;
      return res < -1402 ? res - 1 : res;
    }
    return res < 60 ? res - 1 : res;
  }
  function numdate(v) {
    if (v >= 60 && v < 61)
      return v;
    var out = /* @__PURE__ */ new Date();
    out.setTime((v > 60 ? v : v + 1) * 24 * 60 * 60 * 1e3 + dnthresh);
    return out;
  }
  var pdre1 = /^(\d+):(\d+)(:\d+)?(\.\d+)?$/;
  var pdre2 = /^(\d+)-(\d+)-(\d+)$/;
  var pdre3 = /^(\d+)-(\d+)-(\d+)[T ](\d+):(\d+)(:\d+)?(\.\d+)?$/;
  function parseDate(str, date1904) {
    if (str instanceof Date)
      return str;
    var m = str.match(pdre1);
    if (m)
      return new Date((date1904 ? dnthresh2 : dnthresh1) + ((parseInt(m[1], 10) * 60 + parseInt(m[2], 10)) * 60 + (m[3] ? parseInt(m[3].slice(1), 10) : 0)) * 1e3 + (m[4] ? parseInt((m[4] + "000").slice(1, 4), 10) : 0));
    m = str.match(pdre2);
    if (m)
      return new Date(Date.UTC(+m[1], +m[2] - 1, +m[3], 0, 0, 0, 0));
    m = str.match(pdre3);
    if (m)
      return new Date(Date.UTC(+m[1], +m[2] - 1, +m[3], +m[4], +m[5], m[6] && parseInt(m[6].slice(1), 10) || 0, m[7] && parseInt((m[7] + "0000").slice(1, 4), 10) || 0));
    var d = new Date(str);
    return d;
  }
  function dup(o) {
    if (typeof JSON != "undefined" && !Array.isArray(o))
      return JSON.parse(JSON.stringify(o));
    if (typeof o != "object" || o == null)
      return o;
    if (o instanceof Date)
      return new Date(o.getTime());
    var out = {};
    for (var k in o)
      if (Object.prototype.hasOwnProperty.call(o, k))
        out[k] = dup(o[k]);
    return out;
  }
  function fill(c, l) {
    var o = "";
    while (o.length < l)
      o += c;
    return o;
  }
  function fuzzynum(s) {
    var v = Number(s);
    if (!isNaN(v))
      return isFinite(v) ? v : NaN;
    if (!/\d/.test(s))
      return v;
    var wt = 1;
    var ss = s.replace(/([\d]),([\d])/g, "$1$2").replace(/[$]/g, "").replace(/[%]/g, function() {
      wt *= 100;
      return "";
    });
    if (!isNaN(v = Number(ss)))
      return v / wt;
    ss = ss.replace(/[(]([^()]*)[)]/, function($$, $1) {
      wt = -wt;
      return $1;
    });
    if (!isNaN(v = Number(ss)))
      return v / wt;
    return v;
  }
  var FDRE1 = /^(0?\d|1[0-2])(?:|:([0-5]?\d)(?:|(\.\d+)(?:|:([0-5]?\d))|:([0-5]?\d)(|\.\d+)))\s+([ap])m?$/;
  var FDRE2 = /^([01]?\d|2[0-3])(?:|:([0-5]?\d)(?:|(\.\d+)(?:|:([0-5]?\d))|:([0-5]?\d)(|\.\d+)))$/;
  var FDISO = /^(\d+)-(\d+)-(\d+)[T ](\d+):(\d+)(:\d+)(\.\d+)?[Z]?$/;
  var utc_append_works = (/* @__PURE__ */ new Date("6/9/69 00:00 UTC")).valueOf() == -177984e5;
  function fuzzytime1(M) {
    if (!M[2])
      return new Date(Date.UTC(1899, 11, 31, +M[1] % 12 + (M[7] == "p" ? 12 : 0), 0, 0, 0));
    if (M[3]) {
      if (M[4])
        return new Date(Date.UTC(1899, 11, 31, +M[1] % 12 + (M[7] == "p" ? 12 : 0), +M[2], +M[4], parseFloat(M[3]) * 1e3));
      else
        return new Date(Date.UTC(1899, 11, 31, M[7] == "p" ? 12 : 0, +M[1], +M[2], parseFloat(M[3]) * 1e3));
    } else if (M[5])
      return new Date(Date.UTC(1899, 11, 31, +M[1] % 12 + (M[7] == "p" ? 12 : 0), +M[2], +M[5], M[6] ? parseFloat(M[6]) * 1e3 : 0));
    else
      return new Date(Date.UTC(1899, 11, 31, +M[1] % 12 + (M[7] == "p" ? 12 : 0), +M[2], 0, 0));
  }
  function fuzzytime2(M) {
    if (!M[2])
      return new Date(Date.UTC(1899, 11, 31, +M[1], 0, 0, 0));
    if (M[3]) {
      if (M[4])
        return new Date(Date.UTC(1899, 11, 31, +M[1], +M[2], +M[4], parseFloat(M[3]) * 1e3));
      else
        return new Date(Date.UTC(1899, 11, 31, 0, +M[1], +M[2], parseFloat(M[3]) * 1e3));
    } else if (M[5])
      return new Date(Date.UTC(1899, 11, 31, +M[1], +M[2], +M[5], M[6] ? parseFloat(M[6]) * 1e3 : 0));
    else
      return new Date(Date.UTC(1899, 11, 31, +M[1], +M[2], 0, 0));
  }
  var lower_months = ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];
  function fuzzydate(s) {
    if (FDISO.test(s))
      return s.indexOf("Z") == -1 ? local_to_utc(new Date(s)) : new Date(s);
    var lower = s.toLowerCase();
    var lnos = lower.replace(/\s+/g, " ").trim();
    var M = lnos.match(FDRE1);
    if (M)
      return fuzzytime1(M);
    M = lnos.match(FDRE2);
    if (M)
      return fuzzytime2(M);
    M = lnos.match(pdre3);
    if (M)
      return new Date(Date.UTC(+M[1], +M[2] - 1, +M[3], +M[4], +M[5], M[6] && parseInt(M[6].slice(1), 10) || 0, M[7] && parseInt((M[7] + "0000").slice(1, 4), 10) || 0));
    var o = new Date(utc_append_works && s.indexOf("UTC") == -1 ? s + " UTC" : s), n = /* @__PURE__ */ new Date(NaN);
    var y = o.getYear(), m = o.getMonth(), d = o.getDate();
    if (isNaN(d))
      return n;
    if (lower.match(/jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec/)) {
      lower = lower.replace(/[^a-z]/g, "").replace(/([^a-z]|^)[ap]m?([^a-z]|$)/, "");
      if (lower.length > 3 && lower_months.indexOf(lower) == -1)
        return n;
    } else if (lower.replace(/[ap]m?/, "").match(/[a-z]/))
      return n;
    if (y < 0 || y > 8099 || s.match(/[^-0-9:,\/\\\ ]/))
      return n;
    return o;
  }
  function utc_to_local(utc) {
    return new Date(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate(), utc.getUTCHours(), utc.getUTCMinutes(), utc.getUTCSeconds(), utc.getUTCMilliseconds());
  }
  function local_to_utc(local) {
    return new Date(Date.UTC(local.getFullYear(), local.getMonth(), local.getDate(), local.getHours(), local.getMinutes(), local.getSeconds(), local.getMilliseconds()));
  }
  function zip_add_file(zip, path, content) {
    if (zip.FullPaths) {
      if (Array.isArray(content) && typeof content[0] == "string") {
        content = content.join("");
      }
      if (typeof content == "string") {
        var res;
        if (has_buf)
          res = Buffer_from(content);
        else
          res = utf8decode(content);
        return CFB.utils.cfb_add(zip, path, res);
      }
      CFB.utils.cfb_add(zip, path, content);
    } else
      zip.file(path, content);
  }
  function zip_new() {
    return CFB.utils.cfb_new();
  }
  var XML_HEADER = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>\r\n';
  var encodings = {
    "&quot;": '"',
    "&apos;": "'",
    "&gt;": ">",
    "&lt;": "<",
    "&amp;": "&"
  };
  var rencoding = /* @__PURE__ */ evert(encodings);
  var decregex = /[&<>'"]/g;
  var charegex = /[\u0000-\u0008\u000b-\u001f\uFFFE-\uFFFF]/g;
  function escapexml(text) {
    var s = text + "";
    return s.replace(decregex, function(y) {
      return rencoding[y];
    }).replace(charegex, function(s2) {
      return "_x" + ("000" + s2.charCodeAt(0).toString(16)).slice(-4) + "_";
    });
  }
  var htmlcharegex = /[\u0000-\u001f]/g;
  function escapehtml(text) {
    var s = text + "";
    return s.replace(decregex, function(y) {
      return rencoding[y];
    }).replace(/\n/g, "<br/>").replace(htmlcharegex, function(s2) {
      return "&#x" + ("000" + s2.charCodeAt(0).toString(16)).slice(-4) + ";";
    });
  }
  function utf8reada(orig) {
    var out = "", i = 0, c = 0, d = 0, e = 0, f = 0, w = 0;
    while (i < orig.length) {
      c = orig.charCodeAt(i++);
      if (c < 128) {
        out += String.fromCharCode(c);
        continue;
      }
      d = orig.charCodeAt(i++);
      if (c > 191 && c < 224) {
        f = (c & 31) << 6;
        f |= d & 63;
        out += String.fromCharCode(f);
        continue;
      }
      e = orig.charCodeAt(i++);
      if (c < 240) {
        out += String.fromCharCode((c & 15) << 12 | (d & 63) << 6 | e & 63);
        continue;
      }
      f = orig.charCodeAt(i++);
      w = ((c & 7) << 18 | (d & 63) << 12 | (e & 63) << 6 | f & 63) - 65536;
      out += String.fromCharCode(55296 + (w >>> 10 & 1023));
      out += String.fromCharCode(56320 + (w & 1023));
    }
    return out;
  }
  function utf8readb(data) {
    var out = new_raw_buf(2 * data.length), w, i, j = 1, k = 0, ww = 0, c;
    for (i = 0; i < data.length; i += j) {
      j = 1;
      if ((c = data.charCodeAt(i)) < 128)
        w = c;
      else if (c < 224) {
        w = (c & 31) * 64 + (data.charCodeAt(i + 1) & 63);
        j = 2;
      } else if (c < 240) {
        w = (c & 15) * 4096 + (data.charCodeAt(i + 1) & 63) * 64 + (data.charCodeAt(i + 2) & 63);
        j = 3;
      } else {
        j = 4;
        w = (c & 7) * 262144 + (data.charCodeAt(i + 1) & 63) * 4096 + (data.charCodeAt(i + 2) & 63) * 64 + (data.charCodeAt(i + 3) & 63);
        w -= 65536;
        ww = 55296 + (w >>> 10 & 1023);
        w = 56320 + (w & 1023);
      }
      if (ww !== 0) {
        out[k++] = ww & 255;
        out[k++] = ww >>> 8;
        ww = 0;
      }
      out[k++] = w % 256;
      out[k++] = w >>> 8;
    }
    return out.slice(0, k).toString("ucs2");
  }
  function utf8readc(data) {
    return Buffer_from(data, "binary").toString("utf8");
  }
  var utf8corpus = "foo bar baz\xE2\x98\x83\xF0\x9F\x8D\xA3";
  var utf8read = has_buf && (/* @__PURE__ */ utf8readc(utf8corpus) == /* @__PURE__ */ utf8reada(utf8corpus) && utf8readc || /* @__PURE__ */ utf8readb(utf8corpus) == /* @__PURE__ */ utf8reada(utf8corpus) && utf8readb) || utf8reada;
  var utf8write = has_buf ? function(data) {
    return Buffer_from(data, "utf8").toString("binary");
  } : function(orig) {
    var out = [], i = 0, c = 0, d = 0;
    while (i < orig.length) {
      c = orig.charCodeAt(i++);
      switch (true) {
        case c < 128:
          out.push(String.fromCharCode(c));
          break;
        case c < 2048:
          out.push(String.fromCharCode(192 + (c >> 6)));
          out.push(String.fromCharCode(128 + (c & 63)));
          break;
        case (c >= 55296 && c < 57344):
          c -= 55296;
          d = orig.charCodeAt(i++) - 56320 + (c << 10);
          out.push(String.fromCharCode(240 + (d >> 18 & 7)));
          out.push(String.fromCharCode(144 + (d >> 12 & 63)));
          out.push(String.fromCharCode(128 + (d >> 6 & 63)));
          out.push(String.fromCharCode(128 + (d & 63)));
          break;
        default:
          out.push(String.fromCharCode(224 + (c >> 12)));
          out.push(String.fromCharCode(128 + (c >> 6 & 63)));
          out.push(String.fromCharCode(128 + (c & 63)));
      }
    }
    return out.join("");
  };
  var htmldecode = /* @__PURE__ */ function() {
    var entities = [
      ["nbsp", " "],
      ["middot", "\xB7"],
      ["quot", '"'],
      ["apos", "'"],
      ["gt", ">"],
      ["lt", "<"],
      ["amp", "&"]
    ].map(function(x) {
      return [new RegExp("&" + x[0] + ";", "ig"), x[1]];
    });
    return function htmldecode2(str) {
      var o = str.replace(/^[\t\n\r ]+/, "").replace(/(^|[^\t\n\r ])[\t\n\r ]+$/, "$1").replace(/>\s+/g, ">").replace(/\b\s+</g, "<").replace(/[\t\n\r ]+/g, " ").replace(/<\s*[bB][rR]\s*\/?>/g, "\n").replace(/<[^<>]*>/g, "");
      for (var i = 0; i < entities.length; ++i)
        o = o.replace(entities[i][0], entities[i][1]);
      return o;
    };
  }();
  var wtregex = /(^\s|\s$|\n)/;
  function writetag(f, g) {
    return "<" + f + (g.match(wtregex) ? ' xml:space="preserve"' : "") + ">" + g + "</" + f + ">";
  }
  function wxt_helper(h) {
    return keys(h).map(function(k) {
      return " " + k + '="' + h[k] + '"';
    }).join("");
  }
  function writextag(f, g, h) {
    return "<" + f + (h != null ? wxt_helper(h) : "") + (g != null ? (g.match(wtregex) ? ' xml:space="preserve"' : "") + ">" + g + "</" + f : "/") + ">";
  }
  function write_w3cdtf(d, t) {
    try {
      return d.toISOString().replace(/\.\d*/, "");
    } catch (e) {
      if (t)
        throw e;
    }
    return "";
  }
  function write_vt(s, xlsx) {
    switch (typeof s) {
      case "string":
        var o = writextag("vt:lpwstr", escapexml(s));
        if (xlsx)
          o = o.replace(/&quot;/g, "_x0022_");
        return o;
      case "number":
        return writextag((s | 0) == s ? "vt:i4" : "vt:r8", escapexml(String(s)));
      case "boolean":
        return writextag("vt:bool", s ? "true" : "false");
    }
    if (s instanceof Date)
      return writextag("vt:filetime", write_w3cdtf(s));
    throw new Error("Unable to serialize " + s);
  }
  var XMLNS = {
    CORE_PROPS: "http://schemas.openxmlformats.org/package/2006/metadata/core-properties",
    CUST_PROPS: "http://schemas.openxmlformats.org/officeDocument/2006/custom-properties",
    EXT_PROPS: "http://schemas.openxmlformats.org/officeDocument/2006/extended-properties",
    CT: "http://schemas.openxmlformats.org/package/2006/content-types",
    RELS: "http://schemas.openxmlformats.org/package/2006/relationships",
    TCMNT: "http://schemas.microsoft.com/office/spreadsheetml/2018/threadedcomments",
    "dc": "http://purl.org/dc/elements/1.1/",
    "dcterms": "http://purl.org/dc/terms/",
    "dcmitype": "http://purl.org/dc/dcmitype/",
    "mx": "http://schemas.microsoft.com/office/mac/excel/2008/main",
    "r": "http://schemas.openxmlformats.org/officeDocument/2006/relationships",
    "sjs": "http://schemas.openxmlformats.org/package/2006/sheetjs/core-properties",
    "vt": "http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes",
    "xsi": "http://www.w3.org/2001/XMLSchema-instance",
    "xsd": "http://www.w3.org/2001/XMLSchema"
  };
  var XMLNS_main = [
    "http://schemas.openxmlformats.org/spreadsheetml/2006/main",
    "http://purl.oclc.org/ooxml/spreadsheetml/main",
    "http://schemas.microsoft.com/office/excel/2006/main",
    "http://schemas.microsoft.com/office/excel/2006/2"
  ];
  var XLMLNS = {
    "o": "urn:schemas-microsoft-com:office:office",
    "x": "urn:schemas-microsoft-com:office:excel",
    "ss": "urn:schemas-microsoft-com:office:spreadsheet",
    "dt": "uuid:C2F41010-65B3-11d1-A29F-00AA00C14882",
    "mv": "http://macVmlSchemaUri",
    "v": "urn:schemas-microsoft-com:vml",
    "html": "http://www.w3.org/TR/REC-html40"
  };
  function read_double_le(b, idx) {
    var s = 1 - 2 * (b[idx + 7] >>> 7);
    var e = ((b[idx + 7] & 127) << 4) + (b[idx + 6] >>> 4 & 15);
    var m = b[idx + 6] & 15;
    for (var i = 5; i >= 0; --i)
      m = m * 256 + b[idx + i];
    if (e == 2047)
      return m == 0 ? s * Infinity : NaN;
    if (e == 0)
      e = -1022;
    else {
      e -= 1023;
      m += Math.pow(2, 52);
    }
    return s * Math.pow(2, e - 52) * m;
  }
  function write_double_le(b, v, idx) {
    var bs = (v < 0 || 1 / v == -Infinity ? 1 : 0) << 7, e = 0, m = 0;
    var av = bs ? -v : v;
    if (!isFinite(av)) {
      e = 2047;
      m = isNaN(v) ? 26985 : 0;
    } else if (av == 0)
      e = m = 0;
    else {
      e = Math.floor(Math.log(av) / Math.LN2);
      m = av * Math.pow(2, 52 - e);
      if (e <= -1023 && (!isFinite(m) || m < Math.pow(2, 52))) {
        e = -1022;
      } else {
        m -= Math.pow(2, 52);
        e += 1023;
      }
    }
    for (var i = 0; i <= 5; ++i, m /= 256)
      b[idx + i] = m & 255;
    b[idx + 6] = (e & 15) << 4 | m & 15;
    b[idx + 7] = e >> 4 | bs;
  }
  var ___toBuffer = function(bufs) {
    var x = [], w = 10240;
    for (var i = 0; i < bufs[0].length; ++i)
      if (bufs[0][i])
        for (var j = 0, L = bufs[0][i].length; j < L; j += w)
          x.push.apply(x, bufs[0][i].slice(j, j + w));
    return x;
  };
  var __toBuffer = has_buf ? function(bufs) {
    return bufs[0].length > 0 && Buffer.isBuffer(bufs[0][0]) ? Buffer.concat(bufs[0].map(function(x) {
      return Buffer.isBuffer(x) ? x : Buffer_from(x);
    })) : ___toBuffer(bufs);
  } : ___toBuffer;
  var ___utf16le = function(b, s, e) {
    var ss = [];
    for (var i = s; i < e; i += 2)
      ss.push(String.fromCharCode(__readUInt16LE(b, i)));
    return ss.join("").replace(chr0, "");
  };
  var __utf16le = has_buf ? function(b, s, e) {
    if (!Buffer.isBuffer(b) || !buf_utf16le)
      return ___utf16le(b, s, e);
    return b.toString("utf16le", s, e).replace(chr0, "");
  } : ___utf16le;
  var ___hexlify = function(b, s, l) {
    var ss = [];
    for (var i = s; i < s + l; ++i)
      ss.push(("0" + b[i].toString(16)).slice(-2));
    return ss.join("");
  };
  var __hexlify = has_buf ? function(b, s, l) {
    return Buffer.isBuffer(b) ? b.toString("hex", s, s + l) : ___hexlify(b, s, l);
  } : ___hexlify;
  var ___utf8 = function(b, s, e) {
    var ss = [];
    for (var i = s; i < e; i++)
      ss.push(String.fromCharCode(__readUInt8(b, i)));
    return ss.join("");
  };
  var __utf8 = has_buf ? function utf8_b(b, s, e) {
    return Buffer.isBuffer(b) ? b.toString("utf8", s, e) : ___utf8(b, s, e);
  } : ___utf8;
  var ___lpstr = function(b, i) {
    var len = __readUInt32LE(b, i);
    return len > 0 ? __utf8(b, i + 4, i + 4 + len - 1) : "";
  };
  var __lpstr = ___lpstr;
  var ___cpstr = function(b, i) {
    var len = __readUInt32LE(b, i);
    return len > 0 ? __utf8(b, i + 4, i + 4 + len - 1) : "";
  };
  var __cpstr = ___cpstr;
  var ___lpwstr = function(b, i) {
    var len = 2 * __readUInt32LE(b, i);
    return len > 0 ? __utf8(b, i + 4, i + 4 + len - 1) : "";
  };
  var __lpwstr = ___lpwstr;
  var ___lpp4 = function lpp4_(b, i) {
    var len = __readUInt32LE(b, i);
    return len > 0 ? __utf16le(b, i + 4, i + 4 + len) : "";
  };
  var __lpp4 = ___lpp4;
  var ___8lpp4 = function(b, i) {
    var len = __readUInt32LE(b, i);
    return len > 0 ? __utf8(b, i + 4, i + 4 + len) : "";
  };
  var __8lpp4 = ___8lpp4;
  var ___double = function(b, idx) {
    return read_double_le(b, idx);
  };
  var __double = ___double;
  var is_buf = function is_buf_a(a) {
    return Array.isArray(a) || typeof Uint8Array !== "undefined" && a instanceof Uint8Array;
  };
  if (has_buf) {
    __lpstr = function lpstr_b(b, i) {
      if (!Buffer.isBuffer(b))
        return ___lpstr(b, i);
      var len = b.readUInt32LE(i);
      return len > 0 ? b.toString("utf8", i + 4, i + 4 + len - 1) : "";
    };
    __cpstr = function cpstr_b(b, i) {
      if (!Buffer.isBuffer(b))
        return ___cpstr(b, i);
      var len = b.readUInt32LE(i);
      return len > 0 ? b.toString("utf8", i + 4, i + 4 + len - 1) : "";
    };
    __lpwstr = function lpwstr_b(b, i) {
      if (!Buffer.isBuffer(b) || !buf_utf16le)
        return ___lpwstr(b, i);
      var len = 2 * b.readUInt32LE(i);
      return b.toString("utf16le", i + 4, i + 4 + len - 1);
    };
    __lpp4 = function lpp4_b(b, i) {
      if (!Buffer.isBuffer(b) || !buf_utf16le)
        return ___lpp4(b, i);
      var len = b.readUInt32LE(i);
      return b.toString("utf16le", i + 4, i + 4 + len);
    };
    __8lpp4 = function lpp4_8b(b, i) {
      if (!Buffer.isBuffer(b))
        return ___8lpp4(b, i);
      var len = b.readUInt32LE(i);
      return b.toString("utf8", i + 4, i + 4 + len);
    };
    __double = function double_(b, i) {
      if (Buffer.isBuffer(b))
        return b.readDoubleLE(i);
      return ___double(b, i);
    };
    is_buf = function is_buf_b(a) {
      return Buffer.isBuffer(a) || Array.isArray(a) || typeof Uint8Array !== "undefined" && a instanceof Uint8Array;
    };
  }
  function cpdoit() {
    __utf16le = function(b, s, e) {
      return $cptable.utils.decode(1200, b.slice(s, e)).replace(chr0, "");
    };
    __utf8 = function(b, s, e) {
      return $cptable.utils.decode(65001, b.slice(s, e));
    };
    __lpstr = function(b, i) {
      var len = __readUInt32LE(b, i);
      return len > 0 ? $cptable.utils.decode(current_ansi, b.slice(i + 4, i + 4 + len - 1)) : "";
    };
    __cpstr = function(b, i) {
      var len = __readUInt32LE(b, i);
      return len > 0 ? $cptable.utils.decode(current_codepage, b.slice(i + 4, i + 4 + len - 1)) : "";
    };
    __lpwstr = function(b, i) {
      var len = 2 * __readUInt32LE(b, i);
      return len > 0 ? $cptable.utils.decode(1200, b.slice(i + 4, i + 4 + len - 1)) : "";
    };
    __lpp4 = function(b, i) {
      var len = __readUInt32LE(b, i);
      return len > 0 ? $cptable.utils.decode(1200, b.slice(i + 4, i + 4 + len)) : "";
    };
    __8lpp4 = function(b, i) {
      var len = __readUInt32LE(b, i);
      return len > 0 ? $cptable.utils.decode(65001, b.slice(i + 4, i + 4 + len)) : "";
    };
  }
  if (typeof $cptable !== "undefined")
    cpdoit();
  var __readUInt8 = function(b, idx) {
    return b[idx];
  };
  var __readUInt16LE = function(b, idx) {
    return b[idx + 1] * (1 << 8) + b[idx];
  };
  var __readInt16LE = function(b, idx) {
    var u = b[idx + 1] * (1 << 8) + b[idx];
    return u < 32768 ? u : (65535 - u + 1) * -1;
  };
  var __readUInt32LE = function(b, idx) {
    return b[idx + 3] * (1 << 24) + (b[idx + 2] << 16) + (b[idx + 1] << 8) + b[idx];
  };
  var __readInt32LE = function(b, idx) {
    return b[idx + 3] << 24 | b[idx + 2] << 16 | b[idx + 1] << 8 | b[idx];
  };
  var __readInt32BE = function(b, idx) {
    return b[idx] << 24 | b[idx + 1] << 16 | b[idx + 2] << 8 | b[idx + 3];
  };
  function ReadShift(size, t) {
    var o = "", oI, oR, oo = [], w, vv, i, loc;
    switch (t) {
      case "dbcs":
        loc = this.l;
        if (has_buf && Buffer.isBuffer(this) && buf_utf16le)
          o = this.slice(this.l, this.l + 2 * size).toString("utf16le");
        else
          for (i = 0; i < size; ++i) {
            o += String.fromCharCode(__readUInt16LE(this, loc));
            loc += 2;
          }
        size *= 2;
        break;
      case "utf8":
        o = __utf8(this, this.l, this.l + size);
        break;
      case "utf16le":
        size *= 2;
        o = __utf16le(this, this.l, this.l + size);
        break;
      case "wstr":
        if (typeof $cptable !== "undefined")
          o = $cptable.utils.decode(current_codepage, this.slice(this.l, this.l + 2 * size));
        else
          return ReadShift.call(this, size, "dbcs");
        size = 2 * size;
        break;
      case "lpstr-ansi":
        o = __lpstr(this, this.l);
        size = 4 + __readUInt32LE(this, this.l);
        break;
      case "lpstr-cp":
        o = __cpstr(this, this.l);
        size = 4 + __readUInt32LE(this, this.l);
        break;
      case "lpwstr":
        o = __lpwstr(this, this.l);
        size = 4 + 2 * __readUInt32LE(this, this.l);
        break;
      case "lpp4":
        size = 4 + __readUInt32LE(this, this.l);
        o = __lpp4(this, this.l);
        if (size & 2)
          size += 2;
        break;
      case "8lpp4":
        size = 4 + __readUInt32LE(this, this.l);
        o = __8lpp4(this, this.l);
        if (size & 3)
          size += 4 - (size & 3);
        break;
      case "cstr":
        size = 0;
        o = "";
        while ((w = __readUInt8(this, this.l + size++)) !== 0)
          oo.push(_getchar(w));
        o = oo.join("");
        break;
      case "_wstr":
        size = 0;
        o = "";
        while ((w = __readUInt16LE(this, this.l + size)) !== 0) {
          oo.push(_getchar(w));
          size += 2;
        }
        size += 2;
        o = oo.join("");
        break;
      case "dbcs-cont":
        o = "";
        loc = this.l;
        for (i = 0; i < size; ++i) {
          if (this.lens && this.lens.indexOf(loc) !== -1) {
            w = __readUInt8(this, loc);
            this.l = loc + 1;
            vv = ReadShift.call(this, size - i, w ? "dbcs-cont" : "sbcs-cont");
            return oo.join("") + vv;
          }
          oo.push(_getchar(__readUInt16LE(this, loc)));
          loc += 2;
        }
        o = oo.join("");
        size *= 2;
        break;
      case "cpstr":
        if (typeof $cptable !== "undefined") {
          o = $cptable.utils.decode(current_codepage, this.slice(this.l, this.l + size));
          break;
        }
      case "sbcs-cont":
        o = "";
        loc = this.l;
        for (i = 0; i != size; ++i) {
          if (this.lens && this.lens.indexOf(loc) !== -1) {
            w = __readUInt8(this, loc);
            this.l = loc + 1;
            vv = ReadShift.call(this, size - i, w ? "dbcs-cont" : "sbcs-cont");
            return oo.join("") + vv;
          }
          oo.push(_getchar(__readUInt8(this, loc)));
          loc += 1;
        }
        o = oo.join("");
        break;
      default:
        switch (size) {
          case 1:
            oI = __readUInt8(this, this.l);
            this.l++;
            return oI;
          case 2:
            oI = (t === "i" ? __readInt16LE : __readUInt16LE)(this, this.l);
            this.l += 2;
            return oI;
          case 4:
          case -4:
            if (t === "i" || (this[this.l + 3] & 128) === 0) {
              oI = (size > 0 ? __readInt32LE : __readInt32BE)(this, this.l);
              this.l += 4;
              return oI;
            } else {
              oR = __readUInt32LE(this, this.l);
              this.l += 4;
            }
            return oR;
          case 8:
          case -8:
            if (t === "f") {
              if (size == 8)
                oR = __double(this, this.l);
              else
                oR = __double([this[this.l + 7], this[this.l + 6], this[this.l + 5], this[this.l + 4], this[this.l + 3], this[this.l + 2], this[this.l + 1], this[this.l + 0]], 0);
              this.l += 8;
              return oR;
            } else
              size = 8;
          case 16:
            o = __hexlify(this, this.l, size);
            break;
        }
    }
    this.l += size;
    return o;
  }
  var __writeUInt32LE = function(b, val2, idx) {
    b[idx] = val2 & 255;
    b[idx + 1] = val2 >>> 8 & 255;
    b[idx + 2] = val2 >>> 16 & 255;
    b[idx + 3] = val2 >>> 24 & 255;
  };
  var __writeInt32LE = function(b, val2, idx) {
    b[idx] = val2 & 255;
    b[idx + 1] = val2 >> 8 & 255;
    b[idx + 2] = val2 >> 16 & 255;
    b[idx + 3] = val2 >> 24 & 255;
  };
  var __writeUInt16LE = function(b, val2, idx) {
    b[idx] = val2 & 255;
    b[idx + 1] = val2 >>> 8 & 255;
  };
  function WriteShift(t, val2, f) {
    var size = 0, i = 0;
    if (f === "dbcs") {
      for (i = 0; i != val2.length; ++i)
        __writeUInt16LE(this, val2.charCodeAt(i), this.l + 2 * i);
      size = 2 * val2.length;
    } else if (f === "sbcs" || f == "cpstr") {
      if (typeof $cptable !== "undefined" && current_ansi == 874) {
        for (i = 0; i != val2.length; ++i) {
          var cpp = $cptable.utils.encode(current_ansi, val2.charAt(i));
          this[this.l + i] = cpp[0];
        }
        size = val2.length;
      } else if (typeof $cptable !== "undefined" && f == "cpstr") {
        cpp = $cptable.utils.encode(current_codepage, val2);
        if (cpp.length == val2.length) {
          for (i = 0; i < val2.length; ++i)
            if (cpp[i] == 0 && val2.charCodeAt(i) != 0)
              cpp[i] = 95;
        }
        if (cpp.length == 2 * val2.length) {
          for (i = 0; i < val2.length; ++i)
            if (cpp[2 * i] == 0 && cpp[2 * i + 1] == 0 && val2.charCodeAt(i) != 0)
              cpp[2 * i] = 95;
        }
        for (i = 0; i < cpp.length; ++i)
          this[this.l + i] = cpp[i];
        size = cpp.length;
      } else {
        val2 = val2.replace(/[^\x00-\x7F]/g, "_");
        for (i = 0; i != val2.length; ++i)
          this[this.l + i] = val2.charCodeAt(i) & 255;
        size = val2.length;
      }
    } else if (f === "hex") {
      for (; i < t; ++i) {
        this[this.l++] = parseInt(val2.slice(2 * i, 2 * i + 2), 16) || 0;
      }
      return this;
    } else if (f === "utf16le") {
      var end = Math.min(this.l + t, this.length);
      for (i = 0; i < Math.min(val2.length, t); ++i) {
        var cc = val2.charCodeAt(i);
        this[this.l++] = cc & 255;
        this[this.l++] = cc >> 8;
      }
      while (this.l < end)
        this[this.l++] = 0;
      return this;
    } else
      switch (t) {
        case 1:
          size = 1;
          this[this.l] = val2 & 255;
          break;
        case 2:
          size = 2;
          this[this.l] = val2 & 255;
          val2 >>>= 8;
          this[this.l + 1] = val2 & 255;
          break;
        case 3:
          size = 3;
          this[this.l] = val2 & 255;
          val2 >>>= 8;
          this[this.l + 1] = val2 & 255;
          val2 >>>= 8;
          this[this.l + 2] = val2 & 255;
          break;
        case 4:
          size = 4;
          __writeUInt32LE(this, val2, this.l);
          break;
        case 8:
          size = 8;
          if (f === "f") {
            write_double_le(this, val2, this.l);
            break;
          }
        case 16:
          break;
        case -4:
          size = 4;
          __writeInt32LE(this, val2, this.l);
          break;
      }
    this.l += size;
    return this;
  }
  function CheckField(hexstr, fld) {
    var m = __hexlify(this, this.l, hexstr.length >> 1);
    if (m !== hexstr)
      throw new Error(fld + "Expected " + hexstr + " saw " + m);
    this.l += hexstr.length >> 1;
  }
  function prep_blob(blob, pos) {
    blob.l = pos;
    blob.read_shift = /*::(*/
    ReadShift;
    blob.chk = CheckField;
    blob.write_shift = WriteShift;
  }
  function new_buf(sz) {
    var o = new_raw_buf(sz);
    prep_blob(o, 0);
    return o;
  }
  function decode_row(rowstr) {
    return parseInt(unfix_row(rowstr), 10) - 1;
  }
  function encode_row(row) {
    return "" + (row + 1);
  }
  function unfix_row(cstr) {
    return cstr.replace(/\$(\d+)$/, "$1");
  }
  function decode_col(colstr) {
    var c = unfix_col(colstr), d = 0, i = 0;
    for (; i !== c.length; ++i)
      d = 26 * d + c.charCodeAt(i) - 64;
    return d - 1;
  }
  function encode_col(col) {
    if (col < 0)
      throw new Error("invalid column " + col);
    var s = "";
    for (++col; col; col = Math.floor((col - 1) / 26))
      s = String.fromCharCode((col - 1) % 26 + 65) + s;
    return s;
  }
  function unfix_col(cstr) {
    return cstr.replace(/^\$([A-Z])/, "$1");
  }
  function split_cell(cstr) {
    return cstr.replace(/(\$?[A-Z]*)(\$?\d*)/, "$1,$2").split(",");
  }
  function decode_cell(cstr) {
    var R = 0, C = 0;
    for (var i = 0; i < cstr.length; ++i) {
      var cc = cstr.charCodeAt(i);
      if (cc >= 48 && cc <= 57)
        R = 10 * R + (cc - 48);
      else if (cc >= 65 && cc <= 90)
        C = 26 * C + (cc - 64);
    }
    return { c: C - 1, r: R - 1 };
  }
  function encode_cell(cell) {
    var col = cell.c + 1;
    var s = "";
    for (; col; col = (col - 1) / 26 | 0)
      s = String.fromCharCode((col - 1) % 26 + 65) + s;
    return s + (cell.r + 1);
  }
  function decode_range(range) {
    var idx = range.indexOf(":");
    if (idx == -1)
      return { s: decode_cell(range), e: decode_cell(range) };
    return { s: decode_cell(range.slice(0, idx)), e: decode_cell(range.slice(idx + 1)) };
  }
  function encode_range(cs, ce) {
    if (typeof ce === "undefined" || typeof ce === "number") {
      return encode_range(cs.s, cs.e);
    }
    if (typeof cs !== "string")
      cs = encode_cell(cs);
    if (typeof ce !== "string")
      ce = encode_cell(ce);
    return cs == ce ? cs : cs + ":" + ce;
  }
  function fix_range(a1) {
    var s = decode_range(a1);
    return "$" + encode_col(s.s.c) + "$" + encode_row(s.s.r) + ":$" + encode_col(s.e.c) + "$" + encode_row(s.e.r);
  }
  function formula_quote_sheet_name(sname, opts) {
    if (!sname && !(opts && opts.biff <= 5 && opts.biff >= 2))
      throw new Error("empty sheet name");
    if (/[^\w\u4E00-\u9FFF\u3040-\u30FF]/.test(sname))
      return "'" + sname.replace(/'/g, "''") + "'";
    return sname;
  }
  function safe_decode_range(range) {
    var o = { s: { c: 0, r: 0 }, e: { c: 0, r: 0 } };
    var idx = 0, i = 0, cc = 0;
    var len = range.length;
    for (idx = 0; i < len; ++i) {
      if ((cc = range.charCodeAt(i) - 64) < 1 || cc > 26)
        break;
      idx = 26 * idx + cc;
    }
    o.s.c = --idx;
    for (idx = 0; i < len; ++i) {
      if ((cc = range.charCodeAt(i) - 48) < 0 || cc > 9)
        break;
      idx = 10 * idx + cc;
    }
    o.s.r = --idx;
    if (i === len || cc != 10) {
      o.e.c = o.s.c;
      o.e.r = o.s.r;
      return o;
    }
    ++i;
    for (idx = 0; i != len; ++i) {
      if ((cc = range.charCodeAt(i) - 64) < 1 || cc > 26)
        break;
      idx = 26 * idx + cc;
    }
    o.e.c = --idx;
    for (idx = 0; i != len; ++i) {
      if ((cc = range.charCodeAt(i) - 48) < 0 || cc > 9)
        break;
      idx = 10 * idx + cc;
    }
    o.e.r = --idx;
    return o;
  }
  function safe_format_cell(cell, v) {
    var q = cell.t == "d" && v instanceof Date;
    if (cell.z != null)
      try {
        return cell.w = SSF_format(cell.z, q ? datenum(v) : v);
      } catch (e) {
      }
    try {
      return cell.w = SSF_format((cell.XF || {}).numFmtId || (q ? 14 : 0), q ? datenum(v) : v);
    } catch (e) {
      return "" + v;
    }
  }
  function format_cell(cell, v, o) {
    if (cell == null || cell.t == null || cell.t == "z")
      return "";
    if (cell.w !== void 0)
      return cell.w;
    if (cell.t == "d" && !cell.z && o && o.dateNF)
      cell.z = o.dateNF;
    if (cell.t == "e")
      return BErr[cell.v] || cell.v;
    if (v == void 0)
      return safe_format_cell(cell, cell.v);
    return safe_format_cell(cell, v);
  }
  function sheet_to_workbook(sheet, opts) {
    var n = opts && opts.sheet ? opts.sheet : "Sheet1";
    var sheets = {};
    sheets[n] = sheet;
    return { SheetNames: [n], Sheets: sheets };
  }
  function sheet_new(opts) {
    var out = {};
    var o = opts || {};
    if (o.dense)
      out["!data"] = [];
    return out;
  }
  function sheet_add_aoa(_ws, data, opts) {
    var o = opts || {};
    var dense = _ws ? _ws["!data"] != null : o.dense;
    if (DENSE != null && dense == null)
      dense = DENSE;
    var ws = _ws || (dense ? { "!data": [] } : {});
    if (dense && !ws["!data"])
      ws["!data"] = [];
    var _R = 0, _C = 0;
    if (ws && o.origin != null) {
      if (typeof o.origin == "number")
        _R = o.origin;
      else {
        var _origin = typeof o.origin == "string" ? decode_cell(o.origin) : o.origin;
        _R = _origin.r;
        _C = _origin.c;
      }
    }
    var range = { s: { c: 1e7, r: 1e7 }, e: { c: 0, r: 0 } };
    if (ws["!ref"]) {
      var _range = safe_decode_range(ws["!ref"]);
      range.s.c = _range.s.c;
      range.s.r = _range.s.r;
      range.e.c = Math.max(range.e.c, _range.e.c);
      range.e.r = Math.max(range.e.r, _range.e.r);
      if (_R == -1)
        range.e.r = _R = ws["!ref"] ? _range.e.r + 1 : 0;
    } else {
      range.s.c = range.e.c = range.s.r = range.e.r = 0;
    }
    var row = [], seen = false;
    for (var R = 0; R != data.length; ++R) {
      if (!data[R])
        continue;
      if (!Array.isArray(data[R]))
        throw new Error("aoa_to_sheet expects an array of arrays");
      var __R = _R + R;
      if (dense) {
        if (!ws["!data"][__R])
          ws["!data"][__R] = [];
        row = ws["!data"][__R];
      }
      var data_R = data[R];
      for (var C = 0; C != data_R.length; ++C) {
        if (typeof data_R[C] === "undefined")
          continue;
        var cell = { v: data_R[C], t: "" };
        var __C = _C + C;
        if (range.s.r > __R)
          range.s.r = __R;
        if (range.s.c > __C)
          range.s.c = __C;
        if (range.e.r < __R)
          range.e.r = __R;
        if (range.e.c < __C)
          range.e.c = __C;
        seen = true;
        if (data_R[C] && typeof data_R[C] === "object" && !Array.isArray(data_R[C]) && !(data_R[C] instanceof Date))
          cell = data_R[C];
        else {
          if (Array.isArray(cell.v)) {
            cell.f = data_R[C][1];
            cell.v = cell.v[0];
          }
          if (cell.v === null) {
            if (cell.f)
              cell.t = "n";
            else if (o.nullError) {
              cell.t = "e";
              cell.v = 0;
            } else if (!o.sheetStubs)
              continue;
            else
              cell.t = "z";
          } else if (typeof cell.v === "number") {
            if (isFinite(cell.v))
              cell.t = "n";
            else if (isNaN(cell.v)) {
              cell.t = "e";
              cell.v = 15;
            } else {
              cell.t = "e";
              cell.v = 7;
            }
          } else if (typeof cell.v === "boolean")
            cell.t = "b";
          else if (cell.v instanceof Date) {
            cell.z = o.dateNF || table_fmt[14];
            if (!o.UTC)
              cell.v = local_to_utc(cell.v);
            if (o.cellDates) {
              cell.t = "d";
              cell.w = SSF_format(cell.z, datenum(cell.v, o.date1904));
            } else {
              cell.t = "n";
              cell.v = datenum(cell.v, o.date1904);
              cell.w = SSF_format(cell.z, cell.v);
            }
          } else
            cell.t = "s";
        }
        if (dense) {
          if (row[__C] && row[__C].z)
            cell.z = row[__C].z;
          row[__C] = cell;
        } else {
          var cell_ref = encode_col(__C) + (__R + 1);
          if (ws[cell_ref] && ws[cell_ref].z)
            cell.z = ws[cell_ref].z;
          ws[cell_ref] = cell;
        }
      }
    }
    if (seen && range.s.c < 104e5)
      ws["!ref"] = encode_range(range);
    return ws;
  }
  function aoa_to_sheet(data, opts) {
    return sheet_add_aoa(null, data, opts);
  }
  var BErr = {
    0: "#NULL!",
    7: "#DIV/0!",
    15: "#VALUE!",
    23: "#REF!",
    29: "#NAME?",
    36: "#NUM!",
    42: "#N/A",
    43: "#GETTING_DATA",
    255: "#WTF?"
  };
  var RBErr = {
    "#NULL!": 0,
    "#DIV/0!": 7,
    "#VALUE!": 15,
    "#REF!": 23,
    "#NAME?": 29,
    "#NUM!": 36,
    "#N/A": 42,
    "#GETTING_DATA": 43,
    "#WTF?": 255
  };
  var ct2type = {
    /* Workbook */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml": "workbooks",
    "application/vnd.ms-excel.sheet.macroEnabled.main+xml": "workbooks",
    "application/vnd.ms-excel.sheet.binary.macroEnabled.main": "workbooks",
    "application/vnd.ms-excel.addin.macroEnabled.main+xml": "workbooks",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.template.main+xml": "workbooks",
    /* Worksheet */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml": "sheets",
    "application/vnd.ms-excel.worksheet": "sheets",
    "application/vnd.ms-excel.binIndexWs": "TODO",
    /* Binary Index */
    /* Chartsheet */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.chartsheet+xml": "charts",
    "application/vnd.ms-excel.chartsheet": "charts",
    /* Macrosheet */
    "application/vnd.ms-excel.macrosheet+xml": "macros",
    "application/vnd.ms-excel.macrosheet": "macros",
    "application/vnd.ms-excel.intlmacrosheet": "TODO",
    "application/vnd.ms-excel.binIndexMs": "TODO",
    /* Binary Index */
    /* Dialogsheet */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.dialogsheet+xml": "dialogs",
    "application/vnd.ms-excel.dialogsheet": "dialogs",
    /* Shared Strings */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml": "strs",
    "application/vnd.ms-excel.sharedStrings": "strs",
    /* Styles */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml": "styles",
    "application/vnd.ms-excel.styles": "styles",
    /* File Properties */
    "application/vnd.openxmlformats-package.core-properties+xml": "coreprops",
    "application/vnd.openxmlformats-officedocument.custom-properties+xml": "custprops",
    "application/vnd.openxmlformats-officedocument.extended-properties+xml": "extprops",
    /* Custom Data Properties */
    "application/vnd.openxmlformats-officedocument.customXmlProperties+xml": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.customProperty": "TODO",
    /* Comments */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.comments+xml": "comments",
    "application/vnd.ms-excel.comments": "comments",
    "application/vnd.ms-excel.threadedcomments+xml": "threadedcomments",
    "application/vnd.ms-excel.person+xml": "people",
    /* Metadata (Stock/Geography and Dynamic Array) */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheetMetadata+xml": "metadata",
    "application/vnd.ms-excel.sheetMetadata": "metadata",
    /* PivotTable */
    "application/vnd.ms-excel.pivotTable": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.pivotTable+xml": "TODO",
    /* Chart Objects */
    "application/vnd.openxmlformats-officedocument.drawingml.chart+xml": "TODO",
    /* Chart Colors */
    "application/vnd.ms-office.chartcolorstyle+xml": "TODO",
    /* Chart Style */
    "application/vnd.ms-office.chartstyle+xml": "TODO",
    /* Chart Advanced */
    "application/vnd.ms-office.chartex+xml": "TODO",
    /* Calculation Chain */
    "application/vnd.ms-excel.calcChain": "calcchains",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.calcChain+xml": "calcchains",
    /* Printer Settings */
    "application/vnd.openxmlformats-officedocument.spreadsheetml.printerSettings": "TODO",
    /* ActiveX */
    "application/vnd.ms-office.activeX": "TODO",
    "application/vnd.ms-office.activeX+xml": "TODO",
    /* Custom Toolbars */
    "application/vnd.ms-excel.attachedToolbars": "TODO",
    /* External Data Connections */
    "application/vnd.ms-excel.connections": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.connections+xml": "TODO",
    /* External Links */
    "application/vnd.ms-excel.externalLink": "links",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.externalLink+xml": "links",
    /* PivotCache */
    "application/vnd.ms-excel.pivotCacheDefinition": "TODO",
    "application/vnd.ms-excel.pivotCacheRecords": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.pivotCacheDefinition+xml": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.pivotCacheRecords+xml": "TODO",
    /* Query Table */
    "application/vnd.ms-excel.queryTable": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.queryTable+xml": "TODO",
    /* Shared Workbook */
    "application/vnd.ms-excel.userNames": "TODO",
    "application/vnd.ms-excel.revisionHeaders": "TODO",
    "application/vnd.ms-excel.revisionLog": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.revisionHeaders+xml": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.revisionLog+xml": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.userNames+xml": "TODO",
    /* Single Cell Table */
    "application/vnd.ms-excel.tableSingleCells": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.tableSingleCells+xml": "TODO",
    /* Slicer */
    "application/vnd.ms-excel.slicer": "TODO",
    "application/vnd.ms-excel.slicerCache": "TODO",
    "application/vnd.ms-excel.slicer+xml": "TODO",
    "application/vnd.ms-excel.slicerCache+xml": "TODO",
    /* Sort Map */
    "application/vnd.ms-excel.wsSortMap": "TODO",
    /* Table */
    "application/vnd.ms-excel.table": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.table+xml": "TODO",
    /* Themes */
    "application/vnd.openxmlformats-officedocument.theme+xml": "themes",
    /* Theme Override */
    "application/vnd.openxmlformats-officedocument.themeOverride+xml": "TODO",
    /* Timeline */
    "application/vnd.ms-excel.Timeline+xml": "TODO",
    /* verify */
    "application/vnd.ms-excel.TimelineCache+xml": "TODO",
    /* verify */
    /* VBA */
    "application/vnd.ms-office.vbaProject": "vba",
    "application/vnd.ms-office.vbaProjectSignature": "TODO",
    /* Volatile Dependencies */
    "application/vnd.ms-office.volatileDependencies": "TODO",
    "application/vnd.openxmlformats-officedocument.spreadsheetml.volatileDependencies+xml": "TODO",
    /* Control Properties */
    "application/vnd.ms-excel.controlproperties+xml": "TODO",
    /* Data Model */
    "application/vnd.openxmlformats-officedocument.model+data": "TODO",
    /* Survey */
    "application/vnd.ms-excel.Survey+xml": "TODO",
    /* Drawing */
    "application/vnd.openxmlformats-officedocument.drawing+xml": "drawings",
    "application/vnd.openxmlformats-officedocument.drawingml.chartshapes+xml": "TODO",
    "application/vnd.openxmlformats-officedocument.drawingml.diagramColors+xml": "TODO",
    "application/vnd.openxmlformats-officedocument.drawingml.diagramData+xml": "TODO",
    "application/vnd.openxmlformats-officedocument.drawingml.diagramLayout+xml": "TODO",
    "application/vnd.openxmlformats-officedocument.drawingml.diagramStyle+xml": "TODO",
    /* VML */
    "application/vnd.openxmlformats-officedocument.vmlDrawing": "TODO",
    "application/vnd.openxmlformats-package.relationships+xml": "rels",
    "application/vnd.openxmlformats-officedocument.oleObject": "TODO",
    /* Image */
    "image/png": "TODO",
    "sheet": "js"
  };
  var CT_LIST = {
    workbooks: {
      xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml",
      xlsm: "application/vnd.ms-excel.sheet.macroEnabled.main+xml",
      xlsb: "application/vnd.ms-excel.sheet.binary.macroEnabled.main",
      xlam: "application/vnd.ms-excel.addin.macroEnabled.main+xml",
      xltx: "application/vnd.openxmlformats-officedocument.spreadsheetml.template.main+xml"
    },
    strs: {
      /* Shared Strings */
      xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml",
      xlsb: "application/vnd.ms-excel.sharedStrings"
    },
    comments: {
      /* Comments */
      xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.comments+xml",
      xlsb: "application/vnd.ms-excel.comments"
    },
    sheets: {
      /* Worksheet */
      xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml",
      xlsb: "application/vnd.ms-excel.worksheet"
    },
    charts: {
      /* Chartsheet */
      xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.chartsheet+xml",
      xlsb: "application/vnd.ms-excel.chartsheet"
    },
    dialogs: {
      /* Dialogsheet */
      xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.dialogsheet+xml",
      xlsb: "application/vnd.ms-excel.dialogsheet"
    },
    macros: {
      /* Macrosheet (Excel 4.0 Macros) */
      xlsx: "application/vnd.ms-excel.macrosheet+xml",
      xlsb: "application/vnd.ms-excel.macrosheet"
    },
    metadata: {
      /* Metadata (Stock/Geography and Dynamic Array) */
      xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheetMetadata+xml",
      xlsb: "application/vnd.ms-excel.sheetMetadata"
    },
    styles: {
      /* Styles */
      xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml",
      xlsb: "application/vnd.ms-excel.styles"
    }
  };
  function new_ct() {
    return {
      workbooks: [],
      sheets: [],
      charts: [],
      dialogs: [],
      macros: [],
      rels: [],
      strs: [],
      comments: [],
      threadedcomments: [],
      links: [],
      coreprops: [],
      extprops: [],
      custprops: [],
      themes: [],
      styles: [],
      calcchains: [],
      vba: [],
      drawings: [],
      metadata: [],
      people: [],
      TODO: [],
      xmlns: ""
    };
  }
  function write_ct(ct, opts, raw) {
    var type2ct = evert_arr(ct2type);
    var o = [], v;
    if (!raw) {
      o[o.length] = XML_HEADER;
      o[o.length] = writextag("Types", null, {
        "xmlns": XMLNS.CT,
        "xmlns:xsd": XMLNS.xsd,
        "xmlns:xsi": XMLNS.xsi
      });
      o = o.concat([
        ["xml", "application/xml"],
        ["bin", "application/vnd.ms-excel.sheet.binary.macroEnabled.main"],
        ["vml", "application/vnd.openxmlformats-officedocument.vmlDrawing"],
        ["data", "application/vnd.openxmlformats-officedocument.model+data"],
        /* from test files */
        ["bmp", "image/bmp"],
        ["png", "image/png"],
        ["gif", "image/gif"],
        ["emf", "image/x-emf"],
        ["wmf", "image/x-wmf"],
        ["jpg", "image/jpeg"],
        ["jpeg", "image/jpeg"],
        ["tif", "image/tiff"],
        ["tiff", "image/tiff"],
        ["pdf", "application/pdf"],
        ["rels", "application/vnd.openxmlformats-package.relationships+xml"]
      ].map(function(x) {
        return writextag("Default", null, { "Extension": x[0], "ContentType": x[1] });
      }));
    }
    var f1 = function(w) {
      if (ct[w] && ct[w].length > 0) {
        v = ct[w][0];
        o[o.length] = writextag("Override", null, {
          "PartName": (v[0] == "/" ? "" : "/") + v,
          "ContentType": CT_LIST[w][opts.bookType] || CT_LIST[w]["xlsx"]
        });
      }
    };
    var f2 = function(w) {
      (ct[w] || []).forEach(function(v2) {
        o[o.length] = writextag("Override", null, {
          "PartName": (v2[0] == "/" ? "" : "/") + v2,
          "ContentType": CT_LIST[w][opts.bookType] || CT_LIST[w]["xlsx"]
        });
      });
    };
    var f3 = function(t) {
      (ct[t] || []).forEach(function(v2) {
        o[o.length] = writextag("Override", null, {
          "PartName": (v2[0] == "/" ? "" : "/") + v2,
          "ContentType": type2ct[t][0]
        });
      });
    };
    f1("workbooks");
    f2("sheets");
    f2("charts");
    f3("themes");
    ["strs", "styles"].forEach(f1);
    ["coreprops", "extprops", "custprops"].forEach(f3);
    f3("vba");
    f3("comments");
    f3("threadedcomments");
    f3("drawings");
    f2("metadata");
    f3("people");
    if (!raw && o.length > 2) {
      o[o.length] = "</Types>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  var RELS = {
    WB: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument",
    SHEET: "http://sheetjs.openxmlformats.org/officeDocument/2006/relationships/officeDocument",
    HLINK: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink",
    VML: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/vmlDrawing",
    XPATH: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/externalLinkPath",
    XMISS: "http://schemas.microsoft.com/office/2006/relationships/xlExternalLinkPath/xlPathMissing",
    XLINK: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/externalLink",
    CXML: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/customXml",
    CXMLP: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/customXmlProps",
    CMNT: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/comments",
    CORE_PROPS: "http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties",
    EXT_PROPS: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties",
    CUST_PROPS: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/custom-properties",
    SST: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings",
    STY: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles",
    THEME: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme",
    CHART: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/chart",
    CHARTEX: "http://schemas.microsoft.com/office/2014/relationships/chartEx",
    CS: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/chartsheet",
    WS: [
      "http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet",
      "http://purl.oclc.org/ooxml/officeDocument/relationships/worksheet"
    ],
    DS: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/dialogsheet",
    MS: "http://schemas.microsoft.com/office/2006/relationships/xlMacrosheet",
    IMG: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/image",
    DRAW: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/drawing",
    XLMETA: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/sheetMetadata",
    TCMNT: "http://schemas.microsoft.com/office/2017/10/relationships/threadedComment",
    PEOPLE: "http://schemas.microsoft.com/office/2017/10/relationships/person",
    CONN: "http://schemas.openxmlformats.org/officeDocument/2006/relationships/connections",
    VBA: "http://schemas.microsoft.com/office/2006/relationships/vbaProject"
  };
  function get_rels_path(file) {
    var n = file.lastIndexOf("/");
    return file.slice(0, n + 1) + "_rels/" + file.slice(n + 1) + ".rels";
  }
  function write_rels(rels) {
    var o = [XML_HEADER, writextag("Relationships", null, {
      //'xmlns:ns0': XMLNS.RELS,
      "xmlns": XMLNS.RELS
    })];
    keys(rels["!id"]).forEach(function(rid) {
      o[o.length] = writextag("Relationship", null, rels["!id"][rid]);
    });
    if (o.length > 2) {
      o[o.length] = "</Relationships>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  function add_rels(rels, rId, f, type, relobj, targetmode) {
    if (!relobj)
      relobj = {};
    if (!rels["!id"])
      rels["!id"] = {};
    if (!rels["!idx"])
      rels["!idx"] = 1;
    if (rId < 0)
      for (rId = rels["!idx"]; rels["!id"]["rId" + rId]; ++rId) {
      }
    rels["!idx"] = rId + 1;
    relobj.Id = "rId" + rId;
    relobj.Type = type;
    relobj.Target = f;
    if (targetmode)
      relobj.TargetMode = targetmode;
    else if ([RELS.HLINK, RELS.XPATH, RELS.XMISS].indexOf(relobj.Type) > -1)
      relobj.TargetMode = "External";
    if (rels["!id"][relobj.Id])
      throw new Error("Cannot rewrite rId " + rId);
    rels["!id"][relobj.Id] = relobj;
    rels[("/" + relobj.Target).replace("//", "/")] = relobj;
    return rId;
  }
  var CORE_PROPS = [
    ["cp:category", "Category"],
    ["cp:contentStatus", "ContentStatus"],
    ["cp:keywords", "Keywords"],
    ["cp:lastModifiedBy", "LastAuthor"],
    ["cp:lastPrinted", "LastPrinted"],
    ["cp:revision", "RevNumber"],
    ["cp:version", "Version"],
    ["dc:creator", "Author"],
    ["dc:description", "Comments"],
    ["dc:identifier", "Identifier"],
    ["dc:language", "Language"],
    ["dc:subject", "Subject"],
    ["dc:title", "Title"],
    ["dcterms:created", "CreatedDate", "date"],
    ["dcterms:modified", "ModifiedDate", "date"]
  ];
  function cp_doit(f, g, h, o, p) {
    if (p[f] != null || g == null || g === "")
      return;
    p[f] = g;
    g = escapexml(g);
    o[o.length] = h ? writextag(f, g, h) : writetag(f, g);
  }
  function write_core_props(cp, _opts) {
    var opts = _opts || {};
    var o = [XML_HEADER, writextag("cp:coreProperties", null, {
      //'xmlns': XMLNS.CORE_PROPS,
      "xmlns:cp": XMLNS.CORE_PROPS,
      "xmlns:dc": XMLNS.dc,
      "xmlns:dcterms": XMLNS.dcterms,
      "xmlns:dcmitype": XMLNS.dcmitype,
      "xmlns:xsi": XMLNS.xsi
    })], p = {};
    if (!cp && !opts.Props)
      return o.join("");
    if (cp) {
      if (cp.CreatedDate != null)
        cp_doit("dcterms:created", typeof cp.CreatedDate === "string" ? cp.CreatedDate : write_w3cdtf(cp.CreatedDate, opts.WTF), { "xsi:type": "dcterms:W3CDTF" }, o, p);
      if (cp.ModifiedDate != null)
        cp_doit("dcterms:modified", typeof cp.ModifiedDate === "string" ? cp.ModifiedDate : write_w3cdtf(cp.ModifiedDate, opts.WTF), { "xsi:type": "dcterms:W3CDTF" }, o, p);
    }
    for (var i = 0; i != CORE_PROPS.length; ++i) {
      var f = CORE_PROPS[i];
      var v = opts.Props && opts.Props[f[1]] != null ? opts.Props[f[1]] : cp ? cp[f[1]] : null;
      if (v === true)
        v = "1";
      else if (v === false)
        v = "0";
      else if (typeof v == "number")
        v = String(v);
      if (v != null)
        cp_doit(f[0], v, null, o, p);
    }
    if (o.length > 2) {
      o[o.length] = "</cp:coreProperties>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  var EXT_PROPS = [
    ["Application", "Application", "string"],
    ["AppVersion", "AppVersion", "string"],
    ["Company", "Company", "string"],
    ["DocSecurity", "DocSecurity", "string"],
    ["Manager", "Manager", "string"],
    ["HyperlinksChanged", "HyperlinksChanged", "bool"],
    ["SharedDoc", "SharedDoc", "bool"],
    ["LinksUpToDate", "LinksUpToDate", "bool"],
    ["ScaleCrop", "ScaleCrop", "bool"],
    ["HeadingPairs", "HeadingPairs", "raw"],
    ["TitlesOfParts", "TitlesOfParts", "raw"]
  ];
  function write_ext_props(cp) {
    var o = [], W = writextag;
    if (!cp)
      cp = {};
    cp.Application = "SheetJS";
    o[o.length] = XML_HEADER;
    o[o.length] = writextag("Properties", null, {
      "xmlns": XMLNS.EXT_PROPS,
      "xmlns:vt": XMLNS.vt
    });
    EXT_PROPS.forEach(function(f) {
      if (cp[f[1]] === void 0)
        return;
      var v;
      switch (f[2]) {
        case "string":
          v = escapexml(String(cp[f[1]]));
          break;
        case "bool":
          v = cp[f[1]] ? "true" : "false";
          break;
      }
      if (v !== void 0)
        o[o.length] = W(f[0], v);
    });
    o[o.length] = W("HeadingPairs", W("vt:vector", W("vt:variant", "<vt:lpstr>Worksheets</vt:lpstr>") + W("vt:variant", W("vt:i4", String(cp.Worksheets))), { size: 2, baseType: "variant" }));
    o[o.length] = W("TitlesOfParts", W("vt:vector", cp.SheetNames.map(function(s) {
      return "<vt:lpstr>" + escapexml(s) + "</vt:lpstr>";
    }).join(""), { size: cp.Worksheets, baseType: "lpstr" }));
    if (o.length > 2) {
      o[o.length] = "</Properties>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  function write_cust_props(cp) {
    var o = [XML_HEADER, writextag("Properties", null, {
      "xmlns": XMLNS.CUST_PROPS,
      "xmlns:vt": XMLNS.vt
    })];
    if (!cp)
      return o.join("");
    var pid = 1;
    keys(cp).forEach(function custprop(k) {
      ++pid;
      o[o.length] = writextag("property", write_vt(cp[k], true), {
        "fmtid": "{D5CDD505-2E9C-101B-9397-08002B2CF9AE}",
        "pid": pid,
        "name": escapexml(k)
      });
    });
    if (o.length > 2) {
      o[o.length] = "</Properties>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  var straywsregex = /^\s|\s$|[\t\n\r]/;
  function write_sst_xml(sst, opts) {
    if (!opts.bookSST)
      return "";
    var o = [XML_HEADER];
    o[o.length] = writextag("sst", null, {
      xmlns: XMLNS_main[0],
      count: sst.Count,
      uniqueCount: sst.Unique
    });
    for (var i = 0; i != sst.length; ++i) {
      if (sst[i] == null)
        continue;
      var s = sst[i];
      var sitag = "<si>";
      if (s.r)
        sitag += s.r;
      else {
        sitag += "<t";
        if (!s.t)
          s.t = "";
        if (typeof s.t !== "string")
          s.t = String(s.t);
        if (s.t.match(straywsregex))
          sitag += ' xml:space="preserve"';
        sitag += ">" + escapexml(s.t) + "</t>";
      }
      sitag += "</si>";
      o[o.length] = sitag;
    }
    if (o.length > 2) {
      o[o.length] = "</sst>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  function _JS2ANSI(str) {
    if (typeof $cptable !== "undefined")
      return $cptable.utils.encode(current_ansi, str);
    var o = [], oo = str.split("");
    for (var i = 0; i < oo.length; ++i)
      o[i] = oo[i].charCodeAt(0);
    return o;
  }
  function crypto_CreatePasswordVerifier_Method1(Password) {
    var Verifier = 0, PasswordArray;
    var PasswordDecoded = _JS2ANSI(Password);
    var len = PasswordDecoded.length + 1, i, PasswordByte;
    var Intermediate1, Intermediate2, Intermediate3;
    PasswordArray = new_raw_buf(len);
    PasswordArray[0] = PasswordDecoded.length;
    for (i = 1; i != len; ++i)
      PasswordArray[i] = PasswordDecoded[i - 1];
    for (i = len - 1; i >= 0; --i) {
      PasswordByte = PasswordArray[i];
      Intermediate1 = (Verifier & 16384) === 0 ? 0 : 1;
      Intermediate2 = Verifier << 1 & 32767;
      Intermediate3 = Intermediate1 | Intermediate2;
      Verifier = Intermediate3 ^ PasswordByte;
    }
    return Verifier ^ 52811;
  }
  var DEF_MDW = 6;
  var MDW = DEF_MDW;
  function px2char(px) {
    return Math.floor((px - 5) / MDW * 100 + 0.5) / 100;
  }
  function char2width(chr) {
    return Math.round((chr * MDW + 5) / MDW * 256) / 256;
  }
  var DEF_PPI = 96;
  var PPI = DEF_PPI;
  function px2pt(px) {
    return px * 96 / PPI;
  }
  function write_numFmts(NF) {
    var o = ["<numFmts>"];
    [[5, 8], [23, 26], [41, 44], [
      /*63*/
      50,
      /*66],[164,*/
      392
    ]].forEach(function(r) {
      for (var i = r[0]; i <= r[1]; ++i)
        if (NF[i] != null)
          o[o.length] = writextag("numFmt", null, { numFmtId: i, formatCode: escapexml(NF[i]) });
    });
    if (o.length === 1)
      return "";
    o[o.length] = "</numFmts>";
    o[0] = writextag("numFmts", null, { count: o.length - 2 }).replace("/>", ">");
    return o.join("");
  }
  function write_cellXfs(cellXfs) {
    var o = [];
    o[o.length] = writextag("cellXfs", null);
    cellXfs.forEach(function(c) {
      o[o.length] = writextag("xf", null, c);
    });
    o[o.length] = "</cellXfs>";
    if (o.length === 2)
      return "";
    o[0] = writextag("cellXfs", null, { count: o.length - 2 }).replace("/>", ">");
    return o.join("");
  }
  function write_sty_xml(wb, opts) {
    var o = [XML_HEADER, writextag("styleSheet", null, {
      "xmlns": XMLNS_main[0],
      "xmlns:vt": XMLNS.vt
    })], w;
    if (wb.SSF && (w = write_numFmts(wb.SSF)) != null)
      o[o.length] = w;
    o[o.length] = '<fonts count="1"><font><sz val="12"/><color theme="1"/><name val="Calibri"/><family val="2"/><scheme val="minor"/></font></fonts>';
    o[o.length] = '<fills count="2"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill></fills>';
    o[o.length] = '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>';
    o[o.length] = '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>';
    if (w = write_cellXfs(opts.cellXfs))
      o[o.length] = w;
    o[o.length] = '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>';
    o[o.length] = '<dxfs count="0"/>';
    o[o.length] = '<tableStyles count="0" defaultTableStyle="TableStyleMedium9" defaultPivotStyle="PivotStyleMedium4"/>';
    if (o.length > 2) {
      o[o.length] = "</styleSheet>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  function write_theme(Themes, opts) {
    if (opts && opts.themeXLSX)
      return opts.themeXLSX;
    if (Themes && typeof Themes.raw == "string")
      return Themes.raw;
    var o = [XML_HEADER];
    o[o.length] = '<a:theme xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" name="Office Theme">';
    o[o.length] = "<a:themeElements>";
    o[o.length] = '<a:clrScheme name="Office">';
    o[o.length] = '<a:dk1><a:sysClr val="windowText" lastClr="000000"/></a:dk1>';
    o[o.length] = '<a:lt1><a:sysClr val="window" lastClr="FFFFFF"/></a:lt1>';
    o[o.length] = '<a:dk2><a:srgbClr val="1F497D"/></a:dk2>';
    o[o.length] = '<a:lt2><a:srgbClr val="EEECE1"/></a:lt2>';
    o[o.length] = '<a:accent1><a:srgbClr val="4F81BD"/></a:accent1>';
    o[o.length] = '<a:accent2><a:srgbClr val="C0504D"/></a:accent2>';
    o[o.length] = '<a:accent3><a:srgbClr val="9BBB59"/></a:accent3>';
    o[o.length] = '<a:accent4><a:srgbClr val="8064A2"/></a:accent4>';
    o[o.length] = '<a:accent5><a:srgbClr val="4BACC6"/></a:accent5>';
    o[o.length] = '<a:accent6><a:srgbClr val="F79646"/></a:accent6>';
    o[o.length] = '<a:hlink><a:srgbClr val="0000FF"/></a:hlink>';
    o[o.length] = '<a:folHlink><a:srgbClr val="800080"/></a:folHlink>';
    o[o.length] = "</a:clrScheme>";
    o[o.length] = '<a:fontScheme name="Office">';
    o[o.length] = "<a:majorFont>";
    o[o.length] = '<a:latin typeface="Cambria"/>';
    o[o.length] = '<a:ea typeface=""/>';
    o[o.length] = '<a:cs typeface=""/>';
    o[o.length] = '<a:font script="Jpan" typeface="\uFF2D\uFF33 \uFF30\u30B4\u30B7\u30C3\u30AF"/>';
    o[o.length] = '<a:font script="Hang" typeface="\uB9D1\uC740 \uACE0\uB515"/>';
    o[o.length] = '<a:font script="Hans" typeface="\u5B8B\u4F53"/>';
    o[o.length] = '<a:font script="Hant" typeface="\u65B0\u7D30\u660E\u9AD4"/>';
    o[o.length] = '<a:font script="Arab" typeface="Times New Roman"/>';
    o[o.length] = '<a:font script="Hebr" typeface="Times New Roman"/>';
    o[o.length] = '<a:font script="Thai" typeface="Tahoma"/>';
    o[o.length] = '<a:font script="Ethi" typeface="Nyala"/>';
    o[o.length] = '<a:font script="Beng" typeface="Vrinda"/>';
    o[o.length] = '<a:font script="Gujr" typeface="Shruti"/>';
    o[o.length] = '<a:font script="Khmr" typeface="MoolBoran"/>';
    o[o.length] = '<a:font script="Knda" typeface="Tunga"/>';
    o[o.length] = '<a:font script="Guru" typeface="Raavi"/>';
    o[o.length] = '<a:font script="Cans" typeface="Euphemia"/>';
    o[o.length] = '<a:font script="Cher" typeface="Plantagenet Cherokee"/>';
    o[o.length] = '<a:font script="Yiii" typeface="Microsoft Yi Baiti"/>';
    o[o.length] = '<a:font script="Tibt" typeface="Microsoft Himalaya"/>';
    o[o.length] = '<a:font script="Thaa" typeface="MV Boli"/>';
    o[o.length] = '<a:font script="Deva" typeface="Mangal"/>';
    o[o.length] = '<a:font script="Telu" typeface="Gautami"/>';
    o[o.length] = '<a:font script="Taml" typeface="Latha"/>';
    o[o.length] = '<a:font script="Syrc" typeface="Estrangelo Edessa"/>';
    o[o.length] = '<a:font script="Orya" typeface="Kalinga"/>';
    o[o.length] = '<a:font script="Mlym" typeface="Kartika"/>';
    o[o.length] = '<a:font script="Laoo" typeface="DokChampa"/>';
    o[o.length] = '<a:font script="Sinh" typeface="Iskoola Pota"/>';
    o[o.length] = '<a:font script="Mong" typeface="Mongolian Baiti"/>';
    o[o.length] = '<a:font script="Viet" typeface="Times New Roman"/>';
    o[o.length] = '<a:font script="Uigh" typeface="Microsoft Uighur"/>';
    o[o.length] = '<a:font script="Geor" typeface="Sylfaen"/>';
    o[o.length] = "</a:majorFont>";
    o[o.length] = "<a:minorFont>";
    o[o.length] = '<a:latin typeface="Calibri"/>';
    o[o.length] = '<a:ea typeface=""/>';
    o[o.length] = '<a:cs typeface=""/>';
    o[o.length] = '<a:font script="Jpan" typeface="\uFF2D\uFF33 \uFF30\u30B4\u30B7\u30C3\u30AF"/>';
    o[o.length] = '<a:font script="Hang" typeface="\uB9D1\uC740 \uACE0\uB515"/>';
    o[o.length] = '<a:font script="Hans" typeface="\u5B8B\u4F53"/>';
    o[o.length] = '<a:font script="Hant" typeface="\u65B0\u7D30\u660E\u9AD4"/>';
    o[o.length] = '<a:font script="Arab" typeface="Arial"/>';
    o[o.length] = '<a:font script="Hebr" typeface="Arial"/>';
    o[o.length] = '<a:font script="Thai" typeface="Tahoma"/>';
    o[o.length] = '<a:font script="Ethi" typeface="Nyala"/>';
    o[o.length] = '<a:font script="Beng" typeface="Vrinda"/>';
    o[o.length] = '<a:font script="Gujr" typeface="Shruti"/>';
    o[o.length] = '<a:font script="Khmr" typeface="DaunPenh"/>';
    o[o.length] = '<a:font script="Knda" typeface="Tunga"/>';
    o[o.length] = '<a:font script="Guru" typeface="Raavi"/>';
    o[o.length] = '<a:font script="Cans" typeface="Euphemia"/>';
    o[o.length] = '<a:font script="Cher" typeface="Plantagenet Cherokee"/>';
    o[o.length] = '<a:font script="Yiii" typeface="Microsoft Yi Baiti"/>';
    o[o.length] = '<a:font script="Tibt" typeface="Microsoft Himalaya"/>';
    o[o.length] = '<a:font script="Thaa" typeface="MV Boli"/>';
    o[o.length] = '<a:font script="Deva" typeface="Mangal"/>';
    o[o.length] = '<a:font script="Telu" typeface="Gautami"/>';
    o[o.length] = '<a:font script="Taml" typeface="Latha"/>';
    o[o.length] = '<a:font script="Syrc" typeface="Estrangelo Edessa"/>';
    o[o.length] = '<a:font script="Orya" typeface="Kalinga"/>';
    o[o.length] = '<a:font script="Mlym" typeface="Kartika"/>';
    o[o.length] = '<a:font script="Laoo" typeface="DokChampa"/>';
    o[o.length] = '<a:font script="Sinh" typeface="Iskoola Pota"/>';
    o[o.length] = '<a:font script="Mong" typeface="Mongolian Baiti"/>';
    o[o.length] = '<a:font script="Viet" typeface="Arial"/>';
    o[o.length] = '<a:font script="Uigh" typeface="Microsoft Uighur"/>';
    o[o.length] = '<a:font script="Geor" typeface="Sylfaen"/>';
    o[o.length] = "</a:minorFont>";
    o[o.length] = "</a:fontScheme>";
    o[o.length] = '<a:fmtScheme name="Office">';
    o[o.length] = "<a:fillStyleLst>";
    o[o.length] = '<a:solidFill><a:schemeClr val="phClr"/></a:solidFill>';
    o[o.length] = '<a:gradFill rotWithShape="1">';
    o[o.length] = "<a:gsLst>";
    o[o.length] = '<a:gs pos="0"><a:schemeClr val="phClr"><a:tint val="50000"/><a:satMod val="300000"/></a:schemeClr></a:gs>';
    o[o.length] = '<a:gs pos="35000"><a:schemeClr val="phClr"><a:tint val="37000"/><a:satMod val="300000"/></a:schemeClr></a:gs>';
    o[o.length] = '<a:gs pos="100000"><a:schemeClr val="phClr"><a:tint val="15000"/><a:satMod val="350000"/></a:schemeClr></a:gs>';
    o[o.length] = "</a:gsLst>";
    o[o.length] = '<a:lin ang="16200000" scaled="1"/>';
    o[o.length] = "</a:gradFill>";
    o[o.length] = '<a:gradFill rotWithShape="1">';
    o[o.length] = "<a:gsLst>";
    o[o.length] = '<a:gs pos="0"><a:schemeClr val="phClr"><a:tint val="100000"/><a:shade val="100000"/><a:satMod val="130000"/></a:schemeClr></a:gs>';
    o[o.length] = '<a:gs pos="100000"><a:schemeClr val="phClr"><a:tint val="50000"/><a:shade val="100000"/><a:satMod val="350000"/></a:schemeClr></a:gs>';
    o[o.length] = "</a:gsLst>";
    o[o.length] = '<a:lin ang="16200000" scaled="0"/>';
    o[o.length] = "</a:gradFill>";
    o[o.length] = "</a:fillStyleLst>";
    o[o.length] = "<a:lnStyleLst>";
    o[o.length] = '<a:ln w="9525" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"><a:shade val="95000"/><a:satMod val="105000"/></a:schemeClr></a:solidFill><a:prstDash val="solid"/></a:ln>';
    o[o.length] = '<a:ln w="25400" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"/></a:solidFill><a:prstDash val="solid"/></a:ln>';
    o[o.length] = '<a:ln w="38100" cap="flat" cmpd="sng" algn="ctr"><a:solidFill><a:schemeClr val="phClr"/></a:solidFill><a:prstDash val="solid"/></a:ln>';
    o[o.length] = "</a:lnStyleLst>";
    o[o.length] = "<a:effectStyleLst>";
    o[o.length] = "<a:effectStyle>";
    o[o.length] = "<a:effectLst>";
    o[o.length] = '<a:outerShdw blurRad="40000" dist="20000" dir="5400000" rotWithShape="0"><a:srgbClr val="000000"><a:alpha val="38000"/></a:srgbClr></a:outerShdw>';
    o[o.length] = "</a:effectLst>";
    o[o.length] = "</a:effectStyle>";
    o[o.length] = "<a:effectStyle>";
    o[o.length] = "<a:effectLst>";
    o[o.length] = '<a:outerShdw blurRad="40000" dist="23000" dir="5400000" rotWithShape="0"><a:srgbClr val="000000"><a:alpha val="35000"/></a:srgbClr></a:outerShdw>';
    o[o.length] = "</a:effectLst>";
    o[o.length] = "</a:effectStyle>";
    o[o.length] = "<a:effectStyle>";
    o[o.length] = "<a:effectLst>";
    o[o.length] = '<a:outerShdw blurRad="40000" dist="23000" dir="5400000" rotWithShape="0"><a:srgbClr val="000000"><a:alpha val="35000"/></a:srgbClr></a:outerShdw>';
    o[o.length] = "</a:effectLst>";
    o[o.length] = '<a:scene3d><a:camera prst="orthographicFront"><a:rot lat="0" lon="0" rev="0"/></a:camera><a:lightRig rig="threePt" dir="t"><a:rot lat="0" lon="0" rev="1200000"/></a:lightRig></a:scene3d>';
    o[o.length] = '<a:sp3d><a:bevelT w="63500" h="25400"/></a:sp3d>';
    o[o.length] = "</a:effectStyle>";
    o[o.length] = "</a:effectStyleLst>";
    o[o.length] = "<a:bgFillStyleLst>";
    o[o.length] = '<a:solidFill><a:schemeClr val="phClr"/></a:solidFill>';
    o[o.length] = '<a:gradFill rotWithShape="1">';
    o[o.length] = "<a:gsLst>";
    o[o.length] = '<a:gs pos="0"><a:schemeClr val="phClr"><a:tint val="40000"/><a:satMod val="350000"/></a:schemeClr></a:gs>';
    o[o.length] = '<a:gs pos="40000"><a:schemeClr val="phClr"><a:tint val="45000"/><a:shade val="99000"/><a:satMod val="350000"/></a:schemeClr></a:gs>';
    o[o.length] = '<a:gs pos="100000"><a:schemeClr val="phClr"><a:shade val="20000"/><a:satMod val="255000"/></a:schemeClr></a:gs>';
    o[o.length] = "</a:gsLst>";
    o[o.length] = '<a:path path="circle"><a:fillToRect l="50000" t="-80000" r="50000" b="180000"/></a:path>';
    o[o.length] = "</a:gradFill>";
    o[o.length] = '<a:gradFill rotWithShape="1">';
    o[o.length] = "<a:gsLst>";
    o[o.length] = '<a:gs pos="0"><a:schemeClr val="phClr"><a:tint val="80000"/><a:satMod val="300000"/></a:schemeClr></a:gs>';
    o[o.length] = '<a:gs pos="100000"><a:schemeClr val="phClr"><a:shade val="30000"/><a:satMod val="200000"/></a:schemeClr></a:gs>';
    o[o.length] = "</a:gsLst>";
    o[o.length] = '<a:path path="circle"><a:fillToRect l="50000" t="50000" r="50000" b="50000"/></a:path>';
    o[o.length] = "</a:gradFill>";
    o[o.length] = "</a:bgFillStyleLst>";
    o[o.length] = "</a:fmtScheme>";
    o[o.length] = "</a:themeElements>";
    o[o.length] = "<a:objectDefaults>";
    o[o.length] = "<a:spDef>";
    o[o.length] = '<a:spPr/><a:bodyPr/><a:lstStyle/><a:style><a:lnRef idx="1"><a:schemeClr val="accent1"/></a:lnRef><a:fillRef idx="3"><a:schemeClr val="accent1"/></a:fillRef><a:effectRef idx="2"><a:schemeClr val="accent1"/></a:effectRef><a:fontRef idx="minor"><a:schemeClr val="lt1"/></a:fontRef></a:style>';
    o[o.length] = "</a:spDef>";
    o[o.length] = "<a:lnDef>";
    o[o.length] = '<a:spPr/><a:bodyPr/><a:lstStyle/><a:style><a:lnRef idx="2"><a:schemeClr val="accent1"/></a:lnRef><a:fillRef idx="0"><a:schemeClr val="accent1"/></a:fillRef><a:effectRef idx="1"><a:schemeClr val="accent1"/></a:effectRef><a:fontRef idx="minor"><a:schemeClr val="tx1"/></a:fontRef></a:style>';
    o[o.length] = "</a:lnDef>";
    o[o.length] = "</a:objectDefaults>";
    o[o.length] = "<a:extraClrSchemeLst/>";
    o[o.length] = "</a:theme>";
    return o.join("");
  }
  function write_xlmeta_xml() {
    var o = [XML_HEADER];
    o.push('<metadata xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:xlrd="http://schemas.microsoft.com/office/spreadsheetml/2017/richdata" xmlns:xda="http://schemas.microsoft.com/office/spreadsheetml/2017/dynamicarray">\n  <metadataTypes count="1">\n    <metadataType name="XLDAPR" minSupportedVersion="120000" copy="1" pasteAll="1" pasteValues="1" merge="1" splitFirst="1" rowColShift="1" clearFormats="1" clearComments="1" assign="1" coerce="1" cellMeta="1"/>\n  </metadataTypes>\n  <futureMetadata name="XLDAPR" count="1">\n    <bk>\n      <extLst>\n        <ext uri="{bdbb8cdc-fa1e-496e-a857-3c3f30c029c3}">\n          <xda:dynamicArrayProperties fDynamic="1" fCollapsed="0"/>\n        </ext>\n      </extLst>\n    </bk>\n  </futureMetadata>\n  <cellMetadata count="1">\n    <bk>\n      <rc t="1" v="0"/>\n    </bk>\n  </cellMetadata>\n</metadata>');
    return o.join("");
  }
  function write_vml(rId, comments, ws) {
    var csize = [21600, 21600];
    var bbox = ["m0,0l0", csize[1], csize[0], csize[1], csize[0], "0xe"].join(",");
    var o = [
      writextag("xml", null, { "xmlns:v": XLMLNS.v, "xmlns:o": XLMLNS.o, "xmlns:x": XLMLNS.x, "xmlns:mv": XLMLNS.mv }).replace(/\/>/, ">"),
      writextag("o:shapelayout", writextag("o:idmap", null, { "v:ext": "edit", "data": rId }), { "v:ext": "edit" })
    ];
    var _shapeid = 65536 * rId;
    var _comments = comments || [];
    if (_comments.length > 0)
      o.push(writextag("v:shapetype", [
        writextag("v:stroke", null, { joinstyle: "miter" }),
        writextag("v:path", null, { gradientshapeok: "t", "o:connecttype": "rect" })
      ].join(""), { id: "_x0000_t202", coordsize: csize.join(","), "o:spt": 202, path: bbox }));
    _comments.forEach(function(x) {
      ++_shapeid;
      o.push(write_vml_comment(x, _shapeid));
    });
    o.push("</xml>");
    return o.join("");
  }
  function write_vml_comment(x, _shapeid, ws) {
    var c = decode_cell(x[0]);
    var fillopts = (
      /*::(*/
      { "color2": "#BEFF82", "type": "gradient" }
    );
    if (fillopts.type == "gradient")
      fillopts.angle = "-180";
    var fillparm = fillopts.type == "gradient" ? writextag("o:fill", null, { type: "gradientUnscaled", "v:ext": "view" }) : null;
    var fillxml = writextag("v:fill", fillparm, fillopts);
    var shadata = { on: "t", "obscured": "t" };
    return [
      "<v:shape" + wxt_helper({
        id: "_x0000_s" + _shapeid,
        type: "#_x0000_t202",
        style: "position:absolute; margin-left:80pt;margin-top:5pt;width:104pt;height:64pt;z-index:10" + (x[1].hidden ? ";visibility:hidden" : ""),
        fillcolor: "#ECFAD4",
        strokecolor: "#edeaa1"
      }) + ">",
      fillxml,
      writextag("v:shadow", null, shadata),
      writextag("v:path", null, { "o:connecttype": "none" }),
      '<v:textbox><div style="text-align:left"></div></v:textbox>',
      '<x:ClientData ObjectType="Note">',
      "<x:MoveWithCells/>",
      "<x:SizeWithCells/>",
      /* Part 4 19.4.2.3 Anchor (Anchor) */
      writetag("x:Anchor", [c.c + 1, 0, c.r + 1, 0, c.c + 3, 20, c.r + 5, 20].join(",")),
      writetag("x:AutoFill", "False"),
      writetag("x:Row", String(c.r)),
      writetag("x:Column", String(c.c)),
      x[1].hidden ? "" : "<x:Visible/>",
      "</x:ClientData>",
      "</v:shape>"
    ].join("");
  }
  function write_comments_xml(data) {
    var o = [XML_HEADER, writextag("comments", null, { "xmlns": XMLNS_main[0] })];
    var iauthor = [];
    o.push("<authors>");
    data.forEach(function(x) {
      x[1].forEach(function(w) {
        var a = escapexml(w.a);
        if (iauthor.indexOf(a) == -1) {
          iauthor.push(a);
          o.push("<author>" + a + "</author>");
        }
        if (w.T && w.ID && iauthor.indexOf("tc=" + w.ID) == -1) {
          iauthor.push("tc=" + w.ID);
          o.push("<author>tc=" + w.ID + "</author>");
        }
      });
    });
    if (iauthor.length == 0) {
      iauthor.push("SheetJ5");
      o.push("<author>SheetJ5</author>");
    }
    o.push("</authors>");
    o.push("<commentList>");
    data.forEach(function(d) {
      var lastauthor = 0, ts = [], tcnt = 0;
      if (d[1][0] && d[1][0].T && d[1][0].ID)
        lastauthor = iauthor.indexOf("tc=" + d[1][0].ID);
      d[1].forEach(function(c) {
        if (c.a)
          lastauthor = iauthor.indexOf(escapexml(c.a));
        if (c.T)
          ++tcnt;
        ts.push(c.t == null ? "" : escapexml(c.t));
      });
      if (tcnt === 0) {
        d[1].forEach(function(c) {
          o.push('<comment ref="' + d[0] + '" authorId="' + iauthor.indexOf(escapexml(c.a)) + '"><text>');
          o.push(writetag("t", c.t == null ? "" : escapexml(c.t)));
          o.push("</text></comment>");
        });
      } else {
        if (d[1][0] && d[1][0].T && d[1][0].ID)
          lastauthor = iauthor.indexOf("tc=" + d[1][0].ID);
        o.push('<comment ref="' + d[0] + '" authorId="' + lastauthor + '"><text>');
        var t = "Comment:\n    " + ts[0] + "\n";
        for (var i = 1; i < ts.length; ++i)
          t += "Reply:\n    " + ts[i] + "\n";
        o.push(writetag("t", escapexml(t)));
        o.push("</text></comment>");
      }
    });
    o.push("</commentList>");
    if (o.length > 2) {
      o[o.length] = "</comments>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  function write_tcmnt_xml(comments, people, opts) {
    var o = [XML_HEADER, writextag("ThreadedComments", null, { "xmlns": XMLNS.TCMNT }).replace(/[\/]>/, ">")];
    comments.forEach(function(carr) {
      var rootid = "";
      (carr[1] || []).forEach(function(c, idx) {
        if (!c.T) {
          delete c.ID;
          return;
        }
        if (c.a && people.indexOf(c.a) == -1)
          people.push(c.a);
        var tcopts = {
          ref: carr[0],
          id: "{54EE7951-7262-4200-6969-" + ("000000000000" + opts.tcid++).slice(-12) + "}"
        };
        if (idx == 0)
          rootid = tcopts.id;
        else
          tcopts.parentId = rootid;
        c.ID = tcopts.id;
        if (c.a)
          tcopts.personId = "{54EE7950-7262-4200-6969-" + ("000000000000" + people.indexOf(c.a)).slice(-12) + "}";
        o.push(writextag("threadedComment", writetag("text", c.t || ""), tcopts));
      });
    });
    o.push("</ThreadedComments>");
    return o.join("");
  }
  function write_people_xml(people) {
    var o = [XML_HEADER, writextag("personList", null, {
      "xmlns": XMLNS.TCMNT,
      "xmlns:x": XMLNS_main[0]
    }).replace(/[\/]>/, ">")];
    people.forEach(function(person, idx) {
      o.push(writextag("person", null, {
        displayName: person,
        id: "{54EE7950-7262-4200-6969-" + ("000000000000" + idx).slice(-12) + "}",
        userId: person,
        providerId: "None"
      }));
    });
    o.push("</personList>");
    return o.join("");
  }
  var VBAFMTS = ["xlsb", "xlsm", "xlam", "biff8", "xla"];
  var crefregex = /(^|[^._A-Z0-9])(\$?)([A-Z]{1,2}|[A-W][A-Z]{2}|X[A-E][A-Z]|XF[A-D])(\$?)(\d{1,7})(?![_.\(A-Za-z0-9])/g;
  try {
    crefregex = /(^|[^._A-Z0-9])([$]?)([A-Z]{1,2}|[A-W][A-Z]{2}|X[A-E][A-Z]|XF[A-D])([$]?)(10[0-3]\d{4}|104[0-7]\d{3}|1048[0-4]\d{2}|10485[0-6]\d|104857[0-6]|[1-9]\d{0,5})(?![_.\(A-Za-z0-9])/g;
  } catch (e) {
  }
  var browser_has_Map = typeof Map !== "undefined";
  function get_sst_id(sst, str, rev) {
    var i = 0, len = sst.length;
    if (rev) {
      if (browser_has_Map ? rev.has(str) : Object.prototype.hasOwnProperty.call(rev, str)) {
        var revarr = browser_has_Map ? rev.get(str) : rev[str];
        for (; i < revarr.length; ++i) {
          if (sst[revarr[i]].t === str) {
            sst.Count++;
            return revarr[i];
          }
        }
      }
    } else
      for (; i < len; ++i) {
        if (sst[i].t === str) {
          sst.Count++;
          return i;
        }
      }
    sst[len] = { t: str };
    sst.Count++;
    sst.Unique++;
    if (rev) {
      if (browser_has_Map) {
        if (!rev.has(str))
          rev.set(str, []);
        rev.get(str).push(len);
      } else {
        if (!Object.prototype.hasOwnProperty.call(rev, str))
          rev[str] = [];
        rev[str].push(len);
      }
    }
    return len;
  }
  function col_obj_w(C, col) {
    var p = { min: C + 1, max: C + 1 };
    var wch = -1;
    if (col.MDW)
      MDW = col.MDW;
    if (col.width != null)
      p.customWidth = 1;
    else if (col.wpx != null)
      wch = px2char(col.wpx);
    else if (col.wch != null)
      wch = col.wch;
    if (wch > -1) {
      p.width = char2width(wch);
      p.customWidth = 1;
    } else if (col.width != null)
      p.width = col.width;
    if (col.hidden)
      p.hidden = true;
    if (col.level != null) {
      p.outlineLevel = p.level = col.level;
    }
    return p;
  }
  function default_margins(margins, mode) {
    if (!margins)
      return;
    var defs = [0.7, 0.7, 0.75, 0.75, 0.3, 0.3];
    if (mode == "xlml")
      defs = [1, 1, 1, 1, 0.5, 0.5];
    if (margins.left == null)
      margins.left = defs[0];
    if (margins.right == null)
      margins.right = defs[1];
    if (margins.top == null)
      margins.top = defs[2];
    if (margins.bottom == null)
      margins.bottom = defs[3];
    if (margins.header == null)
      margins.header = defs[4];
    if (margins.footer == null)
      margins.footer = defs[5];
  }
  function get_cell_style(styles, cell, opts) {
    var z = opts.revssf[cell.z != null ? cell.z : "General"];
    var i = 60, len = styles.length;
    if (z == null && opts.ssf) {
      for (; i < 392; ++i)
        if (opts.ssf[i] == null) {
          SSF__load(cell.z, i);
          opts.ssf[i] = cell.z;
          opts.revssf[cell.z] = z = i;
          break;
        }
    }
    for (i = 0; i != len; ++i)
      if (styles[i].numFmtId === z)
        return i;
    styles[len] = {
      numFmtId: z,
      fontId: 0,
      fillId: 0,
      borderId: 0,
      xfId: 0,
      applyNumberFormat: 1
    };
    return len;
  }
  function check_ws(ws, sname, i) {
    if (ws && ws["!ref"]) {
      var range = safe_decode_range(ws["!ref"]);
      if (range.e.c < range.s.c || range.e.r < range.s.r)
        throw new Error("Bad range (" + i + "): " + ws["!ref"]);
    }
  }
  function write_ws_xml_merges(merges) {
    if (merges.length === 0)
      return "";
    var o = '<mergeCells count="' + merges.length + '">';
    for (var i = 0; i != merges.length; ++i)
      o += '<mergeCell ref="' + encode_range(merges[i]) + '"/>';
    return o + "</mergeCells>";
  }
  function write_ws_xml_sheetpr(ws, wb, idx, opts, o) {
    var needed = false;
    var props = {}, payload = null;
    if (opts.bookType !== "xlsx" && wb.vbaraw) {
      var cname = wb.SheetNames[idx];
      try {
        if (wb.Workbook)
          cname = wb.Workbook.Sheets[idx].CodeName || cname;
      } catch (e) {
      }
      needed = true;
      props.codeName = utf8write(escapexml(cname));
    }
    if (ws && ws["!outline"]) {
      var outlineprops = { summaryBelow: 1, summaryRight: 1 };
      if (ws["!outline"].above)
        outlineprops.summaryBelow = 0;
      if (ws["!outline"].left)
        outlineprops.summaryRight = 0;
      payload = (payload || "") + writextag("outlinePr", null, outlineprops);
    }
    if (!needed && !payload)
      return;
    o[o.length] = writextag("sheetPr", payload, props);
  }
  var sheetprot_deffalse = ["objects", "scenarios", "selectLockedCells", "selectUnlockedCells"];
  var sheetprot_deftrue = [
    "formatColumns",
    "formatRows",
    "formatCells",
    "insertColumns",
    "insertRows",
    "insertHyperlinks",
    "deleteColumns",
    "deleteRows",
    "sort",
    "autoFilter",
    "pivotTables"
  ];
  function write_ws_xml_protection(sp) {
    var o = { sheet: 1 };
    sheetprot_deffalse.forEach(function(n) {
      if (sp[n] != null && sp[n])
        o[n] = "1";
    });
    sheetprot_deftrue.forEach(function(n) {
      if (sp[n] != null && !sp[n])
        o[n] = "0";
    });
    if (sp.password)
      o.password = crypto_CreatePasswordVerifier_Method1(sp.password).toString(16).toUpperCase();
    return writextag("sheetProtection", null, o);
  }
  function write_ws_xml_margins(margin) {
    default_margins(margin);
    return writextag("pageMargins", null, margin);
  }
  function write_ws_xml_cols(ws, cols) {
    var o = ["<cols>"], col;
    for (var i = 0; i != cols.length; ++i) {
      if (!(col = cols[i]))
        continue;
      o[o.length] = writextag("col", null, col_obj_w(i, col));
    }
    o[o.length] = "</cols>";
    return o.join("");
  }
  function write_ws_xml_autofilter(data, ws, wb, idx) {
    var ref = typeof data.ref == "string" ? data.ref : encode_range(data.ref);
    if (!wb.Workbook)
      wb.Workbook = { Sheets: [] };
    if (!wb.Workbook.Names)
      wb.Workbook.Names = [];
    var names = wb.Workbook.Names;
    var range = decode_range(ref);
    if (range.s.r == range.e.r) {
      range.e.r = decode_range(ws["!ref"]).e.r;
      ref = encode_range(range);
    }
    for (var i = 0; i < names.length; ++i) {
      var name = names[i];
      if (name.Name != "_xlnm._FilterDatabase")
        continue;
      if (name.Sheet != idx)
        continue;
      name.Ref = formula_quote_sheet_name(wb.SheetNames[idx]) + "!" + fix_range(ref);
      break;
    }
    if (i == names.length)
      names.push({ Name: "_xlnm._FilterDatabase", Sheet: idx, Ref: "'" + wb.SheetNames[idx] + "'!" + ref });
    return writextag("autoFilter", null, { ref });
  }
  function write_ws_xml_sheetviews(ws, opts, idx, wb) {
    var sview = { workbookViewId: "0" };
    if ((((wb || {}).Workbook || {}).Views || [])[0])
      sview.rightToLeft = wb.Workbook.Views[0].RTL ? "1" : "0";
    return writextag("sheetViews", writextag("sheetView", null, sview), {});
  }
  function write_ws_xml_cell(cell, ref, ws, opts, idx, wb, date1904) {
    if (cell.c)
      ws["!comments"].push([ref, cell.c]);
    if ((cell.v === void 0 || cell.t === "z" && !(opts || {}).sheetStubs) && typeof cell.f !== "string" && typeof cell.z == "undefined")
      return "";
    var vv = "";
    var oldt = cell.t, oldv = cell.v;
    if (cell.t !== "z")
      switch (cell.t) {
        case "b":
          vv = cell.v ? "1" : "0";
          break;
        case "n":
          if (isNaN(cell.v)) {
            cell.t = "e";
            vv = BErr[cell.v = 36];
          } else if (!isFinite(cell.v)) {
            cell.t = "e";
            vv = BErr[cell.v = 7];
          } else
            vv = "" + cell.v;
          break;
        case "e":
          vv = BErr[cell.v];
          break;
        case "d":
          if (opts && opts.cellDates) {
            var _vv = parseDate(cell.v, date1904);
            vv = _vv.toISOString();
            if (_vv.getUTCFullYear() < 1900)
              vv = vv.slice(vv.indexOf("T") + 1).replace("Z", "");
          } else {
            cell = dup(cell);
            cell.t = "n";
            vv = "" + (cell.v = datenum(parseDate(cell.v, date1904), date1904));
          }
          if (typeof cell.z === "undefined")
            cell.z = table_fmt[14];
          break;
        default:
          vv = cell.v;
          break;
      }
    var v = cell.t == "z" || cell.v == null ? "" : writetag("v", escapexml(vv)), o = { r: ref };
    var os = get_cell_style(opts.cellXfs, cell, opts);
    if (os !== 0)
      o.s = os;
    switch (cell.t) {
      case "n":
        break;
      case "d":
        o.t = "d";
        break;
      case "b":
        o.t = "b";
        break;
      case "e":
        o.t = "e";
        break;
      case "z":
        break;
      default:
        if (cell.v == null) {
          delete cell.t;
          break;
        }
        if (cell.v.length > 32767)
          throw new Error("Text length must not exceed 32767 characters");
        if (opts && opts.bookSST) {
          v = writetag("v", "" + get_sst_id(opts.Strings, cell.v, opts.revStrings));
          o.t = "s";
          break;
        } else
          o.t = "str";
        break;
    }
    if (cell.t != oldt) {
      cell.t = oldt;
      cell.v = oldv;
    }
    if (typeof cell.f == "string" && cell.f) {
      var ff = cell.F && cell.F.slice(0, ref.length) == ref ? { t: "array", ref: cell.F } : null;
      v = writextag("f", escapexml(cell.f), ff) + (cell.v != null ? v : "");
    }
    if (cell.l) {
      cell.l.display = escapexml(vv);
      ws["!links"].push([ref, cell.l]);
    }
    if (cell.D)
      o.cm = 1;
    return writextag("c", v, o);
  }
  function write_ws_xml_data(ws, opts, idx, wb) {
    var o = [], r = [], range = safe_decode_range(ws["!ref"]), cell = "", ref, rr = "", cols = [], R = 0, C = 0, rows = ws["!rows"];
    var dense = ws["!data"] != null, data = dense ? ws["!data"] : [];
    var params = { r: rr }, row, height = -1;
    var date1904 = (((wb || {}).Workbook || {}).WBProps || {}).date1904;
    for (C = range.s.c; C <= range.e.c; ++C)
      cols[C] = encode_col(C);
    for (R = range.s.r; R <= range.e.r; ++R) {
      r = [];
      rr = encode_row(R);
      var data_R = dense ? data[R] : [];
      for (C = range.s.c; C <= range.e.c; ++C) {
        ref = cols[C] + rr;
        var _cell = dense ? data_R[C] : ws[ref];
        if (_cell === void 0)
          continue;
        if ((cell = write_ws_xml_cell(_cell, ref, ws, opts, idx, wb, date1904)) != null)
          r.push(cell);
      }
      if (r.length > 0 || rows && rows[R]) {
        params = { r: rr };
        if (rows && rows[R]) {
          row = rows[R];
          if (row.hidden)
            params.hidden = 1;
          height = -1;
          if (row.hpx)
            height = px2pt(row.hpx);
          else if (row.hpt)
            height = row.hpt;
          if (height > -1) {
            params.ht = height;
            params.customHeight = 1;
          }
          if (row.level) {
            params.outlineLevel = row.level;
          }
        }
        o[o.length] = writextag("row", r.join(""), params);
      }
    }
    if (rows)
      for (; R < rows.length; ++R) {
        if (rows && rows[R]) {
          params = { r: R + 1 };
          row = rows[R];
          if (row.hidden)
            params.hidden = 1;
          height = -1;
          if (row.hpx)
            height = px2pt(row.hpx);
          else if (row.hpt)
            height = row.hpt;
          if (height > -1) {
            params.ht = height;
            params.customHeight = 1;
          }
          if (row.level) {
            params.outlineLevel = row.level;
          }
          o[o.length] = writextag("row", "", params);
        }
      }
    return o.join("");
  }
  function write_ws_xml(idx, opts, wb, rels) {
    var o = [XML_HEADER, writextag("worksheet", null, {
      "xmlns": XMLNS_main[0],
      "xmlns:r": XMLNS.r
    })];
    var s = wb.SheetNames[idx], sidx = 0, rdata = "";
    var ws = wb.Sheets[s];
    if (ws == null)
      ws = {};
    var ref = ws["!ref"] || "A1";
    var range = safe_decode_range(ref);
    if (range.e.c > 16383 || range.e.r > 1048575) {
      if (opts.WTF)
        throw new Error("Range " + ref + " exceeds format limit A1:XFD1048576");
      range.e.c = Math.min(range.e.c, 16383);
      range.e.r = Math.min(range.e.c, 1048575);
      ref = encode_range(range);
    }
    if (!rels)
      rels = {};
    ws["!comments"] = [];
    var _drawing = [];
    write_ws_xml_sheetpr(ws, wb, idx, opts, o);
    o[o.length] = writextag("dimension", null, { "ref": ref });
    o[o.length] = write_ws_xml_sheetviews(ws, opts, idx, wb);
    if (opts.sheetFormat)
      o[o.length] = writextag("sheetFormatPr", null, {
        defaultRowHeight: opts.sheetFormat.defaultRowHeight || "16",
        baseColWidth: opts.sheetFormat.baseColWidth || "10",
        outlineLevelRow: opts.sheetFormat.outlineLevelRow || "7"
      });
    if (ws["!cols"] != null && ws["!cols"].length > 0)
      o[o.length] = write_ws_xml_cols(ws, ws["!cols"]);
    o[sidx = o.length] = "<sheetData/>";
    ws["!links"] = [];
    if (ws["!ref"] != null) {
      rdata = write_ws_xml_data(ws, opts, idx, wb, rels);
      if (rdata.length > 0)
        o[o.length] = rdata;
    }
    if (o.length > sidx + 1) {
      o[o.length] = "</sheetData>";
      o[sidx] = o[sidx].replace("/>", ">");
    }
    if (ws["!protect"])
      o[o.length] = write_ws_xml_protection(ws["!protect"]);
    if (ws["!autofilter"] != null)
      o[o.length] = write_ws_xml_autofilter(ws["!autofilter"], ws, wb, idx);
    if (ws["!merges"] != null && ws["!merges"].length > 0)
      o[o.length] = write_ws_xml_merges(ws["!merges"]);
    var relc = -1, rel, rId = -1;
    if (
      /*::(*/
      ws["!links"].length > 0
    ) {
      o[o.length] = "<hyperlinks>";
      ws["!links"].forEach(function(l) {
        if (!l[1].Target)
          return;
        rel = { "ref": l[0] };
        if (l[1].Target.charAt(0) != "#") {
          rId = add_rels(rels, -1, escapexml(l[1].Target).replace(/#[\s\S]*$/, ""), RELS.HLINK);
          rel["r:id"] = "rId" + rId;
        }
        if ((relc = l[1].Target.indexOf("#")) > -1)
          rel.location = escapexml(l[1].Target.slice(relc + 1));
        if (l[1].Tooltip)
          rel.tooltip = escapexml(l[1].Tooltip);
        rel.display = l[1].display;
        o[o.length] = writextag("hyperlink", null, rel);
      });
      o[o.length] = "</hyperlinks>";
    }
    delete ws["!links"];
    if (ws["!margins"] != null)
      o[o.length] = write_ws_xml_margins(ws["!margins"]);
    if (!opts || opts.ignoreEC || opts.ignoreEC == void 0)
      o[o.length] = writetag("ignoredErrors", writextag("ignoredError", null, { numberStoredAsText: 1, sqref: ref }));
    if (_drawing.length > 0) {
      rId = add_rels(rels, -1, "../drawings/drawing" + (idx + 1) + ".xml", RELS.DRAW);
      o[o.length] = writextag("drawing", null, { "r:id": "rId" + rId });
      ws["!drawing"] = _drawing;
    }
    if (ws["!comments"].length > 0) {
      rId = add_rels(rels, -1, "../drawings/vmlDrawing" + (idx + 1) + ".vml", RELS.VML);
      o[o.length] = writextag("legacyDrawing", null, { "r:id": "rId" + rId });
      ws["!legacy"] = rId;
    }
    if (o.length > 1) {
      o[o.length] = "</worksheet>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  var WBPropsDef = [
    ["allowRefreshQuery", false, "bool"],
    ["autoCompressPictures", true, "bool"],
    ["backupFile", false, "bool"],
    ["checkCompatibility", false, "bool"],
    ["CodeName", ""],
    ["date1904", false, "bool"],
    ["defaultThemeVersion", 0, "int"],
    ["filterPrivacy", false, "bool"],
    ["hidePivotFieldList", false, "bool"],
    ["promptedSolutions", false, "bool"],
    ["publishItems", false, "bool"],
    ["refreshAllConnections", false, "bool"],
    ["saveExternalLinkValues", true, "bool"],
    ["showBorderUnselectedTables", true, "bool"],
    ["showInkAnnotation", true, "bool"],
    ["showObjects", "all"],
    ["showPivotChartFilter", false, "bool"],
    ["updateLinks", "userSet"]
  ];
  var badchars = /* @__PURE__ */ ":][*?/\\".split("");
  function check_ws_name(n, safe) {
    try {
      if (n == "")
        throw new Error("Sheet name cannot be blank");
      if (n.length > 31)
        throw new Error("Sheet name cannot exceed 31 chars");
      if (n.charCodeAt(0) == 39 || n.charCodeAt(n.length - 1) == 39)
        throw new Error("Sheet name cannot start or end with apostrophe (')");
      if (n.toLowerCase() == "history")
        throw new Error("Sheet name cannot be 'History'");
      badchars.forEach(function(c) {
        if (n.indexOf(c) == -1)
          return;
        throw new Error("Sheet name cannot contain : \\ / ? * [ ]");
      });
    } catch (e) {
      if (safe)
        return false;
      throw e;
    }
    return true;
  }
  function check_wb_names(N, S, codes) {
    N.forEach(function(n, i) {
      check_ws_name(n);
      for (var j = 0; j < i; ++j)
        if (n == N[j])
          throw new Error("Duplicate Sheet Name: " + n);
      if (codes) {
        var cn = S && S[i] && S[i].CodeName || n;
        if (cn.charCodeAt(0) == 95 && cn.length > 22)
          throw new Error("Bad Code Name: Worksheet" + cn);
      }
    });
  }
  function check_wb(wb) {
    if (!wb || !wb.SheetNames || !wb.Sheets)
      throw new Error("Invalid Workbook");
    if (!wb.SheetNames.length)
      throw new Error("Workbook is empty");
    var Sheets = wb.Workbook && wb.Workbook.Sheets || [];
    check_wb_names(wb.SheetNames, Sheets, !!wb.vbaraw);
    for (var i = 0; i < wb.SheetNames.length; ++i)
      check_ws(wb.Sheets[wb.SheetNames[i]], wb.SheetNames[i], i);
    wb.SheetNames.forEach(function(n, i2) {
      var ws = wb.Sheets[n];
      if (!ws || !ws["!autofilter"])
        return;
      var DN;
      if (!wb.Workbook)
        wb.Workbook = {};
      if (!wb.Workbook.Names)
        wb.Workbook.Names = [];
      wb.Workbook.Names.forEach(function(dn) {
        if (dn.Name == "_xlnm._FilterDatabase" && dn.Sheet == i2)
          DN = dn;
      });
      var nn = formula_quote_sheet_name(n) + "!" + fix_range(ws["!autofilter"].ref);
      if (DN)
        DN.Ref = nn;
      else
        wb.Workbook.Names.push({ Name: "_xlnm._FilterDatabase", Sheet: i2, Ref: nn });
    });
  }
  function write_wb_xml(wb) {
    var o = [XML_HEADER];
    o[o.length] = writextag("workbook", null, {
      "xmlns": XMLNS_main[0],
      //'xmlns:mx': XMLNS.mx,
      //'xmlns:s': XMLNS_main[0],
      "xmlns:r": XMLNS.r
    });
    var write_names = wb.Workbook && (wb.Workbook.Names || []).length > 0;
    var workbookPr = { codeName: "ThisWorkbook" };
    if (wb.Workbook && wb.Workbook.WBProps) {
      WBPropsDef.forEach(function(x) {
        if (wb.Workbook.WBProps[x[0]] == null)
          return;
        if (wb.Workbook.WBProps[x[0]] == x[1])
          return;
        workbookPr[x[0]] = wb.Workbook.WBProps[x[0]];
      });
      if (wb.Workbook.WBProps.CodeName) {
        workbookPr.codeName = wb.Workbook.WBProps.CodeName;
        delete workbookPr.CodeName;
      }
    }
    o[o.length] = writextag("workbookPr", null, workbookPr);
    var sheets = wb.Workbook && wb.Workbook.Sheets || [];
    var i = 0;
    if (sheets && sheets[0] && !!sheets[0].Hidden) {
      o[o.length] = "<bookViews>";
      for (i = 0; i != wb.SheetNames.length; ++i) {
        if (!sheets[i])
          break;
        if (!sheets[i].Hidden)
          break;
      }
      if (i == wb.SheetNames.length)
        i = 0;
      o[o.length] = '<workbookView firstSheet="' + i + '" activeTab="' + i + '"/>';
      o[o.length] = "</bookViews>";
    }
    o[o.length] = "<sheets>";
    for (i = 0; i != wb.SheetNames.length; ++i) {
      var sht = { name: escapexml(wb.SheetNames[i].slice(0, 31)) };
      sht.sheetId = "" + (i + 1);
      sht["r:id"] = "rId" + (i + 1);
      if (sheets[i])
        switch (sheets[i].Hidden) {
          case 1:
            sht.state = "hidden";
            break;
          case 2:
            sht.state = "veryHidden";
            break;
        }
      o[o.length] = writextag("sheet", null, sht);
    }
    o[o.length] = "</sheets>";
    if (write_names) {
      o[o.length] = "<definedNames>";
      if (wb.Workbook && wb.Workbook.Names)
        wb.Workbook.Names.forEach(function(n) {
          var d = { name: n.Name };
          if (n.Comment)
            d.comment = n.Comment;
          if (n.Sheet != null)
            d.localSheetId = "" + n.Sheet;
          if (n.Hidden)
            d.hidden = "1";
          if (!n.Ref)
            return;
          o[o.length] = writextag("definedName", escapexml(n.Ref), d);
        });
      o[o.length] = "</definedNames>";
    }
    if (o.length > 2) {
      o[o.length] = "</workbook>";
      o[1] = o[1].replace("/>", ">");
    }
    return o.join("");
  }
  function make_html_row(ws, r, R, o) {
    var M = ws["!merges"] || [];
    var oo = [];
    var sp = {};
    var dense = ws["!data"] != null;
    for (var C = r.s.c; C <= r.e.c; ++C) {
      var RS = 0, CS = 0;
      for (var j = 0; j < M.length; ++j) {
        if (M[j].s.r > R || M[j].s.c > C)
          continue;
        if (M[j].e.r < R || M[j].e.c < C)
          continue;
        if (M[j].s.r < R || M[j].s.c < C) {
          RS = -1;
          break;
        }
        RS = M[j].e.r - M[j].s.r + 1;
        CS = M[j].e.c - M[j].s.c + 1;
        break;
      }
      if (RS < 0)
        continue;
      var coord = encode_col(C) + encode_row(R);
      var cell = dense ? (ws["!data"][R] || [])[C] : ws[coord];
      if (cell && cell.t == "n" && cell.v != null && !isFinite(cell.v)) {
        if (isNaN(cell.v))
          cell = { t: "e", v: 36, w: BErr[36] };
        else
          cell = { t: "e", v: 7, w: BErr[7] };
      }
      var w = cell && cell.v != null && (cell.h || escapehtml(cell.w || (format_cell(cell), cell.w) || "")) || "";
      sp = {};
      if (RS > 1)
        sp.rowspan = RS;
      if (CS > 1)
        sp.colspan = CS;
      if (o.editable)
        w = '<span contenteditable="true">' + w + "</span>";
      else if (cell) {
        sp["data-t"] = cell && cell.t || "z";
        if (cell.v != null)
          sp["data-v"] = escapehtml(cell.v instanceof Date ? cell.v.toISOString() : cell.v);
        if (cell.z != null)
          sp["data-z"] = cell.z;
        if (cell.l && (cell.l.Target || "#").charAt(0) != "#")
          w = '<a href="' + escapehtml(cell.l.Target) + '">' + w + "</a>";
      }
      sp.id = (o.id || "sjs") + "-" + coord;
      oo.push(writextag("td", w, sp));
    }
    var preamble = "<tr>";
    return preamble + oo.join("") + "</tr>";
  }
  var HTML_BEGIN = '<html><head><meta charset="utf-8"/><title>SheetJS Table Export</title></head><body>';
  var HTML_END = "</body></html>";
  function make_html_preamble(ws, R, o) {
    var out = [];
    return out.join("") + "<table" + (o && o.id ? ' id="' + o.id + '"' : "") + ">";
  }
  function sheet_to_html(ws, opts) {
    var o = opts || {};
    var header = o.header != null ? o.header : HTML_BEGIN;
    var footer = o.footer != null ? o.footer : HTML_END;
    var out = [header];
    var r = decode_range(ws["!ref"] || "A1");
    out.push(make_html_preamble(ws, r, o));
    if (ws["!ref"])
      for (var R = r.s.r; R <= r.e.r; ++R)
        out.push(make_html_row(ws, r, R, o));
    out.push("</table>" + footer);
    return out.join("");
  }
  function sheet_add_dom(ws, table, _opts) {
    var rows = table.rows;
    if (!rows) {
      throw "Unsupported origin when " + table.tagName + " is not a TABLE";
    }
    var opts = _opts || {};
    var dense = ws["!data"] != null;
    var or_R = 0, or_C = 0;
    if (opts.origin != null) {
      if (typeof opts.origin == "number")
        or_R = opts.origin;
      else {
        var _origin = typeof opts.origin == "string" ? decode_cell(opts.origin) : opts.origin;
        or_R = _origin.r;
        or_C = _origin.c;
      }
    }
    var sheetRows = Math.min(opts.sheetRows || 1e7, rows.length);
    var range = { s: { r: 0, c: 0 }, e: { r: or_R, c: or_C } };
    if (ws["!ref"]) {
      var _range = decode_range(ws["!ref"]);
      range.s.r = Math.min(range.s.r, _range.s.r);
      range.s.c = Math.min(range.s.c, _range.s.c);
      range.e.r = Math.max(range.e.r, _range.e.r);
      range.e.c = Math.max(range.e.c, _range.e.c);
      if (or_R == -1)
        range.e.r = or_R = _range.e.r + 1;
    }
    var merges = [], midx = 0;
    var rowinfo = ws["!rows"] || (ws["!rows"] = []);
    var _R = 0, R = 0, _C = 0, C = 0, RS = 0, CS = 0;
    if (!ws["!cols"])
      ws["!cols"] = [];
    for (; _R < rows.length && R < sheetRows; ++_R) {
      var row = rows[_R];
      if (is_dom_element_hidden(row)) {
        if (opts.display)
          continue;
        rowinfo[R] = { hidden: true };
      }
      var elts = row.cells;
      for (_C = C = 0; _C < elts.length; ++_C) {
        var elt = elts[_C];
        if (opts.display && is_dom_element_hidden(elt))
          continue;
        var v = elt.hasAttribute("data-v") ? elt.getAttribute("data-v") : elt.hasAttribute("v") ? elt.getAttribute("v") : htmldecode(elt.innerHTML);
        var z = elt.getAttribute("data-z") || elt.getAttribute("z");
        for (midx = 0; midx < merges.length; ++midx) {
          var m = merges[midx];
          if (m.s.c == C + or_C && m.s.r < R + or_R && R + or_R <= m.e.r) {
            C = m.e.c + 1 - or_C;
            midx = -1;
          }
        }
        CS = +elt.getAttribute("colspan") || 1;
        if ((RS = +elt.getAttribute("rowspan") || 1) > 1 || CS > 1)
          merges.push({ s: { r: R + or_R, c: C + or_C }, e: { r: R + or_R + (RS || 1) - 1, c: C + or_C + (CS || 1) - 1 } });
        var o = { t: "s", v };
        var _t = elt.getAttribute("data-t") || elt.getAttribute("t") || "";
        if (v != null) {
          if (v.length == 0)
            o.t = _t || "z";
          else if (opts.raw || v.trim().length == 0 || _t == "s") {
          } else if (_t == "e" && BErr[+v])
            o = { t: "e", v: +v, w: BErr[+v] };
          else if (v === "TRUE")
            o = { t: "b", v: true };
          else if (v === "FALSE")
            o = { t: "b", v: false };
          else if (!isNaN(fuzzynum(v)))
            o = { t: "n", v: fuzzynum(v) };
          else if (!isNaN(fuzzydate(v).getDate())) {
            o = { t: "d", v: parseDate(v) };
            if (opts.UTC)
              o.v = local_to_utc(o.v);
            if (!opts.cellDates)
              o = { t: "n", v: datenum(o.v) };
            o.z = opts.dateNF || table_fmt[14];
          } else if (v.charCodeAt(0) == 35 && RBErr[v] != null)
            o = { t: "e", v: RBErr[v], w: v };
        }
        if (o.z === void 0 && z != null)
          o.z = z;
        var l = "", Aelts = elt.getElementsByTagName("A");
        if (Aelts && Aelts.length) {
          for (var Aelti = 0; Aelti < Aelts.length; ++Aelti)
            if (Aelts[Aelti].hasAttribute("href")) {
              l = Aelts[Aelti].getAttribute("href");
              if (l.charAt(0) != "#")
                break;
            }
        }
        if (l && l.charAt(0) != "#" && l.slice(0, 11).toLowerCase() != "javascript:")
          o.l = { Target: l };
        if (dense) {
          if (!ws["!data"][R + or_R])
            ws["!data"][R + or_R] = [];
          ws["!data"][R + or_R][C + or_C] = o;
        } else
          ws[encode_cell({ c: C + or_C, r: R + or_R })] = o;
        if (range.e.c < C + or_C)
          range.e.c = C + or_C;
        C += CS;
      }
      ++R;
    }
    if (merges.length)
      ws["!merges"] = (ws["!merges"] || []).concat(merges);
    range.e.r = Math.max(range.e.r, R - 1 + or_R);
    ws["!ref"] = encode_range(range);
    if (R >= sheetRows)
      ws["!fullref"] = encode_range((range.e.r = rows.length - _R + R - 1 + or_R, range));
    return ws;
  }
  function parse_dom_table(table, _opts) {
    var opts = _opts || {};
    var ws = {};
    if (opts.dense)
      ws["!data"] = [];
    return sheet_add_dom(ws, table, _opts);
  }
  function table_to_book(table, opts) {
    var o = sheet_to_workbook(parse_dom_table(table, opts), opts);
    return o;
  }
  function is_dom_element_hidden(element) {
    var display = "";
    var get_computed_style = get_get_computed_style_function(element);
    if (get_computed_style)
      display = get_computed_style(element).getPropertyValue("display");
    if (!display)
      display = element.style && element.style.display;
    return display === "none";
  }
  function get_get_computed_style_function(element) {
    if (element.ownerDocument.defaultView && typeof element.ownerDocument.defaultView.getComputedStyle === "function")
      return element.ownerDocument.defaultView.getComputedStyle;
    if (typeof getComputedStyle === "function")
      return getComputedStyle;
    return null;
  }
  var subarray = function() {
    try {
      if (typeof Uint8Array == "undefined")
        return "slice";
      if (typeof Uint8Array.prototype.subarray == "undefined")
        return "slice";
      if (typeof Buffer !== "undefined") {
        if (typeof Buffer.prototype.subarray == "undefined")
          return "slice";
        if ((typeof Buffer.from == "function" ? Buffer.from([72, 62]) : new Buffer([72, 62])) instanceof Uint8Array)
          return "subarray";
        return "slice";
      }
      return "subarray";
    } catch (e) {
      return "slice";
    }
  }();
  function fix_opts_func(defaults) {
    return function fix_opts(opts) {
      for (var i = 0; i != defaults.length; ++i) {
        var d = defaults[i];
        if (opts[d[0]] === void 0)
          opts[d[0]] = d[1];
        if (d[2] === "n")
          opts[d[0]] = Number(opts[d[0]]);
      }
    };
  }
  function fix_write_opts(opts) {
    fix_opts_func([
      ["cellDates", false],
      /* write date cells with type `d` */
      ["bookSST", false],
      /* Generate Shared String Table */
      ["bookType", "xlsx"],
      /* Type of workbook (xlsx/m/b) */
      ["compression", false],
      /* Use file compression */
      ["WTF", false]
      /* WTF mode (throws errors) */
    ])(opts);
  }
  function write_zip_xlsx(wb, opts) {
    if (wb && !wb.SSF) {
      wb.SSF = dup(table_fmt);
    }
    if (wb && wb.SSF) {
      make_ssf();
      SSF_load_table(wb.SSF);
      opts.revssf = evert_num(wb.SSF);
      opts.revssf[wb.SSF[65535]] = 0;
      opts.ssf = wb.SSF;
    }
    opts.rels = {};
    opts.wbrels = {};
    opts.Strings = /*::((*/
    [];
    opts.Strings.Count = 0;
    opts.Strings.Unique = 0;
    if (browser_has_Map)
      opts.revStrings = /* @__PURE__ */ new Map();
    else {
      opts.revStrings = {};
      opts.revStrings.foo = [];
      delete opts.revStrings.foo;
    }
    var wbext = "xml";
    var vbafmt = VBAFMTS.indexOf(opts.bookType) > -1;
    var ct = new_ct();
    fix_write_opts(opts = opts || {});
    var zip = zip_new();
    var f = "", rId = 0;
    opts.cellXfs = [];
    get_cell_style(opts.cellXfs, {}, { revssf: { "General": 0 } });
    if (!wb.Props)
      wb.Props = {};
    f = "docProps/core.xml";
    zip_add_file(zip, f, write_core_props(wb.Props, opts));
    ct.coreprops.push(f);
    add_rels(opts.rels, 2, f, RELS.CORE_PROPS);
    f = "docProps/app.xml";
    if (wb.Props && wb.Props.SheetNames) {
    } else if (!wb.Workbook || !wb.Workbook.Sheets)
      wb.Props.SheetNames = wb.SheetNames;
    else {
      var _sn = [];
      for (var _i = 0; _i < wb.SheetNames.length; ++_i)
        if ((wb.Workbook.Sheets[_i] || {}).Hidden != 2)
          _sn.push(wb.SheetNames[_i]);
      wb.Props.SheetNames = _sn;
    }
    wb.Props.Worksheets = wb.Props.SheetNames.length;
    zip_add_file(zip, f, write_ext_props(wb.Props, opts));
    ct.extprops.push(f);
    add_rels(opts.rels, 3, f, RELS.EXT_PROPS);
    if (wb.Custprops !== wb.Props && keys(wb.Custprops || {}).length > 0) {
      f = "docProps/custom.xml";
      zip_add_file(zip, f, write_cust_props(wb.Custprops, opts));
      ct.custprops.push(f);
      add_rels(opts.rels, 4, f, RELS.CUST_PROPS);
    }
    var people = ["SheetJ5"];
    opts.tcid = 0;
    for (rId = 1; rId <= wb.SheetNames.length; ++rId) {
      var wsrels = { "!id": {} };
      var ws = wb.Sheets[wb.SheetNames[rId - 1]];
      var _type = (ws || {})["!type"] || "sheet";
      switch (_type) {
        case "chart":
        default:
          f = "xl/worksheets/sheet" + rId + "." + wbext;
          zip_add_file(zip, f, write_ws_xml(rId - 1, opts, wb, wsrels));
          ct.sheets.push(f);
          add_rels(opts.wbrels, -1, "worksheets/sheet" + rId + "." + wbext, RELS.WS[0]);
      }
      if (ws) {
        var comments = ws["!comments"];
        var need_vml = false;
        var cf = "";
        if (comments && comments.length > 0) {
          var needtc = false;
          comments.forEach(function(carr) {
            carr[1].forEach(function(c) {
              if (c.T == true)
                needtc = true;
            });
          });
          if (needtc) {
            cf = "xl/threadedComments/threadedComment" + rId + ".xml";
            zip_add_file(zip, cf, write_tcmnt_xml(comments, people, opts));
            ct.threadedcomments.push(cf);
            add_rels(wsrels, -1, "../threadedComments/threadedComment" + rId + ".xml", RELS.TCMNT);
          }
          cf = "xl/comments" + rId + "." + wbext;
          zip_add_file(zip, cf, write_comments_xml(comments, opts));
          ct.comments.push(cf);
          add_rels(wsrels, -1, "../comments" + rId + "." + wbext, RELS.CMNT);
          need_vml = true;
        }
        if (ws["!legacy"]) {
          if (need_vml)
            zip_add_file(zip, "xl/drawings/vmlDrawing" + rId + ".vml", write_vml(rId, ws["!comments"]));
        }
        delete ws["!comments"];
        delete ws["!legacy"];
      }
      if (wsrels["!id"].rId1)
        zip_add_file(zip, get_rels_path(f), write_rels(wsrels));
    }
    if (opts.Strings != null && opts.Strings.length > 0) {
      f = "xl/sharedStrings." + wbext;
      zip_add_file(zip, f, write_sst_xml(opts.Strings, opts));
      ct.strs.push(f);
      add_rels(opts.wbrels, -1, "sharedStrings." + wbext, RELS.SST);
    }
    f = "xl/workbook." + wbext;
    zip_add_file(zip, f, write_wb_xml(wb, opts));
    ct.workbooks.push(f);
    add_rels(opts.rels, 1, f, RELS.WB);
    f = "xl/theme/theme1.xml";
    zip_add_file(zip, f, write_theme(wb.Themes, opts));
    ct.themes.push(f);
    add_rels(opts.wbrels, -1, "theme/theme1.xml", RELS.THEME);
    f = "xl/styles." + wbext;
    zip_add_file(zip, f, write_sty_xml(wb, opts));
    ct.styles.push(f);
    add_rels(opts.wbrels, -1, "styles." + wbext, RELS.STY);
    if (wb.vbaraw && vbafmt) {
      f = "xl/vbaProject.bin";
      zip_add_file(zip, f, wb.vbaraw);
      ct.vba.push(f);
      add_rels(opts.wbrels, -1, "vbaProject.bin", RELS.VBA);
    }
    f = "xl/metadata." + wbext;
    zip_add_file(zip, f, write_xlmeta_xml());
    ct.metadata.push(f);
    add_rels(opts.wbrels, -1, "metadata." + wbext, RELS.XLMETA);
    if (people.length > 1) {
      f = "xl/persons/person.xml";
      zip_add_file(zip, f, write_people_xml(people, opts));
      ct.people.push(f);
      add_rels(opts.wbrels, -1, "persons/person.xml", RELS.PEOPLE);
    }
    zip_add_file(zip, "[Content_Types].xml", write_ct(ct, opts));
    zip_add_file(zip, "_rels/.rels", write_rels(opts.rels));
    zip_add_file(zip, "xl/_rels/workbook." + wbext + ".rels", write_rels(opts.wbrels));
    delete opts.revssf;
    delete opts.ssf;
    return zip;
  }
  function write_cfb_ctr(cfb, o) {
    switch (o.type) {
      case "base64":
      case "binary":
        break;
      case "buffer":
      case "array":
        o.type = "";
        break;
      case "file":
        return write_dl(o.file, CFB.write(cfb, { type: has_buf ? "buffer" : "" }));
      case "string":
        throw new Error("'string' output type invalid for '" + o.bookType + "' files");
      default:
        throw new Error("Unrecognized type " + o.type);
    }
    return CFB.write(cfb, o);
  }
  function write_zip_typeXLSX(wb, opts) {
    var o = dup(opts || {});
    var z = write_zip_xlsx(wb, o);
    return write_zip_denouement(z, o);
  }
  function write_zip_denouement(z, o) {
    var oopts = {};
    var ftype = has_buf ? "nodebuffer" : typeof Uint8Array !== "undefined" ? "array" : "string";
    if (o.compression)
      oopts.compression = "DEFLATE";
    if (o.password)
      oopts.type = ftype;
    else
      switch (o.type) {
        case "base64":
          oopts.type = "base64";
          break;
        case "binary":
          oopts.type = "string";
          break;
        case "string":
          throw new Error("'string' output type invalid for '" + o.bookType + "' files");
        case "buffer":
        case "file":
          oopts.type = ftype;
          break;
        default:
          throw new Error("Unrecognized type " + o.type);
      }
    var out = z.FullPaths ? CFB.write(z, { fileType: "zip", type: (
      /*::(*/
      { "nodebuffer": "buffer", "string": "binary" }[oopts.type] || oopts.type
    ), compression: !!o.compression }) : z.generate(oopts);
    if (typeof Deno !== "undefined") {
      if (typeof out == "string") {
        if (o.type == "binary" || o.type == "base64")
          return out;
        out = new Uint8Array(s2ab(out));
      }
    }
    if (o.password && typeof encrypt_agile !== "undefined")
      return write_cfb_ctr(encrypt_agile(out, o.password), o);
    if (o.type === "file")
      return write_dl(o.file, out);
    return o.type == "string" ? utf8read(
      /*::(*/
      out
      /*:: :any)*/
    ) : out;
  }
  function writeSyncXLSX(wb, opts) {
    reset_cp();
    check_wb(wb);
    var o = dup(opts || {});
    if (o.cellStyles) {
      o.cellNF = true;
      o.sheetStubs = true;
    }
    if (o.type == "array") {
      o.type = "binary";
      var out = writeSyncXLSX(wb, o);
      o.type = "array";
      return s2ab(out);
    }
    return write_zip_typeXLSX(wb, o);
  }
  function resolve_book_type(o) {
    if (o.bookType)
      return;
    var _BT = {
      "xls": "biff8",
      "htm": "html",
      "slk": "sylk",
      "socialcalc": "eth",
      "Sh33tJS": "WTF"
    };
    var ext = o.file.slice(o.file.lastIndexOf(".")).toLowerCase();
    if (ext.match(/^\.[a-z]+$/))
      o.bookType = ext.slice(1);
    o.bookType = _BT[o.bookType] || o.bookType;
  }
  function writeFileSyncXLSX(wb, filename, opts) {
    var o = opts || {};
    o.type = "file";
    o.file = filename;
    resolve_book_type(o);
    return writeSyncXLSX(wb, o);
  }
  function make_json_row(sheet, r, R, cols, header, hdr, o) {
    var rr = encode_row(R);
    var defval = o.defval, raw = o.raw || !Object.prototype.hasOwnProperty.call(o, "raw");
    var isempty = true, dense = sheet["!data"] != null;
    var row = header === 1 ? [] : {};
    if (header !== 1) {
      if (Object.defineProperty)
        try {
          Object.defineProperty(row, "__rowNum__", { value: R, enumerable: false });
        } catch (e) {
          row.__rowNum__ = R;
        }
      else
        row.__rowNum__ = R;
    }
    if (!dense || sheet["!data"][R])
      for (var C = r.s.c; C <= r.e.c; ++C) {
        var val2 = dense ? (sheet["!data"][R] || [])[C] : sheet[cols[C] + rr];
        if (val2 == null || val2.t === void 0) {
          if (defval === void 0)
            continue;
          if (hdr[C] != null) {
            row[hdr[C]] = defval;
          }
          continue;
        }
        var v = val2.v;
        switch (val2.t) {
          case "z":
            if (v == null)
              break;
            continue;
          case "e":
            v = v == 0 ? null : void 0;
            break;
          case "s":
          case "b":
          case "n":
            if (!val2.z || !fmt_is_date(val2.z))
              break;
            v = numdate(v);
            if (typeof v == "number")
              break;
          case "d":
            if (!(o && (o.UTC || o.raw === false)))
              v = utc_to_local(new Date(v));
            break;
          default:
            throw new Error("unrecognized type " + val2.t);
        }
        if (hdr[C] != null) {
          if (v == null) {
            if (val2.t == "e" && v === null)
              row[hdr[C]] = null;
            else if (defval !== void 0)
              row[hdr[C]] = defval;
            else if (raw && v === null)
              row[hdr[C]] = null;
            else
              continue;
          } else {
            row[hdr[C]] = (val2.t === "n" && typeof o.rawNumbers === "boolean" ? o.rawNumbers : raw) ? v : format_cell(val2, v, o);
          }
          if (v != null)
            isempty = false;
        }
      }
    return { row, isempty };
  }
  function sheet_to_json(sheet, opts) {
    if (sheet == null || sheet["!ref"] == null)
      return [];
    var val2 = { t: "n", v: 0 }, header = 0, offset = 1, hdr = [], v = 0, vv = "";
    var r = { s: { r: 0, c: 0 }, e: { r: 0, c: 0 } };
    var o = opts || {};
    var range = o.range != null ? o.range : sheet["!ref"];
    if (o.header === 1)
      header = 1;
    else if (o.header === "A")
      header = 2;
    else if (Array.isArray(o.header))
      header = 3;
    else if (o.header == null)
      header = 0;
    switch (typeof range) {
      case "string":
        r = safe_decode_range(range);
        break;
      case "number":
        r = safe_decode_range(sheet["!ref"]);
        r.s.r = range;
        break;
      default:
        r = range;
    }
    if (header > 0)
      offset = 0;
    var rr = encode_row(r.s.r);
    var cols = [];
    var out = [];
    var outi = 0, counter = 0;
    var dense = sheet["!data"] != null;
    var R = r.s.r, C = 0;
    var header_cnt = {};
    if (dense && !sheet["!data"][R])
      sheet["!data"][R] = [];
    var colinfo = o.skipHidden && sheet["!cols"] || [];
    var rowinfo = o.skipHidden && sheet["!rows"] || [];
    for (C = r.s.c; C <= r.e.c; ++C) {
      if ((colinfo[C] || {}).hidden)
        continue;
      cols[C] = encode_col(C);
      val2 = dense ? sheet["!data"][R][C] : sheet[cols[C] + rr];
      switch (header) {
        case 1:
          hdr[C] = C - r.s.c;
          break;
        case 2:
          hdr[C] = cols[C];
          break;
        case 3:
          hdr[C] = o.header[C - r.s.c];
          break;
        default:
          if (val2 == null)
            val2 = { w: "__EMPTY", t: "s" };
          vv = v = format_cell(val2, null, o);
          counter = header_cnt[v] || 0;
          if (!counter)
            header_cnt[v] = 1;
          else {
            do {
              vv = v + "_" + counter++;
            } while (header_cnt[vv]);
            header_cnt[v] = counter;
            header_cnt[vv] = 1;
          }
          hdr[C] = vv;
      }
    }
    for (R = r.s.r + offset; R <= r.e.r; ++R) {
      if ((rowinfo[R] || {}).hidden)
        continue;
      var row = make_json_row(sheet, r, R, cols, header, hdr, o);
      if (row.isempty === false || (header === 1 ? o.blankrows !== false : !!o.blankrows))
        out[outi++] = row.row;
    }
    out.length = outi;
    return out;
  }
  var qreg = /"/g;
  function make_csv_row(sheet, r, R, cols, fs, rs, FS, w, o) {
    var isempty = true;
    var row = [], txt = "", rr = encode_row(R);
    var dense = sheet["!data"] != null;
    var datarow = dense && sheet["!data"][R] || [];
    for (var C = r.s.c; C <= r.e.c; ++C) {
      if (!cols[C])
        continue;
      var val2 = dense ? datarow[C] : sheet[cols[C] + rr];
      if (val2 == null)
        txt = "";
      else if (val2.v != null) {
        isempty = false;
        txt = "" + (o.rawNumbers && val2.t == "n" ? val2.v : format_cell(val2, null, o));
        for (var i = 0, cc = 0; i !== txt.length; ++i)
          if ((cc = txt.charCodeAt(i)) === fs || cc === rs || cc === 34 || o.forceQuotes) {
            txt = '"' + txt.replace(qreg, '""') + '"';
            break;
          }
        if (txt == "ID" && w == 0 && row.length == 0)
          txt = '"ID"';
      } else if (val2.f != null && !val2.F) {
        isempty = false;
        txt = "=" + val2.f;
        if (txt.indexOf(",") >= 0)
          txt = '"' + txt.replace(qreg, '""') + '"';
      } else
        txt = "";
      row.push(txt);
    }
    if (o.strip)
      while (row[row.length - 1] === "")
        --row.length;
    if (o.blankrows === false && isempty)
      return null;
    return row.join(FS);
  }
  function sheet_to_csv(sheet, opts) {
    var out = [];
    var o = opts == null ? {} : opts;
    if (sheet == null || sheet["!ref"] == null)
      return "";
    var r = safe_decode_range(sheet["!ref"]);
    var FS = o.FS !== void 0 ? o.FS : ",", fs = FS.charCodeAt(0);
    var RS = o.RS !== void 0 ? o.RS : "\n", rs = RS.charCodeAt(0);
    var row = "", cols = [];
    var colinfo = o.skipHidden && sheet["!cols"] || [];
    var rowinfo = o.skipHidden && sheet["!rows"] || [];
    for (var C = r.s.c; C <= r.e.c; ++C)
      if (!(colinfo[C] || {}).hidden)
        cols[C] = encode_col(C);
    var w = 0;
    for (var R = r.s.r; R <= r.e.r; ++R) {
      if ((rowinfo[R] || {}).hidden)
        continue;
      row = make_csv_row(sheet, r, R, cols, fs, rs, FS, w, o);
      if (row == null) {
        continue;
      }
      if (row || o.blankrows !== false)
        out.push((w++ ? RS : "") + row);
    }
    return out.join("");
  }
  function sheet_to_txt(sheet, opts) {
    if (!opts)
      opts = {};
    opts.FS = "	";
    opts.RS = "\n";
    var s = sheet_to_csv(sheet, opts);
    if (typeof $cptable == "undefined" || opts.type == "string")
      return s;
    var o = $cptable.utils.encode(1200, s, "str");
    return String.fromCharCode(255) + String.fromCharCode(254) + o;
  }
  function sheet_to_formulae(sheet, opts) {
    var y = "", x, val2 = "";
    if (sheet == null || sheet["!ref"] == null)
      return [];
    var r = safe_decode_range(sheet["!ref"]), rr = "", cols = [], C;
    var cmds = [];
    var dense = sheet["!data"] != null;
    for (C = r.s.c; C <= r.e.c; ++C)
      cols[C] = encode_col(C);
    for (var R = r.s.r; R <= r.e.r; ++R) {
      rr = encode_row(R);
      for (C = r.s.c; C <= r.e.c; ++C) {
        y = cols[C] + rr;
        x = dense ? (sheet["!data"][R] || [])[C] : sheet[y];
        val2 = "";
        if (x === void 0)
          continue;
        else if (x.F != null) {
          y = x.F;
          if (!x.f)
            continue;
          val2 = x.f;
          if (y.indexOf(":") == -1)
            y = y + ":" + y;
        }
        if (x.f != null)
          val2 = x.f;
        else if (opts && opts.values === false)
          continue;
        else if (x.t == "z")
          continue;
        else if (x.t == "n" && x.v != null)
          val2 = "" + x.v;
        else if (x.t == "b")
          val2 = x.v ? "TRUE" : "FALSE";
        else if (x.w !== void 0)
          val2 = "'" + x.w;
        else if (x.v === void 0)
          continue;
        else if (x.t == "s")
          val2 = "'" + x.v;
        else
          val2 = "" + x.v;
        cmds[cmds.length] = y + "=" + val2;
      }
    }
    return cmds;
  }
  function sheet_add_json(_ws, js, opts) {
    var o = opts || {};
    var dense = _ws ? _ws["!data"] != null : o.dense;
    if (DENSE != null && dense == null)
      dense = DENSE;
    var offset = +!o.skipHeader;
    var ws = _ws || {};
    if (!_ws && dense)
      ws["!data"] = [];
    var _R = 0, _C = 0;
    if (ws && o.origin != null) {
      if (typeof o.origin == "number")
        _R = o.origin;
      else {
        var _origin = typeof o.origin == "string" ? decode_cell(o.origin) : o.origin;
        _R = _origin.r;
        _C = _origin.c;
      }
    }
    var range = { s: { c: 0, r: 0 }, e: { c: _C, r: _R + js.length - 1 + offset } };
    if (ws["!ref"]) {
      var _range = safe_decode_range(ws["!ref"]);
      range.e.c = Math.max(range.e.c, _range.e.c);
      range.e.r = Math.max(range.e.r, _range.e.r);
      if (_R == -1) {
        _R = _range.e.r + 1;
        range.e.r = _R + js.length - 1 + offset;
      }
    } else {
      if (_R == -1) {
        _R = 0;
        range.e.r = js.length - 1 + offset;
      }
    }
    var hdr = o.header || [], C = 0;
    var ROW = [];
    js.forEach(function(JS, R) {
      if (dense && !ws["!data"][_R + R + offset])
        ws["!data"][_R + R + offset] = [];
      if (dense)
        ROW = ws["!data"][_R + R + offset];
      keys(JS).forEach(function(k) {
        if ((C = hdr.indexOf(k)) == -1)
          hdr[C = hdr.length] = k;
        var v = JS[k];
        var t = "z";
        var z = "";
        var ref = dense ? "" : encode_col(_C + C) + encode_row(_R + R + offset);
        var cell = dense ? ROW[_C + C] : ws[ref];
        if (v && typeof v === "object" && !(v instanceof Date)) {
          if (dense)
            ROW[_C + C] = v;
          else
            ws[ref] = v;
        } else {
          if (typeof v == "number")
            t = "n";
          else if (typeof v == "boolean")
            t = "b";
          else if (typeof v == "string")
            t = "s";
          else if (v instanceof Date) {
            t = "d";
            if (!o.UTC)
              v = local_to_utc(v);
            if (!o.cellDates) {
              t = "n";
              v = datenum(v);
            }
            z = cell != null && cell.z && fmt_is_date(cell.z) ? cell.z : o.dateNF || table_fmt[14];
          } else if (v === null && o.nullError) {
            t = "e";
            v = 0;
          }
          if (!cell) {
            if (!dense)
              ws[ref] = cell = { t, v };
            else
              ROW[_C + C] = cell = { t, v };
          } else {
            cell.t = t;
            cell.v = v;
            delete cell.w;
            delete cell.R;
            if (z)
              cell.z = z;
          }
          if (z)
            cell.z = z;
        }
      });
    });
    range.e.c = Math.max(range.e.c, _C + hdr.length - 1);
    var __R = encode_row(_R);
    if (dense && !ws["!data"][_R])
      ws["!data"][_R] = [];
    if (offset)
      for (C = 0; C < hdr.length; ++C) {
        if (dense)
          ws["!data"][_R][C + _C] = { t: "s", v: hdr[C] };
        else
          ws[encode_col(C + _C) + __R] = { t: "s", v: hdr[C] };
      }
    ws["!ref"] = encode_range(range);
    return ws;
  }
  function json_to_sheet(js, opts) {
    return sheet_add_json(null, js, opts);
  }
  function ws_get_cell_stub(ws, R, C) {
    if (typeof R == "string") {
      if (ws["!data"] != null) {
        var RC = decode_cell(R);
        if (!ws["!data"][RC.r])
          ws["!data"][RC.r] = [];
        return ws["!data"][RC.r][RC.c] || (ws["!data"][RC.r][RC.c] = { t: "z" });
      }
      return ws[R] || (ws[R] = { t: "z" });
    }
    if (typeof R != "number")
      return ws_get_cell_stub(ws, encode_cell(R));
    return ws_get_cell_stub(ws, encode_col(C || 0) + encode_row(R));
  }
  function wb_sheet_idx(wb, sh) {
    if (typeof sh == "number") {
      if (sh >= 0 && wb.SheetNames.length > sh)
        return sh;
      throw new Error("Cannot find sheet # " + sh);
    } else if (typeof sh == "string") {
      var idx = wb.SheetNames.indexOf(sh);
      if (idx > -1)
        return idx;
      throw new Error("Cannot find sheet name |" + sh + "|");
    } else
      throw new Error("Cannot find sheet |" + sh + "|");
  }
  function book_new(ws, wsname) {
    var wb = { SheetNames: [], Sheets: {} };
    if (ws)
      book_append_sheet(wb, ws, wsname || "Sheet1");
    return wb;
  }
  function book_append_sheet(wb, ws, name, roll) {
    var i = 1;
    if (!name) {
      for (; i <= 65535; ++i, name = void 0)
        if (wb.SheetNames.indexOf(name = "Sheet" + i) == -1)
          break;
    }
    if (!name || wb.SheetNames.length >= 65535)
      throw new Error("Too many worksheets");
    if (roll && wb.SheetNames.indexOf(name) >= 0 && name.length < 32) {
      var m = name.match(/\d+$/);
      i = m && +m[0] || 0;
      var root = m && name.slice(0, m.index) || name;
      for (++i; i <= 65535; ++i)
        if (wb.SheetNames.indexOf(name = root + i) == -1)
          break;
    }
    check_ws_name(name);
    if (wb.SheetNames.indexOf(name) >= 0)
      throw new Error("Worksheet with name |" + name + "| already exists!");
    wb.SheetNames.push(name);
    wb.Sheets[name] = ws;
    return name;
  }
  function book_set_sheet_visibility(wb, sh, vis) {
    if (!wb.Workbook)
      wb.Workbook = {};
    if (!wb.Workbook.Sheets)
      wb.Workbook.Sheets = [];
    var idx = wb_sheet_idx(wb, sh);
    if (!wb.Workbook.Sheets[idx])
      wb.Workbook.Sheets[idx] = {};
    switch (vis) {
      case 0:
      case 1:
      case 2:
        break;
      default:
        throw new Error("Bad sheet visibility setting " + vis);
    }
    wb.Workbook.Sheets[idx].Hidden = vis;
  }
  function cell_set_number_format(cell, fmt) {
    cell.z = fmt;
    return cell;
  }
  function cell_set_hyperlink(cell, target, tooltip) {
    if (!target) {
      delete cell.l;
    } else {
      cell.l = { Target: target };
      if (tooltip)
        cell.l.Tooltip = tooltip;
    }
    return cell;
  }
  function cell_set_internal_link(cell, range, tooltip) {
    return cell_set_hyperlink(cell, "#" + range, tooltip);
  }
  function cell_add_comment(cell, text, author) {
    if (!cell.c)
      cell.c = [];
    cell.c.push({ t: text, a: author || "SheetJS" });
  }
  function sheet_set_array_formula(ws, range, formula, dynamic) {
    var rng = typeof range != "string" ? range : safe_decode_range(range);
    var rngstr = typeof range == "string" ? range : encode_range(range);
    for (var R = rng.s.r; R <= rng.e.r; ++R)
      for (var C = rng.s.c; C <= rng.e.c; ++C) {
        var cell = ws_get_cell_stub(ws, R, C);
        cell.t = "n";
        cell.F = rngstr;
        delete cell.v;
        if (R == rng.s.r && C == rng.s.c) {
          cell.f = formula;
          if (dynamic)
            cell.D = true;
        }
      }
    var wsr = decode_range(ws["!ref"]);
    if (wsr.s.r > rng.s.r)
      wsr.s.r = rng.s.r;
    if (wsr.s.c > rng.s.c)
      wsr.s.c = rng.s.c;
    if (wsr.e.r < rng.e.r)
      wsr.e.r = rng.e.r;
    if (wsr.e.c < rng.e.c)
      wsr.e.c = rng.e.c;
    ws["!ref"] = encode_range(wsr);
    return ws;
  }
  var utils = {
    encode_col,
    encode_row,
    encode_cell,
    encode_range,
    decode_col,
    decode_row,
    split_cell,
    decode_cell,
    decode_range,
    format_cell,
    sheet_new,
    sheet_add_aoa,
    sheet_add_json,
    sheet_add_dom,
    aoa_to_sheet,
    json_to_sheet,
    table_to_sheet: parse_dom_table,
    table_to_book,
    sheet_to_csv,
    sheet_to_txt,
    sheet_to_json,
    sheet_to_html,
    sheet_to_formulae,
    sheet_to_row_object_array: sheet_to_json,
    sheet_get_cell: ws_get_cell_stub,
    book_new,
    book_append_sheet,
    book_set_sheet_visibility,
    cell_set_number_format,
    cell_set_hyperlink,
    cell_set_internal_link,
    cell_add_comment,
    sheet_set_array_formula,
    consts: {
      SHEET_VISIBLE: 0,
      SHEET_HIDDEN: 1,
      SHEET_VERY_HIDDEN: 2
    }
  };
  var version = XLSX.version;

  // src/AppReservasAdmin/BotaoExportarXLS.jsx
  var import_prop_types4 = __toESM(require_prop_types());
  var import_jsx_runtime4 = __toESM(require_jsx_runtime());
  var BotaoExportarXLS = ({ _ref }) => {
    return /* @__PURE__ */ (0, import_jsx_runtime4.jsx)(
      "button",
      {
        onClick: () => {
          const wb = utils.table_to_book(_ref.current);
          writeFileSyncXLSX(wb, "SheetJSReactExport.xlsx");
        },
        id: "exportSheetBtn",
        children: "Exportar XLS"
      }
    );
  };
  BotaoExportarXLS.propTypes = {
    _ref: import_prop_types4.default.object.isRequired
  };
  var BotaoExportarXLS_default = BotaoExportarXLS;

  // src/AppReservasAdmin/AppReservasAdmin.jsx
  var import_jsx_runtime5 = __toESM(require_jsx_runtime());
  function AppReservasAdmin({ ajaxUrl }) {
    const [toast, setToast] = React.useState(false);
    const [reservas, setReservas] = React.useState(null);
    const [reservas_f, setReservas_f] = React.useState([]);
    const [excDetails, setExcDetails] = React.useState(null);
    const [excDetails2, setExcDetails2] = React.useState(null);
    const [filter, setFilter] = React.useState(0);
    const tableToSheetRef = React.useRef(null);
    const adminAjax = useAdminAjax_default(ajaxUrl);
    React.useEffect(() => {
      adminAjax.get_reservas(setReservas, setExcDetails);
    }, []);
    React.useEffect(() => {
      if (excDetails)
        setExcDetails2(Object.values(excDetails));
    }, [excDetails]);
    React.useEffect(() => {
      const sheetBtn = document.querySelector("#exportSheetBtn");
      const thead_embarque = document.querySelector(
        '#adminReservasTable thead th[data-coluna="embarque"]'
      );
      if (filter > 0) {
        setReservas_f(
          reservas.filter((r) => {
            if (r.variation_id == filter)
              return r;
          })
        );
        if (thead_embarque)
          thead_embarque.classList.add("sort-enabled");
        if (sheetBtn)
          sheetBtn.removeAttribute("disabled");
      } else {
        setReservas_f([]);
        if (thead_embarque)
          thead_embarque.classList.remove("sort-enabled");
        if (sheetBtn)
          sheetBtn.setAttribute("disabled", "true");
      }
    }, [filter]);
    function ordenarPassageiros({ target }) {
      if (target.classList.contains("sort-enabled")) {
        let reservas_ordenadas = {};
        reservas_f.forEach((_reserva) => {
          if (typeof reservas_ordenadas[_reserva.embarque] == "undefined") {
            reservas_ordenadas[_reserva.embarque] = [];
          }
          reservas_ordenadas[_reserva.embarque].push(_reserva);
        });
        let _res_fil_ord = [];
        Object.keys(reservas_ordenadas).forEach((_local_emb) => {
          _res_fil_ord = [..._res_fil_ord, ...reservas_ordenadas[_local_emb]];
        });
        setReservas_f(_res_fil_ord);
      }
    }
    return /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { id: "adminReservasTable", children: [
      toast ? /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(Toast_default, { message: toast, setToast }) : null,
      /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("div", { className: "filtros", children: [
        /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("div", { className: "exc-search", children: excDetails2 ? /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(
          SelectLiveSearch_default,
          {
            srcArray: excDetails2,
            setFilter,
            filter
          }
        ) : "carregado excurs\xF5es..." }),
        /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(BotaoExportarXLS_default, { _ref: tableToSheetRef })
      ] }),
      reservas ? /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("p", { children: [
        reservas_f.length > 0 ? reservas_f.length : reservas.length,
        " reservas"
      ] }) : null,
      /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("table", { ref: tableToSheetRef, children: [
        /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("thead", { children: /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("tr", { children: [
          /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("th", { "data-coluna": "order-id", children: "Pedido" }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("th", { "data-coluna": "excursao", children: "Excurs\xE3o" }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("th", { "data-coluna": "nome-completo", children: "Nome Completo" }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("th", { "data-coluna": "cpf", children: "CPF" }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("th", { "data-coluna": "telefone", children: "Telefone" }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("th", { "data-coluna": "embarque", onClick: ordenarPassageiros, children: "Embarque" }),
          /* @__PURE__ */ (0, import_jsx_runtime5.jsx)("th", { "data-coluna": "horario", children: "Hor\xE1rio" })
        ] }) }),
        /* @__PURE__ */ (0, import_jsx_runtime5.jsxs)("tbody", { children: [
          reservas && reservas_f.length > 0 ? reservas_f.map((reserva, _i) => {
            return /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(
              ItemReserva_default,
              {
                reserva,
                excDetails,
                setToast
              },
              _i
            );
          }) : null,
          reservas && reservas_f.length == 0 ? reservas.map((reserva) => {
            return /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(
              ItemReserva_default,
              {
                reserva,
                excDetails,
                adminAjax,
                setToast
              },
              reserva.ID
            );
          }) : null
        ] })
      ] })
    ] });
  }
  AppReservasAdmin.propTypes = {
    ajaxUrl: import_prop_types5.default.string.isRequired
  };
  var reserva_admin_app_root = document.getElementById("adminReservasApp");
  if (reserva_admin_app_root) {
    ReactDOM.createRoot(reserva_admin_app_root).render(
      /* @__PURE__ */ (0, import_jsx_runtime5.jsx)(AppReservasAdmin, { ajaxUrl: reserva_admin_app_root.dataset.ajaxUrl })
    );
  }
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

xlsx/xlsx.mjs:
  (*! xlsx.js (C) 2013-present SheetJS -- http://sheetjs.com *)

xlsx/xlsx.mjs:
  (*! sheetjs (C) 2013-present SheetJS -- http://sheetjs.com *)
*/
