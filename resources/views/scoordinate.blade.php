@extends('layouts.app')

@section('content')

    <div class="container justify-content-center">
        <div class="row pb-3">

            <div class="col-md-6">
                <label for="favcolor">Select your favorite line color:</label>
                <input class="" type="color" value="Clear" name="Clear" onchange="edit(this.value)">
            </div>
            <div class="col-md-6">
                <a id="download" href="#"  onclick="saveit()" download>download</a>
            </div>
        </div>


        <div class="row ">
            <div class="col-lg-6">
                <canvas id="myCanvas" width="1000" height="500" style="border:1px solid black">
                </canvas>
                <img id="image" style="display: none;"/>
            </div>
            <div class="col-lg-3">
                <ul id="dvLegend"></ul>
            </div>
        </div>
    </div>


<script>

    var canvas = document.getElementById('myCanvas');
    var color = "#042b76";


    var ctx = canvas.getContext('2d');
    var values = {!! $all !!};


    var entries = Object.entries(values);


    function drawGrids() {
        var xGrid = 10;
        var yGrid = 10;
        var cellSize = 10;
        ctx.beginPath();

        while(xGrid < canvas.height){
            ctx.moveTo(0,xGrid);
            ctx.lineTo(canvas.width,xGrid);
            xGrid+=cellSize;
        }

        while(yGrid < canvas.width){
            ctx.moveTo(yGrid,0);
            ctx.lineTo(yGrid,canvas.height);
            yGrid+=cellSize;
        }
        ctx.strokeStyle = "gray";
        ctx.stroke();
    }

    function blocks(count){
        return count*10;
    }

    function drawAxis(){
        var yPlot = 40;
        var pop = 0;

        ctx.beginPath();
        ctx.strokeStyle = "black";
        ctx.moveTo(blocks(5),blocks(5));
        ctx.lineTo(blocks(5),blocks(40));
        ctx.lineTo(blocks(80),blocks(40));

        ctx.moveTo(blocks(5),blocks(40));

        for(var i=1;i<=10;i++){
            ctx.strokeText(pop,blocks(2),blocks(yPlot));
            yPlot-=5;
            pop+=500;
        }

        ctx.stroke();

    }

    function drawChart() {
        ctx.beginPath();
        ctx.strokeStyle = "red";
        ctx.moveTo(blocks(5),blocks(40));

        var xPlot = 10;

        entries.forEach(function (val,idx){
            var populationBlocks = val[1][1]/100;
            ctx.strokeStyle = "black";
            ctx.lineWidth   = 2;
            ctx.font="15pt Calibri";
            ctx.strokeText(val[1][0],blocks(xPlot),blocks(40-populationBlocks-2));
            ctx.strokeStyle = color;
            ctx.lineWidth   = 3;
            ctx.lineTo(blocks(xPlot),blocks(40-populationBlocks));
            ctx.arc(blocks(xPlot),blocks(40-populationBlocks),2,0,Math.PI*2,true);
            xPlot+=5;
        });
        ctx.stroke();
    }

    function reset(){
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.font='10px Arial';
        ctx.lineWidth   = 1;
    }
    function edit(col) {

        color = col;
        reset();
        drawGrids();
        drawAxis();
        drawChart();
    }
    function saveit() {

        var dataUrl = canvas.toDataURL();
        document.getElementById("image").src = dataUrl;
        document.getElementById("download").href = dataUrl;
    }


    drawGrids();
    drawAxis();
    drawChart();
</script>
@endsection