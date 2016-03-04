function barchart(){
	var selection,data,x,y,xAxis,yAxis,svg,height,width,svg,
		scaleSize = 30,
		labelSize=20;

	function years(sel){
		selection = sel;

		d3.csv("http://www.energiebeteiligt.de/all", function(e, d) {
			var y = [];
			for(var i = 0; i<d.length; i++){
				var exists = false;
				for(var ii = 0; ii<y.length; ii++){
					if(y[ii].date == parseInt(d[i].beginn)){
						y[ii].count++;
						exists = true;
					}
				}
				if(!exists){
					y.push({date:parseInt(d[i].beginn), count:1});
				}
			}

			data = y;
			years.init();
		});
	}

	years.resize = function(){
		years.init();
	};

	years.init = function(){
		selection.each(function(d, i) {
			svg = d3.select(this).append("svg");

			var bb = this.node().getBoundingClientRect();
			width = bb.width;
			height = bb.height;

			svg.select(".container").remove();
			svg = svg.append("g").attr("class","container");

			var xMax = d3.max(data, function(d){return d.date;})+1;
			var xMin = d3.min(data, function(d){return d.date;});

			x = d3.scale.linear()
				.range([0, width-(2*scaleSize)])
				.domain([xMin, xMax]);

			xAxis = d3.svg.axis()
				.scale(x)
				.tickFormat(d3.format(".0f"))
				.ticks(Math.min(Math.max(width/30, 2),data.length))
				.orient("bottom");

			y = d3.scale.linear()
				.domain([0, d3.max(data, function(d){ return d.count })])
				.range([height-scaleSize-labelSize, 0]);

			var bar = svg.selectAll(".bar")
				.data(data)
				.enter().append("g")
				.attr("class", "bar")
				.attr("transform", function(d, i) { return "translate(" + (x(d.date)+scaleSize) + "," + y(d.count) + ")"; });

			bar.append("rect")
				.attr("x", 1)
				.attr("y", labelSize)
				.attr("width", ((width-(2*scaleSize))/(xMax-xMin))-1)
				.attr("height", function(d) { return height - scaleSize - labelSize - y(d.count); });

			bar.append("text")
				.attr("x", ((width-(2*scaleSize))/(xMax-xMin))/2)
				.attr("y", labelSize-3)
				.style("text-anchor", "middle")
				.attr("class", "count")
				.attr("height", 10)
				.text(function(d){ var r = d.count; if(r<1){r = "";} return r;});

			svg.append("g")
				.attr("class", "x axis")
				.attr("transform", "translate("+scaleSize+"," + (height-scaleSize+1) + ")")
				.call(xAxis)
				.selectAll("text")
				.attr("y", 8)
				.attr("x", 2)
				.style("text-anchor", "start");

			var ticks = d3.select(this).selectAll('.tick');
			var last = ticks.size() - 1;
			d3.select(ticks[0][last]).style('display', 'none');
		});
	}

	return years;
}