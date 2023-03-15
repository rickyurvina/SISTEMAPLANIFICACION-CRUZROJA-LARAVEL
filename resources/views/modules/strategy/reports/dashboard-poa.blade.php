<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">

    <style>
        table {
            border-spacing: 0;
        }

        .bg-red {
            background-color: #D52B1E;
            color: #FFFFFF;
        }

        .bg-gray {
            background-color: #f2f2f2;
        }

        .bg-blue {
            background-color: #0046AD;
            color: #ffffff;
        }

        .w-100 {
            width: 100%;
        }

        .w-8 {
            width: 5%;
        }


        .w-3 {
            width: 3%;
        }

        .w-30 {
            width: 30%;
        }

        .w-45 {
            width: 45%;
        }

        .w-50 {
            width: 50%;
        }

        .w-98 {
            width: 98%;
        }

        td > img {
            margin-left: 30px;
        }

        .title {
            color: #D52B1E;
            font-size: 30px;
        }

        .text-center {
            text-align: center;
        }

        .date {
            font-size: 25px;
            font-weight: bold;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .px-3 {
            padding-left: 1rem !important;
        }

        .py-1 {
            padding-bottom: 0.25rem !important;
        }

        .rounded {
            border-radius: 4px !important;
        }

        .fw-500 {
            font-weight: 500 !important;
        }

        .fw-300 {
            font-weight: 300 !important;
        }

        .l-h-n {
            line-height: normal;
        }

        .d-block {
            display: block !important;
        }

        .fs-4 {
            font-size: 2.5rem;
        }

        .fs-1 {
            font-size: 0.9375rem;
        }

        .m-0 {
            margin: 0;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .ml-auto {
            margin-left: auto;
        }

        .mr-auto {
            margin-right: auto;
        }

        .d-table {
            display: table;
        }

        .fl {
            float: left;
        }

        .fr {
            float: right;
        }
    </style>

    <script src="{{ asset('vendor/echarts/echarts.js') }}"></script>

    <title></title>
</head>

<body style="margin: 0">

<table class="w-100">
    <tbody>
    <tr>
        <td class="bg-red w-30">
            <img style="height: 70px" src="{{ asset('img/logo_cre_white.png') }}">
        </td>
        <td class="bg-gray w-50 text-center">
            <span class="title">{{$data['plan']->name}} </span>
        </td>
        <td class="bg-gray"><span class="date">{{ $data['date'] }}</span></td>
    </tr>
    </tbody>
</table>

<table class="w-98 mt-20 ml-auto mr-auto">
    <tbody>
    <tr>
        <td class="w-45">
            <div class="p-3 bg-red rounded">
                <h3 class="fs-4 d-block l-h-n m-0 fw-500">
                    {{$data['sumHombresAlcanzadas']+$data['sumMujeresAlcanzadas']}} <small style="font-size: 14px;"> / {{$data['goalPersonasCapacitadas']}}</small>
                    <small class="l-h-n" style="font-size: 18px; font-weight: 700; display: table">PERSONAS ALCANZADAS</small>
                </h3>
            </div>
        </td>
        <td class="w-8"></td>
        <td class="w-45">
            <div class="p-3 bg-blue rounded">
                <h3 class="fs-4 d-block l-h-n m-0 fw-500">
                    {{$data['sumHombresCapacitadas']+$data['sumMujeresCapacitadas']}} <small style="font-size: 14px;"> / {{$data['totalGoalCapacitadas']}}</small>
                    <small class="l-h-n" style="font-size: 18px; font-weight: 700; display: table">PERSONAS CAPACITADAS</small>
                </h3>
            </div>
        </td>
    </tr>
    <tr style="height: 10px">

    </tr>
    <tr>
        <td class="w-45">
            <div class="px-3 py-1 bg-red rounded w-45 fl">
                <h3 class="fs-4 d-block l-h-n m-0 fw-300">
                    {{$data['sumHombresAlcanzadas']}}
                    <small class="m-0 l-h-n fs-1 d-table">Hombres</small>
                </h3>
            </div>
            <div class="px-3 py-1 bg-red rounded w-45 fr">
                <h3 class="fs-4 d-block l-h-n m-0 fw-300">
                    {{$data['sumMujeresAlcanzadas']}}
                    <small class="m-0 l-h-n fs-1 d-table">Mujeres</small>
                </h3>
            </div>
        </td>
        <td class="w-8"></td>
        <td class="w-45">
            <div class="px-3 py-1 bg-blue rounded w-45 fl">
                <h3 class="fs-4 d-block l-h-n m-0 fw-300">
                    {{$data['sumHombresCapacitadas']}}
                    <small class="m-0 l-h-n fs-1 d-table">Hombres</small>
                </h3>
            </div>
            <div class="px-3 py-1 bg-blue rounded w-45 fr">
                <h3 class="fs-4 d-block l-h-n m-0 fw-300">
                    {{$data['sumMujeresCapacitadas']}}
                    <small class="m-0 l-h-n fs-1 d-table">Mujeres</small>
                </h3>
            </div>
        </td>
    </tr>
    <tr>
        <td class="w-45 text-center">
            <div id="chart-pa" style="height: 300px; width: 430px"></div>
        </td>
        <td class="w-8"></td>
        <td class="w-45">
            <div id="chart-pc" style="height: 300px; width: 430px"></div>
        </td>
    </tr>
    </tbody>
</table>

<table class="w-98 mt-10 ml-auto">
    <tbody>
    <tr>
        <td class="w-30">
            <h5 class="m-0">PERSONAS ALCANZADAS POR PROGRAMA</h5>
            <div id="chart-pap" style="height: 300px; width: 310px"></div>
        </td>
        <td class="w-3"></td>
        <td class="w-30">
            <h5 class="m-0">PERSONAS CAPACITADAS POR PROGRAMA</h5>
            <div id="chart-pcp" style="height: 300px; width: 310px"></div>
        </td>
        <td class="w-3"></td>
        <td class="w-30">
            <h5 class="m-0">CALIFICACIÓN DE SERVICIOS</h5>
            <div id="chart-cs" style="height: 300px; width: 310px"></div>
        </td>
    </tr>
    </tbody>
</table>


<script type="text/javascript">
    var options = {
        animation: false,
        toolbox: {
            show: false,
        },
        xAxis: {
            type: 'category',
            data: ['Hombres', 'Mujeres', 'Total']
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            label: {
                show: true,
                position: 'inside',
                formatter: '{c}%'
            },
            type: 'bar'
        }]
    };

    var opt_pa = options;
    opt_pa.series[0].data = [
        {
            value: {{$data['totalHombres']}},
            itemStyle: {
                color: '#0046AD'
            }
        },
        {
            value: {{$data['totalMujeres']}},
            itemStyle: {
                color: '#0046AD'
            }
        },
        {
            value: {{$data['totalHombres']+$data['totalMujeres']}},
            itemStyle: {
                color: '#D52B1E'
            }
        }]
    echarts.init(document.getElementById('chart-pa')).setOption(opt_pa);

    var opt_pc = options;
    opt_pc.series[0].data = [
        {
            value: {{$data['totalHombresCapacitados']}},
            itemStyle: {
                color: '#0046AD'
            }
        },
        {
            value: {{$data['totalMujeresCapacitados']}},
            itemStyle: {
                color: '#0046AD'
            }
        },
        {
            value: {{$data['totalMujeresCapacitados']+$data['totalHombresCapacitados']}},
            itemStyle: {
                color: '#D52B1E'
            }
        }]
    echarts.init(document.getElementById('chart-pc')).setOption(opt_pc);

    var opt_cs = options;
    //calificacion de servicios
    opt_cs.series[0].data = [
            @foreach($data['groups3'] as $personasAlcanzadas)
        {
            value: {{$personasAlcanzadas['progress']}},
            itemStyle: {
                color: '#0046AD'
            }
        },
        @endforeach];
    opt_cs.xAxis.data = [

        @foreach($data['groups3'] as $personasAlcanzadas)
            '{{$personasAlcanzadas['name']}}',
        @endforeach
    ];
    echarts.init(document.getElementById('chart-cs')).setOption(opt_cs);

    var opt_pap = options;
    //personas alcanzadas por porgrama
    opt_pap.series[0].data = [
            @foreach($data['groups'] as $personasAlcanzadas)
        {
            value: {{$personasAlcanzadas['progress']}},
            itemStyle: {
                color: '#0046AD'
            }
        },
        @endforeach
    ];
    opt_pap.xAxis.data = [

        @foreach($data['groups'] as $personasAlcanzadas)
            '{{$personasAlcanzadas['name']}}',
        @endforeach
    ];
    opt_pap.xAxis.axisLabel = {
        interval: 0,
        rotate: 30
    };
    echarts.init(document.getElementById('chart-pap')).setOption(opt_pap);

    var opt_pcp = options;
    //personas capacitadas por programa
    opt_pcp.series[0].data = [
            @foreach($data['groups2'] as $personasAlcanzadas)
        {
            value: {{$personasAlcanzadas['progress']}},
            itemStyle: {
                color: '#0046AD'
            }
        },
        @endforeach];
    opt_pcp.xAxis.data = [

        @foreach($data['groups2'] as $personasAlcanzadas)
            '{{$personasAlcanzadas['name']}}',
        @endforeach
    ];
    opt_pcp.xAxis.axisLabel = {
        interval: 0,
        rotate: 30
    };
    echarts.init(document.getElementById('chart-pcp')).setOption(opt_pcp);
</script>
</body>
</html>