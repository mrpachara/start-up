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

		.run([
			'$rootRouter',
			function($rootRouter){
				/*
				$rootRouter.config([
					{'path': '/oauth2/token', 'name': 'OAuth2 Token', 'component': 'oauth2token'},
					{'path': '/oauth2/tokeninfo', 'name': 'OAuth2 Info', 'component': 'oauth2tokeninfo'},
					{'path': '/oauth2/jwttoken', 'name': 'OAuth2 JWT Token', 'component': 'oauth2jwttoken'},
				]);
				*/
			}
		])

		.provider('oauth2ServiceProvider', [
			function(){
				var local = {
					'client': {},
					'storage': null,
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

				var provider = {
					'setClient': function(client){
						angular.extend(local.client, client);

						return provider;
					},
					'setStorage': function(storage){
						storageInjector = storage;

						return provider;
					},
					'$get': [
						'$q', '$injector', '$ldrvn', 'service01ConfigLoader',
						function($q, $ldrvn, service01ConfigLoader){
							local.storage = $injector.invoke(storageInjector, GLOBALOBJECT);

							return $ldrvn.createService(service01ConfigLoader, {
								'token': function(data, config){
									var service = this;
									if(angular.isUndefined(service.$$configService)) return $q.reject(new Error('Service is not ready'));
									if(angular.isUndefined(local.client.client_id)) return $q.reject(new Error('Client is not defined'));

									config = config || {};
									if(angular.isUndefined(config.headers)) config.headers = {};
									config._bypassToken = true;
									config.headers['Authorization'] = 'Basic ' + btoa(local.client.client_id + ':' + ((local.client.secret)? local.client.secret : ''));
									angular.extend(data, local.client);

									return service.$$configService.$send('token', data, config).then(function(model){
										angular.forEach(model, function(value, key){
											if(key === 'expires_in'){
												local.storage.prop('expires', Date.now() + ((data.expires_in - 60) * 1000));
											} else{
												local.storage.prop(key, value);
											}
										});

										return model;
									});
								},
								'info': function(data){
									var service = this;
									if(angular.isUndefined(service.$$configService)) return $q.reject(new Error('Service is not ready'));

									return service.$$configService.$load('tokeninfo');
								},
								'preRequest': function(config){
									var service = this;
									if(angular.isUndefined(service.$$configService)) return config;
									if(config._bypassToken) return config;

									if(angular.isDefined(local.storage.prop('access_token')) && (parseInt(local.storage.prop('expires')) > Date.now())){
										if(angular.isUndefined(config.headers)) config.headers = {};
										config.headers['Authorization'] = local.storage.prop('token_type') + ' ' + local.storage.prop('access_token');

										return config;
									} else{
										local.storage.remove('access_token');
										local.storage.remove('expires');
									}

									if(angular.isDefined(local.storage.prop('refresh_token'))){
										return service.token({
											'grant_type': 'refresh_token',
											'refresh_token': local.storage.prop('refresh_token'),
										}).then(
											function(){
												return config;
											},
											function(){
												local.storage.clear();
												return config;
											}
										);
									}

									return config;
								},
							});
						}
					],
				};

				return provider;
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
