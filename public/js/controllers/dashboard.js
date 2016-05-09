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
        
        self.modals = {
          autoplay:true,
          init:function(){
            $(document).mouseup(function (e){
              if($('.videoPlayer').is(':visible')){
                var container = $(".videoPlayer");

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                  container.dialog("close");
                  $('#overlay').fadeOut(1500);
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