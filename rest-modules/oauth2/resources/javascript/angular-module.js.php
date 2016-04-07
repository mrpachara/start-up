<?php
	if(!defined("RESTCONFIGURATED")){
		header(((isset($_SERVER['SERVER_PROTOCOL']))? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0')." 404 Not Found");
		exit;
	}
?>
(function(GLOBALOBJECT, angular){
	'use strict';

	angular.module(<?= json_encode($config->linkProp('angular-module', 'module-id')) ?>, [
		'ldrvn', 'ldrvn.service', 'ngComponentRouter',
		'util',
	])
		.config([
			'$httpProvider',
			function($httpProvider){
				$httpProvider.interceptors.push('oauth2HttpInterceptor');
			}
		])

		.run([
			function(){

			}
		])

		.provider('oauth2Service', [
			function(){
				var localProvider = {
					'client': {},
					'storage': null,
					'tokenHandler': null,
				};

				var storageInjector = [function(){
					var data = {};
					return {
						'prop': function(name, value){
							if(arguments.length === 2){
								data[name] = value;
							} else{
								return data[name];
							}
						},
						'remove': function(name){
							if(name in data){
								delete data[name];

								return true;
							} else{
								return false;
							}
						},
						'clear': function(){
							data = {};
						},
					};
				}];

				var provider = this;

				angular.extend(provider, {
					'setClient': function(client){
						angular.extend(localProvider.client, client);

						return provider;
					},
					'setStorage': function(storage){
						storageInjector = storage;

						return provider;
					},
					'$get': [
						'$q', '$injector', '$ldrvn', 'oauth2ConfigLoader',
						function($q, $injector, $ldrvn, oauth2ConfigLoader){
							localProvider.storage = $injector.invoke(storageInjector, GLOBALOBJECT);

							function refreshToken(service){
								if(!(parseInt(localProvider.storage.prop('expires')) > Date.now()) && localProvider.storage.prop('refresh_token')){
									return service.token({
										'grant_type': 'refresh_token',
										'refresh_token': localProvider.storage.prop('refresh_token'),
									});
								}
							}

							return $ldrvn.createService(oauth2ConfigLoader, {
								'token': function(data, config){
									if(angular.isUndefined(localProvider.client.client_id)) return $q.reject(new Error('Client is not defined'));

									config = config || {};
									if(angular.isUndefined(config.headers)) config.headers = {};
									config._bypassToken = true;
									config.headers['Authorization'] = 'Basic ' + btoa(localProvider.client.client_id + ':' + ((localProvider.client.secret)? localProvider.client.secret : ''));
									//angular.extend(data, localProvider.client);

									return localProvider.tokenHandler = this.promise.then(function(service){
										return service.$$configService.$send('token', data, config)
											.then(
												function(model){
													angular.forEach(model, function(value, key){
														if(key === 'expires_in'){
															localProvider.storage.prop('expires', Date.now() + ((value - 60) * 1000));
														} else{
															localProvider.storage.prop(key, value);
														}
													});

													return model;
												},
												function(model){
													localProvider.storage.clear();
													return $q.reject(model);
												}
											)
										;
									});
								},
								'info': function(){
									return this.promise.then(function(service){
										return service.$$configService.$load('tokeninfo');
									});
								},
								'loginPageUrl': function(data){
									var service = this;

									if(angular.isUndefined(service.$$configService)) return null;

									return service.$$configService.$link('login-page').href;
								},
								'preRequest': function(config){
									var service = this;

									if(config._bypassToken || config._public) return config;

									return ((localProvider.tokenHandler !== null)? localProvider.tokenHandler.then(function(){return service}).then(refreshToken) : $q.when(refreshToken(service)))
										.then(
											function(){
												if(localProvider.storage.prop('access_token')){
													if(angular.isUndefined(config.headers)) config.headers = {};
													config.headers['Authorization'] = localProvider.storage.prop('token_type') + ' ' + localProvider.storage.prop('access_token');
												}

												return config;
											},
											function(){
												return config;
											}
										)
									;
								},
							});
						}
					],
				});
			}
		])

		.factory('oauth2ConfigLoader', [
			'$ldrvn',
			function($ldrvn){
				return $ldrvn.loadConfig(<?= json_encode($GLOBALS['_rest']->getConfigUri()) ?>);
			}
		])

		.factory('oauth2HttpInterceptor', [
			'$injector', '$log',
			function($injector, $log){
				return {
					'request': function(config){
						try{
							var oauth2Service = $injector.get('oauth2Service');
							return oauth2Service.preRequest(config);
						} catch(excp){
							$log.error(excp);
							return config;
						}
					},
				};
			}
		])
	;
})(this, angular);
