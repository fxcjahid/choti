/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/alpinejs/dist/module.esm.js":
/*!**************************************************!*\
  !*** ./node_modules/alpinejs/dist/module.esm.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ module_default)
/* harmony export */ });
// packages/alpinejs/src/scheduler.js
var flushPending = false;
var flushing = false;
var queue = [];
function scheduler(callback) {
  queueJob(callback);
}
function queueJob(job) {
  if (!queue.includes(job))
    queue.push(job);
  queueFlush();
}
function dequeueJob(job) {
  let index = queue.indexOf(job);
  if (index !== -1)
    queue.splice(index, 1);
}
function queueFlush() {
  if (!flushing && !flushPending) {
    flushPending = true;
    queueMicrotask(flushJobs);
  }
}
function flushJobs() {
  flushPending = false;
  flushing = true;
  for (let i = 0; i < queue.length; i++) {
    queue[i]();
  }
  queue.length = 0;
  flushing = false;
}

// packages/alpinejs/src/reactivity.js
var reactive;
var effect;
var release;
var raw;
var shouldSchedule = true;
function disableEffectScheduling(callback) {
  shouldSchedule = false;
  callback();
  shouldSchedule = true;
}
function setReactivityEngine(engine) {
  reactive = engine.reactive;
  release = engine.release;
  effect = (callback) => engine.effect(callback, {scheduler: (task) => {
    if (shouldSchedule) {
      scheduler(task);
    } else {
      task();
    }
  }});
  raw = engine.raw;
}
function overrideEffect(override) {
  effect = override;
}
function elementBoundEffect(el) {
  let cleanup2 = () => {
  };
  let wrappedEffect = (callback) => {
    let effectReference = effect(callback);
    if (!el._x_effects) {
      el._x_effects = new Set();
      el._x_runEffects = () => {
        el._x_effects.forEach((i) => i());
      };
    }
    el._x_effects.add(effectReference);
    cleanup2 = () => {
      if (effectReference === void 0)
        return;
      el._x_effects.delete(effectReference);
      release(effectReference);
    };
    return effectReference;
  };
  return [wrappedEffect, () => {
    cleanup2();
  }];
}

// packages/alpinejs/src/mutation.js
var onAttributeAddeds = [];
var onElRemoveds = [];
var onElAddeds = [];
function onElAdded(callback) {
  onElAddeds.push(callback);
}
function onElRemoved(el, callback) {
  if (typeof callback === "function") {
    if (!el._x_cleanups)
      el._x_cleanups = [];
    el._x_cleanups.push(callback);
  } else {
    callback = el;
    onElRemoveds.push(callback);
  }
}
function onAttributesAdded(callback) {
  onAttributeAddeds.push(callback);
}
function onAttributeRemoved(el, name, callback) {
  if (!el._x_attributeCleanups)
    el._x_attributeCleanups = {};
  if (!el._x_attributeCleanups[name])
    el._x_attributeCleanups[name] = [];
  el._x_attributeCleanups[name].push(callback);
}
function cleanupAttributes(el, names) {
  if (!el._x_attributeCleanups)
    return;
  Object.entries(el._x_attributeCleanups).forEach(([name, value]) => {
    if (names === void 0 || names.includes(name)) {
      value.forEach((i) => i());
      delete el._x_attributeCleanups[name];
    }
  });
}
var observer = new MutationObserver(onMutate);
var currentlyObserving = false;
function startObservingMutations() {
  observer.observe(document, {subtree: true, childList: true, attributes: true, attributeOldValue: true});
  currentlyObserving = true;
}
function stopObservingMutations() {
  flushObserver();
  observer.disconnect();
  currentlyObserving = false;
}
var recordQueue = [];
var willProcessRecordQueue = false;
function flushObserver() {
  recordQueue = recordQueue.concat(observer.takeRecords());
  if (recordQueue.length && !willProcessRecordQueue) {
    willProcessRecordQueue = true;
    queueMicrotask(() => {
      processRecordQueue();
      willProcessRecordQueue = false;
    });
  }
}
function processRecordQueue() {
  onMutate(recordQueue);
  recordQueue.length = 0;
}
function mutateDom(callback) {
  if (!currentlyObserving)
    return callback();
  stopObservingMutations();
  let result = callback();
  startObservingMutations();
  return result;
}
var isCollecting = false;
var deferredMutations = [];
function deferMutations() {
  isCollecting = true;
}
function flushAndStopDeferringMutations() {
  isCollecting = false;
  onMutate(deferredMutations);
  deferredMutations = [];
}
function onMutate(mutations) {
  if (isCollecting) {
    deferredMutations = deferredMutations.concat(mutations);
    return;
  }
  let addedNodes = [];
  let removedNodes = [];
  let addedAttributes = new Map();
  let removedAttributes = new Map();
  for (let i = 0; i < mutations.length; i++) {
    if (mutations[i].target._x_ignoreMutationObserver)
      continue;
    if (mutations[i].type === "childList") {
      mutations[i].addedNodes.forEach((node) => node.nodeType === 1 && addedNodes.push(node));
      mutations[i].removedNodes.forEach((node) => node.nodeType === 1 && removedNodes.push(node));
    }
    if (mutations[i].type === "attributes") {
      let el = mutations[i].target;
      let name = mutations[i].attributeName;
      let oldValue = mutations[i].oldValue;
      let add2 = () => {
        if (!addedAttributes.has(el))
          addedAttributes.set(el, []);
        addedAttributes.get(el).push({name, value: el.getAttribute(name)});
      };
      let remove = () => {
        if (!removedAttributes.has(el))
          removedAttributes.set(el, []);
        removedAttributes.get(el).push(name);
      };
      if (el.hasAttribute(name) && oldValue === null) {
        add2();
      } else if (el.hasAttribute(name)) {
        remove();
        add2();
      } else {
        remove();
      }
    }
  }
  removedAttributes.forEach((attrs, el) => {
    cleanupAttributes(el, attrs);
  });
  addedAttributes.forEach((attrs, el) => {
    onAttributeAddeds.forEach((i) => i(el, attrs));
  });
  for (let node of removedNodes) {
    if (addedNodes.includes(node))
      continue;
    onElRemoveds.forEach((i) => i(node));
    if (node._x_cleanups) {
      while (node._x_cleanups.length)
        node._x_cleanups.pop()();
    }
  }
  addedNodes.forEach((node) => {
    node._x_ignoreSelf = true;
    node._x_ignore = true;
  });
  for (let node of addedNodes) {
    if (removedNodes.includes(node))
      continue;
    if (!node.isConnected)
      continue;
    delete node._x_ignoreSelf;
    delete node._x_ignore;
    onElAddeds.forEach((i) => i(node));
    node._x_ignore = true;
    node._x_ignoreSelf = true;
  }
  addedNodes.forEach((node) => {
    delete node._x_ignoreSelf;
    delete node._x_ignore;
  });
  addedNodes = null;
  removedNodes = null;
  addedAttributes = null;
  removedAttributes = null;
}

// packages/alpinejs/src/scope.js
function scope(node) {
  return mergeProxies(closestDataStack(node));
}
function addScopeToNode(node, data2, referenceNode) {
  node._x_dataStack = [data2, ...closestDataStack(referenceNode || node)];
  return () => {
    node._x_dataStack = node._x_dataStack.filter((i) => i !== data2);
  };
}
function refreshScope(element, scope2) {
  let existingScope = element._x_dataStack[0];
  Object.entries(scope2).forEach(([key, value]) => {
    existingScope[key] = value;
  });
}
function closestDataStack(node) {
  if (node._x_dataStack)
    return node._x_dataStack;
  if (typeof ShadowRoot === "function" && node instanceof ShadowRoot) {
    return closestDataStack(node.host);
  }
  if (!node.parentNode) {
    return [];
  }
  return closestDataStack(node.parentNode);
}
function mergeProxies(objects) {
  let thisProxy = new Proxy({}, {
    ownKeys: () => {
      return Array.from(new Set(objects.flatMap((i) => Object.keys(i))));
    },
    has: (target, name) => {
      return objects.some((obj) => obj.hasOwnProperty(name));
    },
    get: (target, name) => {
      return (objects.find((obj) => {
        if (obj.hasOwnProperty(name)) {
          let descriptor = Object.getOwnPropertyDescriptor(obj, name);
          if (descriptor.get && descriptor.get._x_alreadyBound || descriptor.set && descriptor.set._x_alreadyBound) {
            return true;
          }
          if ((descriptor.get || descriptor.set) && descriptor.enumerable) {
            let getter = descriptor.get;
            let setter = descriptor.set;
            let property = descriptor;
            getter = getter && getter.bind(thisProxy);
            setter = setter && setter.bind(thisProxy);
            if (getter)
              getter._x_alreadyBound = true;
            if (setter)
              setter._x_alreadyBound = true;
            Object.defineProperty(obj, name, {
              ...property,
              get: getter,
              set: setter
            });
          }
          return true;
        }
        return false;
      }) || {})[name];
    },
    set: (target, name, value) => {
      let closestObjectWithKey = objects.find((obj) => obj.hasOwnProperty(name));
      if (closestObjectWithKey) {
        closestObjectWithKey[name] = value;
      } else {
        objects[objects.length - 1][name] = value;
      }
      return true;
    }
  });
  return thisProxy;
}

// packages/alpinejs/src/interceptor.js
function initInterceptors(data2) {
  let isObject2 = (val) => typeof val === "object" && !Array.isArray(val) && val !== null;
  let recurse = (obj, basePath = "") => {
    Object.entries(Object.getOwnPropertyDescriptors(obj)).forEach(([key, {value, enumerable}]) => {
      if (enumerable === false || value === void 0)
        return;
      let path = basePath === "" ? key : `${basePath}.${key}`;
      if (typeof value === "object" && value !== null && value._x_interceptor) {
        obj[key] = value.initialize(data2, path, key);
      } else {
        if (isObject2(value) && value !== obj && !(value instanceof Element)) {
          recurse(value, path);
        }
      }
    });
  };
  return recurse(data2);
}
function interceptor(callback, mutateObj = () => {
}) {
  let obj = {
    initialValue: void 0,
    _x_interceptor: true,
    initialize(data2, path, key) {
      return callback(this.initialValue, () => get(data2, path), (value) => set(data2, path, value), path, key);
    }
  };
  mutateObj(obj);
  return (initialValue) => {
    if (typeof initialValue === "object" && initialValue !== null && initialValue._x_interceptor) {
      let initialize = obj.initialize.bind(obj);
      obj.initialize = (data2, path, key) => {
        let innerValue = initialValue.initialize(data2, path, key);
        obj.initialValue = innerValue;
        return initialize(data2, path, key);
      };
    } else {
      obj.initialValue = initialValue;
    }
    return obj;
  };
}
function get(obj, path) {
  return path.split(".").reduce((carry, segment) => carry[segment], obj);
}
function set(obj, path, value) {
  if (typeof path === "string")
    path = path.split(".");
  if (path.length === 1)
    obj[path[0]] = value;
  else if (path.length === 0)
    throw error;
  else {
    if (obj[path[0]])
      return set(obj[path[0]], path.slice(1), value);
    else {
      obj[path[0]] = {};
      return set(obj[path[0]], path.slice(1), value);
    }
  }
}

// packages/alpinejs/src/magics.js
var magics = {};
function magic(name, callback) {
  magics[name] = callback;
}
function injectMagics(obj, el) {
  Object.entries(magics).forEach(([name, callback]) => {
    Object.defineProperty(obj, `$${name}`, {
      get() {
        let [utilities, cleanup2] = getElementBoundUtilities(el);
        utilities = {interceptor, ...utilities};
        onElRemoved(el, cleanup2);
        return callback(el, utilities);
      },
      enumerable: false
    });
  });
  return obj;
}

// packages/alpinejs/src/utils/error.js
function tryCatch(el, expression, callback, ...args) {
  try {
    return callback(...args);
  } catch (e) {
    handleError(e, el, expression);
  }
}
function handleError(error2, el, expression = void 0) {
  Object.assign(error2, {el, expression});
  console.warn(`Alpine Expression Error: ${error2.message}

${expression ? 'Expression: "' + expression + '"\n\n' : ""}`, el);
  setTimeout(() => {
    throw error2;
  }, 0);
}

// packages/alpinejs/src/evaluator.js
var shouldAutoEvaluateFunctions = true;
function dontAutoEvaluateFunctions(callback) {
  let cache = shouldAutoEvaluateFunctions;
  shouldAutoEvaluateFunctions = false;
  callback();
  shouldAutoEvaluateFunctions = cache;
}
function evaluate(el, expression, extras = {}) {
  let result;
  evaluateLater(el, expression)((value) => result = value, extras);
  return result;
}
function evaluateLater(...args) {
  return theEvaluatorFunction(...args);
}
var theEvaluatorFunction = normalEvaluator;
function setEvaluator(newEvaluator) {
  theEvaluatorFunction = newEvaluator;
}
function normalEvaluator(el, expression) {
  let overriddenMagics = {};
  injectMagics(overriddenMagics, el);
  let dataStack = [overriddenMagics, ...closestDataStack(el)];
  if (typeof expression === "function") {
    return generateEvaluatorFromFunction(dataStack, expression);
  }
  let evaluator = generateEvaluatorFromString(dataStack, expression, el);
  return tryCatch.bind(null, el, expression, evaluator);
}
function generateEvaluatorFromFunction(dataStack, func) {
  return (receiver = () => {
  }, {scope: scope2 = {}, params = []} = {}) => {
    let result = func.apply(mergeProxies([scope2, ...dataStack]), params);
    runIfTypeOfFunction(receiver, result);
  };
}
var evaluatorMemo = {};
function generateFunctionFromString(expression, el) {
  if (evaluatorMemo[expression]) {
    return evaluatorMemo[expression];
  }
  let AsyncFunction = Object.getPrototypeOf(async function() {
  }).constructor;
  let rightSideSafeExpression = /^[\n\s]*if.*\(.*\)/.test(expression) || /^(let|const)\s/.test(expression) ? `(() => { ${expression} })()` : expression;
  const safeAsyncFunction = () => {
    try {
      return new AsyncFunction(["__self", "scope"], `with (scope) { __self.result = ${rightSideSafeExpression} }; __self.finished = true; return __self.result;`);
    } catch (error2) {
      handleError(error2, el, expression);
      return Promise.resolve();
    }
  };
  let func = safeAsyncFunction();
  evaluatorMemo[expression] = func;
  return func;
}
function generateEvaluatorFromString(dataStack, expression, el) {
  let func = generateFunctionFromString(expression, el);
  return (receiver = () => {
  }, {scope: scope2 = {}, params = []} = {}) => {
    func.result = void 0;
    func.finished = false;
    let completeScope = mergeProxies([scope2, ...dataStack]);
    if (typeof func === "function") {
      let promise = func(func, completeScope).catch((error2) => handleError(error2, el, expression));
      if (func.finished) {
        runIfTypeOfFunction(receiver, func.result, completeScope, params, el);
        func.result = void 0;
      } else {
        promise.then((result) => {
          runIfTypeOfFunction(receiver, result, completeScope, params, el);
        }).catch((error2) => handleError(error2, el, expression)).finally(() => func.result = void 0);
      }
    }
  };
}
function runIfTypeOfFunction(receiver, value, scope2, params, el) {
  if (shouldAutoEvaluateFunctions && typeof value === "function") {
    let result = value.apply(scope2, params);
    if (result instanceof Promise) {
      result.then((i) => runIfTypeOfFunction(receiver, i, scope2, params)).catch((error2) => handleError(error2, el, value));
    } else {
      receiver(result);
    }
  } else {
    receiver(value);
  }
}

// packages/alpinejs/src/directives.js
var prefixAsString = "x-";
function prefix(subject = "") {
  return prefixAsString + subject;
}
function setPrefix(newPrefix) {
  prefixAsString = newPrefix;
}
var directiveHandlers = {};
function directive(name, callback) {
  directiveHandlers[name] = callback;
}
function directives(el, attributes, originalAttributeOverride) {
  attributes = Array.from(attributes);
  if (el._x_virtualDirectives) {
    let vAttributes = Object.entries(el._x_virtualDirectives).map(([name, value]) => ({name, value}));
    let staticAttributes = attributesOnly(vAttributes);
    vAttributes = vAttributes.map((attribute) => {
      if (staticAttributes.find((attr) => attr.name === attribute.name)) {
        return {
          name: `x-bind:${attribute.name}`,
          value: `"${attribute.value}"`
        };
      }
      return attribute;
    });
    attributes = attributes.concat(vAttributes);
  }
  let transformedAttributeMap = {};
  let directives2 = attributes.map(toTransformedAttributes((newName, oldName) => transformedAttributeMap[newName] = oldName)).filter(outNonAlpineAttributes).map(toParsedDirectives(transformedAttributeMap, originalAttributeOverride)).sort(byPriority);
  return directives2.map((directive2) => {
    return getDirectiveHandler(el, directive2);
  });
}
function attributesOnly(attributes) {
  return Array.from(attributes).map(toTransformedAttributes()).filter((attr) => !outNonAlpineAttributes(attr));
}
var isDeferringHandlers = false;
var directiveHandlerStacks = new Map();
var currentHandlerStackKey = Symbol();
function deferHandlingDirectives(callback) {
  isDeferringHandlers = true;
  let key = Symbol();
  currentHandlerStackKey = key;
  directiveHandlerStacks.set(key, []);
  let flushHandlers = () => {
    while (directiveHandlerStacks.get(key).length)
      directiveHandlerStacks.get(key).shift()();
    directiveHandlerStacks.delete(key);
  };
  let stopDeferring = () => {
    isDeferringHandlers = false;
    flushHandlers();
  };
  callback(flushHandlers);
  stopDeferring();
}
function getElementBoundUtilities(el) {
  let cleanups = [];
  let cleanup2 = (callback) => cleanups.push(callback);
  let [effect3, cleanupEffect] = elementBoundEffect(el);
  cleanups.push(cleanupEffect);
  let utilities = {
    Alpine: alpine_default,
    effect: effect3,
    cleanup: cleanup2,
    evaluateLater: evaluateLater.bind(evaluateLater, el),
    evaluate: evaluate.bind(evaluate, el)
  };
  let doCleanup = () => cleanups.forEach((i) => i());
  return [utilities, doCleanup];
}
function getDirectiveHandler(el, directive2) {
  let noop = () => {
  };
  let handler3 = directiveHandlers[directive2.type] || noop;
  let [utilities, cleanup2] = getElementBoundUtilities(el);
  onAttributeRemoved(el, directive2.original, cleanup2);
  let fullHandler = () => {
    if (el._x_ignore || el._x_ignoreSelf)
      return;
    handler3.inline && handler3.inline(el, directive2, utilities);
    handler3 = handler3.bind(handler3, el, directive2, utilities);
    isDeferringHandlers ? directiveHandlerStacks.get(currentHandlerStackKey).push(handler3) : handler3();
  };
  fullHandler.runCleanups = cleanup2;
  return fullHandler;
}
var startingWith = (subject, replacement) => ({name, value}) => {
  if (name.startsWith(subject))
    name = name.replace(subject, replacement);
  return {name, value};
};
var into = (i) => i;
function toTransformedAttributes(callback = () => {
}) {
  return ({name, value}) => {
    let {name: newName, value: newValue} = attributeTransformers.reduce((carry, transform) => {
      return transform(carry);
    }, {name, value});
    if (newName !== name)
      callback(newName, name);
    return {name: newName, value: newValue};
  };
}
var attributeTransformers = [];
function mapAttributes(callback) {
  attributeTransformers.push(callback);
}
function outNonAlpineAttributes({name}) {
  return alpineAttributeRegex().test(name);
}
var alpineAttributeRegex = () => new RegExp(`^${prefixAsString}([^:^.]+)\\b`);
function toParsedDirectives(transformedAttributeMap, originalAttributeOverride) {
  return ({name, value}) => {
    let typeMatch = name.match(alpineAttributeRegex());
    let valueMatch = name.match(/:([a-zA-Z0-9\-:]+)/);
    let modifiers = name.match(/\.[^.\]]+(?=[^\]]*$)/g) || [];
    let original = originalAttributeOverride || transformedAttributeMap[name] || name;
    return {
      type: typeMatch ? typeMatch[1] : null,
      value: valueMatch ? valueMatch[1] : null,
      modifiers: modifiers.map((i) => i.replace(".", "")),
      expression: value,
      original
    };
  };
}
var DEFAULT = "DEFAULT";
var directiveOrder = [
  "ignore",
  "ref",
  "data",
  "id",
  "tabs",
  "radio",
  "switch",
  "disclosure",
  "bind",
  "init",
  "for",
  "mask",
  "model",
  "modelable",
  "transition",
  "show",
  "if",
  DEFAULT,
  "teleport"
];
function byPriority(a, b) {
  let typeA = directiveOrder.indexOf(a.type) === -1 ? DEFAULT : a.type;
  let typeB = directiveOrder.indexOf(b.type) === -1 ? DEFAULT : b.type;
  return directiveOrder.indexOf(typeA) - directiveOrder.indexOf(typeB);
}

// packages/alpinejs/src/utils/dispatch.js
function dispatch(el, name, detail = {}) {
  el.dispatchEvent(new CustomEvent(name, {
    detail,
    bubbles: true,
    composed: true,
    cancelable: true
  }));
}

// packages/alpinejs/src/nextTick.js
var tickStack = [];
var isHolding = false;
function nextTick(callback = () => {
}) {
  queueMicrotask(() => {
    isHolding || setTimeout(() => {
      releaseNextTicks();
    });
  });
  return new Promise((res) => {
    tickStack.push(() => {
      callback();
      res();
    });
  });
}
function releaseNextTicks() {
  isHolding = false;
  while (tickStack.length)
    tickStack.shift()();
}
function holdNextTicks() {
  isHolding = true;
}

// packages/alpinejs/src/utils/walk.js
function walk(el, callback) {
  if (typeof ShadowRoot === "function" && el instanceof ShadowRoot) {
    Array.from(el.children).forEach((el2) => walk(el2, callback));
    return;
  }
  let skip = false;
  callback(el, () => skip = true);
  if (skip)
    return;
  let node = el.firstElementChild;
  while (node) {
    walk(node, callback, false);
    node = node.nextElementSibling;
  }
}

// packages/alpinejs/src/utils/warn.js
function warn(message, ...args) {
  console.warn(`Alpine Warning: ${message}`, ...args);
}

// packages/alpinejs/src/lifecycle.js
function start() {
  if (!document.body)
    warn("Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?");
  dispatch(document, "alpine:init");
  dispatch(document, "alpine:initializing");
  startObservingMutations();
  onElAdded((el) => initTree(el, walk));
  onElRemoved((el) => destroyTree(el));
  onAttributesAdded((el, attrs) => {
    directives(el, attrs).forEach((handle) => handle());
  });
  let outNestedComponents = (el) => !closestRoot(el.parentElement, true);
  Array.from(document.querySelectorAll(allSelectors())).filter(outNestedComponents).forEach((el) => {
    initTree(el);
  });
  dispatch(document, "alpine:initialized");
}
var rootSelectorCallbacks = [];
var initSelectorCallbacks = [];
function rootSelectors() {
  return rootSelectorCallbacks.map((fn) => fn());
}
function allSelectors() {
  return rootSelectorCallbacks.concat(initSelectorCallbacks).map((fn) => fn());
}
function addRootSelector(selectorCallback) {
  rootSelectorCallbacks.push(selectorCallback);
}
function addInitSelector(selectorCallback) {
  initSelectorCallbacks.push(selectorCallback);
}
function closestRoot(el, includeInitSelectors = false) {
  return findClosest(el, (element) => {
    const selectors = includeInitSelectors ? allSelectors() : rootSelectors();
    if (selectors.some((selector) => element.matches(selector)))
      return true;
  });
}
function findClosest(el, callback) {
  if (!el)
    return;
  if (callback(el))
    return el;
  if (el._x_teleportBack)
    el = el._x_teleportBack;
  if (!el.parentElement)
    return;
  return findClosest(el.parentElement, callback);
}
function isRoot(el) {
  return rootSelectors().some((selector) => el.matches(selector));
}
function initTree(el, walker = walk) {
  deferHandlingDirectives(() => {
    walker(el, (el2, skip) => {
      directives(el2, el2.attributes).forEach((handle) => handle());
      el2._x_ignore && skip();
    });
  });
}
function destroyTree(root) {
  walk(root, (el) => cleanupAttributes(el));
}

// packages/alpinejs/src/utils/classes.js
function setClasses(el, value) {
  if (Array.isArray(value)) {
    return setClassesFromString(el, value.join(" "));
  } else if (typeof value === "object" && value !== null) {
    return setClassesFromObject(el, value);
  } else if (typeof value === "function") {
    return setClasses(el, value());
  }
  return setClassesFromString(el, value);
}
function setClassesFromString(el, classString) {
  let split = (classString2) => classString2.split(" ").filter(Boolean);
  let missingClasses = (classString2) => classString2.split(" ").filter((i) => !el.classList.contains(i)).filter(Boolean);
  let addClassesAndReturnUndo = (classes) => {
    el.classList.add(...classes);
    return () => {
      el.classList.remove(...classes);
    };
  };
  classString = classString === true ? classString = "" : classString || "";
  return addClassesAndReturnUndo(missingClasses(classString));
}
function setClassesFromObject(el, classObject) {
  let split = (classString) => classString.split(" ").filter(Boolean);
  let forAdd = Object.entries(classObject).flatMap(([classString, bool]) => bool ? split(classString) : false).filter(Boolean);
  let forRemove = Object.entries(classObject).flatMap(([classString, bool]) => !bool ? split(classString) : false).filter(Boolean);
  let added = [];
  let removed = [];
  forRemove.forEach((i) => {
    if (el.classList.contains(i)) {
      el.classList.remove(i);
      removed.push(i);
    }
  });
  forAdd.forEach((i) => {
    if (!el.classList.contains(i)) {
      el.classList.add(i);
      added.push(i);
    }
  });
  return () => {
    removed.forEach((i) => el.classList.add(i));
    added.forEach((i) => el.classList.remove(i));
  };
}

// packages/alpinejs/src/utils/styles.js
function setStyles(el, value) {
  if (typeof value === "object" && value !== null) {
    return setStylesFromObject(el, value);
  }
  return setStylesFromString(el, value);
}
function setStylesFromObject(el, value) {
  let previousStyles = {};
  Object.entries(value).forEach(([key, value2]) => {
    previousStyles[key] = el.style[key];
    if (!key.startsWith("--")) {
      key = kebabCase(key);
    }
    el.style.setProperty(key, value2);
  });
  setTimeout(() => {
    if (el.style.length === 0) {
      el.removeAttribute("style");
    }
  });
  return () => {
    setStyles(el, previousStyles);
  };
}
function setStylesFromString(el, value) {
  let cache = el.getAttribute("style", value);
  el.setAttribute("style", value);
  return () => {
    el.setAttribute("style", cache || "");
  };
}
function kebabCase(subject) {
  return subject.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase();
}

// packages/alpinejs/src/utils/once.js
function once(callback, fallback = () => {
}) {
  let called = false;
  return function() {
    if (!called) {
      called = true;
      callback.apply(this, arguments);
    } else {
      fallback.apply(this, arguments);
    }
  };
}

// packages/alpinejs/src/directives/x-transition.js
directive("transition", (el, {value, modifiers, expression}, {evaluate: evaluate2}) => {
  if (typeof expression === "function")
    expression = evaluate2(expression);
  if (!expression) {
    registerTransitionsFromHelper(el, modifiers, value);
  } else {
    registerTransitionsFromClassString(el, expression, value);
  }
});
function registerTransitionsFromClassString(el, classString, stage) {
  registerTransitionObject(el, setClasses, "");
  let directiveStorageMap = {
    enter: (classes) => {
      el._x_transition.enter.during = classes;
    },
    "enter-start": (classes) => {
      el._x_transition.enter.start = classes;
    },
    "enter-end": (classes) => {
      el._x_transition.enter.end = classes;
    },
    leave: (classes) => {
      el._x_transition.leave.during = classes;
    },
    "leave-start": (classes) => {
      el._x_transition.leave.start = classes;
    },
    "leave-end": (classes) => {
      el._x_transition.leave.end = classes;
    }
  };
  directiveStorageMap[stage](classString);
}
function registerTransitionsFromHelper(el, modifiers, stage) {
  registerTransitionObject(el, setStyles);
  let doesntSpecify = !modifiers.includes("in") && !modifiers.includes("out") && !stage;
  let transitioningIn = doesntSpecify || modifiers.includes("in") || ["enter"].includes(stage);
  let transitioningOut = doesntSpecify || modifiers.includes("out") || ["leave"].includes(stage);
  if (modifiers.includes("in") && !doesntSpecify) {
    modifiers = modifiers.filter((i, index) => index < modifiers.indexOf("out"));
  }
  if (modifiers.includes("out") && !doesntSpecify) {
    modifiers = modifiers.filter((i, index) => index > modifiers.indexOf("out"));
  }
  let wantsAll = !modifiers.includes("opacity") && !modifiers.includes("scale");
  let wantsOpacity = wantsAll || modifiers.includes("opacity");
  let wantsScale = wantsAll || modifiers.includes("scale");
  let opacityValue = wantsOpacity ? 0 : 1;
  let scaleValue = wantsScale ? modifierValue(modifiers, "scale", 95) / 100 : 1;
  let delay = modifierValue(modifiers, "delay", 0);
  let origin = modifierValue(modifiers, "origin", "center");
  let property = "opacity, transform";
  let durationIn = modifierValue(modifiers, "duration", 150) / 1e3;
  let durationOut = modifierValue(modifiers, "duration", 75) / 1e3;
  let easing = `cubic-bezier(0.4, 0.0, 0.2, 1)`;
  if (transitioningIn) {
    el._x_transition.enter.during = {
      transformOrigin: origin,
      transitionDelay: delay,
      transitionProperty: property,
      transitionDuration: `${durationIn}s`,
      transitionTimingFunction: easing
    };
    el._x_transition.enter.start = {
      opacity: opacityValue,
      transform: `scale(${scaleValue})`
    };
    el._x_transition.enter.end = {
      opacity: 1,
      transform: `scale(1)`
    };
  }
  if (transitioningOut) {
    el._x_transition.leave.during = {
      transformOrigin: origin,
      transitionDelay: delay,
      transitionProperty: property,
      transitionDuration: `${durationOut}s`,
      transitionTimingFunction: easing
    };
    el._x_transition.leave.start = {
      opacity: 1,
      transform: `scale(1)`
    };
    el._x_transition.leave.end = {
      opacity: opacityValue,
      transform: `scale(${scaleValue})`
    };
  }
}
function registerTransitionObject(el, setFunction, defaultValue = {}) {
  if (!el._x_transition)
    el._x_transition = {
      enter: {during: defaultValue, start: defaultValue, end: defaultValue},
      leave: {during: defaultValue, start: defaultValue, end: defaultValue},
      in(before = () => {
      }, after = () => {
      }) {
        transition(el, setFunction, {
          during: this.enter.during,
          start: this.enter.start,
          end: this.enter.end
        }, before, after);
      },
      out(before = () => {
      }, after = () => {
      }) {
        transition(el, setFunction, {
          during: this.leave.during,
          start: this.leave.start,
          end: this.leave.end
        }, before, after);
      }
    };
}
window.Element.prototype._x_toggleAndCascadeWithTransitions = function(el, value, show, hide) {
  const nextTick2 = document.visibilityState === "visible" ? requestAnimationFrame : setTimeout;
  let clickAwayCompatibleShow = () => nextTick2(show);
  if (value) {
    if (el._x_transition && (el._x_transition.enter || el._x_transition.leave)) {
      el._x_transition.enter && (Object.entries(el._x_transition.enter.during).length || Object.entries(el._x_transition.enter.start).length || Object.entries(el._x_transition.enter.end).length) ? el._x_transition.in(show) : clickAwayCompatibleShow();
    } else {
      el._x_transition ? el._x_transition.in(show) : clickAwayCompatibleShow();
    }
    return;
  }
  el._x_hidePromise = el._x_transition ? new Promise((resolve, reject) => {
    el._x_transition.out(() => {
    }, () => resolve(hide));
    el._x_transitioning.beforeCancel(() => reject({isFromCancelledTransition: true}));
  }) : Promise.resolve(hide);
  queueMicrotask(() => {
    let closest = closestHide(el);
    if (closest) {
      if (!closest._x_hideChildren)
        closest._x_hideChildren = [];
      closest._x_hideChildren.push(el);
    } else {
      nextTick2(() => {
        let hideAfterChildren = (el2) => {
          let carry = Promise.all([
            el2._x_hidePromise,
            ...(el2._x_hideChildren || []).map(hideAfterChildren)
          ]).then(([i]) => i());
          delete el2._x_hidePromise;
          delete el2._x_hideChildren;
          return carry;
        };
        hideAfterChildren(el).catch((e) => {
          if (!e.isFromCancelledTransition)
            throw e;
        });
      });
    }
  });
};
function closestHide(el) {
  let parent = el.parentNode;
  if (!parent)
    return;
  return parent._x_hidePromise ? parent : closestHide(parent);
}
function transition(el, setFunction, {during, start: start2, end} = {}, before = () => {
}, after = () => {
}) {
  if (el._x_transitioning)
    el._x_transitioning.cancel();
  if (Object.keys(during).length === 0 && Object.keys(start2).length === 0 && Object.keys(end).length === 0) {
    before();
    after();
    return;
  }
  let undoStart, undoDuring, undoEnd;
  performTransition(el, {
    start() {
      undoStart = setFunction(el, start2);
    },
    during() {
      undoDuring = setFunction(el, during);
    },
    before,
    end() {
      undoStart();
      undoEnd = setFunction(el, end);
    },
    after,
    cleanup() {
      undoDuring();
      undoEnd();
    }
  });
}
function performTransition(el, stages) {
  let interrupted, reachedBefore, reachedEnd;
  let finish = once(() => {
    mutateDom(() => {
      interrupted = true;
      if (!reachedBefore)
        stages.before();
      if (!reachedEnd) {
        stages.end();
        releaseNextTicks();
      }
      stages.after();
      if (el.isConnected)
        stages.cleanup();
      delete el._x_transitioning;
    });
  });
  el._x_transitioning = {
    beforeCancels: [],
    beforeCancel(callback) {
      this.beforeCancels.push(callback);
    },
    cancel: once(function() {
      while (this.beforeCancels.length) {
        this.beforeCancels.shift()();
      }
      ;
      finish();
    }),
    finish
  };
  mutateDom(() => {
    stages.start();
    stages.during();
  });
  holdNextTicks();
  requestAnimationFrame(() => {
    if (interrupted)
      return;
    let duration = Number(getComputedStyle(el).transitionDuration.replace(/,.*/, "").replace("s", "")) * 1e3;
    let delay = Number(getComputedStyle(el).transitionDelay.replace(/,.*/, "").replace("s", "")) * 1e3;
    if (duration === 0)
      duration = Number(getComputedStyle(el).animationDuration.replace("s", "")) * 1e3;
    mutateDom(() => {
      stages.before();
    });
    reachedBefore = true;
    requestAnimationFrame(() => {
      if (interrupted)
        return;
      mutateDom(() => {
        stages.end();
      });
      releaseNextTicks();
      setTimeout(el._x_transitioning.finish, duration + delay);
      reachedEnd = true;
    });
  });
}
function modifierValue(modifiers, key, fallback) {
  if (modifiers.indexOf(key) === -1)
    return fallback;
  const rawValue = modifiers[modifiers.indexOf(key) + 1];
  if (!rawValue)
    return fallback;
  if (key === "scale") {
    if (isNaN(rawValue))
      return fallback;
  }
  if (key === "duration") {
    let match = rawValue.match(/([0-9]+)ms/);
    if (match)
      return match[1];
  }
  if (key === "origin") {
    if (["top", "right", "left", "center", "bottom"].includes(modifiers[modifiers.indexOf(key) + 2])) {
      return [rawValue, modifiers[modifiers.indexOf(key) + 2]].join(" ");
    }
  }
  return rawValue;
}

// packages/alpinejs/src/clone.js
var isCloning = false;
function skipDuringClone(callback, fallback = () => {
}) {
  return (...args) => isCloning ? fallback(...args) : callback(...args);
}
function clone(oldEl, newEl) {
  if (!newEl._x_dataStack)
    newEl._x_dataStack = oldEl._x_dataStack;
  isCloning = true;
  dontRegisterReactiveSideEffects(() => {
    cloneTree(newEl);
  });
  isCloning = false;
}
function cloneTree(el) {
  let hasRunThroughFirstEl = false;
  let shallowWalker = (el2, callback) => {
    walk(el2, (el3, skip) => {
      if (hasRunThroughFirstEl && isRoot(el3))
        return skip();
      hasRunThroughFirstEl = true;
      callback(el3, skip);
    });
  };
  initTree(el, shallowWalker);
}
function dontRegisterReactiveSideEffects(callback) {
  let cache = effect;
  overrideEffect((callback2, el) => {
    let storedEffect = cache(callback2);
    release(storedEffect);
    return () => {
    };
  });
  callback();
  overrideEffect(cache);
}

// packages/alpinejs/src/utils/bind.js
function bind(el, name, value, modifiers = []) {
  if (!el._x_bindings)
    el._x_bindings = reactive({});
  el._x_bindings[name] = value;
  name = modifiers.includes("camel") ? camelCase(name) : name;
  switch (name) {
    case "value":
      bindInputValue(el, value);
      break;
    case "style":
      bindStyles(el, value);
      break;
    case "class":
      bindClasses(el, value);
      break;
    default:
      bindAttribute(el, name, value);
      break;
  }
}
function bindInputValue(el, value) {
  if (el.type === "radio") {
    if (el.attributes.value === void 0) {
      el.value = value;
    }
    if (window.fromModel) {
      el.checked = checkedAttrLooseCompare(el.value, value);
    }
  } else if (el.type === "checkbox") {
    if (Number.isInteger(value)) {
      el.value = value;
    } else if (!Number.isInteger(value) && !Array.isArray(value) && typeof value !== "boolean" && ![null, void 0].includes(value)) {
      el.value = String(value);
    } else {
      if (Array.isArray(value)) {
        el.checked = value.some((val) => checkedAttrLooseCompare(val, el.value));
      } else {
        el.checked = !!value;
      }
    }
  } else if (el.tagName === "SELECT") {
    updateSelect(el, value);
  } else {
    if (el.value === value)
      return;
    el.value = value;
  }
}
function bindClasses(el, value) {
  if (el._x_undoAddedClasses)
    el._x_undoAddedClasses();
  el._x_undoAddedClasses = setClasses(el, value);
}
function bindStyles(el, value) {
  if (el._x_undoAddedStyles)
    el._x_undoAddedStyles();
  el._x_undoAddedStyles = setStyles(el, value);
}
function bindAttribute(el, name, value) {
  if ([null, void 0, false].includes(value) && attributeShouldntBePreservedIfFalsy(name)) {
    el.removeAttribute(name);
  } else {
    if (isBooleanAttr(name))
      value = name;
    setIfChanged(el, name, value);
  }
}
function setIfChanged(el, attrName, value) {
  if (el.getAttribute(attrName) != value) {
    el.setAttribute(attrName, value);
  }
}
function updateSelect(el, value) {
  const arrayWrappedValue = [].concat(value).map((value2) => {
    return value2 + "";
  });
  Array.from(el.options).forEach((option) => {
    option.selected = arrayWrappedValue.includes(option.value);
  });
}
function camelCase(subject) {
  return subject.toLowerCase().replace(/-(\w)/g, (match, char) => char.toUpperCase());
}
function checkedAttrLooseCompare(valueA, valueB) {
  return valueA == valueB;
}
function isBooleanAttr(attrName) {
  const booleanAttributes = [
    "disabled",
    "checked",
    "required",
    "readonly",
    "hidden",
    "open",
    "selected",
    "autofocus",
    "itemscope",
    "multiple",
    "novalidate",
    "allowfullscreen",
    "allowpaymentrequest",
    "formnovalidate",
    "autoplay",
    "controls",
    "loop",
    "muted",
    "playsinline",
    "default",
    "ismap",
    "reversed",
    "async",
    "defer",
    "nomodule"
  ];
  return booleanAttributes.includes(attrName);
}
function attributeShouldntBePreservedIfFalsy(name) {
  return !["aria-pressed", "aria-checked", "aria-expanded", "aria-selected"].includes(name);
}
function getBinding(el, name, fallback) {
  if (el._x_bindings && el._x_bindings[name] !== void 0)
    return el._x_bindings[name];
  let attr = el.getAttribute(name);
  if (attr === null)
    return typeof fallback === "function" ? fallback() : fallback;
  if (attr === "")
    return true;
  if (isBooleanAttr(name)) {
    return !![name, "true"].includes(attr);
  }
  return attr;
}

// packages/alpinejs/src/utils/debounce.js
function debounce(func, wait) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      func.apply(context, args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// packages/alpinejs/src/utils/throttle.js
function throttle(func, limit) {
  let inThrottle;
  return function() {
    let context = this, args = arguments;
    if (!inThrottle) {
      func.apply(context, args);
      inThrottle = true;
      setTimeout(() => inThrottle = false, limit);
    }
  };
}

// packages/alpinejs/src/plugin.js
function plugin(callback) {
  callback(alpine_default);
}

// packages/alpinejs/src/store.js
var stores = {};
var isReactive = false;
function store(name, value) {
  if (!isReactive) {
    stores = reactive(stores);
    isReactive = true;
  }
  if (value === void 0) {
    return stores[name];
  }
  stores[name] = value;
  if (typeof value === "object" && value !== null && value.hasOwnProperty("init") && typeof value.init === "function") {
    stores[name].init();
  }
  initInterceptors(stores[name]);
}
function getStores() {
  return stores;
}

// packages/alpinejs/src/binds.js
var binds = {};
function bind2(name, bindings) {
  let getBindings = typeof bindings !== "function" ? () => bindings : bindings;
  if (name instanceof Element) {
    applyBindingsObject(name, getBindings());
  } else {
    binds[name] = getBindings;
  }
}
function injectBindingProviders(obj) {
  Object.entries(binds).forEach(([name, callback]) => {
    Object.defineProperty(obj, name, {
      get() {
        return (...args) => {
          return callback(...args);
        };
      }
    });
  });
  return obj;
}
function applyBindingsObject(el, obj, original) {
  let cleanupRunners = [];
  while (cleanupRunners.length)
    cleanupRunners.pop()();
  let attributes = Object.entries(obj).map(([name, value]) => ({name, value}));
  let staticAttributes = attributesOnly(attributes);
  attributes = attributes.map((attribute) => {
    if (staticAttributes.find((attr) => attr.name === attribute.name)) {
      return {
        name: `x-bind:${attribute.name}`,
        value: `"${attribute.value}"`
      };
    }
    return attribute;
  });
  directives(el, attributes, original).map((handle) => {
    cleanupRunners.push(handle.runCleanups);
    handle();
  });
}

// packages/alpinejs/src/datas.js
var datas = {};
function data(name, callback) {
  datas[name] = callback;
}
function injectDataProviders(obj, context) {
  Object.entries(datas).forEach(([name, callback]) => {
    Object.defineProperty(obj, name, {
      get() {
        return (...args) => {
          return callback.bind(context)(...args);
        };
      },
      enumerable: false
    });
  });
  return obj;
}

// packages/alpinejs/src/alpine.js
var Alpine = {
  get reactive() {
    return reactive;
  },
  get release() {
    return release;
  },
  get effect() {
    return effect;
  },
  get raw() {
    return raw;
  },
  version: "3.10.4",
  flushAndStopDeferringMutations,
  dontAutoEvaluateFunctions,
  disableEffectScheduling,
  setReactivityEngine,
  closestDataStack,
  skipDuringClone,
  addRootSelector,
  addInitSelector,
  addScopeToNode,
  deferMutations,
  mapAttributes,
  evaluateLater,
  setEvaluator,
  mergeProxies,
  findClosest,
  closestRoot,
  interceptor,
  transition,
  setStyles,
  mutateDom,
  directive,
  throttle,
  debounce,
  evaluate,
  initTree,
  nextTick,
  prefixed: prefix,
  prefix: setPrefix,
  plugin,
  magic,
  store,
  start,
  clone,
  bound: getBinding,
  $data: scope,
  data,
  bind: bind2
};
var alpine_default = Alpine;

// node_modules/@vue/shared/dist/shared.esm-bundler.js
function makeMap(str, expectsLowerCase) {
  const map = Object.create(null);
  const list = str.split(",");
  for (let i = 0; i < list.length; i++) {
    map[list[i]] = true;
  }
  return expectsLowerCase ? (val) => !!map[val.toLowerCase()] : (val) => !!map[val];
}
var PatchFlagNames = {
  [1]: `TEXT`,
  [2]: `CLASS`,
  [4]: `STYLE`,
  [8]: `PROPS`,
  [16]: `FULL_PROPS`,
  [32]: `HYDRATE_EVENTS`,
  [64]: `STABLE_FRAGMENT`,
  [128]: `KEYED_FRAGMENT`,
  [256]: `UNKEYED_FRAGMENT`,
  [512]: `NEED_PATCH`,
  [1024]: `DYNAMIC_SLOTS`,
  [2048]: `DEV_ROOT_FRAGMENT`,
  [-1]: `HOISTED`,
  [-2]: `BAIL`
};
var slotFlagsText = {
  [1]: "STABLE",
  [2]: "DYNAMIC",
  [3]: "FORWARDED"
};
var specialBooleanAttrs = `itemscope,allowfullscreen,formnovalidate,ismap,nomodule,novalidate,readonly`;
var isBooleanAttr2 = /* @__PURE__ */ makeMap(specialBooleanAttrs + `,async,autofocus,autoplay,controls,default,defer,disabled,hidden,loop,open,required,reversed,scoped,seamless,checked,muted,multiple,selected`);
var EMPTY_OBJ =  true ? Object.freeze({}) : 0;
var EMPTY_ARR =  true ? Object.freeze([]) : 0;
var extend = Object.assign;
var hasOwnProperty = Object.prototype.hasOwnProperty;
var hasOwn = (val, key) => hasOwnProperty.call(val, key);
var isArray = Array.isArray;
var isMap = (val) => toTypeString(val) === "[object Map]";
var isString = (val) => typeof val === "string";
var isSymbol = (val) => typeof val === "symbol";
var isObject = (val) => val !== null && typeof val === "object";
var objectToString = Object.prototype.toString;
var toTypeString = (value) => objectToString.call(value);
var toRawType = (value) => {
  return toTypeString(value).slice(8, -1);
};
var isIntegerKey = (key) => isString(key) && key !== "NaN" && key[0] !== "-" && "" + parseInt(key, 10) === key;
var cacheStringFunction = (fn) => {
  const cache = Object.create(null);
  return (str) => {
    const hit = cache[str];
    return hit || (cache[str] = fn(str));
  };
};
var camelizeRE = /-(\w)/g;
var camelize = cacheStringFunction((str) => {
  return str.replace(camelizeRE, (_, c) => c ? c.toUpperCase() : "");
});
var hyphenateRE = /\B([A-Z])/g;
var hyphenate = cacheStringFunction((str) => str.replace(hyphenateRE, "-$1").toLowerCase());
var capitalize = cacheStringFunction((str) => str.charAt(0).toUpperCase() + str.slice(1));
var toHandlerKey = cacheStringFunction((str) => str ? `on${capitalize(str)}` : ``);
var hasChanged = (value, oldValue) => value !== oldValue && (value === value || oldValue === oldValue);

// node_modules/@vue/reactivity/dist/reactivity.esm-bundler.js
var targetMap = new WeakMap();
var effectStack = [];
var activeEffect;
var ITERATE_KEY = Symbol( true ? "iterate" : 0);
var MAP_KEY_ITERATE_KEY = Symbol( true ? "Map key iterate" : 0);
function isEffect(fn) {
  return fn && fn._isEffect === true;
}
function effect2(fn, options = EMPTY_OBJ) {
  if (isEffect(fn)) {
    fn = fn.raw;
  }
  const effect3 = createReactiveEffect(fn, options);
  if (!options.lazy) {
    effect3();
  }
  return effect3;
}
function stop(effect3) {
  if (effect3.active) {
    cleanup(effect3);
    if (effect3.options.onStop) {
      effect3.options.onStop();
    }
    effect3.active = false;
  }
}
var uid = 0;
function createReactiveEffect(fn, options) {
  const effect3 = function reactiveEffect() {
    if (!effect3.active) {
      return fn();
    }
    if (!effectStack.includes(effect3)) {
      cleanup(effect3);
      try {
        enableTracking();
        effectStack.push(effect3);
        activeEffect = effect3;
        return fn();
      } finally {
        effectStack.pop();
        resetTracking();
        activeEffect = effectStack[effectStack.length - 1];
      }
    }
  };
  effect3.id = uid++;
  effect3.allowRecurse = !!options.allowRecurse;
  effect3._isEffect = true;
  effect3.active = true;
  effect3.raw = fn;
  effect3.deps = [];
  effect3.options = options;
  return effect3;
}
function cleanup(effect3) {
  const {deps} = effect3;
  if (deps.length) {
    for (let i = 0; i < deps.length; i++) {
      deps[i].delete(effect3);
    }
    deps.length = 0;
  }
}
var shouldTrack = true;
var trackStack = [];
function pauseTracking() {
  trackStack.push(shouldTrack);
  shouldTrack = false;
}
function enableTracking() {
  trackStack.push(shouldTrack);
  shouldTrack = true;
}
function resetTracking() {
  const last = trackStack.pop();
  shouldTrack = last === void 0 ? true : last;
}
function track(target, type, key) {
  if (!shouldTrack || activeEffect === void 0) {
    return;
  }
  let depsMap = targetMap.get(target);
  if (!depsMap) {
    targetMap.set(target, depsMap = new Map());
  }
  let dep = depsMap.get(key);
  if (!dep) {
    depsMap.set(key, dep = new Set());
  }
  if (!dep.has(activeEffect)) {
    dep.add(activeEffect);
    activeEffect.deps.push(dep);
    if (activeEffect.options.onTrack) {
      activeEffect.options.onTrack({
        effect: activeEffect,
        target,
        type,
        key
      });
    }
  }
}
function trigger(target, type, key, newValue, oldValue, oldTarget) {
  const depsMap = targetMap.get(target);
  if (!depsMap) {
    return;
  }
  const effects = new Set();
  const add2 = (effectsToAdd) => {
    if (effectsToAdd) {
      effectsToAdd.forEach((effect3) => {
        if (effect3 !== activeEffect || effect3.allowRecurse) {
          effects.add(effect3);
        }
      });
    }
  };
  if (type === "clear") {
    depsMap.forEach(add2);
  } else if (key === "length" && isArray(target)) {
    depsMap.forEach((dep, key2) => {
      if (key2 === "length" || key2 >= newValue) {
        add2(dep);
      }
    });
  } else {
    if (key !== void 0) {
      add2(depsMap.get(key));
    }
    switch (type) {
      case "add":
        if (!isArray(target)) {
          add2(depsMap.get(ITERATE_KEY));
          if (isMap(target)) {
            add2(depsMap.get(MAP_KEY_ITERATE_KEY));
          }
        } else if (isIntegerKey(key)) {
          add2(depsMap.get("length"));
        }
        break;
      case "delete":
        if (!isArray(target)) {
          add2(depsMap.get(ITERATE_KEY));
          if (isMap(target)) {
            add2(depsMap.get(MAP_KEY_ITERATE_KEY));
          }
        }
        break;
      case "set":
        if (isMap(target)) {
          add2(depsMap.get(ITERATE_KEY));
        }
        break;
    }
  }
  const run = (effect3) => {
    if (effect3.options.onTrigger) {
      effect3.options.onTrigger({
        effect: effect3,
        target,
        key,
        type,
        newValue,
        oldValue,
        oldTarget
      });
    }
    if (effect3.options.scheduler) {
      effect3.options.scheduler(effect3);
    } else {
      effect3();
    }
  };
  effects.forEach(run);
}
var isNonTrackableKeys = /* @__PURE__ */ makeMap(`__proto__,__v_isRef,__isVue`);
var builtInSymbols = new Set(Object.getOwnPropertyNames(Symbol).map((key) => Symbol[key]).filter(isSymbol));
var get2 = /* @__PURE__ */ createGetter();
var shallowGet = /* @__PURE__ */ createGetter(false, true);
var readonlyGet = /* @__PURE__ */ createGetter(true);
var shallowReadonlyGet = /* @__PURE__ */ createGetter(true, true);
var arrayInstrumentations = {};
["includes", "indexOf", "lastIndexOf"].forEach((key) => {
  const method = Array.prototype[key];
  arrayInstrumentations[key] = function(...args) {
    const arr = toRaw(this);
    for (let i = 0, l = this.length; i < l; i++) {
      track(arr, "get", i + "");
    }
    const res = method.apply(arr, args);
    if (res === -1 || res === false) {
      return method.apply(arr, args.map(toRaw));
    } else {
      return res;
    }
  };
});
["push", "pop", "shift", "unshift", "splice"].forEach((key) => {
  const method = Array.prototype[key];
  arrayInstrumentations[key] = function(...args) {
    pauseTracking();
    const res = method.apply(this, args);
    resetTracking();
    return res;
  };
});
function createGetter(isReadonly = false, shallow = false) {
  return function get3(target, key, receiver) {
    if (key === "__v_isReactive") {
      return !isReadonly;
    } else if (key === "__v_isReadonly") {
      return isReadonly;
    } else if (key === "__v_raw" && receiver === (isReadonly ? shallow ? shallowReadonlyMap : readonlyMap : shallow ? shallowReactiveMap : reactiveMap).get(target)) {
      return target;
    }
    const targetIsArray = isArray(target);
    if (!isReadonly && targetIsArray && hasOwn(arrayInstrumentations, key)) {
      return Reflect.get(arrayInstrumentations, key, receiver);
    }
    const res = Reflect.get(target, key, receiver);
    if (isSymbol(key) ? builtInSymbols.has(key) : isNonTrackableKeys(key)) {
      return res;
    }
    if (!isReadonly) {
      track(target, "get", key);
    }
    if (shallow) {
      return res;
    }
    if (isRef(res)) {
      const shouldUnwrap = !targetIsArray || !isIntegerKey(key);
      return shouldUnwrap ? res.value : res;
    }
    if (isObject(res)) {
      return isReadonly ? readonly(res) : reactive2(res);
    }
    return res;
  };
}
var set2 = /* @__PURE__ */ createSetter();
var shallowSet = /* @__PURE__ */ createSetter(true);
function createSetter(shallow = false) {
  return function set3(target, key, value, receiver) {
    let oldValue = target[key];
    if (!shallow) {
      value = toRaw(value);
      oldValue = toRaw(oldValue);
      if (!isArray(target) && isRef(oldValue) && !isRef(value)) {
        oldValue.value = value;
        return true;
      }
    }
    const hadKey = isArray(target) && isIntegerKey(key) ? Number(key) < target.length : hasOwn(target, key);
    const result = Reflect.set(target, key, value, receiver);
    if (target === toRaw(receiver)) {
      if (!hadKey) {
        trigger(target, "add", key, value);
      } else if (hasChanged(value, oldValue)) {
        trigger(target, "set", key, value, oldValue);
      }
    }
    return result;
  };
}
function deleteProperty(target, key) {
  const hadKey = hasOwn(target, key);
  const oldValue = target[key];
  const result = Reflect.deleteProperty(target, key);
  if (result && hadKey) {
    trigger(target, "delete", key, void 0, oldValue);
  }
  return result;
}
function has(target, key) {
  const result = Reflect.has(target, key);
  if (!isSymbol(key) || !builtInSymbols.has(key)) {
    track(target, "has", key);
  }
  return result;
}
function ownKeys(target) {
  track(target, "iterate", isArray(target) ? "length" : ITERATE_KEY);
  return Reflect.ownKeys(target);
}
var mutableHandlers = {
  get: get2,
  set: set2,
  deleteProperty,
  has,
  ownKeys
};
var readonlyHandlers = {
  get: readonlyGet,
  set(target, key) {
    if (true) {
      console.warn(`Set operation on key "${String(key)}" failed: target is readonly.`, target);
    }
    return true;
  },
  deleteProperty(target, key) {
    if (true) {
      console.warn(`Delete operation on key "${String(key)}" failed: target is readonly.`, target);
    }
    return true;
  }
};
var shallowReactiveHandlers = extend({}, mutableHandlers, {
  get: shallowGet,
  set: shallowSet
});
var shallowReadonlyHandlers = extend({}, readonlyHandlers, {
  get: shallowReadonlyGet
});
var toReactive = (value) => isObject(value) ? reactive2(value) : value;
var toReadonly = (value) => isObject(value) ? readonly(value) : value;
var toShallow = (value) => value;
var getProto = (v) => Reflect.getPrototypeOf(v);
function get$1(target, key, isReadonly = false, isShallow = false) {
  target = target["__v_raw"];
  const rawTarget = toRaw(target);
  const rawKey = toRaw(key);
  if (key !== rawKey) {
    !isReadonly && track(rawTarget, "get", key);
  }
  !isReadonly && track(rawTarget, "get", rawKey);
  const {has: has2} = getProto(rawTarget);
  const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
  if (has2.call(rawTarget, key)) {
    return wrap(target.get(key));
  } else if (has2.call(rawTarget, rawKey)) {
    return wrap(target.get(rawKey));
  } else if (target !== rawTarget) {
    target.get(key);
  }
}
function has$1(key, isReadonly = false) {
  const target = this["__v_raw"];
  const rawTarget = toRaw(target);
  const rawKey = toRaw(key);
  if (key !== rawKey) {
    !isReadonly && track(rawTarget, "has", key);
  }
  !isReadonly && track(rawTarget, "has", rawKey);
  return key === rawKey ? target.has(key) : target.has(key) || target.has(rawKey);
}
function size(target, isReadonly = false) {
  target = target["__v_raw"];
  !isReadonly && track(toRaw(target), "iterate", ITERATE_KEY);
  return Reflect.get(target, "size", target);
}
function add(value) {
  value = toRaw(value);
  const target = toRaw(this);
  const proto = getProto(target);
  const hadKey = proto.has.call(target, value);
  if (!hadKey) {
    target.add(value);
    trigger(target, "add", value, value);
  }
  return this;
}
function set$1(key, value) {
  value = toRaw(value);
  const target = toRaw(this);
  const {has: has2, get: get3} = getProto(target);
  let hadKey = has2.call(target, key);
  if (!hadKey) {
    key = toRaw(key);
    hadKey = has2.call(target, key);
  } else if (true) {
    checkIdentityKeys(target, has2, key);
  }
  const oldValue = get3.call(target, key);
  target.set(key, value);
  if (!hadKey) {
    trigger(target, "add", key, value);
  } else if (hasChanged(value, oldValue)) {
    trigger(target, "set", key, value, oldValue);
  }
  return this;
}
function deleteEntry(key) {
  const target = toRaw(this);
  const {has: has2, get: get3} = getProto(target);
  let hadKey = has2.call(target, key);
  if (!hadKey) {
    key = toRaw(key);
    hadKey = has2.call(target, key);
  } else if (true) {
    checkIdentityKeys(target, has2, key);
  }
  const oldValue = get3 ? get3.call(target, key) : void 0;
  const result = target.delete(key);
  if (hadKey) {
    trigger(target, "delete", key, void 0, oldValue);
  }
  return result;
}
function clear() {
  const target = toRaw(this);
  const hadItems = target.size !== 0;
  const oldTarget =  true ? isMap(target) ? new Map(target) : new Set(target) : 0;
  const result = target.clear();
  if (hadItems) {
    trigger(target, "clear", void 0, void 0, oldTarget);
  }
  return result;
}
function createForEach(isReadonly, isShallow) {
  return function forEach(callback, thisArg) {
    const observed = this;
    const target = observed["__v_raw"];
    const rawTarget = toRaw(target);
    const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
    !isReadonly && track(rawTarget, "iterate", ITERATE_KEY);
    return target.forEach((value, key) => {
      return callback.call(thisArg, wrap(value), wrap(key), observed);
    });
  };
}
function createIterableMethod(method, isReadonly, isShallow) {
  return function(...args) {
    const target = this["__v_raw"];
    const rawTarget = toRaw(target);
    const targetIsMap = isMap(rawTarget);
    const isPair = method === "entries" || method === Symbol.iterator && targetIsMap;
    const isKeyOnly = method === "keys" && targetIsMap;
    const innerIterator = target[method](...args);
    const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
    !isReadonly && track(rawTarget, "iterate", isKeyOnly ? MAP_KEY_ITERATE_KEY : ITERATE_KEY);
    return {
      next() {
        const {value, done} = innerIterator.next();
        return done ? {value, done} : {
          value: isPair ? [wrap(value[0]), wrap(value[1])] : wrap(value),
          done
        };
      },
      [Symbol.iterator]() {
        return this;
      }
    };
  };
}
function createReadonlyMethod(type) {
  return function(...args) {
    if (true) {
      const key = args[0] ? `on key "${args[0]}" ` : ``;
      console.warn(`${capitalize(type)} operation ${key}failed: target is readonly.`, toRaw(this));
    }
    return type === "delete" ? false : this;
  };
}
var mutableInstrumentations = {
  get(key) {
    return get$1(this, key);
  },
  get size() {
    return size(this);
  },
  has: has$1,
  add,
  set: set$1,
  delete: deleteEntry,
  clear,
  forEach: createForEach(false, false)
};
var shallowInstrumentations = {
  get(key) {
    return get$1(this, key, false, true);
  },
  get size() {
    return size(this);
  },
  has: has$1,
  add,
  set: set$1,
  delete: deleteEntry,
  clear,
  forEach: createForEach(false, true)
};
var readonlyInstrumentations = {
  get(key) {
    return get$1(this, key, true);
  },
  get size() {
    return size(this, true);
  },
  has(key) {
    return has$1.call(this, key, true);
  },
  add: createReadonlyMethod("add"),
  set: createReadonlyMethod("set"),
  delete: createReadonlyMethod("delete"),
  clear: createReadonlyMethod("clear"),
  forEach: createForEach(true, false)
};
var shallowReadonlyInstrumentations = {
  get(key) {
    return get$1(this, key, true, true);
  },
  get size() {
    return size(this, true);
  },
  has(key) {
    return has$1.call(this, key, true);
  },
  add: createReadonlyMethod("add"),
  set: createReadonlyMethod("set"),
  delete: createReadonlyMethod("delete"),
  clear: createReadonlyMethod("clear"),
  forEach: createForEach(true, true)
};
var iteratorMethods = ["keys", "values", "entries", Symbol.iterator];
iteratorMethods.forEach((method) => {
  mutableInstrumentations[method] = createIterableMethod(method, false, false);
  readonlyInstrumentations[method] = createIterableMethod(method, true, false);
  shallowInstrumentations[method] = createIterableMethod(method, false, true);
  shallowReadonlyInstrumentations[method] = createIterableMethod(method, true, true);
});
function createInstrumentationGetter(isReadonly, shallow) {
  const instrumentations = shallow ? isReadonly ? shallowReadonlyInstrumentations : shallowInstrumentations : isReadonly ? readonlyInstrumentations : mutableInstrumentations;
  return (target, key, receiver) => {
    if (key === "__v_isReactive") {
      return !isReadonly;
    } else if (key === "__v_isReadonly") {
      return isReadonly;
    } else if (key === "__v_raw") {
      return target;
    }
    return Reflect.get(hasOwn(instrumentations, key) && key in target ? instrumentations : target, key, receiver);
  };
}
var mutableCollectionHandlers = {
  get: createInstrumentationGetter(false, false)
};
var shallowCollectionHandlers = {
  get: createInstrumentationGetter(false, true)
};
var readonlyCollectionHandlers = {
  get: createInstrumentationGetter(true, false)
};
var shallowReadonlyCollectionHandlers = {
  get: createInstrumentationGetter(true, true)
};
function checkIdentityKeys(target, has2, key) {
  const rawKey = toRaw(key);
  if (rawKey !== key && has2.call(target, rawKey)) {
    const type = toRawType(target);
    console.warn(`Reactive ${type} contains both the raw and reactive versions of the same object${type === `Map` ? ` as keys` : ``}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`);
  }
}
var reactiveMap = new WeakMap();
var shallowReactiveMap = new WeakMap();
var readonlyMap = new WeakMap();
var shallowReadonlyMap = new WeakMap();
function targetTypeMap(rawType) {
  switch (rawType) {
    case "Object":
    case "Array":
      return 1;
    case "Map":
    case "Set":
    case "WeakMap":
    case "WeakSet":
      return 2;
    default:
      return 0;
  }
}
function getTargetType(value) {
  return value["__v_skip"] || !Object.isExtensible(value) ? 0 : targetTypeMap(toRawType(value));
}
function reactive2(target) {
  if (target && target["__v_isReadonly"]) {
    return target;
  }
  return createReactiveObject(target, false, mutableHandlers, mutableCollectionHandlers, reactiveMap);
}
function readonly(target) {
  return createReactiveObject(target, true, readonlyHandlers, readonlyCollectionHandlers, readonlyMap);
}
function createReactiveObject(target, isReadonly, baseHandlers, collectionHandlers, proxyMap) {
  if (!isObject(target)) {
    if (true) {
      console.warn(`value cannot be made reactive: ${String(target)}`);
    }
    return target;
  }
  if (target["__v_raw"] && !(isReadonly && target["__v_isReactive"])) {
    return target;
  }
  const existingProxy = proxyMap.get(target);
  if (existingProxy) {
    return existingProxy;
  }
  const targetType = getTargetType(target);
  if (targetType === 0) {
    return target;
  }
  const proxy = new Proxy(target, targetType === 2 ? collectionHandlers : baseHandlers);
  proxyMap.set(target, proxy);
  return proxy;
}
function toRaw(observed) {
  return observed && toRaw(observed["__v_raw"]) || observed;
}
function isRef(r) {
  return Boolean(r && r.__v_isRef === true);
}

// packages/alpinejs/src/magics/$nextTick.js
magic("nextTick", () => nextTick);

// packages/alpinejs/src/magics/$dispatch.js
magic("dispatch", (el) => dispatch.bind(dispatch, el));

// packages/alpinejs/src/magics/$watch.js
magic("watch", (el, {evaluateLater: evaluateLater2, effect: effect3}) => (key, callback) => {
  let evaluate2 = evaluateLater2(key);
  let firstTime = true;
  let oldValue;
  let effectReference = effect3(() => evaluate2((value) => {
    JSON.stringify(value);
    if (!firstTime) {
      queueMicrotask(() => {
        callback(value, oldValue);
        oldValue = value;
      });
    } else {
      oldValue = value;
    }
    firstTime = false;
  }));
  el._x_effects.delete(effectReference);
});

// packages/alpinejs/src/magics/$store.js
magic("store", getStores);

// packages/alpinejs/src/magics/$data.js
magic("data", (el) => scope(el));

// packages/alpinejs/src/magics/$root.js
magic("root", (el) => closestRoot(el));

// packages/alpinejs/src/magics/$refs.js
magic("refs", (el) => {
  if (el._x_refs_proxy)
    return el._x_refs_proxy;
  el._x_refs_proxy = mergeProxies(getArrayOfRefObject(el));
  return el._x_refs_proxy;
});
function getArrayOfRefObject(el) {
  let refObjects = [];
  let currentEl = el;
  while (currentEl) {
    if (currentEl._x_refs)
      refObjects.push(currentEl._x_refs);
    currentEl = currentEl.parentNode;
  }
  return refObjects;
}

// packages/alpinejs/src/ids.js
var globalIdMemo = {};
function findAndIncrementId(name) {
  if (!globalIdMemo[name])
    globalIdMemo[name] = 0;
  return ++globalIdMemo[name];
}
function closestIdRoot(el, name) {
  return findClosest(el, (element) => {
    if (element._x_ids && element._x_ids[name])
      return true;
  });
}
function setIdRoot(el, name) {
  if (!el._x_ids)
    el._x_ids = {};
  if (!el._x_ids[name])
    el._x_ids[name] = findAndIncrementId(name);
}

// packages/alpinejs/src/magics/$id.js
magic("id", (el) => (name, key = null) => {
  let root = closestIdRoot(el, name);
  let id = root ? root._x_ids[name] : findAndIncrementId(name);
  return key ? `${name}-${id}-${key}` : `${name}-${id}`;
});

// packages/alpinejs/src/magics/$el.js
magic("el", (el) => el);

// packages/alpinejs/src/magics/index.js
warnMissingPluginMagic("Focus", "focus", "focus");
warnMissingPluginMagic("Persist", "persist", "persist");
function warnMissingPluginMagic(name, magicName, slug) {
  magic(magicName, (el) => warn(`You can't use [$${directiveName}] without first installing the "${name}" plugin here: https://alpinejs.dev/plugins/${slug}`, el));
}

// packages/alpinejs/src/directives/x-modelable.js
directive("modelable", (el, {expression}, {effect: effect3, evaluateLater: evaluateLater2}) => {
  let func = evaluateLater2(expression);
  let innerGet = () => {
    let result;
    func((i) => result = i);
    return result;
  };
  let evaluateInnerSet = evaluateLater2(`${expression} = __placeholder`);
  let innerSet = (val) => evaluateInnerSet(() => {
  }, {scope: {__placeholder: val}});
  let initialValue = innerGet();
  innerSet(initialValue);
  queueMicrotask(() => {
    if (!el._x_model)
      return;
    el._x_removeModelListeners["default"]();
    let outerGet = el._x_model.get;
    let outerSet = el._x_model.set;
    effect3(() => innerSet(outerGet()));
    effect3(() => outerSet(innerGet()));
  });
});

// packages/alpinejs/src/directives/x-teleport.js
directive("teleport", (el, {expression}, {cleanup: cleanup2}) => {
  if (el.tagName.toLowerCase() !== "template")
    warn("x-teleport can only be used on a <template> tag", el);
  let target = document.querySelector(expression);
  if (!target)
    warn(`Cannot find x-teleport element for selector: "${expression}"`);
  let clone2 = el.content.cloneNode(true).firstElementChild;
  el._x_teleport = clone2;
  clone2._x_teleportBack = el;
  if (el._x_forwardEvents) {
    el._x_forwardEvents.forEach((eventName) => {
      clone2.addEventListener(eventName, (e) => {
        e.stopPropagation();
        el.dispatchEvent(new e.constructor(e.type, e));
      });
    });
  }
  addScopeToNode(clone2, {}, el);
  mutateDom(() => {
    target.appendChild(clone2);
    initTree(clone2);
    clone2._x_ignore = true;
  });
  cleanup2(() => clone2.remove());
});

// packages/alpinejs/src/directives/x-ignore.js
var handler = () => {
};
handler.inline = (el, {modifiers}, {cleanup: cleanup2}) => {
  modifiers.includes("self") ? el._x_ignoreSelf = true : el._x_ignore = true;
  cleanup2(() => {
    modifiers.includes("self") ? delete el._x_ignoreSelf : delete el._x_ignore;
  });
};
directive("ignore", handler);

// packages/alpinejs/src/directives/x-effect.js
directive("effect", (el, {expression}, {effect: effect3}) => effect3(evaluateLater(el, expression)));

// packages/alpinejs/src/utils/on.js
function on(el, event, modifiers, callback) {
  let listenerTarget = el;
  let handler3 = (e) => callback(e);
  let options = {};
  let wrapHandler = (callback2, wrapper) => (e) => wrapper(callback2, e);
  if (modifiers.includes("dot"))
    event = dotSyntax(event);
  if (modifiers.includes("camel"))
    event = camelCase2(event);
  if (modifiers.includes("passive"))
    options.passive = true;
  if (modifiers.includes("capture"))
    options.capture = true;
  if (modifiers.includes("window"))
    listenerTarget = window;
  if (modifiers.includes("document"))
    listenerTarget = document;
  if (modifiers.includes("prevent"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.preventDefault();
      next(e);
    });
  if (modifiers.includes("stop"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.stopPropagation();
      next(e);
    });
  if (modifiers.includes("self"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.target === el && next(e);
    });
  if (modifiers.includes("away") || modifiers.includes("outside")) {
    listenerTarget = document;
    handler3 = wrapHandler(handler3, (next, e) => {
      if (el.contains(e.target))
        return;
      if (e.target.isConnected === false)
        return;
      if (el.offsetWidth < 1 && el.offsetHeight < 1)
        return;
      if (el._x_isShown === false)
        return;
      next(e);
    });
  }
  if (modifiers.includes("once")) {
    handler3 = wrapHandler(handler3, (next, e) => {
      next(e);
      listenerTarget.removeEventListener(event, handler3, options);
    });
  }
  handler3 = wrapHandler(handler3, (next, e) => {
    if (isKeyEvent(event)) {
      if (isListeningForASpecificKeyThatHasntBeenPressed(e, modifiers)) {
        return;
      }
    }
    next(e);
  });
  if (modifiers.includes("debounce")) {
    let nextModifier = modifiers[modifiers.indexOf("debounce") + 1] || "invalid-wait";
    let wait = isNumeric(nextModifier.split("ms")[0]) ? Number(nextModifier.split("ms")[0]) : 250;
    handler3 = debounce(handler3, wait);
  }
  if (modifiers.includes("throttle")) {
    let nextModifier = modifiers[modifiers.indexOf("throttle") + 1] || "invalid-wait";
    let wait = isNumeric(nextModifier.split("ms")[0]) ? Number(nextModifier.split("ms")[0]) : 250;
    handler3 = throttle(handler3, wait);
  }
  listenerTarget.addEventListener(event, handler3, options);
  return () => {
    listenerTarget.removeEventListener(event, handler3, options);
  };
}
function dotSyntax(subject) {
  return subject.replace(/-/g, ".");
}
function camelCase2(subject) {
  return subject.toLowerCase().replace(/-(\w)/g, (match, char) => char.toUpperCase());
}
function isNumeric(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}
function kebabCase2(subject) {
  return subject.replace(/([a-z])([A-Z])/g, "$1-$2").replace(/[_\s]/, "-").toLowerCase();
}
function isKeyEvent(event) {
  return ["keydown", "keyup"].includes(event);
}
function isListeningForASpecificKeyThatHasntBeenPressed(e, modifiers) {
  let keyModifiers = modifiers.filter((i) => {
    return !["window", "document", "prevent", "stop", "once"].includes(i);
  });
  if (keyModifiers.includes("debounce")) {
    let debounceIndex = keyModifiers.indexOf("debounce");
    keyModifiers.splice(debounceIndex, isNumeric((keyModifiers[debounceIndex + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1);
  }
  if (keyModifiers.length === 0)
    return false;
  if (keyModifiers.length === 1 && keyToModifiers(e.key).includes(keyModifiers[0]))
    return false;
  const systemKeyModifiers = ["ctrl", "shift", "alt", "meta", "cmd", "super"];
  const selectedSystemKeyModifiers = systemKeyModifiers.filter((modifier) => keyModifiers.includes(modifier));
  keyModifiers = keyModifiers.filter((i) => !selectedSystemKeyModifiers.includes(i));
  if (selectedSystemKeyModifiers.length > 0) {
    const activelyPressedKeyModifiers = selectedSystemKeyModifiers.filter((modifier) => {
      if (modifier === "cmd" || modifier === "super")
        modifier = "meta";
      return e[`${modifier}Key`];
    });
    if (activelyPressedKeyModifiers.length === selectedSystemKeyModifiers.length) {
      if (keyToModifiers(e.key).includes(keyModifiers[0]))
        return false;
    }
  }
  return true;
}
function keyToModifiers(key) {
  if (!key)
    return [];
  key = kebabCase2(key);
  let modifierToKeyMap = {
    ctrl: "control",
    slash: "/",
    space: "-",
    spacebar: "-",
    cmd: "meta",
    esc: "escape",
    up: "arrow-up",
    down: "arrow-down",
    left: "arrow-left",
    right: "arrow-right",
    period: ".",
    equal: "="
  };
  modifierToKeyMap[key] = key;
  return Object.keys(modifierToKeyMap).map((modifier) => {
    if (modifierToKeyMap[modifier] === key)
      return modifier;
  }).filter((modifier) => modifier);
}

// packages/alpinejs/src/directives/x-model.js
directive("model", (el, {modifiers, expression}, {effect: effect3, cleanup: cleanup2}) => {
  let evaluate2 = evaluateLater(el, expression);
  let assignmentExpression = `${expression} = rightSideOfExpression($event, ${expression})`;
  let evaluateAssignment = evaluateLater(el, assignmentExpression);
  var event = el.tagName.toLowerCase() === "select" || ["checkbox", "radio"].includes(el.type) || modifiers.includes("lazy") ? "change" : "input";
  let assigmentFunction = generateAssignmentFunction(el, modifiers, expression);
  let removeListener = on(el, event, modifiers, (e) => {
    evaluateAssignment(() => {
    }, {scope: {
      $event: e,
      rightSideOfExpression: assigmentFunction
    }});
  });
  if (!el._x_removeModelListeners)
    el._x_removeModelListeners = {};
  el._x_removeModelListeners["default"] = removeListener;
  cleanup2(() => el._x_removeModelListeners["default"]());
  let evaluateSetModel = evaluateLater(el, `${expression} = __placeholder`);
  el._x_model = {
    get() {
      let result;
      evaluate2((value) => result = value);
      return result;
    },
    set(value) {
      evaluateSetModel(() => {
      }, {scope: {__placeholder: value}});
    }
  };
  el._x_forceModelUpdate = () => {
    evaluate2((value) => {
      if (value === void 0 && expression.match(/\./))
        value = "";
      window.fromModel = true;
      mutateDom(() => bind(el, "value", value));
      delete window.fromModel;
    });
  };
  effect3(() => {
    if (modifiers.includes("unintrusive") && document.activeElement.isSameNode(el))
      return;
    el._x_forceModelUpdate();
  });
});
function generateAssignmentFunction(el, modifiers, expression) {
  if (el.type === "radio") {
    mutateDom(() => {
      if (!el.hasAttribute("name"))
        el.setAttribute("name", expression);
    });
  }
  return (event, currentValue) => {
    return mutateDom(() => {
      if (event instanceof CustomEvent && event.detail !== void 0) {
        return event.detail || event.target.value;
      } else if (el.type === "checkbox") {
        if (Array.isArray(currentValue)) {
          let newValue = modifiers.includes("number") ? safeParseNumber(event.target.value) : event.target.value;
          return event.target.checked ? currentValue.concat([newValue]) : currentValue.filter((el2) => !checkedAttrLooseCompare2(el2, newValue));
        } else {
          return event.target.checked;
        }
      } else if (el.tagName.toLowerCase() === "select" && el.multiple) {
        return modifiers.includes("number") ? Array.from(event.target.selectedOptions).map((option) => {
          let rawValue = option.value || option.text;
          return safeParseNumber(rawValue);
        }) : Array.from(event.target.selectedOptions).map((option) => {
          return option.value || option.text;
        });
      } else {
        let rawValue = event.target.value;
        return modifiers.includes("number") ? safeParseNumber(rawValue) : modifiers.includes("trim") ? rawValue.trim() : rawValue;
      }
    });
  };
}
function safeParseNumber(rawValue) {
  let number = rawValue ? parseFloat(rawValue) : null;
  return isNumeric2(number) ? number : rawValue;
}
function checkedAttrLooseCompare2(valueA, valueB) {
  return valueA == valueB;
}
function isNumeric2(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}

// packages/alpinejs/src/directives/x-cloak.js
directive("cloak", (el) => queueMicrotask(() => mutateDom(() => el.removeAttribute(prefix("cloak")))));

// packages/alpinejs/src/directives/x-init.js
addInitSelector(() => `[${prefix("init")}]`);
directive("init", skipDuringClone((el, {expression}, {evaluate: evaluate2}) => {
  if (typeof expression === "string") {
    return !!expression.trim() && evaluate2(expression, {}, false);
  }
  return evaluate2(expression, {}, false);
}));

// packages/alpinejs/src/directives/x-text.js
directive("text", (el, {expression}, {effect: effect3, evaluateLater: evaluateLater2}) => {
  let evaluate2 = evaluateLater2(expression);
  effect3(() => {
    evaluate2((value) => {
      mutateDom(() => {
        el.textContent = value;
      });
    });
  });
});

// packages/alpinejs/src/directives/x-html.js
directive("html", (el, {expression}, {effect: effect3, evaluateLater: evaluateLater2}) => {
  let evaluate2 = evaluateLater2(expression);
  effect3(() => {
    evaluate2((value) => {
      mutateDom(() => {
        el.innerHTML = value;
        el._x_ignoreSelf = true;
        initTree(el);
        delete el._x_ignoreSelf;
      });
    });
  });
});

// packages/alpinejs/src/directives/x-bind.js
mapAttributes(startingWith(":", into(prefix("bind:"))));
directive("bind", (el, {value, modifiers, expression, original}, {effect: effect3}) => {
  if (!value) {
    let bindingProviders = {};
    injectBindingProviders(bindingProviders);
    let getBindings = evaluateLater(el, expression);
    getBindings((bindings) => {
      applyBindingsObject(el, bindings, original);
    }, {scope: bindingProviders});
    return;
  }
  if (value === "key")
    return storeKeyForXFor(el, expression);
  let evaluate2 = evaluateLater(el, expression);
  effect3(() => evaluate2((result) => {
    if (result === void 0 && typeof expression === "string" && expression.match(/\./)) {
      result = "";
    }
    mutateDom(() => bind(el, value, result, modifiers));
  }));
});
function storeKeyForXFor(el, expression) {
  el._x_keyExpression = expression;
}

// packages/alpinejs/src/directives/x-data.js
addRootSelector(() => `[${prefix("data")}]`);
directive("data", skipDuringClone((el, {expression}, {cleanup: cleanup2}) => {
  expression = expression === "" ? "{}" : expression;
  let magicContext = {};
  injectMagics(magicContext, el);
  let dataProviderContext = {};
  injectDataProviders(dataProviderContext, magicContext);
  let data2 = evaluate(el, expression, {scope: dataProviderContext});
  if (data2 === void 0)
    data2 = {};
  injectMagics(data2, el);
  let reactiveData = reactive(data2);
  initInterceptors(reactiveData);
  let undo = addScopeToNode(el, reactiveData);
  reactiveData["init"] && evaluate(el, reactiveData["init"]);
  cleanup2(() => {
    reactiveData["destroy"] && evaluate(el, reactiveData["destroy"]);
    undo();
  });
}));

// packages/alpinejs/src/directives/x-show.js
directive("show", (el, {modifiers, expression}, {effect: effect3}) => {
  let evaluate2 = evaluateLater(el, expression);
  if (!el._x_doHide)
    el._x_doHide = () => {
      mutateDom(() => {
        el.style.setProperty("display", "none", modifiers.includes("important") ? "important" : void 0);
      });
    };
  if (!el._x_doShow)
    el._x_doShow = () => {
      mutateDom(() => {
        if (el.style.length === 1 && el.style.display === "none") {
          el.removeAttribute("style");
        } else {
          el.style.removeProperty("display");
        }
      });
    };
  let hide = () => {
    el._x_doHide();
    el._x_isShown = false;
  };
  let show = () => {
    el._x_doShow();
    el._x_isShown = true;
  };
  let clickAwayCompatibleShow = () => setTimeout(show);
  let toggle = once((value) => value ? show() : hide(), (value) => {
    if (typeof el._x_toggleAndCascadeWithTransitions === "function") {
      el._x_toggleAndCascadeWithTransitions(el, value, show, hide);
    } else {
      value ? clickAwayCompatibleShow() : hide();
    }
  });
  let oldValue;
  let firstTime = true;
  effect3(() => evaluate2((value) => {
    if (!firstTime && value === oldValue)
      return;
    if (modifiers.includes("immediate"))
      value ? clickAwayCompatibleShow() : hide();
    toggle(value);
    oldValue = value;
    firstTime = false;
  }));
});

// packages/alpinejs/src/directives/x-for.js
directive("for", (el, {expression}, {effect: effect3, cleanup: cleanup2}) => {
  let iteratorNames = parseForExpression(expression);
  let evaluateItems = evaluateLater(el, iteratorNames.items);
  let evaluateKey = evaluateLater(el, el._x_keyExpression || "index");
  el._x_prevKeys = [];
  el._x_lookup = {};
  effect3(() => loop(el, iteratorNames, evaluateItems, evaluateKey));
  cleanup2(() => {
    Object.values(el._x_lookup).forEach((el2) => el2.remove());
    delete el._x_prevKeys;
    delete el._x_lookup;
  });
});
function loop(el, iteratorNames, evaluateItems, evaluateKey) {
  let isObject2 = (i) => typeof i === "object" && !Array.isArray(i);
  let templateEl = el;
  evaluateItems((items) => {
    if (isNumeric3(items) && items >= 0) {
      items = Array.from(Array(items).keys(), (i) => i + 1);
    }
    if (items === void 0)
      items = [];
    let lookup = el._x_lookup;
    let prevKeys = el._x_prevKeys;
    let scopes = [];
    let keys = [];
    if (isObject2(items)) {
      items = Object.entries(items).map(([key, value]) => {
        let scope2 = getIterationScopeVariables(iteratorNames, value, key, items);
        evaluateKey((value2) => keys.push(value2), {scope: {index: key, ...scope2}});
        scopes.push(scope2);
      });
    } else {
      for (let i = 0; i < items.length; i++) {
        let scope2 = getIterationScopeVariables(iteratorNames, items[i], i, items);
        evaluateKey((value) => keys.push(value), {scope: {index: i, ...scope2}});
        scopes.push(scope2);
      }
    }
    let adds = [];
    let moves = [];
    let removes = [];
    let sames = [];
    for (let i = 0; i < prevKeys.length; i++) {
      let key = prevKeys[i];
      if (keys.indexOf(key) === -1)
        removes.push(key);
    }
    prevKeys = prevKeys.filter((key) => !removes.includes(key));
    let lastKey = "template";
    for (let i = 0; i < keys.length; i++) {
      let key = keys[i];
      let prevIndex = prevKeys.indexOf(key);
      if (prevIndex === -1) {
        prevKeys.splice(i, 0, key);
        adds.push([lastKey, i]);
      } else if (prevIndex !== i) {
        let keyInSpot = prevKeys.splice(i, 1)[0];
        let keyForSpot = prevKeys.splice(prevIndex - 1, 1)[0];
        prevKeys.splice(i, 0, keyForSpot);
        prevKeys.splice(prevIndex, 0, keyInSpot);
        moves.push([keyInSpot, keyForSpot]);
      } else {
        sames.push(key);
      }
      lastKey = key;
    }
    for (let i = 0; i < removes.length; i++) {
      let key = removes[i];
      if (!!lookup[key]._x_effects) {
        lookup[key]._x_effects.forEach(dequeueJob);
      }
      lookup[key].remove();
      lookup[key] = null;
      delete lookup[key];
    }
    for (let i = 0; i < moves.length; i++) {
      let [keyInSpot, keyForSpot] = moves[i];
      let elInSpot = lookup[keyInSpot];
      let elForSpot = lookup[keyForSpot];
      let marker = document.createElement("div");
      mutateDom(() => {
        elForSpot.after(marker);
        elInSpot.after(elForSpot);
        elForSpot._x_currentIfEl && elForSpot.after(elForSpot._x_currentIfEl);
        marker.before(elInSpot);
        elInSpot._x_currentIfEl && elInSpot.after(elInSpot._x_currentIfEl);
        marker.remove();
      });
      refreshScope(elForSpot, scopes[keys.indexOf(keyForSpot)]);
    }
    for (let i = 0; i < adds.length; i++) {
      let [lastKey2, index] = adds[i];
      let lastEl = lastKey2 === "template" ? templateEl : lookup[lastKey2];
      if (lastEl._x_currentIfEl)
        lastEl = lastEl._x_currentIfEl;
      let scope2 = scopes[index];
      let key = keys[index];
      let clone2 = document.importNode(templateEl.content, true).firstElementChild;
      addScopeToNode(clone2, reactive(scope2), templateEl);
      mutateDom(() => {
        lastEl.after(clone2);
        initTree(clone2);
      });
      if (typeof key === "object") {
        warn("x-for key cannot be an object, it must be a string or an integer", templateEl);
      }
      lookup[key] = clone2;
    }
    for (let i = 0; i < sames.length; i++) {
      refreshScope(lookup[sames[i]], scopes[keys.indexOf(sames[i])]);
    }
    templateEl._x_prevKeys = keys;
  });
}
function parseForExpression(expression) {
  let forIteratorRE = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/;
  let stripParensRE = /^\s*\(|\)\s*$/g;
  let forAliasRE = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/;
  let inMatch = expression.match(forAliasRE);
  if (!inMatch)
    return;
  let res = {};
  res.items = inMatch[2].trim();
  let item = inMatch[1].replace(stripParensRE, "").trim();
  let iteratorMatch = item.match(forIteratorRE);
  if (iteratorMatch) {
    res.item = item.replace(forIteratorRE, "").trim();
    res.index = iteratorMatch[1].trim();
    if (iteratorMatch[2]) {
      res.collection = iteratorMatch[2].trim();
    }
  } else {
    res.item = item;
  }
  return res;
}
function getIterationScopeVariables(iteratorNames, item, index, items) {
  let scopeVariables = {};
  if (/^\[.*\]$/.test(iteratorNames.item) && Array.isArray(item)) {
    let names = iteratorNames.item.replace("[", "").replace("]", "").split(",").map((i) => i.trim());
    names.forEach((name, i) => {
      scopeVariables[name] = item[i];
    });
  } else if (/^\{.*\}$/.test(iteratorNames.item) && !Array.isArray(item) && typeof item === "object") {
    let names = iteratorNames.item.replace("{", "").replace("}", "").split(",").map((i) => i.trim());
    names.forEach((name) => {
      scopeVariables[name] = item[name];
    });
  } else {
    scopeVariables[iteratorNames.item] = item;
  }
  if (iteratorNames.index)
    scopeVariables[iteratorNames.index] = index;
  if (iteratorNames.collection)
    scopeVariables[iteratorNames.collection] = items;
  return scopeVariables;
}
function isNumeric3(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}

// packages/alpinejs/src/directives/x-ref.js
function handler2() {
}
handler2.inline = (el, {expression}, {cleanup: cleanup2}) => {
  let root = closestRoot(el);
  if (!root._x_refs)
    root._x_refs = {};
  root._x_refs[expression] = el;
  cleanup2(() => delete root._x_refs[expression]);
};
directive("ref", handler2);

// packages/alpinejs/src/directives/x-if.js
directive("if", (el, {expression}, {effect: effect3, cleanup: cleanup2}) => {
  let evaluate2 = evaluateLater(el, expression);
  let show = () => {
    if (el._x_currentIfEl)
      return el._x_currentIfEl;
    let clone2 = el.content.cloneNode(true).firstElementChild;
    addScopeToNode(clone2, {}, el);
    mutateDom(() => {
      el.after(clone2);
      initTree(clone2);
    });
    el._x_currentIfEl = clone2;
    el._x_undoIf = () => {
      walk(clone2, (node) => {
        if (!!node._x_effects) {
          node._x_effects.forEach(dequeueJob);
        }
      });
      clone2.remove();
      delete el._x_currentIfEl;
    };
    return clone2;
  };
  let hide = () => {
    if (!el._x_undoIf)
      return;
    el._x_undoIf();
    delete el._x_undoIf;
  };
  effect3(() => evaluate2((value) => {
    value ? show() : hide();
  }));
  cleanup2(() => el._x_undoIf && el._x_undoIf());
});

// packages/alpinejs/src/directives/x-id.js
directive("id", (el, {expression}, {evaluate: evaluate2}) => {
  let names = evaluate2(expression);
  names.forEach((name) => setIdRoot(el, name));
});

// packages/alpinejs/src/directives/x-on.js
mapAttributes(startingWith("@", into(prefix("on:"))));
directive("on", skipDuringClone((el, {value, modifiers, expression}, {cleanup: cleanup2}) => {
  let evaluate2 = expression ? evaluateLater(el, expression) : () => {
  };
  if (el.tagName.toLowerCase() === "template") {
    if (!el._x_forwardEvents)
      el._x_forwardEvents = [];
    if (!el._x_forwardEvents.includes(value))
      el._x_forwardEvents.push(value);
  }
  let removeListener = on(el, value, modifiers, (e) => {
    evaluate2(() => {
    }, {scope: {$event: e}, params: [e]});
  });
  cleanup2(() => removeListener());
}));

// packages/alpinejs/src/directives/index.js
warnMissingPluginDirective("Collapse", "collapse", "collapse");
warnMissingPluginDirective("Intersect", "intersect", "intersect");
warnMissingPluginDirective("Focus", "trap", "focus");
warnMissingPluginDirective("Mask", "mask", "mask");
function warnMissingPluginDirective(name, directiveName2, slug) {
  directive(directiveName2, (el) => warn(`You can't use [x-${directiveName2}] without first installing the "${name}" plugin here: https://alpinejs.dev/plugins/${slug}`, el));
}

// packages/alpinejs/src/index.js
alpine_default.setEvaluator(normalEvaluator);
alpine_default.setReactivityEngine({reactive: reactive2, effect: effect2, release: stop, raw: toRaw});
var src_default = alpine_default;

// packages/alpinejs/builds/module.js
var module_default = src_default;



/***/ }),

/***/ "./node_modules/flowbite/dist/flowbite.js":
/*!************************************************!*\
  !*** ./node_modules/flowbite/dist/flowbite.js ***!
  \************************************************/
/***/ (() => {

/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};

// UNUSED EXPORTS: default

;// CONCATENATED MODULE: ./src/components/accordion.js
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var Default = {
  alwaysOpen: false,
  activeClasses: 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white',
  inactiveClasses: 'text-gray-500 dark:text-gray-400',
  onOpen: function onOpen() {},
  onClose: function onClose() {},
  onToggle: function onToggle() {}
};

var Accordion = /*#__PURE__*/function () {
  function Accordion() {
    var items = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    _classCallCheck(this, Accordion);

    this._items = items;
    this._options = _objectSpread(_objectSpread({}, Default), options);

    this._init();
  }

  _createClass(Accordion, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      if (this._items.length) {
        // show accordion item based on click
        this._items.map(function (item) {
          if (item.active) {
            _this.open(item.id);
          }

          item.triggerEl.addEventListener('click', function () {
            _this.toggle(item.id);
          });
        });
      }
    }
  }, {
    key: "getItem",
    value: function getItem(id) {
      return this._items.filter(function (item) {
        return item.id === id;
      })[0];
    }
  }, {
    key: "open",
    value: function open(id) {
      var _this2 = this,
          _item$triggerEl$class,
          _item$triggerEl$class2;

      var item = this.getItem(id); // don't hide other accordions if always open

      if (!this._options.alwaysOpen) {
        this._items.map(function (i) {
          if (i !== item) {
            var _i$triggerEl$classLis, _i$triggerEl$classLis2;

            (_i$triggerEl$classLis = i.triggerEl.classList).remove.apply(_i$triggerEl$classLis, _toConsumableArray(_this2._options.activeClasses.split(" ")));

            (_i$triggerEl$classLis2 = i.triggerEl.classList).add.apply(_i$triggerEl$classLis2, _toConsumableArray(_this2._options.inactiveClasses.split(" ")));

            i.targetEl.classList.add('hidden');
            i.triggerEl.setAttribute('aria-expanded', false);
            i.active = false; // rotate icon if set

            if (i.iconEl) {
              i.iconEl.classList.remove('rotate-180');
            }
          }
        });
      } // show active item


      (_item$triggerEl$class = item.triggerEl.classList).add.apply(_item$triggerEl$class, _toConsumableArray(this._options.activeClasses.split(" ")));

      (_item$triggerEl$class2 = item.triggerEl.classList).remove.apply(_item$triggerEl$class2, _toConsumableArray(this._options.inactiveClasses.split(" ")));

      item.triggerEl.setAttribute('aria-expanded', true);
      item.targetEl.classList.remove('hidden');
      item.active = true; // rotate icon if set

      if (item.iconEl) {
        item.iconEl.classList.add('rotate-180');
      } // callback function


      this._options.onOpen(this, item);
    }
  }, {
    key: "toggle",
    value: function toggle(id) {
      var item = this.getItem(id);

      if (item.active) {
        this.close(id);
      } else {
        this.open(id);
      } // callback function


      this._options.onToggle(this, item);
    }
  }, {
    key: "close",
    value: function close(id) {
      var _item$triggerEl$class3, _item$triggerEl$class4;

      var item = this.getItem(id);

      (_item$triggerEl$class3 = item.triggerEl.classList).remove.apply(_item$triggerEl$class3, _toConsumableArray(this._options.activeClasses.split(" ")));

      (_item$triggerEl$class4 = item.triggerEl.classList).add.apply(_item$triggerEl$class4, _toConsumableArray(this._options.inactiveClasses.split(" ")));

      item.targetEl.classList.add('hidden');
      item.triggerEl.setAttribute('aria-expanded', false);
      item.active = false; // rotate icon if set

      if (item.iconEl) {
        item.iconEl.classList.remove('rotate-180');
      } // callback function


      this._options.onClose(this, item);
    }
  }]);

  return Accordion;
}();

window.Accordion = Accordion;

function initAccordion() {
  document.querySelectorAll('[data-accordion]').forEach(function (accordionEl) {
    var alwaysOpen = accordionEl.getAttribute('data-accordion');
    var activeClasses = accordionEl.getAttribute('data-active-classes');
    var inactiveClasses = accordionEl.getAttribute('data-inactive-classes');
    var items = [];
    accordionEl.querySelectorAll('[data-accordion-target]').forEach(function (el) {
      var item = {
        id: el.getAttribute('data-accordion-target'),
        triggerEl: el,
        targetEl: document.querySelector(el.getAttribute('data-accordion-target')),
        iconEl: el.querySelector('[data-accordion-icon]'),
        active: el.getAttribute('aria-expanded') === 'true' ? true : false
      };
      items.push(item);
    });
    new Accordion(items, {
      alwaysOpen: alwaysOpen === 'open' ? true : false,
      activeClasses: activeClasses ? activeClasses : Default.activeClasses,
      inactiveClasses: inactiveClasses ? inactiveClasses : Default.inactiveClasses
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initAccordion();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initAccordion);
}

/* harmony default export */ const accordion = (Accordion);
;// CONCATENATED MODULE: ./src/components/collapse.js
function collapse_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function collapse_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? collapse_ownKeys(Object(source), !0).forEach(function (key) { collapse_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : collapse_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function collapse_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function collapse_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function collapse_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function collapse_createClass(Constructor, protoProps, staticProps) { if (protoProps) collapse_defineProperties(Constructor.prototype, protoProps); if (staticProps) collapse_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var collapse_Default = {
  triggerEl: null,
  onCollapse: function onCollapse() {},
  onExpand: function onExpand() {},
  onToggle: function onToggle() {}
};

var Collapse = /*#__PURE__*/function () {
  function Collapse() {
    var targetEl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var options = arguments.length > 1 ? arguments[1] : undefined;

    collapse_classCallCheck(this, Collapse);

    this._targetEl = targetEl;
    this._triggerEl = options ? options.triggerEl : collapse_Default.triggerEl;
    this._options = collapse_objectSpread(collapse_objectSpread({}, collapse_Default), options);
    this._visible = false;

    this._init();
  }

  collapse_createClass(Collapse, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      if (this._triggerEl) {
        if (this._triggerEl.hasAttribute('aria-expanded')) {
          this._visible = this._triggerEl.getAttribute('aria-expanded') === 'true' ? true : false;
        } else {
          // fix until v2 not to break previous single collapses which became dismiss
          this._visible = this._targetEl.classList.contains('hidden') ? false : true;
        }

        this._triggerEl.addEventListener('click', function () {
          _this._visible ? _this.collapse() : _this.expand();
        });
      }
    }
  }, {
    key: "collapse",
    value: function collapse() {
      this._targetEl.classList.add('hidden');

      if (this._triggerEl) {
        this._triggerEl.setAttribute('aria-expanded', 'false');
      }

      this._visible = false; // callback function

      this._options.onCollapse(this);
    }
  }, {
    key: "expand",
    value: function expand() {
      this._targetEl.classList.remove('hidden');

      if (this._triggerEl) {
        this._triggerEl.setAttribute('aria-expanded', 'true');
      }

      this._visible = true; // callback function

      this._options.onExpand(this);
    }
  }, {
    key: "toggle",
    value: function toggle() {
      if (this._visible) {
        this.collapse();
      } else {
        this.expand();
      }
    }
  }]);

  return Collapse;
}();

window.Collapse = Collapse;

function initCollapse() {
  document.querySelectorAll('[data-collapse-toggle]').forEach(function (triggerEl) {
    var targetEl = document.getElementById(triggerEl.getAttribute('data-collapse-toggle'));
    new Collapse(targetEl, {
      triggerEl: triggerEl
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initCollapse();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initCollapse);
}

/* harmony default export */ const collapse = (Collapse);
;// CONCATENATED MODULE: ./src/components/carousel.js
function carousel_toConsumableArray(arr) { return carousel_arrayWithoutHoles(arr) || carousel_iterableToArray(arr) || carousel_unsupportedIterableToArray(arr) || carousel_nonIterableSpread(); }

function carousel_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function carousel_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return carousel_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return carousel_arrayLikeToArray(o, minLen); }

function carousel_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function carousel_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return carousel_arrayLikeToArray(arr); }

function carousel_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function carousel_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function carousel_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? carousel_ownKeys(Object(source), !0).forEach(function (key) { carousel_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : carousel_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function carousel_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function carousel_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function carousel_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function carousel_createClass(Constructor, protoProps, staticProps) { if (protoProps) carousel_defineProperties(Constructor.prototype, protoProps); if (staticProps) carousel_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var carousel_Default = {
  defaultPosition: 0,
  indicators: {
    items: [],
    activeClasses: 'bg-white dark:bg-gray-800',
    inactiveClasses: 'bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800'
  },
  interval: 3000,
  onNext: function onNext() {},
  onPrev: function onPrev() {},
  onChange: function onChange() {}
};

var Carousel = /*#__PURE__*/function () {
  function Carousel() {
    var items = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    carousel_classCallCheck(this, Carousel);

    this._items = items;
    this._options = carousel_objectSpread(carousel_objectSpread(carousel_objectSpread({}, carousel_Default), options), {}, {
      indicators: carousel_objectSpread(carousel_objectSpread({}, carousel_Default.indicators), options.indicators)
    });
    this._activeItem = this.getItem(this._options.defaultPosition);
    this._indicators = this._options.indicators.items;
    this._interval = null;

    this._init();
  }
  /**
   * Initialise carousel and items based on active one
   */


  carousel_createClass(Carousel, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      this._items.map(function (item) {
        item.el.classList.add('absolute', 'inset-0', 'transition-all', 'transform');
      }); // if no active item is set then first position is default


      if (this._getActiveItem()) {
        this.slideTo(this._getActiveItem().position);
      } else {
        this.slideTo(0);
      }

      this._indicators.map(function (indicator, position) {
        indicator.el.addEventListener('click', function () {
          _this.slideTo(position);
        });
      });
    }
  }, {
    key: "getItem",
    value: function getItem(position) {
      return this._items[position];
    }
    /**
     * Slide to the element based on id
     * @param {*} position 
     */

  }, {
    key: "slideTo",
    value: function slideTo(position) {
      var nextItem = this._items[position];
      var rotationItems = {
        'left': nextItem.position === 0 ? this._items[this._items.length - 1] : this._items[nextItem.position - 1],
        'middle': nextItem,
        'right': nextItem.position === this._items.length - 1 ? this._items[0] : this._items[nextItem.position + 1]
      };

      this._rotate(rotationItems);

      this._setActiveItem(nextItem.position);

      if (this._interval) {
        this.pause();
        this.cycle();
      }

      this._options.onChange(this);
    }
    /**
     * Based on the currently active item it will go to the next position
     */

  }, {
    key: "next",
    value: function next() {
      var activeItem = this._getActiveItem();

      var nextItem = null; // check if last item

      if (activeItem.position === this._items.length - 1) {
        nextItem = this._items[0];
      } else {
        nextItem = this._items[activeItem.position + 1];
      }

      this.slideTo(nextItem.position); // callback function

      this._options.onNext(this);
    }
    /**
     * Based on the currently active item it will go to the previous position
     */

  }, {
    key: "prev",
    value: function prev() {
      var activeItem = this._getActiveItem();

      var prevItem = null; // check if first item

      if (activeItem.position === 0) {
        prevItem = this._items[this._items.length - 1];
      } else {
        prevItem = this._items[activeItem.position - 1];
      }

      this.slideTo(prevItem.position); // callback function

      this._options.onPrev(this);
    }
    /**
     * This method applies the transform classes based on the left, middle, and right rotation carousel items
     * @param {*} rotationItems 
     */

  }, {
    key: "_rotate",
    value: function _rotate(rotationItems) {
      // reset
      this._items.map(function (item) {
        item.el.classList.add('hidden');
      }); // left item (previously active)


      rotationItems.left.el.classList.remove('-translate-x-full', 'translate-x-full', 'translate-x-0', 'hidden', 'z-20');
      rotationItems.left.el.classList.add('-translate-x-full', 'z-10'); // currently active item

      rotationItems.middle.el.classList.remove('-translate-x-full', 'translate-x-full', 'translate-x-0', 'hidden', 'z-10');
      rotationItems.middle.el.classList.add('translate-x-0', 'z-20'); // right item (upcoming active)

      rotationItems.right.el.classList.remove('-translate-x-full', 'translate-x-full', 'translate-x-0', 'hidden', 'z-20');
      rotationItems.right.el.classList.add('translate-x-full', 'z-10');
    }
    /**
     * Set an interval to cycle through the carousel items
     */

  }, {
    key: "cycle",
    value: function cycle() {
      var _this2 = this;

      this._interval = setInterval(function () {
        _this2.next();
      }, this._options.interval);
    }
    /**
     * Clears the cycling interval
     */

  }, {
    key: "pause",
    value: function pause() {
      clearInterval(this._interval);
    }
    /**
     * Get the currently active item
     */

  }, {
    key: "_getActiveItem",
    value: function _getActiveItem() {
      return this._activeItem;
    }
    /**
     * Set the currently active item and data attribute
     * @param {*} position 
     */

  }, {
    key: "_setActiveItem",
    value: function _setActiveItem(position) {
      var _this3 = this;

      this._activeItem = this._items[position]; // update the indicators if available

      if (this._indicators.length) {
        var _this$_indicators$pos, _this$_indicators$pos2;

        this._indicators.map(function (indicator) {
          var _indicator$el$classLi, _indicator$el$classLi2;

          indicator.el.setAttribute('aria-current', 'false');

          (_indicator$el$classLi = indicator.el.classList).remove.apply(_indicator$el$classLi, carousel_toConsumableArray(_this3._options.indicators.activeClasses.split(" ")));

          (_indicator$el$classLi2 = indicator.el.classList).add.apply(_indicator$el$classLi2, carousel_toConsumableArray(_this3._options.indicators.inactiveClasses.split(" ")));
        });

        (_this$_indicators$pos = this._indicators[position].el.classList).add.apply(_this$_indicators$pos, carousel_toConsumableArray(this._options.indicators.activeClasses.split(" ")));

        (_this$_indicators$pos2 = this._indicators[position].el.classList).remove.apply(_this$_indicators$pos2, carousel_toConsumableArray(this._options.indicators.inactiveClasses.split(" ")));

        this._indicators[position].el.setAttribute('aria-current', 'true');
      }
    }
  }]);

  return Carousel;
}();

window.Carousel = Carousel;

function initCarousel() {
  document.querySelectorAll('[data-carousel]').forEach(function (carouselEl) {
    var interval = carouselEl.getAttribute('data-carousel-interval');
    var slide = carouselEl.getAttribute('data-carousel') === 'slide' ? true : false;
    var items = [];
    var defaultPosition = 0;

    if (carouselEl.querySelectorAll('[data-carousel-item]').length) {
      carousel_toConsumableArray(carouselEl.querySelectorAll('[data-carousel-item]')).map(function (carouselItemEl, position) {
        items.push({
          position: position,
          el: carouselItemEl
        });

        if (carouselItemEl.getAttribute('data-carousel-item') === 'active') {
          defaultPosition = position;
        }
      });
    }

    var indicators = [];

    if (carouselEl.querySelectorAll('[data-carousel-slide-to]').length) {
      carousel_toConsumableArray(carouselEl.querySelectorAll('[data-carousel-slide-to]')).map(function (indicatorEl) {
        indicators.push({
          position: indicatorEl.getAttribute('data-carousel-slide-to'),
          el: indicatorEl
        });
      });
    }

    var carousel = new Carousel(items, {
      defaultPosition: defaultPosition,
      indicators: {
        items: indicators
      },
      interval: interval ? interval : carousel_Default.interval
    });

    if (slide) {
      carousel.cycle();
    } // check for controls


    var carouselNextEl = carouselEl.querySelector('[data-carousel-next]');
    var carouselPrevEl = carouselEl.querySelector('[data-carousel-prev]');

    if (carouselNextEl) {
      carouselNextEl.addEventListener('click', function () {
        carousel.next();
      });
    }

    if (carouselPrevEl) {
      carouselPrevEl.addEventListener('click', function () {
        carousel.prev();
      });
    }
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initCarousel();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initCarousel);
}

/* harmony default export */ const carousel = (Carousel);
;// CONCATENATED MODULE: ./src/components/dismiss.js
function dismiss_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function dismiss_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? dismiss_ownKeys(Object(source), !0).forEach(function (key) { dismiss_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : dismiss_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function dismiss_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function dismiss_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function dismiss_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function dismiss_createClass(Constructor, protoProps, staticProps) { if (protoProps) dismiss_defineProperties(Constructor.prototype, protoProps); if (staticProps) dismiss_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var dismiss_Default = {
  triggerEl: null,
  transition: 'transition-opacity',
  duration: 300,
  timing: 'ease-out',
  onHide: function onHide() {}
};

var Dismiss = /*#__PURE__*/function () {
  function Dismiss() {
    var targetEl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    dismiss_classCallCheck(this, Dismiss);

    this._targetEl = targetEl;
    this._triggerEl = options ? options.triggerEl : dismiss_Default.triggerEl;
    this._options = dismiss_objectSpread(dismiss_objectSpread({}, dismiss_Default), options);

    this._init();
  }

  dismiss_createClass(Dismiss, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      if (this._triggerEl) {
        this._triggerEl.addEventListener('click', function () {
          _this.hide();
        });
      }
    }
  }, {
    key: "hide",
    value: function hide() {
      var _this2 = this;

      this._targetEl.classList.add(this._options.transition, "duration-".concat(this._options.duration), this._options.timing, 'opacity-0');

      setTimeout(function () {
        _this2._targetEl.classList.add('hidden');
      }, this._options.duration); // callback function

      this._options.onHide(this, this._targetEl);
    }
  }]);

  return Dismiss;
}();

window.Dismiss = Dismiss;

function initDismiss() {
  document.querySelectorAll('[data-dismiss-target]').forEach(function (triggerEl) {
    var targetEl = document.querySelector(triggerEl.getAttribute('data-dismiss-target'));
    new Dismiss(targetEl, {
      triggerEl: triggerEl
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initDismiss();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initDismiss);
}

/* harmony default export */ const dismiss = (Dismiss);
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getWindow.js
function getWindow(node) {
  if (node == null) {
    return window;
  }

  if (node.toString() !== '[object Window]') {
    var ownerDocument = node.ownerDocument;
    return ownerDocument ? ownerDocument.defaultView || window : window;
  }

  return node;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/instanceOf.js


function isElement(node) {
  var OwnElement = getWindow(node).Element;
  return node instanceof OwnElement || node instanceof Element;
}

function isHTMLElement(node) {
  var OwnElement = getWindow(node).HTMLElement;
  return node instanceof OwnElement || node instanceof HTMLElement;
}

function isShadowRoot(node) {
  // IE 11 has no ShadowRoot
  if (typeof ShadowRoot === 'undefined') {
    return false;
  }

  var OwnElement = getWindow(node).ShadowRoot;
  return node instanceof OwnElement || node instanceof ShadowRoot;
}


;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/math.js
var math_max = Math.max;
var math_min = Math.min;
var round = Math.round;
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js


function getBoundingClientRect(element, includeScale) {
  if (includeScale === void 0) {
    includeScale = false;
  }

  var rect = element.getBoundingClientRect();
  var scaleX = 1;
  var scaleY = 1;

  if (isHTMLElement(element) && includeScale) {
    var offsetHeight = element.offsetHeight;
    var offsetWidth = element.offsetWidth; // Do not attempt to divide by 0, otherwise we get `Infinity` as scale
    // Fallback to 1 in case both values are `0`

    if (offsetWidth > 0) {
      scaleX = round(rect.width) / offsetWidth || 1;
    }

    if (offsetHeight > 0) {
      scaleY = round(rect.height) / offsetHeight || 1;
    }
  }

  return {
    width: rect.width / scaleX,
    height: rect.height / scaleY,
    top: rect.top / scaleY,
    right: rect.right / scaleX,
    bottom: rect.bottom / scaleY,
    left: rect.left / scaleX,
    x: rect.left / scaleX,
    y: rect.top / scaleY
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js

function getWindowScroll(node) {
  var win = getWindow(node);
  var scrollLeft = win.pageXOffset;
  var scrollTop = win.pageYOffset;
  return {
    scrollLeft: scrollLeft,
    scrollTop: scrollTop
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getHTMLElementScroll.js
function getHTMLElementScroll(element) {
  return {
    scrollLeft: element.scrollLeft,
    scrollTop: element.scrollTop
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getNodeScroll.js




function getNodeScroll(node) {
  if (node === getWindow(node) || !isHTMLElement(node)) {
    return getWindowScroll(node);
  } else {
    return getHTMLElementScroll(node);
  }
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getNodeName.js
function getNodeName(element) {
  return element ? (element.nodeName || '').toLowerCase() : null;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js

function getDocumentElement(element) {
  // $FlowFixMe[incompatible-return]: assume body is always available
  return ((isElement(element) ? element.ownerDocument : // $FlowFixMe[prop-missing]
  element.document) || window.document).documentElement;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js



function getWindowScrollBarX(element) {
  // If <html> has a CSS width greater than the viewport, then this will be
  // incorrect for RTL.
  // Popper 1 is broken in this case and never had a bug report so let's assume
  // it's not an issue. I don't think anyone ever specifies width on <html>
  // anyway.
  // Browsers where the left scrollbar doesn't cause an issue report `0` for
  // this (e.g. Edge 2019, IE11, Safari)
  return getBoundingClientRect(getDocumentElement(element)).left + getWindowScroll(element).scrollLeft;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js

function getComputedStyle(element) {
  return getWindow(element).getComputedStyle(element);
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js

function isScrollParent(element) {
  // Firefox wants us to check `-x` and `-y` variations as well
  var _getComputedStyle = getComputedStyle(element),
      overflow = _getComputedStyle.overflow,
      overflowX = _getComputedStyle.overflowX,
      overflowY = _getComputedStyle.overflowY;

  return /auto|scroll|overlay|hidden/.test(overflow + overflowY + overflowX);
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getCompositeRect.js









function isElementScaled(element) {
  var rect = element.getBoundingClientRect();
  var scaleX = round(rect.width) / element.offsetWidth || 1;
  var scaleY = round(rect.height) / element.offsetHeight || 1;
  return scaleX !== 1 || scaleY !== 1;
} // Returns the composite rect of an element relative to its offsetParent.
// Composite means it takes into account transforms as well as layout.


function getCompositeRect(elementOrVirtualElement, offsetParent, isFixed) {
  if (isFixed === void 0) {
    isFixed = false;
  }

  var isOffsetParentAnElement = isHTMLElement(offsetParent);
  var offsetParentIsScaled = isHTMLElement(offsetParent) && isElementScaled(offsetParent);
  var documentElement = getDocumentElement(offsetParent);
  var rect = getBoundingClientRect(elementOrVirtualElement, offsetParentIsScaled);
  var scroll = {
    scrollLeft: 0,
    scrollTop: 0
  };
  var offsets = {
    x: 0,
    y: 0
  };

  if (isOffsetParentAnElement || !isOffsetParentAnElement && !isFixed) {
    if (getNodeName(offsetParent) !== 'body' || // https://github.com/popperjs/popper-core/issues/1078
    isScrollParent(documentElement)) {
      scroll = getNodeScroll(offsetParent);
    }

    if (isHTMLElement(offsetParent)) {
      offsets = getBoundingClientRect(offsetParent, true);
      offsets.x += offsetParent.clientLeft;
      offsets.y += offsetParent.clientTop;
    } else if (documentElement) {
      offsets.x = getWindowScrollBarX(documentElement);
    }
  }

  return {
    x: rect.left + scroll.scrollLeft - offsets.x,
    y: rect.top + scroll.scrollTop - offsets.y,
    width: rect.width,
    height: rect.height
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js
 // Returns the layout rect of an element relative to its offsetParent. Layout
// means it doesn't take into account transforms.

function getLayoutRect(element) {
  var clientRect = getBoundingClientRect(element); // Use the clientRect sizes if it's not been transformed.
  // Fixes https://github.com/popperjs/popper-core/issues/1223

  var width = element.offsetWidth;
  var height = element.offsetHeight;

  if (Math.abs(clientRect.width - width) <= 1) {
    width = clientRect.width;
  }

  if (Math.abs(clientRect.height - height) <= 1) {
    height = clientRect.height;
  }

  return {
    x: element.offsetLeft,
    y: element.offsetTop,
    width: width,
    height: height
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getParentNode.js



function getParentNode(element) {
  if (getNodeName(element) === 'html') {
    return element;
  }

  return (// this is a quicker (but less type safe) way to save quite some bytes from the bundle
    // $FlowFixMe[incompatible-return]
    // $FlowFixMe[prop-missing]
    element.assignedSlot || // step into the shadow DOM of the parent of a slotted node
    element.parentNode || ( // DOM Element detected
    isShadowRoot(element) ? element.host : null) || // ShadowRoot detected
    // $FlowFixMe[incompatible-call]: HTMLElement is a Node
    getDocumentElement(element) // fallback

  );
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getScrollParent.js




function getScrollParent(node) {
  if (['html', 'body', '#document'].indexOf(getNodeName(node)) >= 0) {
    // $FlowFixMe[incompatible-return]: assume body is always available
    return node.ownerDocument.body;
  }

  if (isHTMLElement(node) && isScrollParent(node)) {
    return node;
  }

  return getScrollParent(getParentNode(node));
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js




/*
given a DOM element, return the list of all scroll parents, up the list of ancesors
until we get to the top window object. This list is what we attach scroll listeners
to, because if any of these parent elements scroll, we'll need to re-calculate the
reference element's position.
*/

function listScrollParents(element, list) {
  var _element$ownerDocumen;

  if (list === void 0) {
    list = [];
  }

  var scrollParent = getScrollParent(element);
  var isBody = scrollParent === ((_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body);
  var win = getWindow(scrollParent);
  var target = isBody ? [win].concat(win.visualViewport || [], isScrollParent(scrollParent) ? scrollParent : []) : scrollParent;
  var updatedList = list.concat(target);
  return isBody ? updatedList : // $FlowFixMe[incompatible-call]: isBody tells us target will be an HTMLElement here
  updatedList.concat(listScrollParents(getParentNode(target)));
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/isTableElement.js

function isTableElement(element) {
  return ['table', 'td', 'th'].indexOf(getNodeName(element)) >= 0;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js







function getTrueOffsetParent(element) {
  if (!isHTMLElement(element) || // https://github.com/popperjs/popper-core/issues/837
  getComputedStyle(element).position === 'fixed') {
    return null;
  }

  return element.offsetParent;
} // `.offsetParent` reports `null` for fixed elements, while absolute elements
// return the containing block


function getContainingBlock(element) {
  var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') !== -1;
  var isIE = navigator.userAgent.indexOf('Trident') !== -1;

  if (isIE && isHTMLElement(element)) {
    // In IE 9, 10 and 11 fixed elements containing block is always established by the viewport
    var elementCss = getComputedStyle(element);

    if (elementCss.position === 'fixed') {
      return null;
    }
  }

  var currentNode = getParentNode(element);

  while (isHTMLElement(currentNode) && ['html', 'body'].indexOf(getNodeName(currentNode)) < 0) {
    var css = getComputedStyle(currentNode); // This is non-exhaustive but covers the most common CSS properties that
    // create a containing block.
    // https://developer.mozilla.org/en-US/docs/Web/CSS/Containing_block#identifying_the_containing_block

    if (css.transform !== 'none' || css.perspective !== 'none' || css.contain === 'paint' || ['transform', 'perspective'].indexOf(css.willChange) !== -1 || isFirefox && css.willChange === 'filter' || isFirefox && css.filter && css.filter !== 'none') {
      return currentNode;
    } else {
      currentNode = currentNode.parentNode;
    }
  }

  return null;
} // Gets the closest ancestor positioned element. Handles some edge cases,
// such as table ancestors and cross browser bugs.


function getOffsetParent(element) {
  var window = getWindow(element);
  var offsetParent = getTrueOffsetParent(element);

  while (offsetParent && isTableElement(offsetParent) && getComputedStyle(offsetParent).position === 'static') {
    offsetParent = getTrueOffsetParent(offsetParent);
  }

  if (offsetParent && (getNodeName(offsetParent) === 'html' || getNodeName(offsetParent) === 'body' && getComputedStyle(offsetParent).position === 'static')) {
    return window;
  }

  return offsetParent || getContainingBlock(element) || window;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/enums.js
var enums_top = 'top';
var bottom = 'bottom';
var right = 'right';
var left = 'left';
var auto = 'auto';
var basePlacements = [enums_top, bottom, right, left];
var start = 'start';
var end = 'end';
var clippingParents = 'clippingParents';
var viewport = 'viewport';
var popper = 'popper';
var reference = 'reference';
var variationPlacements = /*#__PURE__*/basePlacements.reduce(function (acc, placement) {
  return acc.concat([placement + "-" + start, placement + "-" + end]);
}, []);
var enums_placements = /*#__PURE__*/[].concat(basePlacements, [auto]).reduce(function (acc, placement) {
  return acc.concat([placement, placement + "-" + start, placement + "-" + end]);
}, []); // modifiers that need to read the DOM

var beforeRead = 'beforeRead';
var read = 'read';
var afterRead = 'afterRead'; // pure-logic modifiers

var beforeMain = 'beforeMain';
var main = 'main';
var afterMain = 'afterMain'; // modifier with the purpose to write to the DOM (or write into a framework state)

var beforeWrite = 'beforeWrite';
var write = 'write';
var afterWrite = 'afterWrite';
var modifierPhases = [beforeRead, read, afterRead, beforeMain, main, afterMain, beforeWrite, write, afterWrite];
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/orderModifiers.js
 // source: https://stackoverflow.com/questions/49875255

function order(modifiers) {
  var map = new Map();
  var visited = new Set();
  var result = [];
  modifiers.forEach(function (modifier) {
    map.set(modifier.name, modifier);
  }); // On visiting object, check for its dependencies and visit them recursively

  function sort(modifier) {
    visited.add(modifier.name);
    var requires = [].concat(modifier.requires || [], modifier.requiresIfExists || []);
    requires.forEach(function (dep) {
      if (!visited.has(dep)) {
        var depModifier = map.get(dep);

        if (depModifier) {
          sort(depModifier);
        }
      }
    });
    result.push(modifier);
  }

  modifiers.forEach(function (modifier) {
    if (!visited.has(modifier.name)) {
      // check for visited object
      sort(modifier);
    }
  });
  return result;
}

function orderModifiers(modifiers) {
  // order based on dependencies
  var orderedModifiers = order(modifiers); // order based on phase

  return modifierPhases.reduce(function (acc, phase) {
    return acc.concat(orderedModifiers.filter(function (modifier) {
      return modifier.phase === phase;
    }));
  }, []);
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/debounce.js
function debounce(fn) {
  var pending;
  return function () {
    if (!pending) {
      pending = new Promise(function (resolve) {
        Promise.resolve().then(function () {
          pending = undefined;
          resolve(fn());
        });
      });
    }

    return pending;
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/mergeByName.js
function mergeByName(modifiers) {
  var merged = modifiers.reduce(function (merged, current) {
    var existing = merged[current.name];
    merged[current.name] = existing ? Object.assign({}, existing, current, {
      options: Object.assign({}, existing.options, current.options),
      data: Object.assign({}, existing.data, current.data)
    }) : current;
    return merged;
  }, {}); // IE11 does not support Object.values

  return Object.keys(merged).map(function (key) {
    return merged[key];
  });
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/createPopper.js














var INVALID_ELEMENT_ERROR = 'Popper: Invalid reference or popper argument provided. They must be either a DOM element or virtual element.';
var INFINITE_LOOP_ERROR = 'Popper: An infinite loop in the modifiers cycle has been detected! The cycle has been interrupted to prevent a browser crash.';
var DEFAULT_OPTIONS = {
  placement: 'bottom',
  modifiers: [],
  strategy: 'absolute'
};

function areValidElements() {
  for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
    args[_key] = arguments[_key];
  }

  return !args.some(function (element) {
    return !(element && typeof element.getBoundingClientRect === 'function');
  });
}

function popperGenerator(generatorOptions) {
  if (generatorOptions === void 0) {
    generatorOptions = {};
  }

  var _generatorOptions = generatorOptions,
      _generatorOptions$def = _generatorOptions.defaultModifiers,
      defaultModifiers = _generatorOptions$def === void 0 ? [] : _generatorOptions$def,
      _generatorOptions$def2 = _generatorOptions.defaultOptions,
      defaultOptions = _generatorOptions$def2 === void 0 ? DEFAULT_OPTIONS : _generatorOptions$def2;
  return function createPopper(reference, popper, options) {
    if (options === void 0) {
      options = defaultOptions;
    }

    var state = {
      placement: 'bottom',
      orderedModifiers: [],
      options: Object.assign({}, DEFAULT_OPTIONS, defaultOptions),
      modifiersData: {},
      elements: {
        reference: reference,
        popper: popper
      },
      attributes: {},
      styles: {}
    };
    var effectCleanupFns = [];
    var isDestroyed = false;
    var instance = {
      state: state,
      setOptions: function setOptions(setOptionsAction) {
        var options = typeof setOptionsAction === 'function' ? setOptionsAction(state.options) : setOptionsAction;
        cleanupModifierEffects();
        state.options = Object.assign({}, defaultOptions, state.options, options);
        state.scrollParents = {
          reference: isElement(reference) ? listScrollParents(reference) : reference.contextElement ? listScrollParents(reference.contextElement) : [],
          popper: listScrollParents(popper)
        }; // Orders the modifiers based on their dependencies and `phase`
        // properties

        var orderedModifiers = orderModifiers(mergeByName([].concat(defaultModifiers, state.options.modifiers))); // Strip out disabled modifiers

        state.orderedModifiers = orderedModifiers.filter(function (m) {
          return m.enabled;
        }); // Validate the provided modifiers so that the consumer will get warned
        // if one of the modifiers is invalid for any reason

        if (false) { var _getComputedStyle, marginTop, marginRight, marginBottom, marginLeft, flipModifier, modifiers; }

        runModifierEffects();
        return instance.update();
      },
      // Sync update – it will always be executed, even if not necessary. This
      // is useful for low frequency updates where sync behavior simplifies the
      // logic.
      // For high frequency updates (e.g. `resize` and `scroll` events), always
      // prefer the async Popper#update method
      forceUpdate: function forceUpdate() {
        if (isDestroyed) {
          return;
        }

        var _state$elements = state.elements,
            reference = _state$elements.reference,
            popper = _state$elements.popper; // Don't proceed if `reference` or `popper` are not valid elements
        // anymore

        if (!areValidElements(reference, popper)) {
          if (false) {}

          return;
        } // Store the reference and popper rects to be read by modifiers


        state.rects = {
          reference: getCompositeRect(reference, getOffsetParent(popper), state.options.strategy === 'fixed'),
          popper: getLayoutRect(popper)
        }; // Modifiers have the ability to reset the current update cycle. The
        // most common use case for this is the `flip` modifier changing the
        // placement, which then needs to re-run all the modifiers, because the
        // logic was previously ran for the previous placement and is therefore
        // stale/incorrect

        state.reset = false;
        state.placement = state.options.placement; // On each update cycle, the `modifiersData` property for each modifier
        // is filled with the initial data specified by the modifier. This means
        // it doesn't persist and is fresh on each update.
        // To ensure persistent data, use `${name}#persistent`

        state.orderedModifiers.forEach(function (modifier) {
          return state.modifiersData[modifier.name] = Object.assign({}, modifier.data);
        });
        var __debug_loops__ = 0;

        for (var index = 0; index < state.orderedModifiers.length; index++) {
          if (false) {}

          if (state.reset === true) {
            state.reset = false;
            index = -1;
            continue;
          }

          var _state$orderedModifie = state.orderedModifiers[index],
              fn = _state$orderedModifie.fn,
              _state$orderedModifie2 = _state$orderedModifie.options,
              _options = _state$orderedModifie2 === void 0 ? {} : _state$orderedModifie2,
              name = _state$orderedModifie.name;

          if (typeof fn === 'function') {
            state = fn({
              state: state,
              options: _options,
              name: name,
              instance: instance
            }) || state;
          }
        }
      },
      // Async and optimistically optimized update – it will not be executed if
      // not necessary (debounced to run at most once-per-tick)
      update: debounce(function () {
        return new Promise(function (resolve) {
          instance.forceUpdate();
          resolve(state);
        });
      }),
      destroy: function destroy() {
        cleanupModifierEffects();
        isDestroyed = true;
      }
    };

    if (!areValidElements(reference, popper)) {
      if (false) {}

      return instance;
    }

    instance.setOptions(options).then(function (state) {
      if (!isDestroyed && options.onFirstUpdate) {
        options.onFirstUpdate(state);
      }
    }); // Modifiers have the ability to execute arbitrary code before the first
    // update cycle runs. They will be executed in the same order as the update
    // cycle. This is useful when a modifier adds some persistent data that
    // other modifiers need to use, but the modifier is run after the dependent
    // one.

    function runModifierEffects() {
      state.orderedModifiers.forEach(function (_ref3) {
        var name = _ref3.name,
            _ref3$options = _ref3.options,
            options = _ref3$options === void 0 ? {} : _ref3$options,
            effect = _ref3.effect;

        if (typeof effect === 'function') {
          var cleanupFn = effect({
            state: state,
            name: name,
            instance: instance,
            options: options
          });

          var noopFn = function noopFn() {};

          effectCleanupFns.push(cleanupFn || noopFn);
        }
      });
    }

    function cleanupModifierEffects() {
      effectCleanupFns.forEach(function (fn) {
        return fn();
      });
      effectCleanupFns = [];
    }

    return instance;
  };
}
var createPopper = /*#__PURE__*/(/* unused pure expression or super */ null && (0)); // eslint-disable-next-line import/no-unused-modules


;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/eventListeners.js
 // eslint-disable-next-line import/no-unused-modules

var passive = {
  passive: true
};

function effect(_ref) {
  var state = _ref.state,
      instance = _ref.instance,
      options = _ref.options;
  var _options$scroll = options.scroll,
      scroll = _options$scroll === void 0 ? true : _options$scroll,
      _options$resize = options.resize,
      resize = _options$resize === void 0 ? true : _options$resize;
  var window = getWindow(state.elements.popper);
  var scrollParents = [].concat(state.scrollParents.reference, state.scrollParents.popper);

  if (scroll) {
    scrollParents.forEach(function (scrollParent) {
      scrollParent.addEventListener('scroll', instance.update, passive);
    });
  }

  if (resize) {
    window.addEventListener('resize', instance.update, passive);
  }

  return function () {
    if (scroll) {
      scrollParents.forEach(function (scrollParent) {
        scrollParent.removeEventListener('scroll', instance.update, passive);
      });
    }

    if (resize) {
      window.removeEventListener('resize', instance.update, passive);
    }
  };
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const eventListeners = ({
  name: 'eventListeners',
  enabled: true,
  phase: 'write',
  fn: function fn() {},
  effect: effect,
  data: {}
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/getBasePlacement.js

function getBasePlacement(placement) {
  return placement.split('-')[0];
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/getVariation.js
function getVariation(placement) {
  return placement.split('-')[1];
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js
function getMainAxisFromPlacement(placement) {
  return ['top', 'bottom'].indexOf(placement) >= 0 ? 'x' : 'y';
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/computeOffsets.js




function computeOffsets(_ref) {
  var reference = _ref.reference,
      element = _ref.element,
      placement = _ref.placement;
  var basePlacement = placement ? getBasePlacement(placement) : null;
  var variation = placement ? getVariation(placement) : null;
  var commonX = reference.x + reference.width / 2 - element.width / 2;
  var commonY = reference.y + reference.height / 2 - element.height / 2;
  var offsets;

  switch (basePlacement) {
    case enums_top:
      offsets = {
        x: commonX,
        y: reference.y - element.height
      };
      break;

    case bottom:
      offsets = {
        x: commonX,
        y: reference.y + reference.height
      };
      break;

    case right:
      offsets = {
        x: reference.x + reference.width,
        y: commonY
      };
      break;

    case left:
      offsets = {
        x: reference.x - element.width,
        y: commonY
      };
      break;

    default:
      offsets = {
        x: reference.x,
        y: reference.y
      };
  }

  var mainAxis = basePlacement ? getMainAxisFromPlacement(basePlacement) : null;

  if (mainAxis != null) {
    var len = mainAxis === 'y' ? 'height' : 'width';

    switch (variation) {
      case start:
        offsets[mainAxis] = offsets[mainAxis] - (reference[len] / 2 - element[len] / 2);
        break;

      case end:
        offsets[mainAxis] = offsets[mainAxis] + (reference[len] / 2 - element[len] / 2);
        break;

      default:
    }
  }

  return offsets;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/popperOffsets.js


function popperOffsets(_ref) {
  var state = _ref.state,
      name = _ref.name;
  // Offsets are the actual position the popper needs to have to be
  // properly positioned near its reference element
  // This is the most basic placement, and will be adjusted by
  // the modifiers in the next step
  state.modifiersData[name] = computeOffsets({
    reference: state.rects.reference,
    element: state.rects.popper,
    strategy: 'absolute',
    placement: state.placement
  });
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const modifiers_popperOffsets = ({
  name: 'popperOffsets',
  enabled: true,
  phase: 'read',
  fn: popperOffsets,
  data: {}
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/computeStyles.js







 // eslint-disable-next-line import/no-unused-modules

var unsetSides = {
  top: 'auto',
  right: 'auto',
  bottom: 'auto',
  left: 'auto'
}; // Round the offsets to the nearest suitable subpixel based on the DPR.
// Zooming can change the DPR, but it seems to report a value that will
// cleanly divide the values into the appropriate subpixels.

function roundOffsetsByDPR(_ref) {
  var x = _ref.x,
      y = _ref.y;
  var win = window;
  var dpr = win.devicePixelRatio || 1;
  return {
    x: round(x * dpr) / dpr || 0,
    y: round(y * dpr) / dpr || 0
  };
}

function mapToStyles(_ref2) {
  var _Object$assign2;

  var popper = _ref2.popper,
      popperRect = _ref2.popperRect,
      placement = _ref2.placement,
      variation = _ref2.variation,
      offsets = _ref2.offsets,
      position = _ref2.position,
      gpuAcceleration = _ref2.gpuAcceleration,
      adaptive = _ref2.adaptive,
      roundOffsets = _ref2.roundOffsets,
      isFixed = _ref2.isFixed;
  var _offsets$x = offsets.x,
      x = _offsets$x === void 0 ? 0 : _offsets$x,
      _offsets$y = offsets.y,
      y = _offsets$y === void 0 ? 0 : _offsets$y;

  var _ref3 = typeof roundOffsets === 'function' ? roundOffsets({
    x: x,
    y: y
  }) : {
    x: x,
    y: y
  };

  x = _ref3.x;
  y = _ref3.y;
  var hasX = offsets.hasOwnProperty('x');
  var hasY = offsets.hasOwnProperty('y');
  var sideX = left;
  var sideY = enums_top;
  var win = window;

  if (adaptive) {
    var offsetParent = getOffsetParent(popper);
    var heightProp = 'clientHeight';
    var widthProp = 'clientWidth';

    if (offsetParent === getWindow(popper)) {
      offsetParent = getDocumentElement(popper);

      if (getComputedStyle(offsetParent).position !== 'static' && position === 'absolute') {
        heightProp = 'scrollHeight';
        widthProp = 'scrollWidth';
      }
    } // $FlowFixMe[incompatible-cast]: force type refinement, we compare offsetParent with window above, but Flow doesn't detect it


    offsetParent = offsetParent;

    if (placement === enums_top || (placement === left || placement === right) && variation === end) {
      sideY = bottom;
      var offsetY = isFixed && win.visualViewport ? win.visualViewport.height : // $FlowFixMe[prop-missing]
      offsetParent[heightProp];
      y -= offsetY - popperRect.height;
      y *= gpuAcceleration ? 1 : -1;
    }

    if (placement === left || (placement === enums_top || placement === bottom) && variation === end) {
      sideX = right;
      var offsetX = isFixed && win.visualViewport ? win.visualViewport.width : // $FlowFixMe[prop-missing]
      offsetParent[widthProp];
      x -= offsetX - popperRect.width;
      x *= gpuAcceleration ? 1 : -1;
    }
  }

  var commonStyles = Object.assign({
    position: position
  }, adaptive && unsetSides);

  var _ref4 = roundOffsets === true ? roundOffsetsByDPR({
    x: x,
    y: y
  }) : {
    x: x,
    y: y
  };

  x = _ref4.x;
  y = _ref4.y;

  if (gpuAcceleration) {
    var _Object$assign;

    return Object.assign({}, commonStyles, (_Object$assign = {}, _Object$assign[sideY] = hasY ? '0' : '', _Object$assign[sideX] = hasX ? '0' : '', _Object$assign.transform = (win.devicePixelRatio || 1) <= 1 ? "translate(" + x + "px, " + y + "px)" : "translate3d(" + x + "px, " + y + "px, 0)", _Object$assign));
  }

  return Object.assign({}, commonStyles, (_Object$assign2 = {}, _Object$assign2[sideY] = hasY ? y + "px" : '', _Object$assign2[sideX] = hasX ? x + "px" : '', _Object$assign2.transform = '', _Object$assign2));
}

function computeStyles(_ref5) {
  var state = _ref5.state,
      options = _ref5.options;
  var _options$gpuAccelerat = options.gpuAcceleration,
      gpuAcceleration = _options$gpuAccelerat === void 0 ? true : _options$gpuAccelerat,
      _options$adaptive = options.adaptive,
      adaptive = _options$adaptive === void 0 ? true : _options$adaptive,
      _options$roundOffsets = options.roundOffsets,
      roundOffsets = _options$roundOffsets === void 0 ? true : _options$roundOffsets;

  if (false) { var transitionProperty; }

  var commonStyles = {
    placement: getBasePlacement(state.placement),
    variation: getVariation(state.placement),
    popper: state.elements.popper,
    popperRect: state.rects.popper,
    gpuAcceleration: gpuAcceleration,
    isFixed: state.options.strategy === 'fixed'
  };

  if (state.modifiersData.popperOffsets != null) {
    state.styles.popper = Object.assign({}, state.styles.popper, mapToStyles(Object.assign({}, commonStyles, {
      offsets: state.modifiersData.popperOffsets,
      position: state.options.strategy,
      adaptive: adaptive,
      roundOffsets: roundOffsets
    })));
  }

  if (state.modifiersData.arrow != null) {
    state.styles.arrow = Object.assign({}, state.styles.arrow, mapToStyles(Object.assign({}, commonStyles, {
      offsets: state.modifiersData.arrow,
      position: 'absolute',
      adaptive: false,
      roundOffsets: roundOffsets
    })));
  }

  state.attributes.popper = Object.assign({}, state.attributes.popper, {
    'data-popper-placement': state.placement
  });
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const modifiers_computeStyles = ({
  name: 'computeStyles',
  enabled: true,
  phase: 'beforeWrite',
  fn: computeStyles,
  data: {}
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/applyStyles.js

 // This modifier takes the styles prepared by the `computeStyles` modifier
// and applies them to the HTMLElements such as popper and arrow

function applyStyles(_ref) {
  var state = _ref.state;
  Object.keys(state.elements).forEach(function (name) {
    var style = state.styles[name] || {};
    var attributes = state.attributes[name] || {};
    var element = state.elements[name]; // arrow is optional + virtual elements

    if (!isHTMLElement(element) || !getNodeName(element)) {
      return;
    } // Flow doesn't support to extend this property, but it's the most
    // effective way to apply styles to an HTMLElement
    // $FlowFixMe[cannot-write]


    Object.assign(element.style, style);
    Object.keys(attributes).forEach(function (name) {
      var value = attributes[name];

      if (value === false) {
        element.removeAttribute(name);
      } else {
        element.setAttribute(name, value === true ? '' : value);
      }
    });
  });
}

function applyStyles_effect(_ref2) {
  var state = _ref2.state;
  var initialStyles = {
    popper: {
      position: state.options.strategy,
      left: '0',
      top: '0',
      margin: '0'
    },
    arrow: {
      position: 'absolute'
    },
    reference: {}
  };
  Object.assign(state.elements.popper.style, initialStyles.popper);
  state.styles = initialStyles;

  if (state.elements.arrow) {
    Object.assign(state.elements.arrow.style, initialStyles.arrow);
  }

  return function () {
    Object.keys(state.elements).forEach(function (name) {
      var element = state.elements[name];
      var attributes = state.attributes[name] || {};
      var styleProperties = Object.keys(state.styles.hasOwnProperty(name) ? state.styles[name] : initialStyles[name]); // Set all values to an empty string to unset them

      var style = styleProperties.reduce(function (style, property) {
        style[property] = '';
        return style;
      }, {}); // arrow is optional + virtual elements

      if (!isHTMLElement(element) || !getNodeName(element)) {
        return;
      }

      Object.assign(element.style, style);
      Object.keys(attributes).forEach(function (attribute) {
        element.removeAttribute(attribute);
      });
    });
  };
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const modifiers_applyStyles = ({
  name: 'applyStyles',
  enabled: true,
  phase: 'write',
  fn: applyStyles,
  effect: applyStyles_effect,
  requires: ['computeStyles']
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/offset.js

 // eslint-disable-next-line import/no-unused-modules

function distanceAndSkiddingToXY(placement, rects, offset) {
  var basePlacement = getBasePlacement(placement);
  var invertDistance = [left, enums_top].indexOf(basePlacement) >= 0 ? -1 : 1;

  var _ref = typeof offset === 'function' ? offset(Object.assign({}, rects, {
    placement: placement
  })) : offset,
      skidding = _ref[0],
      distance = _ref[1];

  skidding = skidding || 0;
  distance = (distance || 0) * invertDistance;
  return [left, right].indexOf(basePlacement) >= 0 ? {
    x: distance,
    y: skidding
  } : {
    x: skidding,
    y: distance
  };
}

function offset(_ref2) {
  var state = _ref2.state,
      options = _ref2.options,
      name = _ref2.name;
  var _options$offset = options.offset,
      offset = _options$offset === void 0 ? [0, 0] : _options$offset;
  var data = enums_placements.reduce(function (acc, placement) {
    acc[placement] = distanceAndSkiddingToXY(placement, state.rects, offset);
    return acc;
  }, {});
  var _data$state$placement = data[state.placement],
      x = _data$state$placement.x,
      y = _data$state$placement.y;

  if (state.modifiersData.popperOffsets != null) {
    state.modifiersData.popperOffsets.x += x;
    state.modifiersData.popperOffsets.y += y;
  }

  state.modifiersData[name] = data;
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const modifiers_offset = ({
  name: 'offset',
  enabled: true,
  phase: 'main',
  requires: ['popperOffsets'],
  fn: offset
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/getOppositePlacement.js
var hash = {
  left: 'right',
  right: 'left',
  bottom: 'top',
  top: 'bottom'
};
function getOppositePlacement(placement) {
  return placement.replace(/left|right|bottom|top/g, function (matched) {
    return hash[matched];
  });
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/getOppositeVariationPlacement.js
var getOppositeVariationPlacement_hash = {
  start: 'end',
  end: 'start'
};
function getOppositeVariationPlacement(placement) {
  return placement.replace(/start|end/g, function (matched) {
    return getOppositeVariationPlacement_hash[matched];
  });
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getViewportRect.js



function getViewportRect(element) {
  var win = getWindow(element);
  var html = getDocumentElement(element);
  var visualViewport = win.visualViewport;
  var width = html.clientWidth;
  var height = html.clientHeight;
  var x = 0;
  var y = 0; // NB: This isn't supported on iOS <= 12. If the keyboard is open, the popper
  // can be obscured underneath it.
  // Also, `html.clientHeight` adds the bottom bar height in Safari iOS, even
  // if it isn't open, so if this isn't available, the popper will be detected
  // to overflow the bottom of the screen too early.

  if (visualViewport) {
    width = visualViewport.width;
    height = visualViewport.height; // Uses Layout Viewport (like Chrome; Safari does not currently)
    // In Chrome, it returns a value very close to 0 (+/-) but contains rounding
    // errors due to floating point numbers, so we need to check precision.
    // Safari returns a number <= 0, usually < -1 when pinch-zoomed
    // Feature detection fails in mobile emulation mode in Chrome.
    // Math.abs(win.innerWidth / visualViewport.scale - visualViewport.width) <
    // 0.001
    // Fallback here: "Not Safari" userAgent

    if (!/^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
      x = visualViewport.offsetLeft;
      y = visualViewport.offsetTop;
    }
  }

  return {
    width: width,
    height: height,
    x: x + getWindowScrollBarX(element),
    y: y
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getDocumentRect.js




 // Gets the entire size of the scrollable document area, even extending outside
// of the `<html>` and `<body>` rect bounds if horizontally scrollable

function getDocumentRect(element) {
  var _element$ownerDocumen;

  var html = getDocumentElement(element);
  var winScroll = getWindowScroll(element);
  var body = (_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body;
  var width = math_max(html.scrollWidth, html.clientWidth, body ? body.scrollWidth : 0, body ? body.clientWidth : 0);
  var height = math_max(html.scrollHeight, html.clientHeight, body ? body.scrollHeight : 0, body ? body.clientHeight : 0);
  var x = -winScroll.scrollLeft + getWindowScrollBarX(element);
  var y = -winScroll.scrollTop;

  if (getComputedStyle(body || html).direction === 'rtl') {
    x += math_max(html.clientWidth, body ? body.clientWidth : 0) - width;
  }

  return {
    width: width,
    height: height,
    x: x,
    y: y
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/contains.js

function contains(parent, child) {
  var rootNode = child.getRootNode && child.getRootNode(); // First, attempt with faster native method

  if (parent.contains(child)) {
    return true;
  } // then fallback to custom implementation with Shadow DOM support
  else if (rootNode && isShadowRoot(rootNode)) {
      var next = child;

      do {
        if (next && parent.isSameNode(next)) {
          return true;
        } // $FlowFixMe[prop-missing]: need a better way to handle this...


        next = next.parentNode || next.host;
      } while (next);
    } // Give up, the result is false


  return false;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/rectToClientRect.js
function rectToClientRect(rect) {
  return Object.assign({}, rect, {
    left: rect.x,
    top: rect.y,
    right: rect.x + rect.width,
    bottom: rect.y + rect.height
  });
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/dom-utils/getClippingRect.js















function getInnerBoundingClientRect(element) {
  var rect = getBoundingClientRect(element);
  rect.top = rect.top + element.clientTop;
  rect.left = rect.left + element.clientLeft;
  rect.bottom = rect.top + element.clientHeight;
  rect.right = rect.left + element.clientWidth;
  rect.width = element.clientWidth;
  rect.height = element.clientHeight;
  rect.x = rect.left;
  rect.y = rect.top;
  return rect;
}

function getClientRectFromMixedType(element, clippingParent) {
  return clippingParent === viewport ? rectToClientRect(getViewportRect(element)) : isElement(clippingParent) ? getInnerBoundingClientRect(clippingParent) : rectToClientRect(getDocumentRect(getDocumentElement(element)));
} // A "clipping parent" is an overflowable container with the characteristic of
// clipping (or hiding) overflowing elements with a position different from
// `initial`


function getClippingParents(element) {
  var clippingParents = listScrollParents(getParentNode(element));
  var canEscapeClipping = ['absolute', 'fixed'].indexOf(getComputedStyle(element).position) >= 0;
  var clipperElement = canEscapeClipping && isHTMLElement(element) ? getOffsetParent(element) : element;

  if (!isElement(clipperElement)) {
    return [];
  } // $FlowFixMe[incompatible-return]: https://github.com/facebook/flow/issues/1414


  return clippingParents.filter(function (clippingParent) {
    return isElement(clippingParent) && contains(clippingParent, clipperElement) && getNodeName(clippingParent) !== 'body';
  });
} // Gets the maximum area that the element is visible in due to any number of
// clipping parents


function getClippingRect(element, boundary, rootBoundary) {
  var mainClippingParents = boundary === 'clippingParents' ? getClippingParents(element) : [].concat(boundary);
  var clippingParents = [].concat(mainClippingParents, [rootBoundary]);
  var firstClippingParent = clippingParents[0];
  var clippingRect = clippingParents.reduce(function (accRect, clippingParent) {
    var rect = getClientRectFromMixedType(element, clippingParent);
    accRect.top = math_max(rect.top, accRect.top);
    accRect.right = math_min(rect.right, accRect.right);
    accRect.bottom = math_min(rect.bottom, accRect.bottom);
    accRect.left = math_max(rect.left, accRect.left);
    return accRect;
  }, getClientRectFromMixedType(element, firstClippingParent));
  clippingRect.width = clippingRect.right - clippingRect.left;
  clippingRect.height = clippingRect.bottom - clippingRect.top;
  clippingRect.x = clippingRect.left;
  clippingRect.y = clippingRect.top;
  return clippingRect;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/getFreshSideObject.js
function getFreshSideObject() {
  return {
    top: 0,
    right: 0,
    bottom: 0,
    left: 0
  };
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/mergePaddingObject.js

function mergePaddingObject(paddingObject) {
  return Object.assign({}, getFreshSideObject(), paddingObject);
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/expandToHashMap.js
function expandToHashMap(value, keys) {
  return keys.reduce(function (hashMap, key) {
    hashMap[key] = value;
    return hashMap;
  }, {});
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/detectOverflow.js








 // eslint-disable-next-line import/no-unused-modules

function detectOverflow(state, options) {
  if (options === void 0) {
    options = {};
  }

  var _options = options,
      _options$placement = _options.placement,
      placement = _options$placement === void 0 ? state.placement : _options$placement,
      _options$boundary = _options.boundary,
      boundary = _options$boundary === void 0 ? clippingParents : _options$boundary,
      _options$rootBoundary = _options.rootBoundary,
      rootBoundary = _options$rootBoundary === void 0 ? viewport : _options$rootBoundary,
      _options$elementConte = _options.elementContext,
      elementContext = _options$elementConte === void 0 ? popper : _options$elementConte,
      _options$altBoundary = _options.altBoundary,
      altBoundary = _options$altBoundary === void 0 ? false : _options$altBoundary,
      _options$padding = _options.padding,
      padding = _options$padding === void 0 ? 0 : _options$padding;
  var paddingObject = mergePaddingObject(typeof padding !== 'number' ? padding : expandToHashMap(padding, basePlacements));
  var altContext = elementContext === popper ? reference : popper;
  var popperRect = state.rects.popper;
  var element = state.elements[altBoundary ? altContext : elementContext];
  var clippingClientRect = getClippingRect(isElement(element) ? element : element.contextElement || getDocumentElement(state.elements.popper), boundary, rootBoundary);
  var referenceClientRect = getBoundingClientRect(state.elements.reference);
  var popperOffsets = computeOffsets({
    reference: referenceClientRect,
    element: popperRect,
    strategy: 'absolute',
    placement: placement
  });
  var popperClientRect = rectToClientRect(Object.assign({}, popperRect, popperOffsets));
  var elementClientRect = elementContext === popper ? popperClientRect : referenceClientRect; // positive = overflowing the clipping rect
  // 0 or negative = within the clipping rect

  var overflowOffsets = {
    top: clippingClientRect.top - elementClientRect.top + paddingObject.top,
    bottom: elementClientRect.bottom - clippingClientRect.bottom + paddingObject.bottom,
    left: clippingClientRect.left - elementClientRect.left + paddingObject.left,
    right: elementClientRect.right - clippingClientRect.right + paddingObject.right
  };
  var offsetData = state.modifiersData.offset; // Offsets can be applied only to the popper element

  if (elementContext === popper && offsetData) {
    var offset = offsetData[placement];
    Object.keys(overflowOffsets).forEach(function (key) {
      var multiply = [right, bottom].indexOf(key) >= 0 ? 1 : -1;
      var axis = [enums_top, bottom].indexOf(key) >= 0 ? 'y' : 'x';
      overflowOffsets[key] += offset[axis] * multiply;
    });
  }

  return overflowOffsets;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/computeAutoPlacement.js




function computeAutoPlacement(state, options) {
  if (options === void 0) {
    options = {};
  }

  var _options = options,
      placement = _options.placement,
      boundary = _options.boundary,
      rootBoundary = _options.rootBoundary,
      padding = _options.padding,
      flipVariations = _options.flipVariations,
      _options$allowedAutoP = _options.allowedAutoPlacements,
      allowedAutoPlacements = _options$allowedAutoP === void 0 ? enums_placements : _options$allowedAutoP;
  var variation = getVariation(placement);
  var placements = variation ? flipVariations ? variationPlacements : variationPlacements.filter(function (placement) {
    return getVariation(placement) === variation;
  }) : basePlacements;
  var allowedPlacements = placements.filter(function (placement) {
    return allowedAutoPlacements.indexOf(placement) >= 0;
  });

  if (allowedPlacements.length === 0) {
    allowedPlacements = placements;

    if (false) {}
  } // $FlowFixMe[incompatible-type]: Flow seems to have problems with two array unions...


  var overflows = allowedPlacements.reduce(function (acc, placement) {
    acc[placement] = detectOverflow(state, {
      placement: placement,
      boundary: boundary,
      rootBoundary: rootBoundary,
      padding: padding
    })[getBasePlacement(placement)];
    return acc;
  }, {});
  return Object.keys(overflows).sort(function (a, b) {
    return overflows[a] - overflows[b];
  });
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/flip.js






 // eslint-disable-next-line import/no-unused-modules

function getExpandedFallbackPlacements(placement) {
  if (getBasePlacement(placement) === auto) {
    return [];
  }

  var oppositePlacement = getOppositePlacement(placement);
  return [getOppositeVariationPlacement(placement), oppositePlacement, getOppositeVariationPlacement(oppositePlacement)];
}

function flip(_ref) {
  var state = _ref.state,
      options = _ref.options,
      name = _ref.name;

  if (state.modifiersData[name]._skip) {
    return;
  }

  var _options$mainAxis = options.mainAxis,
      checkMainAxis = _options$mainAxis === void 0 ? true : _options$mainAxis,
      _options$altAxis = options.altAxis,
      checkAltAxis = _options$altAxis === void 0 ? true : _options$altAxis,
      specifiedFallbackPlacements = options.fallbackPlacements,
      padding = options.padding,
      boundary = options.boundary,
      rootBoundary = options.rootBoundary,
      altBoundary = options.altBoundary,
      _options$flipVariatio = options.flipVariations,
      flipVariations = _options$flipVariatio === void 0 ? true : _options$flipVariatio,
      allowedAutoPlacements = options.allowedAutoPlacements;
  var preferredPlacement = state.options.placement;
  var basePlacement = getBasePlacement(preferredPlacement);
  var isBasePlacement = basePlacement === preferredPlacement;
  var fallbackPlacements = specifiedFallbackPlacements || (isBasePlacement || !flipVariations ? [getOppositePlacement(preferredPlacement)] : getExpandedFallbackPlacements(preferredPlacement));
  var placements = [preferredPlacement].concat(fallbackPlacements).reduce(function (acc, placement) {
    return acc.concat(getBasePlacement(placement) === auto ? computeAutoPlacement(state, {
      placement: placement,
      boundary: boundary,
      rootBoundary: rootBoundary,
      padding: padding,
      flipVariations: flipVariations,
      allowedAutoPlacements: allowedAutoPlacements
    }) : placement);
  }, []);
  var referenceRect = state.rects.reference;
  var popperRect = state.rects.popper;
  var checksMap = new Map();
  var makeFallbackChecks = true;
  var firstFittingPlacement = placements[0];

  for (var i = 0; i < placements.length; i++) {
    var placement = placements[i];

    var _basePlacement = getBasePlacement(placement);

    var isStartVariation = getVariation(placement) === start;
    var isVertical = [enums_top, bottom].indexOf(_basePlacement) >= 0;
    var len = isVertical ? 'width' : 'height';
    var overflow = detectOverflow(state, {
      placement: placement,
      boundary: boundary,
      rootBoundary: rootBoundary,
      altBoundary: altBoundary,
      padding: padding
    });
    var mainVariationSide = isVertical ? isStartVariation ? right : left : isStartVariation ? bottom : enums_top;

    if (referenceRect[len] > popperRect[len]) {
      mainVariationSide = getOppositePlacement(mainVariationSide);
    }

    var altVariationSide = getOppositePlacement(mainVariationSide);
    var checks = [];

    if (checkMainAxis) {
      checks.push(overflow[_basePlacement] <= 0);
    }

    if (checkAltAxis) {
      checks.push(overflow[mainVariationSide] <= 0, overflow[altVariationSide] <= 0);
    }

    if (checks.every(function (check) {
      return check;
    })) {
      firstFittingPlacement = placement;
      makeFallbackChecks = false;
      break;
    }

    checksMap.set(placement, checks);
  }

  if (makeFallbackChecks) {
    // `2` may be desired in some cases – research later
    var numberOfChecks = flipVariations ? 3 : 1;

    var _loop = function _loop(_i) {
      var fittingPlacement = placements.find(function (placement) {
        var checks = checksMap.get(placement);

        if (checks) {
          return checks.slice(0, _i).every(function (check) {
            return check;
          });
        }
      });

      if (fittingPlacement) {
        firstFittingPlacement = fittingPlacement;
        return "break";
      }
    };

    for (var _i = numberOfChecks; _i > 0; _i--) {
      var _ret = _loop(_i);

      if (_ret === "break") break;
    }
  }

  if (state.placement !== firstFittingPlacement) {
    state.modifiersData[name]._skip = true;
    state.placement = firstFittingPlacement;
    state.reset = true;
  }
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const modifiers_flip = ({
  name: 'flip',
  enabled: true,
  phase: 'main',
  fn: flip,
  requiresIfExists: ['offset'],
  data: {
    _skip: false
  }
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/getAltAxis.js
function getAltAxis(axis) {
  return axis === 'x' ? 'y' : 'x';
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/utils/within.js

function within(min, value, max) {
  return math_max(min, math_min(value, max));
}
function withinMaxClamp(min, value, max) {
  var v = within(min, value, max);
  return v > max ? max : v;
}
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/preventOverflow.js












function preventOverflow(_ref) {
  var state = _ref.state,
      options = _ref.options,
      name = _ref.name;
  var _options$mainAxis = options.mainAxis,
      checkMainAxis = _options$mainAxis === void 0 ? true : _options$mainAxis,
      _options$altAxis = options.altAxis,
      checkAltAxis = _options$altAxis === void 0 ? false : _options$altAxis,
      boundary = options.boundary,
      rootBoundary = options.rootBoundary,
      altBoundary = options.altBoundary,
      padding = options.padding,
      _options$tether = options.tether,
      tether = _options$tether === void 0 ? true : _options$tether,
      _options$tetherOffset = options.tetherOffset,
      tetherOffset = _options$tetherOffset === void 0 ? 0 : _options$tetherOffset;
  var overflow = detectOverflow(state, {
    boundary: boundary,
    rootBoundary: rootBoundary,
    padding: padding,
    altBoundary: altBoundary
  });
  var basePlacement = getBasePlacement(state.placement);
  var variation = getVariation(state.placement);
  var isBasePlacement = !variation;
  var mainAxis = getMainAxisFromPlacement(basePlacement);
  var altAxis = getAltAxis(mainAxis);
  var popperOffsets = state.modifiersData.popperOffsets;
  var referenceRect = state.rects.reference;
  var popperRect = state.rects.popper;
  var tetherOffsetValue = typeof tetherOffset === 'function' ? tetherOffset(Object.assign({}, state.rects, {
    placement: state.placement
  })) : tetherOffset;
  var normalizedTetherOffsetValue = typeof tetherOffsetValue === 'number' ? {
    mainAxis: tetherOffsetValue,
    altAxis: tetherOffsetValue
  } : Object.assign({
    mainAxis: 0,
    altAxis: 0
  }, tetherOffsetValue);
  var offsetModifierState = state.modifiersData.offset ? state.modifiersData.offset[state.placement] : null;
  var data = {
    x: 0,
    y: 0
  };

  if (!popperOffsets) {
    return;
  }

  if (checkMainAxis) {
    var _offsetModifierState$;

    var mainSide = mainAxis === 'y' ? enums_top : left;
    var altSide = mainAxis === 'y' ? bottom : right;
    var len = mainAxis === 'y' ? 'height' : 'width';
    var offset = popperOffsets[mainAxis];
    var min = offset + overflow[mainSide];
    var max = offset - overflow[altSide];
    var additive = tether ? -popperRect[len] / 2 : 0;
    var minLen = variation === start ? referenceRect[len] : popperRect[len];
    var maxLen = variation === start ? -popperRect[len] : -referenceRect[len]; // We need to include the arrow in the calculation so the arrow doesn't go
    // outside the reference bounds

    var arrowElement = state.elements.arrow;
    var arrowRect = tether && arrowElement ? getLayoutRect(arrowElement) : {
      width: 0,
      height: 0
    };
    var arrowPaddingObject = state.modifiersData['arrow#persistent'] ? state.modifiersData['arrow#persistent'].padding : getFreshSideObject();
    var arrowPaddingMin = arrowPaddingObject[mainSide];
    var arrowPaddingMax = arrowPaddingObject[altSide]; // If the reference length is smaller than the arrow length, we don't want
    // to include its full size in the calculation. If the reference is small
    // and near the edge of a boundary, the popper can overflow even if the
    // reference is not overflowing as well (e.g. virtual elements with no
    // width or height)

    var arrowLen = within(0, referenceRect[len], arrowRect[len]);
    var minOffset = isBasePlacement ? referenceRect[len] / 2 - additive - arrowLen - arrowPaddingMin - normalizedTetherOffsetValue.mainAxis : minLen - arrowLen - arrowPaddingMin - normalizedTetherOffsetValue.mainAxis;
    var maxOffset = isBasePlacement ? -referenceRect[len] / 2 + additive + arrowLen + arrowPaddingMax + normalizedTetherOffsetValue.mainAxis : maxLen + arrowLen + arrowPaddingMax + normalizedTetherOffsetValue.mainAxis;
    var arrowOffsetParent = state.elements.arrow && getOffsetParent(state.elements.arrow);
    var clientOffset = arrowOffsetParent ? mainAxis === 'y' ? arrowOffsetParent.clientTop || 0 : arrowOffsetParent.clientLeft || 0 : 0;
    var offsetModifierValue = (_offsetModifierState$ = offsetModifierState == null ? void 0 : offsetModifierState[mainAxis]) != null ? _offsetModifierState$ : 0;
    var tetherMin = offset + minOffset - offsetModifierValue - clientOffset;
    var tetherMax = offset + maxOffset - offsetModifierValue;
    var preventedOffset = within(tether ? math_min(min, tetherMin) : min, offset, tether ? math_max(max, tetherMax) : max);
    popperOffsets[mainAxis] = preventedOffset;
    data[mainAxis] = preventedOffset - offset;
  }

  if (checkAltAxis) {
    var _offsetModifierState$2;

    var _mainSide = mainAxis === 'x' ? enums_top : left;

    var _altSide = mainAxis === 'x' ? bottom : right;

    var _offset = popperOffsets[altAxis];

    var _len = altAxis === 'y' ? 'height' : 'width';

    var _min = _offset + overflow[_mainSide];

    var _max = _offset - overflow[_altSide];

    var isOriginSide = [enums_top, left].indexOf(basePlacement) !== -1;

    var _offsetModifierValue = (_offsetModifierState$2 = offsetModifierState == null ? void 0 : offsetModifierState[altAxis]) != null ? _offsetModifierState$2 : 0;

    var _tetherMin = isOriginSide ? _min : _offset - referenceRect[_len] - popperRect[_len] - _offsetModifierValue + normalizedTetherOffsetValue.altAxis;

    var _tetherMax = isOriginSide ? _offset + referenceRect[_len] + popperRect[_len] - _offsetModifierValue - normalizedTetherOffsetValue.altAxis : _max;

    var _preventedOffset = tether && isOriginSide ? withinMaxClamp(_tetherMin, _offset, _tetherMax) : within(tether ? _tetherMin : _min, _offset, tether ? _tetherMax : _max);

    popperOffsets[altAxis] = _preventedOffset;
    data[altAxis] = _preventedOffset - _offset;
  }

  state.modifiersData[name] = data;
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const modifiers_preventOverflow = ({
  name: 'preventOverflow',
  enabled: true,
  phase: 'main',
  fn: preventOverflow,
  requiresIfExists: ['offset']
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/arrow.js









 // eslint-disable-next-line import/no-unused-modules

var toPaddingObject = function toPaddingObject(padding, state) {
  padding = typeof padding === 'function' ? padding(Object.assign({}, state.rects, {
    placement: state.placement
  })) : padding;
  return mergePaddingObject(typeof padding !== 'number' ? padding : expandToHashMap(padding, basePlacements));
};

function arrow(_ref) {
  var _state$modifiersData$;

  var state = _ref.state,
      name = _ref.name,
      options = _ref.options;
  var arrowElement = state.elements.arrow;
  var popperOffsets = state.modifiersData.popperOffsets;
  var basePlacement = getBasePlacement(state.placement);
  var axis = getMainAxisFromPlacement(basePlacement);
  var isVertical = [left, right].indexOf(basePlacement) >= 0;
  var len = isVertical ? 'height' : 'width';

  if (!arrowElement || !popperOffsets) {
    return;
  }

  var paddingObject = toPaddingObject(options.padding, state);
  var arrowRect = getLayoutRect(arrowElement);
  var minProp = axis === 'y' ? enums_top : left;
  var maxProp = axis === 'y' ? bottom : right;
  var endDiff = state.rects.reference[len] + state.rects.reference[axis] - popperOffsets[axis] - state.rects.popper[len];
  var startDiff = popperOffsets[axis] - state.rects.reference[axis];
  var arrowOffsetParent = getOffsetParent(arrowElement);
  var clientSize = arrowOffsetParent ? axis === 'y' ? arrowOffsetParent.clientHeight || 0 : arrowOffsetParent.clientWidth || 0 : 0;
  var centerToReference = endDiff / 2 - startDiff / 2; // Make sure the arrow doesn't overflow the popper if the center point is
  // outside of the popper bounds

  var min = paddingObject[minProp];
  var max = clientSize - arrowRect[len] - paddingObject[maxProp];
  var center = clientSize / 2 - arrowRect[len] / 2 + centerToReference;
  var offset = within(min, center, max); // Prevents breaking syntax highlighting...

  var axisProp = axis;
  state.modifiersData[name] = (_state$modifiersData$ = {}, _state$modifiersData$[axisProp] = offset, _state$modifiersData$.centerOffset = offset - center, _state$modifiersData$);
}

function arrow_effect(_ref2) {
  var state = _ref2.state,
      options = _ref2.options;
  var _options$element = options.element,
      arrowElement = _options$element === void 0 ? '[data-popper-arrow]' : _options$element;

  if (arrowElement == null) {
    return;
  } // CSS selector


  if (typeof arrowElement === 'string') {
    arrowElement = state.elements.popper.querySelector(arrowElement);

    if (!arrowElement) {
      return;
    }
  }

  if (false) {}

  if (!contains(state.elements.popper, arrowElement)) {
    if (false) {}

    return;
  }

  state.elements.arrow = arrowElement;
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const modifiers_arrow = ({
  name: 'arrow',
  enabled: true,
  phase: 'main',
  fn: arrow,
  effect: arrow_effect,
  requires: ['popperOffsets'],
  requiresIfExists: ['preventOverflow']
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/modifiers/hide.js



function getSideOffsets(overflow, rect, preventedOffsets) {
  if (preventedOffsets === void 0) {
    preventedOffsets = {
      x: 0,
      y: 0
    };
  }

  return {
    top: overflow.top - rect.height - preventedOffsets.y,
    right: overflow.right - rect.width + preventedOffsets.x,
    bottom: overflow.bottom - rect.height + preventedOffsets.y,
    left: overflow.left - rect.width - preventedOffsets.x
  };
}

function isAnySideFullyClipped(overflow) {
  return [enums_top, right, bottom, left].some(function (side) {
    return overflow[side] >= 0;
  });
}

function hide(_ref) {
  var state = _ref.state,
      name = _ref.name;
  var referenceRect = state.rects.reference;
  var popperRect = state.rects.popper;
  var preventedOffsets = state.modifiersData.preventOverflow;
  var referenceOverflow = detectOverflow(state, {
    elementContext: 'reference'
  });
  var popperAltOverflow = detectOverflow(state, {
    altBoundary: true
  });
  var referenceClippingOffsets = getSideOffsets(referenceOverflow, referenceRect);
  var popperEscapeOffsets = getSideOffsets(popperAltOverflow, popperRect, preventedOffsets);
  var isReferenceHidden = isAnySideFullyClipped(referenceClippingOffsets);
  var hasPopperEscaped = isAnySideFullyClipped(popperEscapeOffsets);
  state.modifiersData[name] = {
    referenceClippingOffsets: referenceClippingOffsets,
    popperEscapeOffsets: popperEscapeOffsets,
    isReferenceHidden: isReferenceHidden,
    hasPopperEscaped: hasPopperEscaped
  };
  state.attributes.popper = Object.assign({}, state.attributes.popper, {
    'data-popper-reference-hidden': isReferenceHidden,
    'data-popper-escaped': hasPopperEscaped
  });
} // eslint-disable-next-line import/no-unused-modules


/* harmony default export */ const modifiers_hide = ({
  name: 'hide',
  enabled: true,
  phase: 'main',
  requiresIfExists: ['preventOverflow'],
  fn: hide
});
;// CONCATENATED MODULE: ./node_modules/@popperjs/core/lib/popper.js










var defaultModifiers = [eventListeners, modifiers_popperOffsets, modifiers_computeStyles, modifiers_applyStyles, modifiers_offset, modifiers_flip, modifiers_preventOverflow, modifiers_arrow, modifiers_hide];
var popper_createPopper = /*#__PURE__*/popperGenerator({
  defaultModifiers: defaultModifiers
}); // eslint-disable-next-line import/no-unused-modules

 // eslint-disable-next-line import/no-unused-modules

 // eslint-disable-next-line import/no-unused-modules


;// CONCATENATED MODULE: ./src/components/dropdown.js
function dropdown_toConsumableArray(arr) { return dropdown_arrayWithoutHoles(arr) || dropdown_iterableToArray(arr) || dropdown_unsupportedIterableToArray(arr) || dropdown_nonIterableSpread(); }

function dropdown_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function dropdown_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return dropdown_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return dropdown_arrayLikeToArray(o, minLen); }

function dropdown_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function dropdown_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return dropdown_arrayLikeToArray(arr); }

function dropdown_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function dropdown_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function dropdown_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? dropdown_ownKeys(Object(source), !0).forEach(function (key) { dropdown_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : dropdown_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function dropdown_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function dropdown_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function dropdown_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function dropdown_createClass(Constructor, protoProps, staticProps) { if (protoProps) dropdown_defineProperties(Constructor.prototype, protoProps); if (staticProps) dropdown_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }


var dropdown_Default = {
  placement: 'bottom',
  triggerType: 'click',
  onShow: function onShow() {},
  onHide: function onHide() {}
};

var Dropdown = /*#__PURE__*/function () {
  function Dropdown() {
    var targetElement = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var triggerElement = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

    dropdown_classCallCheck(this, Dropdown);

    this._targetEl = targetElement;
    this._triggerEl = triggerElement;
    this._options = dropdown_objectSpread(dropdown_objectSpread({}, dropdown_Default), options);
    this._popperInstance = this._createPopperInstace();
    this._visible = false;

    this._init();
  }

  dropdown_createClass(Dropdown, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      if (this._triggerEl) {
        this._triggerEl.addEventListener('click', function () {
          _this.toggle();
        });
      }
    }
  }, {
    key: "_createPopperInstace",
    value: function _createPopperInstace() {
      return popper_createPopper(this._triggerEl, this._targetEl, {
        placement: this._options.placement,
        modifiers: [{
          name: 'offset',
          options: {
            offset: [0, 10]
          }
        }]
      });
    }
  }, {
    key: "_handleClickOutside",
    value: function _handleClickOutside(ev, targetEl) {
      var clickedEl = ev.target;

      if (clickedEl !== targetEl && !targetEl.contains(clickedEl) && !this._triggerEl.contains(clickedEl) && this._visible) {
        this.hide();
      }

      document.body.removeEventListener('click', this._handleClickOutside, true);
    }
  }, {
    key: "toggle",
    value: function toggle() {
      if (this._visible) {
        this.hide();
        document.body.removeEventListener('click', this._handleClickOutside, true);
      } else {
        this.show();
      }
    }
  }, {
    key: "show",
    value: function show() {
      var _this2 = this;

      this._targetEl.classList.remove('hidden');

      this._targetEl.classList.add('block'); // Enable the event listeners


      this._popperInstance.setOptions(function (options) {
        return dropdown_objectSpread(dropdown_objectSpread({}, options), {}, {
          modifiers: [].concat(dropdown_toConsumableArray(options.modifiers), [{
            name: 'eventListeners',
            enabled: true
          }])
        });
      });

      document.body.addEventListener('click', function (ev) {
        _this2._handleClickOutside(ev, _this2._targetEl);
      }, true); // Update its position

      this._popperInstance.update();

      this._visible = true; // callback function

      this._options.onShow(this);
    }
  }, {
    key: "hide",
    value: function hide() {
      this._targetEl.classList.remove('block');

      this._targetEl.classList.add('hidden'); // Disable the event listeners


      this._popperInstance.setOptions(function (options) {
        return dropdown_objectSpread(dropdown_objectSpread({}, options), {}, {
          modifiers: [].concat(dropdown_toConsumableArray(options.modifiers), [{
            name: 'eventListeners',
            enabled: false
          }])
        });
      });

      this._visible = false; // callback function

      this._options.onHide(this);
    }
  }]);

  return Dropdown;
}();

window.Dropdown = Dropdown;

function initDropdown() {
  document.querySelectorAll('[data-dropdown-toggle]').forEach(function (triggerEl) {
    var targetEl = document.getElementById(triggerEl.getAttribute('data-dropdown-toggle'));
    var placement = triggerEl.getAttribute('data-dropdown-placement');
    new Dropdown(targetEl, triggerEl, {
      placement: placement ? placement : dropdown_Default.placement
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initDropdown();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initDropdown);
}

/* harmony default export */ const dropdown = (Dropdown);
;// CONCATENATED MODULE: ./src/components/modal.js
function modal_toConsumableArray(arr) { return modal_arrayWithoutHoles(arr) || modal_iterableToArray(arr) || modal_unsupportedIterableToArray(arr) || modal_nonIterableSpread(); }

function modal_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function modal_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return modal_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return modal_arrayLikeToArray(o, minLen); }

function modal_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function modal_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return modal_arrayLikeToArray(arr); }

function modal_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function modal_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function modal_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? modal_ownKeys(Object(source), !0).forEach(function (key) { modal_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : modal_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function modal_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function modal_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function modal_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function modal_createClass(Constructor, protoProps, staticProps) { if (protoProps) modal_defineProperties(Constructor.prototype, protoProps); if (staticProps) modal_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var modal_Default = {
  placement: 'center',
  backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
  onHide: function onHide() {},
  onShow: function onShow() {},
  onToggle: function onToggle() {}
};

var Modal = /*#__PURE__*/function () {
  function Modal() {
    var targetEl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    modal_classCallCheck(this, Modal);

    this._targetEl = targetEl;
    this._options = modal_objectSpread(modal_objectSpread({}, modal_Default), options);
    this._isHidden = true;

    this._init();
  }

  modal_createClass(Modal, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      this._getPlacementClasses().map(function (c) {
        _this._targetEl.classList.add(c);
      });
    }
  }, {
    key: "_createBackdrop",
    value: function _createBackdrop() {
      if (this._isHidden) {
        var _backdropEl$classList;

        var backdropEl = document.createElement('div');
        backdropEl.setAttribute('modal-backdrop', '');

        (_backdropEl$classList = backdropEl.classList).add.apply(_backdropEl$classList, modal_toConsumableArray(this._options.backdropClasses.split(" ")));

        document.querySelector('body').append(backdropEl);
      }
    }
  }, {
    key: "_destroyBackdropEl",
    value: function _destroyBackdropEl() {
      if (!this._isHidden) {
        document.querySelector('[modal-backdrop]').remove();
      }
    }
  }, {
    key: "_getPlacementClasses",
    value: function _getPlacementClasses() {
      switch (this._options.placement) {
        // top
        case 'top-left':
          return ['justify-start', 'items-start'];

        case 'top-center':
          return ['justify-center', 'items-start'];

        case 'top-right':
          return ['justify-end', 'items-start'];
        // center

        case 'center-left':
          return ['justify-start', 'items-center'];

        case 'center':
          return ['justify-center', 'items-center'];

        case 'center-right':
          return ['justify-end', 'items-center'];
        // bottom

        case 'bottom-left':
          return ['justify-start', 'items-end'];

        case 'bottom-center':
          return ['justify-center', 'items-end'];

        case 'bottom-right':
          return ['justify-end', 'items-end'];

        default:
          return ['justify-center', 'items-center'];
      }
    }
  }, {
    key: "toggle",
    value: function toggle() {
      if (this._isHidden) {
        this.show();
      } else {
        this.hide();
      } // callback function


      this._options.onToggle(this);
    }
  }, {
    key: "show",
    value: function show() {
      this._targetEl.classList.add('flex');

      this._targetEl.classList.remove('hidden');

      this._targetEl.setAttribute('aria-modal', 'true');

      this._targetEl.setAttribute('role', 'dialog');

      this._targetEl.removeAttribute('aria-hidden');

      this._createBackdrop();

      this._isHidden = false; // callback function

      this._options.onShow(this);
    }
  }, {
    key: "hide",
    value: function hide() {
      this._targetEl.classList.add('hidden');

      this._targetEl.classList.remove('flex');

      this._targetEl.setAttribute('aria-hidden', 'true');

      this._targetEl.removeAttribute('aria-modal');

      this._targetEl.removeAttribute('role');

      this._destroyBackdropEl();

      this._isHidden = true; // callback function

      this._options.onHide(this);
    }
  }]);

  return Modal;
}();

window.Modal = Modal;

var getModalInstance = function getModalInstance(id, instances) {
  if (instances.some(function (modalInstance) {
    return modalInstance.id === id;
  })) {
    return instances.find(function (modalInstance) {
      return modalInstance.id === id;
    });
  }

  return false;
};

function initModal() {
  var modalInstances = [];
  document.querySelectorAll('[data-modal-toggle]').forEach(function (el) {
    var modalId = el.getAttribute('data-modal-toggle');
    var modalEl = document.getElementById(modalId);
    var placement = modalEl.getAttribute('data-modal-placement');

    if (modalEl) {
      if (!modalEl.hasAttribute('aria-hidden') && !modalEl.hasAttribute('aria-modal')) {
        modalEl.setAttribute('aria-hidden', 'true');
      }
    }

    var modal = null;

    if (getModalInstance(modalId, modalInstances)) {
      modal = getModalInstance(modalId, modalInstances);
      modal = modal.object;
    } else {
      modal = new Modal(modalEl, {
        placement: placement ? placement : modal_Default.placement
      });
      modalInstances.push({
        id: modalId,
        object: modal
      });
    }

    if (modalEl.hasAttribute('data-modal-show') && modalEl.getAttribute('data-modal-show') === 'true') {
      modal.show();
    }

    el.addEventListener('click', function () {
      modal.toggle();
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initModal();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initModal);
}

/* harmony default export */ const modal = (Modal);
;// CONCATENATED MODULE: ./src/components/drawer.js
function drawer_toConsumableArray(arr) { return drawer_arrayWithoutHoles(arr) || drawer_iterableToArray(arr) || drawer_unsupportedIterableToArray(arr) || drawer_nonIterableSpread(); }

function drawer_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function drawer_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return drawer_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return drawer_arrayLikeToArray(o, minLen); }

function drawer_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function drawer_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return drawer_arrayLikeToArray(arr); }

function drawer_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function drawer_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function drawer_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? drawer_ownKeys(Object(source), !0).forEach(function (key) { drawer_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : drawer_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function drawer_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function drawer_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function drawer_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function drawer_createClass(Constructor, protoProps, staticProps) { if (protoProps) drawer_defineProperties(Constructor.prototype, protoProps); if (staticProps) drawer_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var drawer_Default = {
  placement: 'left',
  bodyScrolling: false,
  backdrop: true,
  edge: false,
  edgeOffset: 'bottom-[60px]',
  backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-30',
  onShow: function onShow() {},
  onHide: function onHide() {},
  onToggle: function onToggle() {}
};

var Drawer = /*#__PURE__*/function () {
  function Drawer() {
    var targetEl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var options = arguments.length > 1 ? arguments[1] : undefined;

    drawer_classCallCheck(this, Drawer);

    this._targetEl = targetEl;
    this._options = drawer_objectSpread(drawer_objectSpread({}, drawer_Default), options);
    this._visible = false;

    this._init();
  }

  drawer_createClass(Drawer, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      // set initial accessibility attributes
      if (this._targetEl) {
        this._targetEl.setAttribute('aria-hidden', 'true');

        this._targetEl.classList.add('transition-transform');
      } // set base placement classes


      this._getPlacementClasses(this._options.placement).base.map(function (c) {
        _this._targetEl.classList.add(c);
      }); // hide by default


      this.hide();
    }
  }, {
    key: "isVisible",
    value: function isVisible() {
      return this._visible;
    }
  }, {
    key: "hide",
    value: function hide() {
      var _this2 = this;

      // based on the edge option show placement classes
      if (this._options.edge) {
        this._getPlacementClasses(this._options.placement + '-edge').active.map(function (c) {
          _this2._targetEl.classList.remove(c);
        });

        this._getPlacementClasses(this._options.placement + '-edge').inactive.map(function (c) {
          _this2._targetEl.classList.add(c);
        });
      } else {
        this._getPlacementClasses(this._options.placement).active.map(function (c) {
          _this2._targetEl.classList.remove(c);
        });

        this._getPlacementClasses(this._options.placement).inactive.map(function (c) {
          _this2._targetEl.classList.add(c);
        });
      } // set accessibility attributes


      this._targetEl.setAttribute('aria-hidden', 'true');

      this._targetEl.removeAttribute('aria-modal');

      this._targetEl.removeAttribute('role'); // enable body scroll


      if (!this._options.bodyScrolling) {
        document.body.classList.remove('overflow-hidden');
      } // destroy backdrop


      if (this._options.backdrop) {
        this._destroyBackdropEl();
      }

      this._visible = false; // callback function

      this._options.onHide(this);
    }
  }, {
    key: "show",
    value: function show() {
      var _this3 = this;

      if (this._options.edge) {
        this._getPlacementClasses(this._options.placement + '-edge').active.map(function (c) {
          _this3._targetEl.classList.add(c);
        });

        this._getPlacementClasses(this._options.placement + '-edge').inactive.map(function (c) {
          _this3._targetEl.classList.remove(c);
        });
      } else {
        this._getPlacementClasses(this._options.placement).active.map(function (c) {
          _this3._targetEl.classList.add(c);
        });

        this._getPlacementClasses(this._options.placement).inactive.map(function (c) {
          _this3._targetEl.classList.remove(c);
        });
      } // set accessibility attributes


      this._targetEl.setAttribute('aria-modal', 'true');

      this._targetEl.setAttribute('role', 'dialog');

      this._targetEl.removeAttribute('aria-hidden'); // disable body scroll


      if (!this._options.bodyScrolling) {
        document.body.classList.add('overflow-hidden');
      } // show backdrop


      if (this._options.backdrop) {
        this._createBackdrop();
      }

      this._visible = true; // callback function

      this._options.onShow(this);
    }
  }, {
    key: "toggle",
    value: function toggle() {
      if (this.isVisible()) {
        this.hide();
      } else {
        this.show();
      }
    }
  }, {
    key: "_createBackdrop",
    value: function _createBackdrop() {
      var _this4 = this;

      if (!this._visible) {
        var _backdropEl$classList;

        var backdropEl = document.createElement('div');
        backdropEl.setAttribute('drawer-backdrop', '');

        (_backdropEl$classList = backdropEl.classList).add.apply(_backdropEl$classList, drawer_toConsumableArray(this._options.backdropClasses.split(" ")));

        document.querySelector('body').append(backdropEl);
        backdropEl.addEventListener('click', function () {
          _this4.hide();
        });
      }
    }
  }, {
    key: "_destroyBackdropEl",
    value: function _destroyBackdropEl() {
      if (this._visible) {
        document.querySelector('[drawer-backdrop]').remove();
      }
    }
  }, {
    key: "_getPlacementClasses",
    value: function _getPlacementClasses(placement) {
      switch (placement) {
        case 'top':
          return {
            base: ['top-0', 'left-0', 'right-0'],
            active: ['transform-none'],
            inactive: ['-translate-y-full']
          };

        case 'right':
          return {
            base: ['right-0', 'top-0'],
            active: ['transform-none'],
            inactive: ['translate-x-full']
          };

        case 'bottom':
          return {
            base: ['bottom-0', 'left-0', 'right-0'],
            active: ['transform-none'],
            inactive: ['translate-y-full']
          };

        case 'left':
          return {
            base: ['left-0', 'top-0'],
            active: ['transform-none'],
            inactive: ['-translate-x-full']
          };

        case 'bottom-edge':
          return {
            base: ['left-0', 'top-0'],
            active: ['transform-none'],
            inactive: ['translate-y-full', this._options.edgeOffset]
          };

        default:
          return {
            base: ['left-0', 'top-0'],
            active: ['transform-none'],
            inactive: ['-translate-x-full']
          };
      }
    }
  }]);

  return Drawer;
}();

window.Drawer = Drawer;

var getDrawerInstance = function getDrawerInstance(id, instances) {
  if (instances.some(function (drawerInstance) {
    return drawerInstance.id === id;
  })) {
    return instances.find(function (drawerInstance) {
      return drawerInstance.id === id;
    });
  }

  return false;
};

function initDrawer() {
  var drawerInstances = [];
  document.querySelectorAll('[data-drawer-target]').forEach(function (triggerEl) {
    // mandatory
    var targetEl = document.getElementById(triggerEl.getAttribute('data-drawer-target'));
    var drawerId = targetEl.id; // optional

    var placement = triggerEl.getAttribute('data-drawer-placement');
    var bodyScrolling = triggerEl.getAttribute('data-drawer-body-scrolling');
    var backdrop = triggerEl.getAttribute('data-drawer-backdrop');
    var edge = triggerEl.getAttribute('data-drawer-edge');
    var edgeOffset = triggerEl.getAttribute('data-drawer-edge-offset');
    var drawer = null;

    if (getDrawerInstance(drawerId, drawerInstances)) {
      drawer = getDrawerInstance(drawerId, drawerInstances);
      drawer = drawer.object;
    } else {
      drawer = new Drawer(targetEl, {
        placement: placement ? placement : drawer_Default.placement,
        bodyScrolling: bodyScrolling ? bodyScrolling === 'true' ? true : false : drawer_Default.bodyScrolling,
        backdrop: backdrop ? backdrop === 'true' ? true : false : drawer_Default.backdrop,
        edge: edge ? edge === 'true' ? true : false : drawer_Default.edge,
        edgeOffset: edgeOffset ? edgeOffset : drawer_Default.edgeOffset
      });
      drawerInstances.push({
        id: drawerId,
        object: drawer
      });
    }
  });
  document.querySelectorAll('[data-drawer-toggle]').forEach(function (triggerEl) {
    var targetEl = document.getElementById(triggerEl.getAttribute('data-drawer-toggle'));
    var drawerId = targetEl.id;
    var drawer = getDrawerInstance(drawerId, drawerInstances);
    triggerEl.addEventListener('click', function () {
      if (drawer.object.isVisible()) {
        drawer.object.hide();
      } else {
        drawer.object.show();
      }
    });
  });
  document.querySelectorAll('[data-drawer-dismiss]').forEach(function (triggerEl) {
    var targetEl = document.getElementById(triggerEl.getAttribute('data-drawer-dismiss'));
    var drawerId = targetEl.id;
    var drawer = getDrawerInstance(drawerId, drawerInstances);
    triggerEl.addEventListener('click', function () {
      drawer.object.hide();
    });
  });
  document.querySelectorAll('[data-drawer-show]').forEach(function (triggerEl) {
    var targetEl = document.getElementById(triggerEl.getAttribute('data-drawer-show'));
    var drawerId = targetEl.id;
    var drawer = getDrawerInstance(drawerId, drawerInstances);
    triggerEl.addEventListener('click', function () {
      drawer.object.show();
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initDrawer();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initDrawer);
}

/* harmony default export */ const drawer = (Drawer);
;// CONCATENATED MODULE: ./src/components/tabs.js
function tabs_toConsumableArray(arr) { return tabs_arrayWithoutHoles(arr) || tabs_iterableToArray(arr) || tabs_unsupportedIterableToArray(arr) || tabs_nonIterableSpread(); }

function tabs_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function tabs_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return tabs_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return tabs_arrayLikeToArray(o, minLen); }

function tabs_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function tabs_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return tabs_arrayLikeToArray(arr); }

function tabs_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function tabs_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function tabs_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? tabs_ownKeys(Object(source), !0).forEach(function (key) { tabs_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : tabs_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function tabs_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function tabs_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function tabs_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function tabs_createClass(Constructor, protoProps, staticProps) { if (protoProps) tabs_defineProperties(Constructor.prototype, protoProps); if (staticProps) tabs_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var tabs_Default = {
  defaultTabId: null,
  activeClasses: 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500',
  inactiveClasses: 'dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
  onShow: function onShow() {}
};

var Tabs = /*#__PURE__*/function () {
  function Tabs() {
    var items = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    tabs_classCallCheck(this, Tabs);

    this._items = items;
    this._activeTab = options ? this.getTab(options.defaultTabId) : null;
    this._options = tabs_objectSpread(tabs_objectSpread({}, tabs_Default), options);

    this._init();
  }

  tabs_createClass(Tabs, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      if (this._items.length) {
        // set the first tab as active if not set by explicitly
        if (!this._activeTab) {
          this._setActiveTab(this._items[0]);
        } // force show the first default tab


        this.show(this._activeTab.id, true); // show tab content based on click

        this._items.map(function (tab) {
          tab.triggerEl.addEventListener('click', function () {
            _this.show(tab.id);
          });
        });
      }
    }
  }, {
    key: "getActiveTab",
    value: function getActiveTab() {
      return this._activeTab;
    }
  }, {
    key: "_setActiveTab",
    value: function _setActiveTab(tab) {
      this._activeTab = tab;
    }
  }, {
    key: "getTab",
    value: function getTab(id) {
      return this._items.filter(function (t) {
        return t.id === id;
      })[0];
    }
  }, {
    key: "show",
    value: function show(id) {
      var _this2 = this,
          _tab$triggerEl$classL,
          _tab$triggerEl$classL2;

      var forceShow = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      var tab = this.getTab(id); // don't do anything if already active

      if (tab === this._activeTab && !forceShow) {
        return;
      } // hide other tabs


      this._items.map(function (t) {
        if (t !== tab) {
          var _t$triggerEl$classLis, _t$triggerEl$classLis2;

          (_t$triggerEl$classLis = t.triggerEl.classList).remove.apply(_t$triggerEl$classLis, tabs_toConsumableArray(_this2._options.activeClasses.split(" ")));

          (_t$triggerEl$classLis2 = t.triggerEl.classList).add.apply(_t$triggerEl$classLis2, tabs_toConsumableArray(_this2._options.inactiveClasses.split(" ")));

          t.targetEl.classList.add('hidden');
          t.triggerEl.setAttribute('aria-selected', false);
        }
      }); // show active tab


      (_tab$triggerEl$classL = tab.triggerEl.classList).add.apply(_tab$triggerEl$classL, tabs_toConsumableArray(this._options.activeClasses.split(" ")));

      (_tab$triggerEl$classL2 = tab.triggerEl.classList).remove.apply(_tab$triggerEl$classL2, tabs_toConsumableArray(this._options.inactiveClasses.split(" ")));

      tab.triggerEl.setAttribute('aria-selected', true);
      tab.targetEl.classList.remove('hidden');

      this._setActiveTab(tab); // callback function


      this._options.onShow(this, tab);
    }
  }]);

  return Tabs;
}();

window.Tabs = Tabs;

function initTabs() {
  document.querySelectorAll('[data-tabs-toggle]').forEach(function (triggerEl) {
    var tabElements = [];
    var defaultTabId = null;
    triggerEl.querySelectorAll('[role="tab"]').forEach(function (el) {
      var isActive = el.getAttribute('aria-selected') === 'true';
      var tab = {
        id: el.getAttribute('data-tabs-target'),
        triggerEl: el,
        targetEl: document.querySelector(el.getAttribute('data-tabs-target'))
      };
      tabElements.push(tab);

      if (isActive) {
        defaultTabId = tab.id;
      }
    });
    new Tabs(tabElements, {
      defaultTabId: defaultTabId
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initTabs();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initTabs);
}

/* harmony default export */ const tabs = (Tabs);
;// CONCATENATED MODULE: ./src/components/tooltip.js
function tooltip_toConsumableArray(arr) { return tooltip_arrayWithoutHoles(arr) || tooltip_iterableToArray(arr) || tooltip_unsupportedIterableToArray(arr) || tooltip_nonIterableSpread(); }

function tooltip_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function tooltip_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return tooltip_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return tooltip_arrayLikeToArray(o, minLen); }

function tooltip_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function tooltip_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return tooltip_arrayLikeToArray(arr); }

function tooltip_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function tooltip_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function tooltip_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? tooltip_ownKeys(Object(source), !0).forEach(function (key) { tooltip_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : tooltip_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function tooltip_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function tooltip_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function tooltip_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function tooltip_createClass(Constructor, protoProps, staticProps) { if (protoProps) tooltip_defineProperties(Constructor.prototype, protoProps); if (staticProps) tooltip_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }


var tooltip_Default = {
  placement: 'top',
  triggerType: 'hover',
  onShow: function onShow() {},
  onHide: function onHide() {}
};

var Tooltip = /*#__PURE__*/function () {
  function Tooltip() {
    var targetEl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var triggerEl = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

    tooltip_classCallCheck(this, Tooltip);

    this._targetEl = targetEl;
    this._triggerEl = triggerEl;
    this._options = tooltip_objectSpread(tooltip_objectSpread({}, tooltip_Default), options);
    this._popperInstance = this._createPopperInstace();

    this._init();
  }

  tooltip_createClass(Tooltip, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      if (this._triggerEl) {
        var triggerEvents = this._getTriggerEvents();

        triggerEvents.showEvents.forEach(function (ev) {
          _this._triggerEl.addEventListener(ev, function () {
            _this.show();
          });
        });
        triggerEvents.hideEvents.forEach(function (ev) {
          _this._triggerEl.addEventListener(ev, function () {
            _this.hide();
          });
        });
      }
    }
  }, {
    key: "_createPopperInstace",
    value: function _createPopperInstace() {
      return popper_createPopper(this._triggerEl, this._targetEl, {
        placement: this._options.placement,
        modifiers: [{
          name: 'offset',
          options: {
            offset: [0, 8]
          }
        }]
      });
    }
  }, {
    key: "_getTriggerEvents",
    value: function _getTriggerEvents() {
      switch (this._options.triggerType) {
        case 'hover':
          return {
            showEvents: ['mouseenter', 'focus'],
            hideEvents: ['mouseleave', 'blur']
          };

        case 'click':
          return {
            showEvents: ['click', 'focus'],
            hideEvents: ['focusout', 'blur']
          };

        default:
          return {
            showEvents: ['mouseenter', 'focus'],
            hideEvents: ['mouseleave', 'blur']
          };
      }
    }
  }, {
    key: "show",
    value: function show() {
      this._targetEl.classList.remove('opacity-0', 'invisible');

      this._targetEl.classList.add('opacity-100', 'visible'); // Enable the event listeners


      this._popperInstance.setOptions(function (options) {
        return tooltip_objectSpread(tooltip_objectSpread({}, options), {}, {
          modifiers: [].concat(tooltip_toConsumableArray(options.modifiers), [{
            name: 'eventListeners',
            enabled: true
          }])
        });
      }); // Update its position


      this._popperInstance.update(); // callback function


      this._options.onShow(this);
    }
  }, {
    key: "hide",
    value: function hide() {
      this._targetEl.classList.remove('opacity-100', 'visible');

      this._targetEl.classList.add('opacity-0', 'invisible'); // Disable the event listeners


      this._popperInstance.setOptions(function (options) {
        return tooltip_objectSpread(tooltip_objectSpread({}, options), {}, {
          modifiers: [].concat(tooltip_toConsumableArray(options.modifiers), [{
            name: 'eventListeners',
            enabled: false
          }])
        });
      }); // callback function


      this._options.onHide(this);
    }
  }]);

  return Tooltip;
}();

window.Tooltip = Tooltip;

function initTooltip() {
  document.querySelectorAll('[data-tooltip-target]').forEach(function (triggerEl) {
    var targetEl = document.getElementById(triggerEl.getAttribute('data-tooltip-target'));
    var triggerType = triggerEl.getAttribute('data-tooltip-trigger');
    var placement = triggerEl.getAttribute('data-tooltip-placement');
    new Tooltip(targetEl, triggerEl, {
      placement: placement ? placement : tooltip_Default.placement,
      triggerType: triggerType ? triggerType : tooltip_Default.triggerType
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initTooltip();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initTooltip);
}

/* harmony default export */ const tooltip = (Tooltip);
;// CONCATENATED MODULE: ./src/components/popover.js
function popover_toConsumableArray(arr) { return popover_arrayWithoutHoles(arr) || popover_iterableToArray(arr) || popover_unsupportedIterableToArray(arr) || popover_nonIterableSpread(); }

function popover_nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function popover_unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return popover_arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return popover_arrayLikeToArray(o, minLen); }

function popover_iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function popover_arrayWithoutHoles(arr) { if (Array.isArray(arr)) return popover_arrayLikeToArray(arr); }

function popover_arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function popover_ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function popover_objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? popover_ownKeys(Object(source), !0).forEach(function (key) { popover_defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : popover_ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function popover_defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function popover_classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function popover_defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function popover_createClass(Constructor, protoProps, staticProps) { if (protoProps) popover_defineProperties(Constructor.prototype, protoProps); if (staticProps) popover_defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }


var popover_Default = {
  placement: 'top',
  offset: 10,
  triggerType: 'hover',
  onShow: function onShow() {},
  onHide: function onHide() {}
};

var Popover = /*#__PURE__*/function () {
  function Popover() {
    var targetEl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var triggerEl = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};

    popover_classCallCheck(this, Popover);

    this._targetEl = targetEl;
    this._triggerEl = triggerEl;
    this._options = popover_objectSpread(popover_objectSpread({}, popover_Default), options);
    this._popperInstance = this._createPopperInstace();

    this._init();
  }

  popover_createClass(Popover, [{
    key: "_init",
    value: function _init() {
      var _this = this;

      if (this._triggerEl) {
        var triggerEvents = this._getTriggerEvents();

        triggerEvents.showEvents.forEach(function (ev) {
          _this._triggerEl.addEventListener(ev, function () {
            _this.show();
          });

          _this._targetEl.addEventListener(ev, function () {
            _this.show();
          });
        });
        triggerEvents.hideEvents.forEach(function (ev) {
          _this._triggerEl.addEventListener(ev, function () {
            setTimeout(function () {
              if (!_this._targetEl.matches(':hover')) {
                _this.hide();
              }
            }, 100);
          });

          _this._targetEl.addEventListener(ev, function () {
            setTimeout(function () {
              if (!_this._triggerEl.matches(':hover')) {
                _this.hide();
              }
            }, 100);
          });
        });
      }
    }
  }, {
    key: "_createPopperInstace",
    value: function _createPopperInstace() {
      return popper_createPopper(this._triggerEl, this._targetEl, {
        placement: this._options.placement,
        modifiers: [{
          name: 'offset',
          options: {
            offset: [0, this._options.offset]
          }
        }]
      });
    }
  }, {
    key: "_getTriggerEvents",
    value: function _getTriggerEvents() {
      switch (this._options.triggerType) {
        case 'hover':
          return {
            showEvents: ['mouseenter', 'focus'],
            hideEvents: ['mouseleave', 'blur']
          };

        case 'click':
          return {
            showEvents: ['click', 'focus'],
            hideEvents: ['focusout', 'blur']
          };

        default:
          return {
            showEvents: ['mouseenter', 'focus'],
            hideEvents: ['mouseleave', 'blur']
          };
      }
    }
  }, {
    key: "show",
    value: function show() {
      this._targetEl.classList.remove('opacity-0', 'invisible');

      this._targetEl.classList.add('opacity-100', 'visible'); // Enable the event listeners


      this._popperInstance.setOptions(function (options) {
        return popover_objectSpread(popover_objectSpread({}, options), {}, {
          modifiers: [].concat(popover_toConsumableArray(options.modifiers), [{
            name: 'eventListeners',
            enabled: true
          }])
        });
      }); // Update its position


      this._popperInstance.update(); // callback function


      this._options.onShow(this);
    }
  }, {
    key: "hide",
    value: function hide() {
      this._targetEl.classList.remove('opacity-100', 'visible');

      this._targetEl.classList.add('opacity-0', 'invisible'); // Disable the event listeners


      this._popperInstance.setOptions(function (options) {
        return popover_objectSpread(popover_objectSpread({}, options), {}, {
          modifiers: [].concat(popover_toConsumableArray(options.modifiers), [{
            name: 'eventListeners',
            enabled: false
          }])
        });
      }); // callback function


      this._options.onHide(this);
    }
  }]);

  return Popover;
}();

window.Popover = Popover;

function initPopover() {
  document.querySelectorAll('[data-popover-target]').forEach(function (triggerEl) {
    var targetEl = document.getElementById(triggerEl.getAttribute('data-popover-target'));
    var triggerType = triggerEl.getAttribute('data-popover-trigger');
    var placement = triggerEl.getAttribute('data-popover-placement');
    var offset = triggerEl.getAttribute('data-popover-offset');
    new Popover(targetEl, triggerEl, {
      placement: placement ? placement : popover_Default.placement,
      offset: offset ? parseInt(offset) : popover_Default.offset,
      triggerType: triggerType ? triggerType : popover_Default.triggerType
    });
  });
}

if (document.readyState !== 'loading') {
  // DOMContentLoaded event were already fired. Perform explicit initialization now
  initPopover();
} else {
  // DOMContentLoaded event not yet fired, attach initialization process to it
  document.addEventListener('DOMContentLoaded', initPopover);
}

/* harmony default export */ const popover = (Popover);
;// CONCATENATED MODULE: ./src/flowbite.js
 // core components











/* harmony default export */ const flowbite = ({
  Accordion: accordion,
  Collapse: collapse,
  Carousel: carousel,
  Dismiss: dismiss,
  Dropdown: dropdown,
  Modal: modal,
  Drawer: drawer,
  Tabs: tabs,
  Tooltip: tooltip,
  Popover: popover
});
/******/ })()
;
//# sourceMappingURL=flowbite.js.map

/***/ }),

/***/ "./node_modules/preline/dist/preline.js":
/*!**********************************************!*\
  !*** ./node_modules/preline/dist/preline.js ***!
  \**********************************************/
/***/ ((module) => {

/*! For license information please see preline.js.LICENSE.txt */
!function(e,t){if(true)module.exports=t();else { var n, o; }}(self,(function(){return(()=>{"use strict";var e={661:(e,t,o)=>{function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}function r(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function i(e,t){return i=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},i(e,t)}function a(e,t){if(t&&("object"===n(t)||"function"==typeof t))return t;if(void 0!==t)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e)}function s(e){return s=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},s(e)}var c=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&i(e,t)}(u,e);var t,o,n,c,l=(n=u,c=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=s(n);if(c){var o=s(this).constructor;e=Reflect.construct(t,arguments,o)}else e=t.apply(this,arguments);return a(this,e)});function u(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,u),l.call(this,".hs-accordion")}return t=u,(o=[{key:"init",value:function(){var e=this;document.addEventListener("click",(function(t){var o=t.target,n=o.closest(e.selector),r=o.closest(".hs-accordion-toggle"),i=o.closest(".hs-accordion-group");n&&i&&r&&(e._hideAll(n),e.show(n))}))}},{key:"show",value:function(e){var t=this;if(e.classList.contains("active"))return this.hide(e);e.classList.add("active");var o=e.querySelector(".hs-accordion-content");o.style.display="block",o.style.height=0,setTimeout((function(){o.style.height="".concat(o.scrollHeight,"px")})),this.afterTransition(o,(function(){e.classList.contains("active")&&(o.style.height="",t._fireEvent("open",e),t._dispatch("open.hs.accordion",e,e))}))}},{key:"hide",value:function(e){var t=this,o=e.querySelector(".hs-accordion-content");o.style.height="".concat(o.scrollHeight,"px"),setTimeout((function(){o.style.height=0})),this.afterTransition(o,(function(){e.classList.contains("active")||(o.style.display="",t._fireEvent("hide",e),t._dispatch("hide.hs.accordion",e,e))})),e.classList.remove("active")}},{key:"_hideAll",value:function(e){var t=this,o=e.closest(".hs-accordion-group");o.hasAttribute("data-hs-accordion-always-open")||o.querySelectorAll(this.selector).forEach((function(o){e!==o&&t.hide(o)}))}}])&&r(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),u}(o(765).Z);window.HSAccordion=new c,document.addEventListener("load",window.HSAccordion.init())},795:(e,t,o)=>{function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}function r(e,t){(null==t||t>e.length)&&(t=e.length);for(var o=0,n=new Array(t);o<t;o++)n[o]=e[o];return n}function i(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function a(e,t){return a=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},a(e,t)}function s(e,t){if(t&&("object"===n(t)||"function"==typeof t))return t;if(void 0!==t)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e)}function c(e){return c=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},c(e)}var l=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&a(e,t)}(f,e);var t,o,n,l,u=(n=f,l=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=c(n);if(l){var o=c(this).constructor;e=Reflect.construct(t,arguments,o)}else e=t.apply(this,arguments);return s(this,e)});function f(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,f),u.call(this,"[data-hs-collapse]")}return t=f,(o=[{key:"init",value:function(){var e=this;document.addEventListener("click",(function(t){var o=t.target.closest(e.selector);if(o){var n=document.querySelectorAll(o.getAttribute("data-hs-collapse"));e.toggle(n)}}))}},{key:"toggle",value:function(e){var t,o=this;e.length&&(t=e,function(e){if(Array.isArray(e))return r(e)}(t)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(t)||function(e,t){if(e){if("string"==typeof e)return r(e,t);var o=Object.prototype.toString.call(e).slice(8,-1);return"Object"===o&&e.constructor&&(o=e.constructor.name),"Map"===o||"Set"===o?Array.from(e):"Arguments"===o||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(o)?r(e,t):void 0}}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()).forEach((function(e){e.classList.contains("hidden")?o.show(e):o.hide(e)}))}},{key:"show",value:function(e){var t=this;e.classList.add("open"),e.classList.remove("hidden"),e.style.height=0,document.querySelectorAll(this.selector).forEach((function(t){e.closest(t.getAttribute("data-hs-collapse"))&&t.classList.add("open")})),e.style.height="".concat(e.scrollHeight,"px"),this.afterTransition(e,(function(){e.classList.contains("open")&&(e.style.height="",t._fireEvent("open",e),t._dispatch("open.hs.collapse",e,e))}))}},{key:"hide",value:function(e){var t=this;e.style.height="".concat(e.scrollHeight,"px"),setTimeout((function(){e.style.height=0})),e.classList.remove("open"),this.afterTransition(e,(function(){e.classList.contains("open")||(e.classList.add("hidden"),e.style.height=null,t._fireEvent("hide",e),t._dispatch("hide.hs.collapse",e,e),e.querySelectorAll(".hs-mega-menu-content.block").forEach((function(e){e.classList.remove("block"),e.classList.add("hidden")})))})),document.querySelectorAll(this.selector).forEach((function(t){e.closest(t.getAttribute("data-hs-collapse"))&&t.classList.remove("open")}))}}])&&i(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),f}(o(765).Z);window.HSCollapse=new l,document.addEventListener("load",window.HSCollapse.init())},682:(e,t,o)=>{var n=o(714),r=o(765);const i={historyIndex:-1,addHistory:function(e){this.historyIndex=e},existsInHistory:function(e){return e>this.historyIndex},clearHistory:function(){this.historyIndex=-1}};function a(e){return a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a(e)}function s(e){return function(e){if(Array.isArray(e))return c(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,t){if(e){if("string"==typeof e)return c(e,t);var o=Object.prototype.toString.call(e).slice(8,-1);return"Object"===o&&e.constructor&&(o=e.constructor.name),"Map"===o||"Set"===o?Array.from(e):"Arguments"===o||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(o)?c(e,t):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function c(e,t){(null==t||t>e.length)&&(t=e.length);for(var o=0,n=new Array(t);o<t;o++)n[o]=e[o];return n}function l(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function u(e,t){return u=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},u(e,t)}function f(e,t){if(t&&("object"===a(t)||"function"==typeof t))return t;if(void 0!==t)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e)}function p(e){return p=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},p(e)}var d=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&u(e,t)}(d,e);var t,o,r,a,c=(r=d,a=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=p(r);if(a){var o=p(this).constructor;e=Reflect.construct(t,arguments,o)}else e=t.apply(this,arguments);return f(this,e)});function d(){var e;return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,d),(e=c.call(this,".hs-dropdown")).positions={top:"top","top-left":"top-start","top-right":"top-end",bottom:"bottom","bottom-left":"bottom-start","bottom-right":"bottom-end",right:"right","right-top":"right-start","right-bottom":"right-end",left:"left","left-top":"left-start","left-bottom":"left-end"},e.absoluteStrategyModifiers=function(e){return[{name:"applyStyles",fn:function(t){var o=(window.getComputedStyle(e).getPropertyValue("--strategy")||"absolute").replace(" ",""),n=(window.getComputedStyle(e).getPropertyValue("--adaptive")||"adaptive").replace(" ","");t.state.elements.popper.style.position=o,t.state.elements.popper.style.transform="adaptive"===n?t.state.styles.popper.transform:null,t.state.elements.popper.style.top=null,t.state.elements.popper.style.bottom=null,t.state.elements.popper.style.left=null,t.state.elements.popper.style.right=null,t.state.elements.popper.style.margin=0}},{name:"computeStyles",options:{adaptive:!1}}]},e._history=i,e}return t=d,o=[{key:"init",value:function(){var e=this;document.addEventListener("click",(function(t){var o=t.target,n=o.closest(e.selector),r=o.closest(".hs-dropdown-menu");if(n&&n.classList.contains("open")||e._closeOthers(n),r){var i=(window.getComputedStyle(n).getPropertyValue("--auto-close")||"").replace(" ","");if(("false"==i||"inside"==i)&&!n.parentElement.closest(e.selector))return}n&&(n.classList.contains("open")?e.close(n):e.open(n))})),document.addEventListener("mousemove",(function(t){var o=t.target,n=o.closest(e.selector);if(o.closest(".hs-dropdown-menu"),n){var r=(window.getComputedStyle(n).getPropertyValue("--trigger")||"click").replace(" ","");if("hover"!==r)return;n&&n.classList.contains("open")||e._closeOthers(n),"hover"!==r||n.classList.contains("open")||/iPad|iPhone|iPod/.test(navigator.platform)||navigator.maxTouchPoints&&navigator.maxTouchPoints>2&&/MacIntel/.test(navigator.platform)||navigator.maxTouchPoints&&navigator.maxTouchPoints>2&&/MacIntel/.test(navigator.platform)||e._hover(o)}})),document.addEventListener("keydown",this._keyboardSupport.bind(this)),window.addEventListener("resize",(function(){document.querySelectorAll(".hs-dropdown.open").forEach((function(t){e.close(t,!0)}))}))}},{key:"_closeOthers",value:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,o=document.querySelectorAll("".concat(this.selector,".open"));o.forEach((function(o){if(!t||t.closest(".hs-dropdown.open")!==o){var n=(window.getComputedStyle(o).getPropertyValue("--auto-close")||"").replace(" ","");"false"!=n&&"outside"!=n&&e.close(o)}}))}},{key:"_hover",value:function(e){var t=this,o=e.closest(this.selector);this.open(o),document.addEventListener("mousemove",(function e(n){n.target.closest(t.selector)&&n.target.closest(t.selector)!==o.parentElement.closest(t.selector)||(t.close(o),document.removeEventListener("mousemove",e,!0))}),!0)}},{key:"close",value:function(e){var t=this,o=arguments.length>1&&void 0!==arguments[1]&&arguments[1],n=e.querySelector(".hs-dropdown-menu"),r=function(){e.classList.contains("open")||(n.classList.remove("block"),n.classList.add("hidden"),n.style.inset=null,n.style.position=null,e._popper&&e._popper.destroy())};o||this.afterTransition(e.querySelector("[data-hs-dropdown-transition]")||n,(function(){r()})),n.style.margin=null,e.classList.remove("open"),o&&r(),this._fireEvent("close",e),this._dispatch("close.hs.dropdown",e,e);var i=n.querySelectorAll(".hs-dropdown.open");i.forEach((function(e){t.close(e,!0)}))}},{key:"open",value:function(e){var t=e.querySelector(".hs-dropdown-menu"),o=(window.getComputedStyle(e).getPropertyValue("--placement")||"").replace(" ",""),r=(window.getComputedStyle(e).getPropertyValue("--strategy")||"fixed").replace(" ",""),i=((window.getComputedStyle(e).getPropertyValue("--adaptive")||"adaptive").replace(" ",""),parseInt((window.getComputedStyle(e).getPropertyValue("--offset")||"10").replace(" ","")));if("static"!==r){e._popper&&e._popper.destroy();var a=(0,n.fi)(e,t,{placement:this.positions[o]||"bottom-start",strategy:r,modifiers:[].concat(s("fixed"!==r?this.absoluteStrategyModifiers(e):[]),[{name:"offset",options:{offset:[0,i]}}])});e._popper=a}t.style.margin=null,t.classList.add("block"),t.classList.remove("hidden"),setTimeout((function(){e.classList.add("open")})),this._fireEvent("open",e),this._dispatch("open.hs.dropdown",e,e)}},{key:"_keyboardSupport",value:function(e){var t=document.querySelector(".hs-dropdown.open");if(t)return 27===e.keyCode?(e.preventDefault(),this._esc(t)):40===e.keyCode?(e.preventDefault(),this._down(t)):38===e.keyCode?(e.preventDefault(),this._up(t)):36===e.keyCode?(e.preventDefault(),this._start(t)):35===e.keyCode?(e.preventDefault(),this._end(t)):void this._byChar(t,e.key)}},{key:"_esc",value:function(e){this.close(e)}},{key:"_up",value:function(e){var t=e.querySelector(".hs-dropdown-menu"),o=s(t.querySelectorAll("a")).reverse().filter((function(e){return!e.disabled})),n=t.querySelector("a:focus"),r=o.findIndex((function(e){return e===n}));r+1<o.length&&r++,o[r].focus()}},{key:"_down",value:function(e){var t=e.querySelector(".hs-dropdown-menu"),o=s(t.querySelectorAll("a")).filter((function(e){return!e.disabled})),n=t.querySelector("a:focus"),r=o.findIndex((function(e){return e===n}));r+1<o.length&&r++,o[r].focus()}},{key:"_start",value:function(e){var t=s(e.querySelector(".hs-dropdown-menu").querySelectorAll("a")).filter((function(e){return!e.disabled}));t.length&&t[0].focus()}},{key:"_end",value:function(e){var t=s(e.querySelector(".hs-dropdown-menu").querySelectorAll("a")).reverse().filter((function(e){return!e.disabled}));t.length&&t[0].focus()}},{key:"_byChar",value:function(e,t){var o=this,n=s(e.querySelector(".hs-dropdown-menu").querySelectorAll("a")),r=function(){return n.findIndex((function(e,n){return e.innerText.toLowerCase().charAt(0)===t.toLowerCase()&&o._history.existsInHistory(n)}))},i=r();-1===i&&(this._history.clearHistory(),i=r()),-1!==i&&(n[i].focus(),this._history.addHistory(i))}},{key:"toggle",value:function(e){e.classList.contains("open")?this.close(e):this.open(e)}}],o&&l(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),d}(r.Z);window.HSDropdown=new d,document.addEventListener("load",window.HSDropdown.init())},284:(e,t,o)=>{function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}function r(e,t){(null==t||t>e.length)&&(t=e.length);for(var o=0,n=new Array(t);o<t;o++)n[o]=e[o];return n}function i(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function a(e,t){return a=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},a(e,t)}function s(e,t){if(t&&("object"===n(t)||"function"==typeof t))return t;if(void 0!==t)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e)}function c(e){return c=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},c(e)}var l=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&a(e,t)}(f,e);var t,o,n,l,u=(n=f,l=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=c(n);if(l){var o=c(this).constructor;e=Reflect.construct(t,arguments,o)}else e=t.apply(this,arguments);return s(this,e)});function f(){var e;return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,f),(e=u.call(this,"[data-hs-overlay]")).openNextOverlay=!1,e}return t=f,(o=[{key:"init",value:function(){var e=this;document.addEventListener("click",(function(t){var o=t.target.closest(e.selector),n=t.target.closest("[data-hs-overlay-close]"),r="true"===t.target.getAttribute("aria-overlay");return n?e.close(n.closest(".hs-overlay.open")):o?e.toggle(document.querySelector(o.getAttribute("data-hs-overlay"))):void(r&&e._onBackdropClick(t.target))})),document.addEventListener("keydown",(function(t){if(27===t.keyCode){var o=document.querySelector(".hs-overlay.open");if(!o)return;setTimeout((function(){"false"!==o.getAttribute("data-hs-overlay-keyboard")&&e.close(o)}))}}))}},{key:"toggle",value:function(e){e&&(e.classList.contains("hidden")?this.open(e):this.close(e))}},{key:"open",value:function(e){var t=this;if(e){var o=document.querySelector(".hs-overlay.open"),n="true"!==this.getClassProperty(e,"--body-scroll","false");if(o)return this.openNextOverlay=!0,this.close(o).then((function(){t.open(e),t.openNextOverlay=!1}));n&&(document.body.style.overflow="hidden"),this._buildBackdrop(e),this._checkTimer(e),this._autoHide(e),e.classList.remove("hidden"),e.setAttribute("aria-overlay","true"),e.setAttribute("tabindex","-1"),setTimeout((function(){e.classList.contains("hidden")||(e.classList.add("open"),t._fireEvent("open",e),t._dispatch("open.hs.overlay",e,e),t._focusInput(e))}),50)}}},{key:"close",value:function(e){var t=this;return new Promise((function(o){e&&(e.classList.remove("open"),e.removeAttribute("aria-overlay"),e.removeAttribute("tabindex","-1"),t.afterTransition(e,(function(){e.classList.contains("open")||(e.classList.add("hidden"),t._destroyBackdrop(),t._fireEvent("close",e),t._dispatch("close.hs.overlay",e,e),document.body.style.overflow="",o(e))})))}))}},{key:"_autoHide",value:function(e){var t=this,o=parseInt(this.getClassProperty(e,"--auto-hide","0"));o&&(e.autoHide=setTimeout((function(){t.close(e)}),o))}},{key:"_checkTimer",value:function(e){e.autoHide&&(clearTimeout(e.autoHide),delete e.autoHide)}},{key:"_onBackdropClick",value:function(e){"static"!==this.getClassProperty(e,"--overlay-backdrop","true")&&this.close(e)}},{key:"_buildBackdrop",value:function(e){var t,o=this,n=e.getAttribute("data-hs-overlay-backdrop-container")||!1,i=document.createElement("div"),a="transition duration fixed inset-0 z-50 bg-gray-900 bg-opacity-50 dark:bg-opacity-80 hs-overlay-backdrop",s=function(e,t){var o="undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(!o){if(Array.isArray(e)||(o=function(e,t){if(e){if("string"==typeof e)return r(e,t);var o=Object.prototype.toString.call(e).slice(8,-1);return"Object"===o&&e.constructor&&(o=e.constructor.name),"Map"===o||"Set"===o?Array.from(e):"Arguments"===o||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(o)?r(e,t):void 0}}(e))||t&&e&&"number"==typeof e.length){o&&(e=o);var n=0,i=function(){};return{s:i,n:function(){return n>=e.length?{done:!0}:{done:!1,value:e[n++]}},e:function(e){throw e},f:i}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var a,s=!0,c=!1;return{s:function(){o=o.call(e)},n:function(){var e=o.next();return s=e.done,e},e:function(e){c=!0,a=e},f:function(){try{s||null==o.return||o.return()}finally{if(c)throw a}}}}(e.classList.values());try{for(s.s();!(t=s.n()).done;){var c=t.value;c.startsWith("hs-overlay-backdrop-open:")&&(a+=" ".concat(c))}}catch(e){s.e(e)}finally{s.f()}var l="static"!==this.getClassProperty(e,"--overlay-backdrop","true");"false"===this.getClassProperty(e,"--overlay-backdrop","true")||(n&&((i=document.querySelector(n).cloneNode(!0)).classList.remove("hidden"),a=i.classList,i.classList=""),l&&i.addEventListener("click",(function(){return o.close(e)}),!0),i.setAttribute("data-hs-overlay-backdrop-template",""),document.body.appendChild(i),setTimeout((function(){i.classList=a})))}},{key:"_destroyBackdrop",value:function(){var e=document.querySelector("[data-hs-overlay-backdrop-template]");e&&(this.openNextOverlay&&(e.style.transitionDuration="".concat(1.8*parseFloat(window.getComputedStyle(e).transitionDuration.replace(/[^\d.-]/g,"")),"s")),e.classList.add("opacity-0"),this.afterTransition(e,(function(){e.remove()})))}},{key:"_focusInput",value:function(e){var t=e.querySelector("[autofocus]");t&&t.focus()}}])&&i(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),f}(o(765).Z);window.HSOverlay=new l,document.addEventListener("load",window.HSOverlay.init())},181:(e,t,o)=>{function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}function r(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function i(e,t){return i=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},i(e,t)}function a(e,t){if(t&&("object"===n(t)||"function"==typeof t))return t;if(void 0!==t)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e)}function s(e){return s=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},s(e)}var c=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&i(e,t)}(u,e);var t,o,n,c,l=(n=u,c=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=s(n);if(c){var o=s(this).constructor;e=Reflect.construct(t,arguments,o)}else e=t.apply(this,arguments);return a(this,e)});function u(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,u),l.call(this,"[data-hs-remove-element]")}return t=u,(o=[{key:"init",value:function(){var e=this;document.addEventListener("click",(function(t){var o=t.target.closest(e.selector);if(o){var n=document.querySelector(o.getAttribute("data-hs-remove-element"));n&&(n.classList.add("hs-removing"),e.afterTransition(n,(function(){n.remove()})))}}))}}])&&r(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),u}(o(765).Z);window.HSRemoveElement=new c,document.addEventListener("load",window.HSRemoveElement.init())},778:(e,t,o)=>{function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}function r(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function i(e,t){return i=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},i(e,t)}function a(e,t){if(t&&("object"===n(t)||"function"==typeof t))return t;if(void 0!==t)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e)}function s(e){return s=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},s(e)}var c=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&i(e,t)}(u,e);var t,o,n,c,l=(n=u,c=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=s(n);if(c){var o=s(this).constructor;e=Reflect.construct(t,arguments,o)}else e=t.apply(this,arguments);return a(this,e)});function u(){var e;return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,u),(e=l.call(this,"[data-hs-scrollspy] ")).activeSection=null,e}return t=u,(o=[{key:"init",value:function(){var e=this;document.querySelectorAll(this.selector).forEach((function(t){var o=document.querySelector(t.getAttribute("data-hs-scrollspy")),n=t.querySelectorAll("[href]"),r=o.children,i=t.getAttribute("data-hs-scrollspy-scrollable-parent")?document.querySelector(t.getAttribute("data-hs-scrollspy-scrollable-parent")):document;Array.from(r).forEach((function(a){a.getAttribute("id")&&i.addEventListener("scroll",(function(i){return e._update({$scrollspyEl:t,$scrollspyContentEl:o,links:n,$sectionEl:a,sections:r,ev:i})}))})),n.forEach((function(o){o.addEventListener("click",(function(n){n.preventDefault(),"javascript:;"!==o.getAttribute("href")&&e._scrollTo({$scrollspyEl:t,$scrollableEl:i,$link:o})}))}))}))}},{key:"_update",value:function(e){var t=e.ev,o=e.$scrollspyEl,n=(e.sections,e.links),r=e.$sectionEl,i=parseInt(this.getClassProperty(o,"--scrollspy-offset","0")),a=this.getClassProperty(r,"--scrollspy-offset")||i,s=t.target===document?0:parseInt(t.target.getBoundingClientRect().top),c=parseInt(r.getBoundingClientRect().top)-a-s,l=r.offsetHeight;if(c<=0&&c+l>0){if(this.activeSection===r)return;n.forEach((function(e){e.classList.remove("active")}));var u=o.querySelector('[href="#'.concat(r.getAttribute("id"),'"]'));if(u){u.classList.add("active");var f=u.closest("[data-hs-scrollspy-group]");if(f){var p=f.querySelector("[href]");p&&p.classList.add("active")}}this.activeSection=r}}},{key:"_scrollTo",value:function(e){var t=e.$scrollspyEl,o=e.$scrollableEl,n=e.$link,r=document.querySelector(n.getAttribute("href")),i=parseInt(this.getClassProperty(t,"--scrollspy-offset","0")),a=this.getClassProperty(r,"--scrollspy-offset")||i,s=o===document?0:o.offsetTop,c=r.offsetTop-a-s,l=o===document?window:o;this._fireEvent("scroll",t),this._dispatch("scroll.hs.scrollspy",t,t),window.history.replaceState(null,null,n.getAttribute("href")),l.scrollTo({top:c,left:0,behavior:"smooth"})}}])&&r(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),u}(o(765).Z);window.HSScrollspy=new c,document.addEventListener("load",window.HSScrollspy.init())},51:(e,t,o)=>{function n(e){return n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},n(e)}function r(e){return function(e){if(Array.isArray(e))return i(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,t){if(e){if("string"==typeof e)return i(e,t);var o=Object.prototype.toString.call(e).slice(8,-1);return"Object"===o&&e.constructor&&(o=e.constructor.name),"Map"===o||"Set"===o?Array.from(e):"Arguments"===o||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(o)?i(e,t):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function i(e,t){(null==t||t>e.length)&&(t=e.length);for(var o=0,n=new Array(t);o<t;o++)n[o]=e[o];return n}function a(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function s(e,t){return s=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},s(e,t)}function c(e,t){if(t&&("object"===n(t)||"function"==typeof t))return t;if(void 0!==t)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e)}function l(e){return l=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},l(e)}var u=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&s(e,t)}(f,e);var t,o,n,i,u=(n=f,i=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=l(n);if(i){var o=l(this).constructor;e=Reflect.construct(t,arguments,o)}else e=t.apply(this,arguments);return c(this,e)});function f(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,f),u.call(this,"[data-hs-tab]")}return t=f,(o=[{key:"init",value:function(){var e=this;document.addEventListener("keydown",this._keyboardSupport.bind(this)),document.addEventListener("click",(function(t){var o=t.target.closest(e.selector);o&&e.open(o)})),document.querySelectorAll("[hs-data-tab-select]").forEach((function(t){var o=document.querySelector(t.getAttribute("hs-data-tab-select"));o&&o.addEventListener("change",(function(t){var o=document.querySelector('[data-hs-tab="'.concat(t.target.value,'"]'));o&&e.open(o)}))}))}},{key:"open",value:function(e){var t=document.querySelector(e.getAttribute("data-hs-tab")),o=r(e.parentElement.children),n=r(t.parentElement.children),i=e.closest("[hs-data-tab-select]"),a=i?document.querySelector(i.getAttribute("data-hs-tab")):null;o.forEach((function(e){return e.classList.remove("active")})),n.forEach((function(e){return e.classList.add("hidden")})),e.classList.add("active"),t.classList.remove("hidden"),this._fireEvent("change",e),this._dispatch("change.hs.tab",e,e),a&&(a.value=e.getAttribute("data-hs-tab"))}},{key:"_keyboardSupport",value:function(e){var t=e.target.closest(this.selector);if(t){var o="true"===t.closest('[role="tablist"]').getAttribute("data-hs-tabs-vertical");return(o?38===e.keyCode:37===e.keyCode)?(e.preventDefault(),this._left(t)):(o?40===e.keyCode:39===e.keyCode)?(e.preventDefault(),this._right(t)):36===e.keyCode?(e.preventDefault(),this._start(t)):35===e.keyCode?(e.preventDefault(),this._end(t)):void 0}}},{key:"_right",value:function(e){var t=e.closest('[role="tablist"]');if(t){var o=r(t.querySelectorAll(this.selector)).filter((function(e){return!e.disabled})),n=t.querySelector("button:focus"),i=o.findIndex((function(e){return e===n}));i+1<o.length?i++:i=0,o[i].focus(),this.open(o[i])}}},{key:"_left",value:function(e){var t=e.closest('[role="tablist"]');if(t){var o=r(t.querySelectorAll(this.selector)).filter((function(e){return!e.disabled})).reverse(),n=t.querySelector("button:focus"),i=o.findIndex((function(e){return e===n}));i+1<o.length?i++:i=0,o[i].focus(),this.open(o[i])}}},{key:"_start",value:function(e){var t=e.closest('[role="tablist"]');if(t){var o=r(t.querySelectorAll(this.selector)).filter((function(e){return!e.disabled}));o.length&&(o[0].focus(),this.open(o[0]))}}},{key:"_end",value:function(e){var t=e.closest('[role="tablist"]');if(t){var o=r(t.querySelectorAll(this.selector)).reverse().filter((function(e){return!e.disabled}));o.length&&(o[0].focus(),this.open(o[0]))}}}])&&a(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),f}(o(765).Z);window.HSTabs=new u,document.addEventListener("load",window.HSTabs.init())},185:(e,t,o)=>{var n=o(765),r=o(714);function i(e){return i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},i(e)}function a(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function s(e,t){return s=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e},s(e,t)}function c(e,t){if(t&&("object"===i(t)||"function"==typeof t))return t;if(void 0!==t)throw new TypeError("Derived constructors may only return object or undefined");return function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e)}function l(e){return l=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)},l(e)}var u=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),Object.defineProperty(e,"prototype",{writable:!1}),t&&s(e,t)}(f,e);var t,o,n,i,u=(n=f,i=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=l(n);if(i){var o=l(this).constructor;e=Reflect.construct(t,arguments,o)}else e=t.apply(this,arguments);return c(this,e)});function f(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,f),u.call(this,".hs-tooltip")}return t=f,(o=[{key:"init",value:function(){var e=this;document.addEventListener("click",(function(t){var o=t.target.closest(e.selector);o&&"focus"===e.getClassProperty(o,"--trigger")&&e._focus(o),o&&"click"===e.getClassProperty(o,"--trigger")&&e._click(o)})),document.addEventListener("mousemove",(function(t){var o=t.target.closest(e.selector);o&&"focus"!==e.getClassProperty(o,"--trigger")&&"click"!==e.getClassProperty(o,"--trigger")&&e._hover(o)}))}},{key:"_hover",value:function(e){var t=this;if(!e.classList.contains("show")){var o=e.querySelector(".hs-tooltip-toggle"),n=e.querySelector(".hs-tooltip-content"),i=this.getClassProperty(e,"--placement");(0,r.fi)(o,n,{placement:i||"top",strategy:"fixed",modifiers:[{name:"offset",options:{offset:[0,5]}}]}),this.show(e),e.addEventListener("mouseleave",(function o(n){n.toElement.closest(t.selector)&&n.toElement.closest(t.selector)==e||(t.hide(e),e.removeEventListener("mouseleave",o,!0))}),!0)}}},{key:"_focus",value:function(e){var t=this,o=e.querySelector(".hs-tooltip-toggle"),n=e.querySelector(".hs-tooltip-content"),i=this.getClassProperty(e,"--placement"),a=this.getClassProperty(e,"--strategy");(0,r.fi)(o,n,{placement:i||"top",strategy:a||"fixed",modifiers:[{name:"offset",options:{offset:[0,5]}}]}),this.show(e),e.addEventListener("blur",(function o(){t.hide(e),e.removeEventListener("blur",o,!0)}),!0)}},{key:"_click",value:function(e){var t=this;if(!e.classList.contains("show")){var o=e.querySelector(".hs-tooltip-toggle"),n=e.querySelector(".hs-tooltip-content"),i=this.getClassProperty(e,"--placement"),a=this.getClassProperty(e,"--strategy");(0,r.fi)(o,n,{placement:i||"top",strategy:a||"fixed",modifiers:[{name:"offset",options:{offset:[0,5]}}]}),this.show(e);var s=function o(n){setTimeout((function(){t.hide(e),e.removeEventListener("click",o,!0),e.removeEventListener("blur",o,!0)}))};e.addEventListener("blur",s,!0),e.addEventListener("click",s,!0)}}},{key:"show",value:function(e){var t=this;e.querySelector(".hs-tooltip-content").classList.remove("hidden"),setTimeout((function(){e.classList.add("show"),t._fireEvent("show",e),t._dispatch("show.hs.tooltip",e,e)}))}},{key:"hide",value:function(e){var t=e.querySelector(".hs-tooltip-content");e.classList.remove("show"),this._fireEvent("hide",e),this._dispatch("hide.hs.tooltip",e,e),this.afterTransition(t,(function(){e.classList.contains("show")||t.classList.add("hidden")}))}}])&&a(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),f}(n.Z);window.HSTooltip=new u,document.addEventListener("load",window.HSTooltip.init())},765:(e,t,o)=>{function n(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}o.d(t,{Z:()=>r});var r=function(){function e(t,o){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.$collection=[],this.selector=t,this.config=o,this.events={}}var t,o;return t=e,o=[{key:"_fireEvent",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null;this.events.hasOwnProperty(e)&&this.events[e](t)}},{key:"_dispatch",value:function(e,t){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,n=new CustomEvent(e,{detail:{payload:o},bubbles:!0,cancelable:!0,composed:!1});t.dispatchEvent(n)}},{key:"on",value:function(e,t){this.events[e]=t}},{key:"afterTransition",value:function(e,t){"all 0s ease 0s"!==window.getComputedStyle(e,null).getPropertyValue("transition")?e.addEventListener("transitionend",(function o(){t(),e.removeEventListener("transitionend",o,!0)}),!0):t()}},{key:"getClassProperty",value:function(e,t){var o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"",n=(window.getComputedStyle(e).getPropertyValue(t)||o).replace(" ","");return n}}],o&&n(t.prototype,o),Object.defineProperty(t,"prototype",{writable:!1}),e}()},714:(e,t,o)=>{function n(e){if(null==e)return window;if("[object Window]"!==e.toString()){var t=e.ownerDocument;return t&&t.defaultView||window}return e}function r(e){return e instanceof n(e).Element||e instanceof Element}function i(e){return e instanceof n(e).HTMLElement||e instanceof HTMLElement}function a(e){return"undefined"!=typeof ShadowRoot&&(e instanceof n(e).ShadowRoot||e instanceof ShadowRoot)}o.d(t,{fi:()=>ce});var s=Math.max,c=Math.min,l=Math.round;function u(e,t){void 0===t&&(t=!1);var o=e.getBoundingClientRect(),n=1,r=1;if(i(e)&&t){var a=e.offsetHeight,s=e.offsetWidth;s>0&&(n=l(o.width)/s||1),a>0&&(r=l(o.height)/a||1)}return{width:o.width/n,height:o.height/r,top:o.top/r,right:o.right/n,bottom:o.bottom/r,left:o.left/n,x:o.left/n,y:o.top/r}}function f(e){var t=n(e);return{scrollLeft:t.pageXOffset,scrollTop:t.pageYOffset}}function p(e){return e?(e.nodeName||"").toLowerCase():null}function d(e){return((r(e)?e.ownerDocument:e.document)||window.document).documentElement}function y(e){return u(d(e)).left+f(e).scrollLeft}function h(e){return n(e).getComputedStyle(e)}function v(e){var t=h(e),o=t.overflow,n=t.overflowX,r=t.overflowY;return/auto|scroll|overlay|hidden/.test(o+r+n)}function m(e,t,o){void 0===o&&(o=!1);var r,a,s=i(t),c=i(t)&&function(e){var t=e.getBoundingClientRect(),o=l(t.width)/e.offsetWidth||1,n=l(t.height)/e.offsetHeight||1;return 1!==o||1!==n}(t),h=d(t),m=u(e,c),b={scrollLeft:0,scrollTop:0},g={x:0,y:0};return(s||!s&&!o)&&(("body"!==p(t)||v(h))&&(b=(r=t)!==n(r)&&i(r)?{scrollLeft:(a=r).scrollLeft,scrollTop:a.scrollTop}:f(r)),i(t)?((g=u(t,!0)).x+=t.clientLeft,g.y+=t.clientTop):h&&(g.x=y(h))),{x:m.left+b.scrollLeft-g.x,y:m.top+b.scrollTop-g.y,width:m.width,height:m.height}}function b(e){var t=u(e),o=e.offsetWidth,n=e.offsetHeight;return Math.abs(t.width-o)<=1&&(o=t.width),Math.abs(t.height-n)<=1&&(n=t.height),{x:e.offsetLeft,y:e.offsetTop,width:o,height:n}}function g(e){return"html"===p(e)?e:e.assignedSlot||e.parentNode||(a(e)?e.host:null)||d(e)}function w(e){return["html","body","#document"].indexOf(p(e))>=0?e.ownerDocument.body:i(e)&&v(e)?e:w(g(e))}function O(e,t){var o;void 0===t&&(t=[]);var r=w(e),i=r===(null==(o=e.ownerDocument)?void 0:o.body),a=n(r),s=i?[a].concat(a.visualViewport||[],v(r)?r:[]):r,c=t.concat(s);return i?c:c.concat(O(g(s)))}function S(e){return["table","td","th"].indexOf(p(e))>=0}function x(e){return i(e)&&"fixed"!==h(e).position?e.offsetParent:null}function _(e){for(var t=n(e),o=x(e);o&&S(o)&&"static"===h(o).position;)o=x(o);return o&&("html"===p(o)||"body"===p(o)&&"static"===h(o).position)?t:o||function(e){var t=-1!==navigator.userAgent.toLowerCase().indexOf("firefox");if(-1!==navigator.userAgent.indexOf("Trident")&&i(e)&&"fixed"===h(e).position)return null;for(var o=g(e);i(o)&&["html","body"].indexOf(p(o))<0;){var n=h(o);if("none"!==n.transform||"none"!==n.perspective||"paint"===n.contain||-1!==["transform","perspective"].indexOf(n.willChange)||t&&"filter"===n.willChange||t&&n.filter&&"none"!==n.filter)return o;o=o.parentNode}return null}(e)||t}var E="top",k="bottom",j="right",P="left",L="auto",A=[E,k,j,P],T="start",C="end",q="viewport",R="popper",D=A.reduce((function(e,t){return e.concat([t+"-"+T,t+"-"+C])}),[]),H=[].concat(A,[L]).reduce((function(e,t){return e.concat([t,t+"-"+T,t+"-"+C])}),[]),B=["beforeRead","read","afterRead","beforeMain","main","afterMain","beforeWrite","write","afterWrite"];function I(e){var t=new Map,o=new Set,n=[];function r(e){o.add(e.name),[].concat(e.requires||[],e.requiresIfExists||[]).forEach((function(e){if(!o.has(e)){var n=t.get(e);n&&r(n)}})),n.push(e)}return e.forEach((function(e){t.set(e.name,e)})),e.forEach((function(e){o.has(e.name)||r(e)})),n}var M={placement:"bottom",modifiers:[],strategy:"absolute"};function V(){for(var e=arguments.length,t=new Array(e),o=0;o<e;o++)t[o]=arguments[o];return!t.some((function(e){return!(e&&"function"==typeof e.getBoundingClientRect)}))}function W(e){void 0===e&&(e={});var t=e,o=t.defaultModifiers,n=void 0===o?[]:o,i=t.defaultOptions,a=void 0===i?M:i;return function(e,t,o){void 0===o&&(o=a);var i,s,c={placement:"bottom",orderedModifiers:[],options:Object.assign({},M,a),modifiersData:{},elements:{reference:e,popper:t},attributes:{},styles:{}},l=[],u=!1,f={state:c,setOptions:function(o){var i="function"==typeof o?o(c.options):o;p(),c.options=Object.assign({},a,c.options,i),c.scrollParents={reference:r(e)?O(e):e.contextElement?O(e.contextElement):[],popper:O(t)};var s,u,d=function(e){var t=I(e);return B.reduce((function(e,o){return e.concat(t.filter((function(e){return e.phase===o})))}),[])}((s=[].concat(n,c.options.modifiers),u=s.reduce((function(e,t){var o=e[t.name];return e[t.name]=o?Object.assign({},o,t,{options:Object.assign({},o.options,t.options),data:Object.assign({},o.data,t.data)}):t,e}),{}),Object.keys(u).map((function(e){return u[e]}))));return c.orderedModifiers=d.filter((function(e){return e.enabled})),c.orderedModifiers.forEach((function(e){var t=e.name,o=e.options,n=void 0===o?{}:o,r=e.effect;if("function"==typeof r){var i=r({state:c,name:t,instance:f,options:n});l.push(i||function(){})}})),f.update()},forceUpdate:function(){if(!u){var e=c.elements,t=e.reference,o=e.popper;if(V(t,o)){c.rects={reference:m(t,_(o),"fixed"===c.options.strategy),popper:b(o)},c.reset=!1,c.placement=c.options.placement,c.orderedModifiers.forEach((function(e){return c.modifiersData[e.name]=Object.assign({},e.data)}));for(var n=0;n<c.orderedModifiers.length;n++)if(!0!==c.reset){var r=c.orderedModifiers[n],i=r.fn,a=r.options,s=void 0===a?{}:a,l=r.name;"function"==typeof i&&(c=i({state:c,options:s,name:l,instance:f})||c)}else c.reset=!1,n=-1}}},update:(i=function(){return new Promise((function(e){f.forceUpdate(),e(c)}))},function(){return s||(s=new Promise((function(e){Promise.resolve().then((function(){s=void 0,e(i())}))}))),s}),destroy:function(){p(),u=!0}};if(!V(e,t))return f;function p(){l.forEach((function(e){return e()})),l=[]}return f.setOptions(o).then((function(e){!u&&o.onFirstUpdate&&o.onFirstUpdate(e)})),f}}var $={passive:!0};function N(e){return e.split("-")[0]}function Z(e){return e.split("-")[1]}function U(e){return["top","bottom"].indexOf(e)>=0?"x":"y"}function z(e){var t,o=e.reference,n=e.element,r=e.placement,i=r?N(r):null,a=r?Z(r):null,s=o.x+o.width/2-n.width/2,c=o.y+o.height/2-n.height/2;switch(i){case E:t={x:s,y:o.y-n.height};break;case k:t={x:s,y:o.y+o.height};break;case j:t={x:o.x+o.width,y:c};break;case P:t={x:o.x-n.width,y:c};break;default:t={x:o.x,y:o.y}}var l=i?U(i):null;if(null!=l){var u="y"===l?"height":"width";switch(a){case T:t[l]=t[l]-(o[u]/2-n[u]/2);break;case C:t[l]=t[l]+(o[u]/2-n[u]/2)}}return t}var F={top:"auto",right:"auto",bottom:"auto",left:"auto"};function X(e){var t,o=e.popper,r=e.popperRect,i=e.placement,a=e.variation,s=e.offsets,c=e.position,u=e.gpuAcceleration,f=e.adaptive,p=e.roundOffsets,y=e.isFixed,v=s.x,m=void 0===v?0:v,b=s.y,g=void 0===b?0:b,w="function"==typeof p?p({x:m,y:g}):{x:m,y:g};m=w.x,g=w.y;var O=s.hasOwnProperty("x"),S=s.hasOwnProperty("y"),x=P,L=E,A=window;if(f){var T=_(o),q="clientHeight",R="clientWidth";T===n(o)&&"static"!==h(T=d(o)).position&&"absolute"===c&&(q="scrollHeight",R="scrollWidth"),T=T,(i===E||(i===P||i===j)&&a===C)&&(L=k,g-=(y&&A.visualViewport?A.visualViewport.height:T[q])-r.height,g*=u?1:-1),i!==P&&(i!==E&&i!==k||a!==C)||(x=j,m-=(y&&A.visualViewport?A.visualViewport.width:T[R])-r.width,m*=u?1:-1)}var D,H=Object.assign({position:c},f&&F),B=!0===p?function(e){var t=e.x,o=e.y,n=window.devicePixelRatio||1;return{x:l(t*n)/n||0,y:l(o*n)/n||0}}({x:m,y:g}):{x:m,y:g};return m=B.x,g=B.y,u?Object.assign({},H,((D={})[L]=S?"0":"",D[x]=O?"0":"",D.transform=(A.devicePixelRatio||1)<=1?"translate("+m+"px, "+g+"px)":"translate3d("+m+"px, "+g+"px, 0)",D)):Object.assign({},H,((t={})[L]=S?g+"px":"",t[x]=O?m+"px":"",t.transform="",t))}var Y={left:"right",right:"left",bottom:"top",top:"bottom"};function G(e){return e.replace(/left|right|bottom|top/g,(function(e){return Y[e]}))}var J={start:"end",end:"start"};function K(e){return e.replace(/start|end/g,(function(e){return J[e]}))}function Q(e,t){var o=t.getRootNode&&t.getRootNode();if(e.contains(t))return!0;if(o&&a(o)){var n=t;do{if(n&&e.isSameNode(n))return!0;n=n.parentNode||n.host}while(n)}return!1}function ee(e){return Object.assign({},e,{left:e.x,top:e.y,right:e.x+e.width,bottom:e.y+e.height})}function te(e,t){return t===q?ee(function(e){var t=n(e),o=d(e),r=t.visualViewport,i=o.clientWidth,a=o.clientHeight,s=0,c=0;return r&&(i=r.width,a=r.height,/^((?!chrome|android).)*safari/i.test(navigator.userAgent)||(s=r.offsetLeft,c=r.offsetTop)),{width:i,height:a,x:s+y(e),y:c}}(e)):r(t)?function(e){var t=u(e);return t.top=t.top+e.clientTop,t.left=t.left+e.clientLeft,t.bottom=t.top+e.clientHeight,t.right=t.left+e.clientWidth,t.width=e.clientWidth,t.height=e.clientHeight,t.x=t.left,t.y=t.top,t}(t):ee(function(e){var t,o=d(e),n=f(e),r=null==(t=e.ownerDocument)?void 0:t.body,i=s(o.scrollWidth,o.clientWidth,r?r.scrollWidth:0,r?r.clientWidth:0),a=s(o.scrollHeight,o.clientHeight,r?r.scrollHeight:0,r?r.clientHeight:0),c=-n.scrollLeft+y(e),l=-n.scrollTop;return"rtl"===h(r||o).direction&&(c+=s(o.clientWidth,r?r.clientWidth:0)-i),{width:i,height:a,x:c,y:l}}(d(e)))}function oe(e){return Object.assign({},{top:0,right:0,bottom:0,left:0},e)}function ne(e,t){return t.reduce((function(t,o){return t[o]=e,t}),{})}function re(e,t){void 0===t&&(t={});var o=t,n=o.placement,a=void 0===n?e.placement:n,l=o.boundary,f=void 0===l?"clippingParents":l,y=o.rootBoundary,v=void 0===y?q:y,m=o.elementContext,b=void 0===m?R:m,w=o.altBoundary,S=void 0!==w&&w,x=o.padding,P=void 0===x?0:x,L=oe("number"!=typeof P?P:ne(P,A)),T=b===R?"reference":R,C=e.rects.popper,D=e.elements[S?T:b],H=function(e,t,o){var n="clippingParents"===t?function(e){var t=O(g(e)),o=["absolute","fixed"].indexOf(h(e).position)>=0&&i(e)?_(e):e;return r(o)?t.filter((function(e){return r(e)&&Q(e,o)&&"body"!==p(e)})):[]}(e):[].concat(t),a=[].concat(n,[o]),l=a[0],u=a.reduce((function(t,o){var n=te(e,o);return t.top=s(n.top,t.top),t.right=c(n.right,t.right),t.bottom=c(n.bottom,t.bottom),t.left=s(n.left,t.left),t}),te(e,l));return u.width=u.right-u.left,u.height=u.bottom-u.top,u.x=u.left,u.y=u.top,u}(r(D)?D:D.contextElement||d(e.elements.popper),f,v),B=u(e.elements.reference),I=z({reference:B,element:C,strategy:"absolute",placement:a}),M=ee(Object.assign({},C,I)),V=b===R?M:B,W={top:H.top-V.top+L.top,bottom:V.bottom-H.bottom+L.bottom,left:H.left-V.left+L.left,right:V.right-H.right+L.right},$=e.modifiersData.offset;if(b===R&&$){var N=$[a];Object.keys(W).forEach((function(e){var t=[j,k].indexOf(e)>=0?1:-1,o=[E,k].indexOf(e)>=0?"y":"x";W[e]+=N[o]*t}))}return W}function ie(e,t,o){return s(e,c(t,o))}function ae(e,t,o){return void 0===o&&(o={x:0,y:0}),{top:e.top-t.height-o.y,right:e.right-t.width+o.x,bottom:e.bottom-t.height+o.y,left:e.left-t.width-o.x}}function se(e){return[E,j,k,P].some((function(t){return e[t]>=0}))}var ce=W({defaultModifiers:[{name:"eventListeners",enabled:!0,phase:"write",fn:function(){},effect:function(e){var t=e.state,o=e.instance,r=e.options,i=r.scroll,a=void 0===i||i,s=r.resize,c=void 0===s||s,l=n(t.elements.popper),u=[].concat(t.scrollParents.reference,t.scrollParents.popper);return a&&u.forEach((function(e){e.addEventListener("scroll",o.update,$)})),c&&l.addEventListener("resize",o.update,$),function(){a&&u.forEach((function(e){e.removeEventListener("scroll",o.update,$)})),c&&l.removeEventListener("resize",o.update,$)}},data:{}},{name:"popperOffsets",enabled:!0,phase:"read",fn:function(e){var t=e.state,o=e.name;t.modifiersData[o]=z({reference:t.rects.reference,element:t.rects.popper,strategy:"absolute",placement:t.placement})},data:{}},{name:"computeStyles",enabled:!0,phase:"beforeWrite",fn:function(e){var t=e.state,o=e.options,n=o.gpuAcceleration,r=void 0===n||n,i=o.adaptive,a=void 0===i||i,s=o.roundOffsets,c=void 0===s||s,l={placement:N(t.placement),variation:Z(t.placement),popper:t.elements.popper,popperRect:t.rects.popper,gpuAcceleration:r,isFixed:"fixed"===t.options.strategy};null!=t.modifiersData.popperOffsets&&(t.styles.popper=Object.assign({},t.styles.popper,X(Object.assign({},l,{offsets:t.modifiersData.popperOffsets,position:t.options.strategy,adaptive:a,roundOffsets:c})))),null!=t.modifiersData.arrow&&(t.styles.arrow=Object.assign({},t.styles.arrow,X(Object.assign({},l,{offsets:t.modifiersData.arrow,position:"absolute",adaptive:!1,roundOffsets:c})))),t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-placement":t.placement})},data:{}},{name:"applyStyles",enabled:!0,phase:"write",fn:function(e){var t=e.state;Object.keys(t.elements).forEach((function(e){var o=t.styles[e]||{},n=t.attributes[e]||{},r=t.elements[e];i(r)&&p(r)&&(Object.assign(r.style,o),Object.keys(n).forEach((function(e){var t=n[e];!1===t?r.removeAttribute(e):r.setAttribute(e,!0===t?"":t)})))}))},effect:function(e){var t=e.state,o={popper:{position:t.options.strategy,left:"0",top:"0",margin:"0"},arrow:{position:"absolute"},reference:{}};return Object.assign(t.elements.popper.style,o.popper),t.styles=o,t.elements.arrow&&Object.assign(t.elements.arrow.style,o.arrow),function(){Object.keys(t.elements).forEach((function(e){var n=t.elements[e],r=t.attributes[e]||{},a=Object.keys(t.styles.hasOwnProperty(e)?t.styles[e]:o[e]).reduce((function(e,t){return e[t]="",e}),{});i(n)&&p(n)&&(Object.assign(n.style,a),Object.keys(r).forEach((function(e){n.removeAttribute(e)})))}))}},requires:["computeStyles"]},{name:"offset",enabled:!0,phase:"main",requires:["popperOffsets"],fn:function(e){var t=e.state,o=e.options,n=e.name,r=o.offset,i=void 0===r?[0,0]:r,a=H.reduce((function(e,o){return e[o]=function(e,t,o){var n=N(e),r=[P,E].indexOf(n)>=0?-1:1,i="function"==typeof o?o(Object.assign({},t,{placement:e})):o,a=i[0],s=i[1];return a=a||0,s=(s||0)*r,[P,j].indexOf(n)>=0?{x:s,y:a}:{x:a,y:s}}(o,t.rects,i),e}),{}),s=a[t.placement],c=s.x,l=s.y;null!=t.modifiersData.popperOffsets&&(t.modifiersData.popperOffsets.x+=c,t.modifiersData.popperOffsets.y+=l),t.modifiersData[n]=a}},{name:"flip",enabled:!0,phase:"main",fn:function(e){var t=e.state,o=e.options,n=e.name;if(!t.modifiersData[n]._skip){for(var r=o.mainAxis,i=void 0===r||r,a=o.altAxis,s=void 0===a||a,c=o.fallbackPlacements,l=o.padding,u=o.boundary,f=o.rootBoundary,p=o.altBoundary,d=o.flipVariations,y=void 0===d||d,h=o.allowedAutoPlacements,v=t.options.placement,m=N(v),b=c||(m!==v&&y?function(e){if(N(e)===L)return[];var t=G(e);return[K(e),t,K(t)]}(v):[G(v)]),g=[v].concat(b).reduce((function(e,o){return e.concat(N(o)===L?function(e,t){void 0===t&&(t={});var o=t,n=o.placement,r=o.boundary,i=o.rootBoundary,a=o.padding,s=o.flipVariations,c=o.allowedAutoPlacements,l=void 0===c?H:c,u=Z(n),f=u?s?D:D.filter((function(e){return Z(e)===u})):A,p=f.filter((function(e){return l.indexOf(e)>=0}));0===p.length&&(p=f);var d=p.reduce((function(t,o){return t[o]=re(e,{placement:o,boundary:r,rootBoundary:i,padding:a})[N(o)],t}),{});return Object.keys(d).sort((function(e,t){return d[e]-d[t]}))}(t,{placement:o,boundary:u,rootBoundary:f,padding:l,flipVariations:y,allowedAutoPlacements:h}):o)}),[]),w=t.rects.reference,O=t.rects.popper,S=new Map,x=!0,_=g[0],C=0;C<g.length;C++){var q=g[C],R=N(q),B=Z(q)===T,I=[E,k].indexOf(R)>=0,M=I?"width":"height",V=re(t,{placement:q,boundary:u,rootBoundary:f,altBoundary:p,padding:l}),W=I?B?j:P:B?k:E;w[M]>O[M]&&(W=G(W));var $=G(W),U=[];if(i&&U.push(V[R]<=0),s&&U.push(V[W]<=0,V[$]<=0),U.every((function(e){return e}))){_=q,x=!1;break}S.set(q,U)}if(x)for(var z=function(e){var t=g.find((function(t){var o=S.get(t);if(o)return o.slice(0,e).every((function(e){return e}))}));if(t)return _=t,"break"},F=y?3:1;F>0&&"break"!==z(F);F--);t.placement!==_&&(t.modifiersData[n]._skip=!0,t.placement=_,t.reset=!0)}},requiresIfExists:["offset"],data:{_skip:!1}},{name:"preventOverflow",enabled:!0,phase:"main",fn:function(e){var t=e.state,o=e.options,n=e.name,r=o.mainAxis,i=void 0===r||r,a=o.altAxis,l=void 0!==a&&a,u=o.boundary,f=o.rootBoundary,p=o.altBoundary,d=o.padding,y=o.tether,h=void 0===y||y,v=o.tetherOffset,m=void 0===v?0:v,g=re(t,{boundary:u,rootBoundary:f,padding:d,altBoundary:p}),w=N(t.placement),O=Z(t.placement),S=!O,x=U(w),L="x"===x?"y":"x",A=t.modifiersData.popperOffsets,C=t.rects.reference,q=t.rects.popper,R="function"==typeof m?m(Object.assign({},t.rects,{placement:t.placement})):m,D="number"==typeof R?{mainAxis:R,altAxis:R}:Object.assign({mainAxis:0,altAxis:0},R),H=t.modifiersData.offset?t.modifiersData.offset[t.placement]:null,B={x:0,y:0};if(A){if(i){var I,M="y"===x?E:P,V="y"===x?k:j,W="y"===x?"height":"width",$=A[x],z=$+g[M],F=$-g[V],X=h?-q[W]/2:0,Y=O===T?C[W]:q[W],G=O===T?-q[W]:-C[W],J=t.elements.arrow,K=h&&J?b(J):{width:0,height:0},Q=t.modifiersData["arrow#persistent"]?t.modifiersData["arrow#persistent"].padding:{top:0,right:0,bottom:0,left:0},ee=Q[M],te=Q[V],oe=ie(0,C[W],K[W]),ne=S?C[W]/2-X-oe-ee-D.mainAxis:Y-oe-ee-D.mainAxis,ae=S?-C[W]/2+X+oe+te+D.mainAxis:G+oe+te+D.mainAxis,se=t.elements.arrow&&_(t.elements.arrow),ce=se?"y"===x?se.clientTop||0:se.clientLeft||0:0,le=null!=(I=null==H?void 0:H[x])?I:0,ue=$+ae-le,fe=ie(h?c(z,$+ne-le-ce):z,$,h?s(F,ue):F);A[x]=fe,B[x]=fe-$}if(l){var pe,de="x"===x?E:P,ye="x"===x?k:j,he=A[L],ve="y"===L?"height":"width",me=he+g[de],be=he-g[ye],ge=-1!==[E,P].indexOf(w),we=null!=(pe=null==H?void 0:H[L])?pe:0,Oe=ge?me:he-C[ve]-q[ve]-we+D.altAxis,Se=ge?he+C[ve]+q[ve]-we-D.altAxis:be,xe=h&&ge?function(e,t,o){var n=ie(e,t,o);return n>o?o:n}(Oe,he,Se):ie(h?Oe:me,he,h?Se:be);A[L]=xe,B[L]=xe-he}t.modifiersData[n]=B}},requiresIfExists:["offset"]},{name:"arrow",enabled:!0,phase:"main",fn:function(e){var t,o=e.state,n=e.name,r=e.options,i=o.elements.arrow,a=o.modifiersData.popperOffsets,s=N(o.placement),c=U(s),l=[P,j].indexOf(s)>=0?"height":"width";if(i&&a){var u=function(e,t){return oe("number"!=typeof(e="function"==typeof e?e(Object.assign({},t.rects,{placement:t.placement})):e)?e:ne(e,A))}(r.padding,o),f=b(i),p="y"===c?E:P,d="y"===c?k:j,y=o.rects.reference[l]+o.rects.reference[c]-a[c]-o.rects.popper[l],h=a[c]-o.rects.reference[c],v=_(i),m=v?"y"===c?v.clientHeight||0:v.clientWidth||0:0,g=y/2-h/2,w=u[p],O=m-f[l]-u[d],S=m/2-f[l]/2+g,x=ie(w,S,O),L=c;o.modifiersData[n]=((t={})[L]=x,t.centerOffset=x-S,t)}},effect:function(e){var t=e.state,o=e.options.element,n=void 0===o?"[data-popper-arrow]":o;null!=n&&("string"!=typeof n||(n=t.elements.popper.querySelector(n)))&&Q(t.elements.popper,n)&&(t.elements.arrow=n)},requires:["popperOffsets"],requiresIfExists:["preventOverflow"]},{name:"hide",enabled:!0,phase:"main",requiresIfExists:["preventOverflow"],fn:function(e){var t=e.state,o=e.name,n=t.rects.reference,r=t.rects.popper,i=t.modifiersData.preventOverflow,a=re(t,{elementContext:"reference"}),s=re(t,{altBoundary:!0}),c=ae(a,n),l=ae(s,r,i),u=se(c),f=se(l);t.modifiersData[o]={referenceClippingOffsets:c,popperEscapeOffsets:l,isReferenceHidden:u,hasPopperEscaped:f},t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-reference-hidden":u,"data-popper-escaped":f})}}]})}},t={};function o(n){var r=t[n];if(void 0!==r)return r.exports;var i=t[n]={exports:{}};return e[n](i,i.exports,o),i.exports}o.d=(e,t)=>{for(var n in t)o.o(t,n)&&!o.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},o.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),o.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})};var n={};return o.r(n),o(661),o(795),o(682),o(284),o(181),o(778),o(51),o(185),n})()}));

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
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*******************************************!*\
  !*** ./resources/assets/public/js/app.js ***!
  \*******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var alpinejs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! alpinejs */ "./node_modules/alpinejs/dist/module.esm.js");
/* harmony import */ var flowbite__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! flowbite */ "./node_modules/flowbite/dist/flowbite.js");
/* harmony import */ var flowbite__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(flowbite__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var preline__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! preline */ "./node_modules/preline/dist/preline.js");
/* harmony import */ var preline__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(preline__WEBPACK_IMPORTED_MODULE_2__);



window.Alpine = alpinejs__WEBPACK_IMPORTED_MODULE_0__["default"];
alpinejs__WEBPACK_IMPORTED_MODULE_0__["default"].start();
})();

/******/ })()
;
//# sourceMappingURL=app.js.map