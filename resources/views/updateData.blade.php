@extends('layouts.app')

@section('content')

    <div class="container">
        <table class="table table-bordered w-75" id="tbl">
            @foreach($all as $key=>$val)
            <tr>
                <th><input type="text" class="form-control" id="{{ $val[0] }}" name="{{ $val[0] }}" value="{{ $val[0] }}"></th>
                <th><input class="form-control" id="{{ $val[1] }}" value="{{ $val[1] }}"></th>
            </tr>
            @endforeach
        </table>

        <button class="btn btn-primary" onclick="saveTbl()">Save</button>
    </div>

    <script>
        function saveTbl() {
            var n1 = document.getElementById("tbl").rows.length;

            var i=0,j=0;
            var str="";
            var all = [];

            for(i=0; i<n1;i++){

                var n2 = document.getElementById("tbl").rows[i].cells.length;
                all[i] = [];
                for(j=0; j<n2;j++){

                    var x=document.getElementById("tbl").rows[i].cells[j].children[0].value;


                    all[i].push(x);

                }

            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/save',
                type:'POST',
                dataType:'json',
                data: {all:all},
                success:function(response){
                    alert("saved")
                },error:function(err){
                    //alert(err)
                }
            });
        }


    </script>
@endsection