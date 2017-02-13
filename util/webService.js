/**
 * Created by xiangwang on 11/28/16.
 */
(function () {
    'use strict';

    /**
     * Config：
     */
    var MODULE_NAME = 'webService';

    angular.module(MODULE_NAME, [])
        .provider('WebService', function () {
            var WebServiceProvider = this;
            var authTokenKey = "DEFAULT_TOKEN";
            var serverBaseUrl = "";
            var error = {
                UNKNOWN_SERVER_error: "Unknown server error, maybe corrupted data received",
                CREDENTIALS_EXPIRED: "Your credential has expired, please login"
            };

            WebServiceProvider.setAuthTokenKey = function (key) {
                authTokenKey = key;
            };

            WebServiceProvider.setServerBaseUrl = function (url) {
                serverBaseUrl = url;
            };

            WebServiceProvider.setUnknownServerError = function (info) {
                error.UNKNOWN_SERVER_error = info;
            };

            WebServiceProvider.setCredentialsExpiredError = function (info) {
                error.CREDENTIALS_EXPIRED = info;
            };

            WebServiceProvider.$get = ['$q', '$http', '$httpParamSerializer', function ($q, $http, $httpParamSerializer) {
                return new WebService($q, $http, $httpParamSerializer, authTokenKey, serverBaseUrl, error);
            }];
        });

    WebService.$inject = ['$q', '$http', '$httpParamSerializer'];
    /* @ngInject */
    function WebService($q, $http, $httpParamSerializer, authTokenKey, serverBaseUrl, error) {
        var WebService = this;


        WebService.ajaxHttpRequestToServer = ajaxHttpRequestToServer;
        WebService.nonAjaxHttpRequestToServer = nonAjaxHttpRequestToServer;

        WebService.updateCachedData = updateCachedData;
        WebService.getCachedData = getCachedData;
        WebService.getCachedCredentials = getCachedCredentials;

        WebService.validateToken = validateToken;
        WebService.loadAuthTokenFromStorage = loadAuthTokenFromStorage;
        WebService.saveAuthTokenToStorage = saveAuthTokenToStorage;
        WebService.removeAuthTokenFromStorage = removeAuthTokenFromStorage;

        WebService.subscribeToListeners = subscribeToListeners;
        WebService.unsubscribeToListeners = unsubscribeToListeners;
        WebService.notifyListeners = notifyListeners;

        ////////////////
        var cachedDataListeners = [];
        var cachedData = {};

        activate();

        function activate() {
            var cachedToken = loadAuthTokenFromStorage();
            if (!validateToken(cachedToken)) {
                removeAuthTokenFromStorage();
            }
        }

        /**
         * Subscribe input listener to cached data listener list
         * @param listener The target controller
         * @returns {boolean} true if success, otherwise false
         */
        function subscribeToListeners(listener) {
            if (cachedDataListeners.indexOf(listener) == -1) {
                cachedDataListeners.push(listener);
                if (cachedData) {
                    listener(cachedData);
                }
                return true;
            }
            return false;
        }

        /**
         * Unsubscribe input listener to cached data listener list
         * @param listener The target controller
         * @returns {boolean} true if success, otherwise false
         */
        function unsubscribeToListeners(listener) {
            var index = cachedDataListeners.indexOf(listener);
            if (index != -1) {
                cachedDataListeners.splice(index, 1);
                return true;
            }
            return false;
        }

        /**
         * Notify listeners with the latest data
         *
         * @param data
         */
        function notifyListeners(data) {
            angular.forEach(cachedDataListeners, function (listener) {
                listener(data);
            });
        }

        /**
         * Update the cached data and notify listeners
         *
         * @param data
         */
        function updateCachedData(data) {
            cachedData = data;
            notifyListeners(cachedData);
        }

        /**
         * Get cached data
         * @returns {null}
         */
        function getCachedData() {
            return cachedData;
        }

        /**
         * Get cached credentials
         *
         * @returns {null}
         */
        function getCachedCredentials() {
            return validateToken(loadAuthTokenFromStorage());
        }

        /**
         * non-AJAX request method without authentication header, mostly used for export
         * note: this does not support file object
         * if authentication needed, please add to the payload instead
         * json key-value pair payload will be transform to form format, where array will be transformed to
         * multiple key-value pairs with key formatted as "key[]" and value is one of the array's element; while object
         * will be transformed to json string
         *
         * @param payload form data
         * @param target form target attribute, default to '_self'
         * @param method form method attribute, default to POST
         */
        function nonAjaxHttpRequestToServer(payload, target, method) {
            var form = document.createElement("form");
            form.action = serverBaseUrl;
            form.method = method ? method : 'POST';
            form.target = target || "_self";
            if (payload) {
                for (var key in payload) {
                    var value = payload[key];
                    if (Array.isArray(value)) {
                        var keyName = key + '[]';
                        for (var index in value) {
                            var textArea = document.createElement("textarea");
                            textArea.name = keyName;
                            textArea.value = typeof value[index] === "object" ? JSON.stringify(value[index]) : value[index];
                            form.appendChild(textArea);
                        }
                    } else {
                        var textArea = document.createElement("textarea");
                        textArea.name = key;
                        textArea.value = typeof value === "object" ? JSON.stringify(value) : value;
                        form.appendChild(textArea);
                    }
                }
            }
            form.style.display = 'none';
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        /**
         * Generalized ajax request method which transform json payload to multipart-form format or url-encoded format,
         * 1. If url-encoded format is used, only one layer of json is supported,
         * 2. If multipart-form format is used, the value can be array or object: where array will be transformed to
         * multiple key-value pairs with key formatted as "key[]" and value is one of the array's element; while object
         * will be transformed to json string
         *
         * @param payload the payload to post, must conform to json format
         * @param tokenNeeded whether the JWT token is needed or not
         * @param isMultipartForm transform request to multipart-form or url-encoded, default to false
         * @param method the http request method (POST, GET etc.), default to POST
         * @returns {Promise} the promise for external code to handle call back response
         */
        function ajaxHttpRequestToServer(payload, tokenNeeded, isMultipartForm, method) {
            if (typeof payload != 'object') {
                throw "The payload data must be in json format";
            }
            var deferred = $q.defer();
            delete $http.defaults.headers.common.Authorization;
            if (tokenNeeded) {
                var cachedToken = loadAuthTokenFromStorage();
                if (!validateToken(cachedToken)) {
                    deferred.reject(error.CREDENTIALS_EXPIRED);
                    return deferred.promise;
                }
                $http.defaults.headers.common.Authorization = 'Authorization ' + cachedToken;
            }

            /*
             Provide different transform request and content type based on whether multi-part form flag is set
             */
            var transformRequest;
            var contentType;
            if (typeof isMultipartForm == 'undefined' || !isMultipartForm) {
                transformRequest = function (data) {
                    return $httpParamSerializer(data);
                };
                contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
            } else {
                transformRequest = function (data, headersGetter) {
                    var formData = new FormData();
                    angular.forEach(data, function (value, key) {
                        if (Array.isArray(value)) {
                            for (var index in value) {
                                if (value[index] instanceof File || typeof value[index] != 'object') {
                                    formData.append(key + '[]', value[index]);
                                } else {
                                    formData.append(key + '[]', JSON.stringify(value[index]));
                                }
                            }
                        } else if (typeof value == 'object') {
                            if (value instanceof File) {
                                formData.append(key, value);
                            } else {
                                formData.append(key, JSON.stringify(value));
                            }
                        } else {
                            formData.append(key, value);
                        }
                    });
                    // for (var pair of formData.entries()) {
                    //     console.log(pair[0]+ ', ' + pair[1]);
                    // }
                    var headers = headersGetter();
                    delete headers['Content-Type'];
                    return formData;
                };
                contentType = undefined;
            }
            $http({
                method: method || "POST",
                url: serverBaseUrl,
                data: payload,
                headers: {
                    'Content-Type': contentType
                },
                transformRequest: transformRequest
            }).then(
                function successCallback(response) {
                    deferred.resolve(response.data);
                },
                function errorCallbackfunction(response) {
                    if (!response.data || response.status == 500) {
                        deferred.reject(error.UNKNOWN_SERVER_error);
                    } else {
                        deferred.reject(response.data);
                    }
                });
            return deferred.promise;
        }

        /**
         * Parse and check if the input token does not expire
         * @param token the token to parse
         * @returns null if failed, otherwise return the credentials
         */
        function validateToken(token) {
            if (token) {
                try {
                    var arr = token.split(".");
                    var credentials = JSON.parse(atob(arr[1]));
                    if (credentials && (credentials.exp > new Date().getTime() / 1000)) {
                        return credentials;
                    } else {
                        removeAuthTokenFromStorage();
                    }
                } catch (err) {
                    return null;
                }
            }
            return null
        }

        // Mark: Local storage utility functions, subject to changes
        function loadAuthTokenFromStorage() {
            return localStorage.getItem(authTokenKey);
        }

        function saveAuthTokenToStorage(token) {
            localStorage.setItem(authTokenKey, token);
        }

        function removeAuthTokenFromStorage() {
            localStorage.removeItem(authTokenKey);
        }
    }
})();

