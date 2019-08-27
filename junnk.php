
                                            <script>
                                            $(function() {
                                              $( "#draggable<?= $row['id']?>-<?= $column['scheduledate']?>" ).draggable({
                                                  containment:\'parent\',axis:\'x\',
                                                  grid: [51.5,51.5],
                                                  start: function(){
                                                    var offset = $(this).offset();
                                                    var xPos = offset.left;
                                                    $(\'#posX\').text(xPos);
                                                  },
                                                  stop: function(){
                                                    var offsetstop = $(this).offset();
                                                    var stopPos = offsetstop.left;
                                                    $(\'#posXstop\').text(stopPos);
                                                    var posX = document.getElementById("posX"); 
                                                    var startPos = posX.innerHTML;
                                                    var travel1 = parseInt(stopPos.valueOf(),10);
                                                    var travel2 = parseInt(startPos.valueOf(),10);
                                                    travel = travel1 - travel2;
                                                    $("#travel").text(travel);
                                                    dayChange = parseInt(travel/51);            // compute new date after drag
                                                    var theDate = new Date("<?= $column['scheduledate']?>");
                                                    theDate.setDate(theDate.getDate() + (dayChange + 1));
                                                    var y = theDate.getFullYear(),
                                                        m = theDate.getMonth() + 1,
                                                        d = theDate.getDate();
                                                    var pad = function(val) { var str = val.toString(); return (str.length < 2) ? "0" + str : str};
                                                    dateString = [y, pad(m), pad(d)].join("-");
                                                    reloadContent("<?= $column['id'] ?>",dateString);
                                                  }
                                              });
                                            });
                                            </script>
                
