<html>
<head>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<style>
    #dragThis {
        width: 6em;
        height: 6em;
        padding: 0.5em;
        border: 3px solid #ccc;
        border-radius: 0 1em 1em 1em;
    }
</style>
</head>
<body>
<script>

        $(function() {
            $('#dragThis').draggable(
                {
                    drag: function(){
                        var offset = $(this).offset();
                        var xPos = offset.left;
                        $('#posX').text('x: ' + xPos);
                    }
                });
            });
</script>

<div id="dragThis">
    <ul>
        <li id="posX"></li>
    </ul>
</div>
</body>
</html>