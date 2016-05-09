materialAdmin

    .service('pitchService', ['$http', function($http){
      this.getPitches = function(){
        return $http({
          method: 'get',
          url: '/pitches'
        });
      };
    }]);