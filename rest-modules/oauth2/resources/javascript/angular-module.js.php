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
	])
		.config([
			'$httpProvider',
			function($httpProvider){
				$httpProvider.interceptors.push('oauth2HttpInterceptor');
			}
		])

		.provider('oauth2Service', [
			function(){
				var local = {
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
						angular.extend(local.client, client);

						return provider;
					},
					'setStorage': function(storage){
						storageInjector = storage;

						return provider;
					},
					'$get': [
						'$q', '$injector', '$ldrvn', 'oauth2ConfigLoader',
						function($q, $injector, $ldrvn, oauth2ConfigLoader){
							local.storage = $injector.invoke(storageInjector, GLOBALOBJECT);

							return $ldrvn.createService(oauth2ConfigLoader, {
								'token': function(data, config){
									if(angular.isUndefined(local.client.client_id)) return $q.reject(new Error('Client is not defined'));

									config = config || {};
									if(angular.isUndefined(config.headers)) config.headers = {};
									config._bypassToken = true;
									config.headers['Authorization'] = 'Basic ' + btoa(local.client.client_id + ':' + ((local.client.secret)? local.client.secret : ''));
									angular.extend(data, local.client);

									return local.tokenHandler = this.promise.then(function(service){
										return service.$$configService.$send('token', data, config)
											.then(
												function(model){
													angular.forEach(model, function(value, key){
														if(key === 'expires_in'){
															local.storage.prop('expires', Date.now() + ((value - 60) * 1000));
														} else{
															local.storage.prop(key, value);
														}
													});

													return model;
												},
												function(model){
													local.storage.clear();
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
								'loginPage': function(data){
									return this.promise.then(function(service){
										return service.$$configService.$link('login-page').href;
									});
								},
								'preRequest': function(config){
									var service = this;
									if(config._bypassToken) return config;

									return $q.when(local.tokenHandler)
										.then(function(){
											if(!(parseInt(local.storage.prop('expires')) > Date.now()) && local.storage.prop('refresh_token')){
												return service.token({
													'grant_type': 'refresh_token',
													'refresh_token': local.storage.prop('refresh_token'),
												});
											}
										})
										.then(
											function(){
												if(local.storage.prop('access_token')){
													if(angular.isUndefined(config.headers)) config.headers = {};
													config.headers['Authorization'] = local.storage.prop('token_type') + ' ' + local.storage.prop('access_token');
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
			'$log', '$injector',
			function($log, $injector){
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
})(this, this.angular);
