var app = angular.module('myApp', ['ngRoute', 'datatables', 'toaster']);
app.factory("services", ['$http','toaster', function($http) {
  var serviceBase = 'services/'
    var obj = {};
  
    obj.getCharacters = function(){
        return $http.get(serviceBase + 'characters');
    }
    obj.getCharacter = function(characterID){
        return $http.get(serviceBase + 'character?id=' + characterID);
    }
    obj.insertCharacter = function (character,toaster) {
        return $http.post(serviceBase + 'insertCharacter', character).then(
            function (response) {
                //toaster.pop('success', "El personaje fue creado con éxito", "");
                console.log('response',response);
                return response;
                
            },function(err){
                console.error('Error',err);
                //toaster.pop('error', "Error: No se pudo crear el personaje.", "");
                return err;
                
            });
    };
   
    return obj;   
}]);

// CONTROLLER LIST AND INSERT
app.controller('listCharactersCtrl', function ($scope, $rootScope, services, $location, toaster) {
    
    $scope.images = [];
    
    services.getCharacters().then(function(data){
        console.log('data',data);
        $scope.characters = data.data;   
        $scope.characters.forEach(function(character){
             $scope.images.push(character.imagen);
        });
    });
    
    $rootScope.title = 'Nuevo personaje';

    $scope.saveCharacter = function (character) {
        console.log('inserted');
        services.insertCharacter(character);
        alert('Datos insertados correctamente');
        toaster.pop('success', "El personaje fue creado con éxito", "text");
        $location.path('/');  
    };
    
});

// ROUTE PROVIDER
app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider
            .when('/', {
                title: '/characters',
                templateUrl: 'partials/characters.html',
                controller: 'listCharactersCtrl'
            })
            .when('/edit-character/:characterID', {  // Add characterID in route for possibility of editing character in the future
                title: 'Insertar personaje',
                templateUrl: 'partials/edit-character.html',
                controller: 'listCharactersCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
}]);

app.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
    });
}]);