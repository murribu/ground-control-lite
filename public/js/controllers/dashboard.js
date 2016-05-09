materialAdmin
    .controller('dashboardCtrl', function($scope, $timeout, playerService, pitchService) {
        var self = this;
        self.filters = {
          'selectedPitcher': null,
        };
        self.batters = [];
        self.pitchers = [];
        self.pitches = [];
        
        pitchService.getPitches().then(function(d){
          self.pitches = d.data;
        });
    
        self.resetPitcher = function(){
            self.filters.selectedPitcher = null;
        }
        
        self.resetBatter = function(){
            self.filters.selectedBatter = null;
        }
        
        self.refreshBatters = function(search){
            playerService.getBatter(search).then(function(d){
                self.batters = d.data.items;
            });
        };
    
        self.refreshPitchers = function(search){
            playerService.getPitcher(search).then(function(d){
                self.pitchers = d.data.items;
            });
        };
        
    });