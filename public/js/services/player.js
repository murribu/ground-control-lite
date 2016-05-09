materialAdmin

    .service('playerService', ['$http', function($http){
        this.getPlayers = function() {
            return $http({
                method: 'get',
                url: "/players"
              });
        };
        
        this.getPlayer = function(id) {
            return $http({
                method: 'get',
                url: "/player/" + id
              });
        };
        
        this.getBatter = function(q){
            return $http({
                method: 'get',
                url: "/players/batters?q=" + q
            });
        };
        
        this.getPitcher = function(q){
            return $http({
                method: 'get',
                url: "/players/pitchers?q=" + q
            });
        };
    }])