/*global paper*/

var inheritsFrom = function (child, parent) {
    child.prototype = Object.create(parent.prototype);
};

function Cord(point){
    var cord = new Object();
	cord.text = new paper.PointText(point);
	cord.text.fillColor = 'black';
	cord.text.content = "(" + point.x + ", " + point.y + ")";
	return cord;
};

$(document).ready(function(){
    inheritsFrom(Cord, paper.Point);
}


function resizeAndRedrawCanvas(){
	var desiredWidth = 10; // For instance: $(window).width();
	var desiredHeight = 10; // For instance $('#canvasContainer').height();
	
	var canvas = $("#myCanvas");
	canvas.width = desiredWidth;
	canvas.height = desiredHeight 
	
	view.viewSize = new Size(desiredWidth, desiredHeight);
	view.draw();
}


function removeGrid(){
	var layers = paper.project.layers;
	var first = layers[0];
	var len = first.children.length;
	var majorAxis = first.children.slice(len-3, len-1);
	first.children = majorAxis;
	removeGridPoints();
}

function addCords(point){
	var text = new paper.PointText(point);
	text.fillColor = 'black';
	text.content = "(" + point.x + ", " + point.y + ")";
}
