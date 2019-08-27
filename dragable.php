<?php



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">  
    <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <style>body { background:#fff; font-family:"Helvetica Neue",Helvetica,Arial,sans-serif; }</style>
</head>
 
<body>
<br><br><br><br><br><br>

    <div class="container">
      

        <style>
        #draggable1 { width: 40px; height: 40px; padding: 0em; background:red }
        #draggable2 { width: 40px; height: 40px; padding: 0em; background:red }
        #draggable3 { width: 40px; height: 40px; padding: 0em; background:red }
        #dragThisab {
            width: 6em;
            height: 6em;
            padding: 0.5em;
            border: 3px solid #ccc;
            border-radius: 0 1em 1em 1em;
        }
        </style>
        <script>
        $(function() {$( "#dragThisab").draggable({containment: "parent", grid: [40,40],drag: function(){var offset = $(this).offset();var xPos = offset.left;$('#posX').text('x: ' + xPos);}});}); 
        $(function() {$( "#draggable1" ).draggable({containment: "parent", grid: [40,40],drag: function(){var offset = $(this).offset();var xPos = offset.left;$('#posX').text('x: ' + xPos);}});});
        $(function() {$( "#draggable2" ).draggable({containment: "parent",grid: [40,40]});});
        $(function() {$( "#draggable3" ).draggable({containment: "parent",grid: [40,40]});});
        </script>



      <div class="demo">
      <div>
          <div id="draggable1" class="ui-widget-content">
            <p>Drag</p>
          </div>
      </div>
      <div>
          <div id="draggable2" class="ui-widget-content">
            <p>Drag</p>
          </div>
      </div>
      <div>
          <div id="draggable3" class="ui-widget-content">
            <p>Drag</p>
          </div>
      </div>
      </div><!-- End demo -->


<div id="results"></div>
    </div>
<div>
  <div id="dragThisab">
  </div>
</div>
<div id="posX"></div>
</body>
</html>