var ajaxGraph,   
    series_data = [],
    palette = new Rickshaw.Color.Palette();

$.get('names.php', function(d) {
  d.forEach(function(s){
    series_data.push({
      name: s,
      color: palette.color(s)
    });
  });

  var helpers = false;
  ajaxGraph = new Rickshaw.Graph.Ajax({
    element: document.getElementById("chart"),
    width: 900,
    height: 500,
    renderer: 'bar',
    dataURL: 'data.php',
    series: series_data,
    onData: function(d){
      Rickshaw.Series.zeroFill(d);
      console.log(d);
      return d;
    },
    onComplete: function(transport){
      var graph = transport.graph;  

      if(!helpers){
        helpers = true;

        var legend = new Rickshaw.Graph.Legend( {
          graph: graph,
          element: document.getElementById('legend')
        });

       var shelving = new Rickshaw.Graph.Behavior.Series.Toggle( {
          graph: graph,
          legend: legend
        });
       
        var order = new Rickshaw.Graph.Behavior.Series.Order( {
          graph: graph,
          legend: legend
        });

        var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight( {
          graph: graph,
          legend: legend
        });        

        /* graph classes */
      
        var hoverDetail = new Rickshaw.Graph.HoverDetail( {
          graph: graph,
          formatter: function(series, x, y) {
            var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
            var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
            var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
            return content;
          }
        });

        var slider = new Rickshaw.Graph.RangeSlider( {
          graph: graph,
          element: $('#slider')
        });       

        var smoother = new Rickshaw.Graph.Smoother( {
          graph: graph,
          element: $('#smoother')
        });  

        var xAxis = new Rickshaw.Graph.Axis.Time( {
          graph: graph,
          ticksTreatment: 'glow'
        });
        xAxis.render();
      
        var yAxis = new Rickshaw.Graph.Axis.Y( {
          graph: graph,
          tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
          ticksTreatment: 'glow'
        });
        yAxis.render();

        var annotator = new Rickshaw.Graph.Annotate( {
          graph: graph,
          element: document.getElementById('timeline')
        });
        
        var controls = new RenderControls( {
          element: document.querySelector('form'),
          graph: graph
        });     
      } 
    }
  });  

},'json');
setInterval(function(){
  ajaxGraph.request(); 
},60000);

$(document).ready(function(){
  $('#date').change(function(){
    console.log(this.value);
    if(this.value!=''){
      ajaxGraph.dataURL = 'data.php?date='+this.value;
    }
    else{
      ajaxGraph.dataURL = 'data.php';
    }
    ajaxGraph.request();
  });

  $('body').ajaxStart(function(){
    $('#throbber').show();
  }).ajaxStop(function(){
    $('#throbber').hide();
  });
});