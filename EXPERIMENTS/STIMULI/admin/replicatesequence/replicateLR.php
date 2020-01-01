<?php 
session_start(); 
$_SESSION["page"] = "replicateLR.php";
include('replicateHeader.php'); 
?>

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
		radius = 35,
    line = 350,
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
		.attr("d","M646.5,289.5v12h-486v-12H646.5z M646.162,285.152l-0.17,20.695l14.508-10.163 L646.162,285.152z")
		.attr("fill","black")
		.attr("transform","scale(2 1.5) translate(-274, -60)")
		.attr("stroke","black")
		
var link = svg.append("g")
    .attr("class", "link")
 	 	.selectAll("line")

var brush = svg.append("g")
    .datum(function() { return {selected: false, previouslySelected: false}; })
    .attr("class", "brush")

var circle;	
var title; 

d3.json("replicateH.json", function(json) {
	

var elem = svg.selectAll("g myCircleText")
        .data(json.nodes)

var elemEnter = elem.enter()
	    .append("g")
			.attr("class","node")
	  

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
				{  recordPos(d); 
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
						     .attr("x2", function(d) { return d.source.x; })
						     .attr("y2", line)
								; //end. link=			
								});	


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
