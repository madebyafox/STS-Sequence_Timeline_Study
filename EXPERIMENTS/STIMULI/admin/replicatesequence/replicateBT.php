<?php 
session_start(); 
$_SESSION["page"] = "replicateBT.php";
include('includes/replicateHeader.php'); 
?>
	<form method="post" id="next_page" action="main.php">
	<input type = "hidden" name ="path[]" id="path" value="">
	<input type = "hidden" name ="pos[]" id="pos" value="">	
	<button type = "submit" onclick="saveLast()" class="timelineSubmit">Submit</button>		
	</form>

<script>

var numElements = 28;	
var dragArray =[];	

var finalArray = new Array(numElements);
  for (var i = 0; i < numElements; i++) 
	{
	    finalArray[i] = new Array(3);
	}	

var width = 775,
    height = 700,
		radius = 32,
    line = 400,
		shiftKey
		
var svg = d3.select("body")
    .attr("tabindex", 1)
    .on("keydown.brush", keydown)
    .on("keyup.brush", keyup)
    .each(function() { this.focus(); })
  	.append("svg")
    .attr("width", width)
    .attr("height", height)

var borderPath = svg.append("rect")
		.attr("x", 0)
		.attr("y", 0)
		.attr("height", height)
		.attr("width", width)
		
var timeline = svg.append("path")
		.attr("d","M416.5,545.5h-12v-486h12V545.5z M410.315,45.5l-10.163,14.508l20.695-0.17 L410.315,45.5z")
		.attr("fill","black")
		.attr("transform","scale(1.5 2) translate(-150, -40)")
		.attr("stroke","black")
		
var link = svg.append("g")
    .attr("class", "link")
 	 	.selectAll("line")

var brush = svg.append("g")
    .datum(function() { return {selected: false, previouslySelected: false}; })
    .attr("class", "brush")

var circle;	
var title; 

d3.json("replicateV.json", function(json) {
	

var elem = svg.selectAll("g myCircleText")
        .data(json.nodes)

var elemEnter = elem.enter()
	    .append("g")
			.attr("class","noder")
	  

		circle = elemEnter.append("circle")
		  .attr("shape-rendering","optimizeQuality")
			.attr("r", radius)
		  .attr("class",function(d){return d.class})
	    .attr("id", function(d){return d.id} )
	    .attr("cx", function(d){return d.x} )
		 	.attr("cy", function(d){return d.y} )
  		.on("mousedown", function(d) {
  					if (!d.selected) { // Don't deselect on shift-drag.
      				if (!shiftKey) circle.classed("selected", function(p) { return p.selected = d === p; });
      				else d3.select(this).classed("selected", d.selected = true);
    				}
  		})
  		.on("mouseup", function(d) {
    			if (d.selected && shiftKey) d3.select(this).classed("selected", d.selected = false);
  			})
			.call(d3.behavior.drag()
						.on("drag", function(d) 
				{ recordPos(d);
					nudge(d3.event.dx, d3.event.dy); 
				}))
																				
 
 		   /* Create the text for each block */
		title = elemEnter.append("foreignObject")
			.attr("class","texty noselect")
			.attr("x", function(d){return d.x - 25} )
		 	.attr("y", function(d){return d.y -(radius/2)} )
			.attr("width","55px")
			.attr("height","50px")
			.text(function(d){return d.title})
	  		.on("mousedown", function(d) {
	  					if (!d.selected) { // Don't deselect on shift-drag.
	      				if (!shiftKey) circle.classed("selected", function(p) { return p.selected = d === p; });
	      				else d3.select(this).classed("selected", d.selected = true);
	    				}
	  		})
	  		.on("mouseup", function(d) {
	    			if (d.selected && shiftKey) d3.select(this).classed("selected", d.selected = false);
	  			})
				.call(d3.behavior.drag()
							.on("drag", function(d) { 	
								nudge(d3.event.dx, d3.event.dy);
							  recordPos(d); }))
																				
		//PULL DATA FOR LINKS
			json.links.forEach(function(d) {
		    d.source = json.nodes[d.source];
		    d.target = json.nodes[d.target];
		  });//end. graph.links.forEach																
			
	 //POPULATE LINKS
	 link = link.data(json.links).enter().append("line")
	     .attr("x1", function(d) { return d.source.x; })
	     .attr("y1", function(d) { return d.source.y; })
	     .attr("x2", line)
	     .attr("y2", function(d) { return d.source.y; }); //end. link=									

	//BRUSH STUFF
		// brush.call(d3.svg.brush()
	//       .x(d3.scale.identity().domain([0, width]))
	//       .y(d3.scale.identity().domain([0, height]))
	//       .on("brushstart", function(d) {
	//         circle.each(function(d) { d.previouslySelected = shiftKey && d.selected; });
	//       })
	//       .on("brush", function() {
	//         var extent = d3.event.target.extent();
	//         circle.classed("selected", function(d) {
	//           return d.selected = d.previouslySelected ^
	//               (extent[0][0] <= d.x && d.x < extent[1][0]
	//               && extent[0][1] <= d.y && d.y < extent[1][1]);
	//         });
	//       })
	//       .on("brushend", function() {
	//         d3.event.target.clear();
	//         d3.select(this).call(d3.event.target);
	//      }));//end. bruch.call

});	

function recordPos (d)
{
	dragArray.push([d.id,d.x,d.y,Date.now()]);
 	document.getElementById("path").value = dragArray;
}

/*SAVE last position of each svg circle element */
function saveLast()
{	
	for (i = 1; i<=numElements; i++)
	{
		finalArray[i-1][0]= document.getElementById(i).getAttribute("id");
		finalArray[i-1][1]= document.getElementById(i).getAttribute("cx");
		finalArray[i-1][2]= document.getElementById(i).getAttribute("cy");	
	}	
 	document.getElementById("pos").value = finalArray;
}

function nudge(dx, dy) {
  	circle.filter(function(d) { return d.selected; })
			.attr("cx", function(d) { 
					if ((d.x + dx) > (width-radius) || (d.x + dx) < (0+radius)) return d.x;
					else return d.x += dx;
			})
      .attr("cy", function(d) { 
					if ((d.y + dy) > (height-radius) || (d.y + dy) < (0+radius)) return d.y;
					else return d.y += dy;
		})

		link.filter(function(d) { return d.source.selected; })
    .attr("x1", function(d) { return d.source.x; })
    .attr("y1", function(d) { return d.source.y; })
    .attr("x2", line)
    .attr("y2", function(d) { return d.source.y; });

		title.filter(function(d) { return d.selected; })
	    .attr("x", function(d) { return d.x -25; })
	    .attr("y", function(d) { return d.y -(radius/2); });

	}
function keydown() {
  if (!d3.event.metaKey) switch (d3.event.keyCode) {
    case 38: nudge( 0, -1); break; // UP
    case 40: nudge( 0, +1); break; // DOWN
    case 37: nudge(-1,  0); break; // LEFT
    case 39: nudge(+1,  0); break; // RIGHT
  }
  shiftKey = d3.event.shiftKey || d3.event.metaKey;
}

function keyup() {
  shiftKey = d3.event.shiftKey || d3.event.metaKey;
}


</script>
