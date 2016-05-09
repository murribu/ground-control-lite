materialAdmin
    .controller('dashboardCtrl', function($scope, $timeout, playerService, pitchService) {
        var self = this;
        self.filters = {
          'selectedPitchers': [],
          'selectedBatters': [],
        };
        self.batters = [];
        self.pitchers = [];
        self.pitches = [];
        self.selectedInning = 1;
        self.selectedSide = 'top';
        
        pitchService.getPitches().then(function(d){
          self.pitches = d.data;
        });
    
        self.showInnings = function(){
          if (self.filters.selectedPitchers.length == 0 && self.filters.selectedBatters.length == 0){
            return true;
          }
        }
    
        self.filterPitches = function(){
          return function(p){
            if (self.showInnings()){
              if (p.plate_appearance.inning != self.selectedInning){
                return false;
              }
              if (p.plate_appearance.side != self.selectedSide){
                return false;
              }
            }
            if (self.filters.selectedPitchers.length > 0){
              for(var pitcher in self.filters.selectedPitchers){
                if (self.filters.selectedPitchers[pitcher].id == p.plate_appearance.pitcher.pl_key){
                  return true;
                }
              }
              return false;
            }
            if (self.filters.selectedBatters.length > 0){
              for(var batter in self.filters.selectedBatters){
                if (self.filters.selectedBatters[batter].id == p.plate_appearance.batter.pl_key){
                  return true;
                }
              }
              return false;
            }
            return true;
          };
        };
    
        self.showVideo = function(id){
          $(".videoPlayer").dialog({
             width: 576,
             height: 324,
             autoOpen: false,
             resizable: false,
             show: {
              effect: 'fade', 
              duration: 300
             },
             hide: {
              effect: "fade",
              duration: 300
             }
          });
          
          $('#videoPlayer_' + id).dialog("open");
          $('#videoPlayer_' + id)[0].play();
          $('#overlay').fadeIn();
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
        
        self.range = function(min,max,step){
            step = step || 1;
            var input = [];
            
            for (var i = min; i <= max; i += step){
                input.push(i);
            }
            return input;
        };
        
        self.modals = {
          autoplay:true,
          init:function(){
            $(document).mouseup(function (e){
              if($('.videoPlayer').is(':visible')){
                var container = $(".videoPlayer");

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                  container.dialog("close");
                  $('#overlay').fadeOut(300);
                  $('video').each(function() {
                    $(this)[0].pause();
                  });
                }
              }
            });
          }
        };
        
        self.modals.init();
        
    });