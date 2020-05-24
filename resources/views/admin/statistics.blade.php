@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">              
                    <div class="card-header">
                      Statistika tiketa
                    </div>
                    <div class="card-body">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    var data1 = @json($tickets_opened);
    var data2 = @json($tickets_closed);
    console.log(data1);
    console.log(data2);
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "Uporedni broj otvorenih i zatvorenih tiketa po danima u tekućem mesecu"
            },
            legend:{
                cursor: "pointer",
                verticalAlign: "center",
                horizontalAlign: "right",
                itemclick: toggleDataSeries
            },
            data: [
                {
                    type: "column",
                    name: "Otvoreni",
                    color: "red",
                    indexLabel: "{y}",
                    yValueFormatString: "#0.##",
                    showInLegend: true,

                    dataPoints: <?php echo json_encode($tickets_opened, JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "column",
                    name: "Zatvoreni",
                    color: "blue",
                    indexLabel: "{y}",
                    yValueFormatString: "#0.##",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($tickets_closed, JSON_NUMERIC_CHECK); ?>
                }
            ]
        });
        chart.render();
        function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            }
            else{
                e.dataSeries.visible = true;
            }
            chart.render();
        }   
    }
</script>