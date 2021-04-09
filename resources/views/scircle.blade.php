@extends('layouts.app')

@section('content')
<div class="container justify-content-center">
    <div class="row">
        <div class="col-md-1">
            <a id="download" href="#"  onclick="saveit()" download>download</a>

        </div>
    </div>
    <div class="row ">
        <div class="col-lg-6">
            <canvas id="can" width="500" height="500"></canvas>
            <img id="image" style="display: none;"/>
        </div>
        <div class="col-lg-3">
            <ul id="dvLegend"></ul>

        </div>
    </div>
</div>

<br/>
<br/>

<script>
    var canvas = document.getElementById("can");
    var ctx = canvas.getContext("2d");
    var lastend = 0;
    var data = [];
    var values = {!! $all !!};
    var entries = Object.entries(values);

    var myTotal = 0;
    var myColor = ['#4CAF50', '#00BCD4', '#E91E63', '#FFC107', '#9E9E9E', '#CDDC39', '#18FFFF', '#F44336', '#6D4C41','red', 'green', 'blue','gray','yellow','black','cyan','pink','purple','brown']; // Colors of each slice


    var arcs =[];
    function draw() {
        arcs = [];
        myTotal = 0;
        entries.forEach(function (val,idx) {

            myTotal+=val[1][1]/1 ;

        });
        document.getElementById("dvLegend").innerHTML = "";
        var beginAngle = 0;
        var endAngle = 0;
        entries.forEach(function (val,idx) {
            ctx.fillStyle = myColor[idx];
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            // Arc Parameters: x, y, radius, startingAngle (radians), endingAngle (radians), antiClockwise (boolean)
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, lastend, lastend + (Math.PI * 2 * (val[1][1] / myTotal)), false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2);
            ctx.fill();
            arcs.push([lastend, lastend + (Math.PI * 2 * (val[1][1] / myTotal))]);
            var x = document.createElement("LI");
            x.id = idx;
            var t = document.createTextNode(val[1][0]);
            var tt = document.createElement("input");
            tt.style.float = "right";
            var emp = document.createTextNode(" ");
            tt.type = "color";
            x.appendChild(t);
            x.appendChild(emp);
            x.appendChild(tt);
            x.style.background = myColor[idx];
            x.className = "list-group-item";

            beginAngle = endAngle; //begin angle
            endAngle = endAngle + ((Math.PI * 2) * (val[1][1] / myTotal)); //end angle
            var pieRadius = Math.min(canvas.width / 2, canvas.height / 2);
            var labelX = canvas.width / 2 + (pieRadius / 2) * Math.cos(beginAngle + (endAngle - beginAngle) / 2);
            var labelY = canvas.height / 2 + (pieRadius / 2) * Math.sin(beginAngle + (endAngle - beginAngle) / 2);
            ctx.fillStyle = "white";
            ctx.font = "bold 10px Arial";
            ctx.fillText(""+ val[1][1], labelX, labelY);


            document.getElementById("dvLegend").append(x);

            x.onmouseover = function () {
                hover(this.id);
                this.style.fontSize = "20px";
                this.style.cursor = "pointer";
            };
            x.onmouseout = function () {
                //hover(this.id);
                this.style.fontSize = "18px";
            };

            tt.onchange = function () {
                edit(idx,this.value);
            };

            lastend += Math.PI * 2 * (val[1][1] / myTotal);
        });
    }

    function edit(idx,col) {

        myColor[idx] = col;
        reset();
        draw();
    }
    function reset(){
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    function hover(id) {

        var i = 0, r;
        var beginAngle = 0;
        var endAngle = 0;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var j=0;
        while (r = arcs[i]) {
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, arcs[i][0], arcs[i][1], false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2);
            ctx.fillStyle = myColor[j];

            if(id == i) {
                ctx.lineWidth   = 8;
                ctx.strokeStyle = myColor[j];
                ctx.stroke();
            }
            ctx.fill();

            beginAngle = arcs[i][0]; //begin angle
            endAngle = arcs[i][1]; //end angle
            var pieRadius = Math.min(canvas.width / 2, canvas.height / 2);
            var labelX = canvas.width / 2 + (pieRadius / 2) * Math.cos(beginAngle + (endAngle - beginAngle) / 2);
            var labelY = canvas.height / 2 + (pieRadius / 2) * Math.sin(beginAngle + (endAngle - beginAngle) / 2);
            ctx.fillStyle = "white";
            ctx.font = "bold 10px Arial";
            ctx.fillText(""+ values[i][1], labelX, labelY);
            j++;
            i++;
        }

    }

    canvas.onmousemove = function (e) {


        var rect = this.getBoundingClientRect(),
            x = e.clientX - rect.left,
            y = e.clientY - rect.top,
            i = 0, r;
        var beginAngle = 0;
        var endAngle = 0;

        ctx.clearRect(0, 0, canvas.width, canvas.height);


        var j=0;
        while (r = arcs[i]) {
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, canvas.height / 2, arcs[i][0], arcs[i][1], false);
            ctx.lineTo(canvas.width / 2, canvas.height / 2);
            //alert(arcs[i][0]+" "+x+" "+arcs[i][1]+" "+y);
            ctx.fillStyle = myColor[j];

            if(ctx.isPointInPath(x, y)) {
                document.getElementById(i).style.fontSize = "20px";
                document.getElementById("can").style.cursor = "pointer";
                ctx.lineWidth   = 8;
                ctx.strokeStyle = myColor[j];
                ctx.stroke();
            }
            ctx.fill();

            beginAngle = arcs[i][0]; //begin angle
            endAngle = arcs[i][1]; //end angle
            var pieRadius = Math.min(canvas.width / 2, canvas.height / 2);
            var labelX = canvas.width / 2 + (pieRadius / 2) * Math.cos(beginAngle + (endAngle - beginAngle) / 2);
            var labelY = canvas.height / 2 + (pieRadius / 2) * Math.sin(beginAngle + (endAngle - beginAngle) / 2);
            ctx.fillStyle = "white";
            ctx.font = "bold 10px Arial";
            ctx.fillText(""+ values[i][1], labelX, labelY);
            j++;
            i++;
        }

    };

    canvas.onmouseout = function (e) {
        for(var i=0;i<entries.length;i++) {
            document.getElementById(i).style.fontSize = "18px";
        }
    };

    function saveit() {

        var dataUrl = canvas.toDataURL();
        document.getElementById("image").src = dataUrl;
        document.getElementById("download").href = dataUrl;
    }

    
    draw();

</script>
@endsection