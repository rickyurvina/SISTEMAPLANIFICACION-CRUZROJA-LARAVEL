<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <style>

        .pdf-table > thead > tr th:after {
            display: none !important;
        }

        .pdf-table {
            border-collapse: collapse;
        }

        .pdf-table > thead > tr th {
            font-size: 11pt !important;
        }

        .pdf-table > thead > tr th,
        .pdf-table td {
            border: 1px solid #000 !important;
            font-size: 12px;
        }

        .pdf-table th {
            border: 1px solid #000 !important;
            font-size: 12px;
        }

        .color-black {
            color: #000000;
        }

        .color-red {
            color: #D52B1E;
        }

        .text-center {
            text-align: center !important;
        }

        .summary-table {
            border: 1px solid;
        }

        .summary-table td,
        .summary-table th {
            padding: 0 10px;
            text-align: left;
            border: 1px solid;
        }

        .w-100 {
            width: 100%;
        }

        .index a {
            text-decoration: none;
            color: #000000;
        }

        .index a:hover {
            text-decoration: underline;
        }

        .index li {
            margin: 15px 0;
        }

        table {
            border-spacing: 0;
        }

        td > img {
            margin-left: 30px;
        }

    </style>
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

        .w-1 {
            width: 1%;
        }

        .w-2 {
            width: 2%;
        }

        .w-3 {
            width: 3%;
        }

        .w-4 {
            width: 4%;
        }

        .w-5 {
            width: 5%;
        }

        .w-6 {
            width: 6%;
        }

        .w-7 {
            width: 7%;
        }

        .w-8 {
            width: 5%;
        }


        .w-10 {
            width: 10%;
        }

        .w-15 {
            width: 15%;
        }

        .w-20 {
            width: 20%;
        }

        .w-25 {
            width: 25%;
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

        .w-60 {
            width: 60%;
        }

        .w-70 {
            width: 70%;
        }

        .w-80 {
            width: 80%;
        }

        .w-98 {
            width: 98%;
        }

        .w-100 {
            width: 100%;
        }

        td > img {
            margin-left: 30px;
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


        .fw-700 {
            font-weight: 700 !important;
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

        .ml-3 {
            margin-left: 3%;
        }

        .ml-2 {
            margin-left: 2%;
        }

        .mt-3 {
            margin-top: 3%;
        }

        .mt-2 {
            margin-top: 2%;
        }

        .mb-3 {
            margin-bottom: 3%;
        }

        .mb-2 {
            margin-bottom: 2%;
        }

        .mr-3 {
            margin-right: 3%;
        }

        .mr-2 {
            margin-right: 2%;
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

        .bg-piat {
            background-color: #e09494;
        }

        .color-piat {
            color: #e09494;
        }
    </style>

    <title></title>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            {{--logo--}}
            <table class="w-100 ml-auto mr-auto d-table">
                <tbody>
                <tr>
                    <td class="w-30">
                        <img style="height: 50px" src="{{ asset('img/logo_cre_trans.png') }}">
                    </td>
                </tr>
                </tbody>
            </table>
            {{--informe datos--}}
            <table class="pdf-table w-100" style="height: 25px;">
                <thead>
                <tr class="d-table w-100">
                    <th scope="col" class="text-center bg-piat">
                        <h1 style="font-size: 20px; font-weight: 700; text-align: center">{{trans('poa.piat.title_report')}}</h1>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.name_activity')}}
                        </span>
                    </td>
                    <td class="w-80">
                        <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->name}}
                        </span>
                    </td>
                </tr>
                <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.place')}}
                        </span>
                    </td>
                    <td class="w-40">
                         <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->place}}
                        </span>
                    </td>
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.date')}}
                        </span>
                    </td>
                    <td class="w-20">
                        <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->date}}
                        </span>
                    </td>
                </tr>
                <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.init_time')}}
                        </span>
                    </td>
                    <td class="w-10">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->initial_time}}
                        </span>
                    </td>
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.end_time')}}
                        </span>
                    </td>
                    <td class="w-10">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->end_time}}
                        </span>
                    </td>
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.duration_time')}}
                        </span>
                    </td>
                    <td class="w-20">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->end_time}}resta de horas
                        </span>
                    </td>
                </tr>
                <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.place')}}
                        </span>
                    </td>
                    <td class="w-80">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->location($activityPiatReport->piat->parish)->getPath()}}
                        </span>
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.activity_completed')}}
                        </span>
                    </td>
                    <td class="w-10 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.yes')}}
                        </span>
                    </td>
                    <td class="w-5">
                        @if($activityPiatReport->accomplished==true)
                            X
                        @endif
                    </td>
                    <td class="w-10 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.no')}}
                        </span>
                    </td>
                    <td class="w-5">
                        @if($activityPiatReport->accomplished==false)
                            X
                        @endif
                    </td>
                    <td class="w-30 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.number_facilities')}}
                        </span>
                    </td>
                    <td class="w-5 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.man')}}
                        </span>
                    </td>
                    <td class="w-5">
                        <span class="color-black fw-700 ml-2 mr-2">

                        </span>
                    </td>
                    <td class="w-5 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.woman')}}
                        </span>
                    </td>
                    <td class="w-5">
                        <span class="color-black fw-700 ml-2 mr-2">
                        </span>
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2   ">
                            {{trans('poa.piat.activity_piat_name')}}
                        </span>
                    </td>
                    <td class="w-80">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->piatable->name}}
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
            {{--beneficiarios--}}
            <table class="  pdf-table w-100 ">
                <tbody>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-70 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.beneficiaries')}}
                        </span>
                    </td>
                    <td class="w-30 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.volunteer')}}
                        </span>
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-40 text-center bg-piat">
                    </td>
                    <td class="w-30 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.disability_person')}}
                        </span>
                    </td>
                    <td class="w-30 text-center bg-piat">
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.man')}}
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.woman')}}
                        </span>
                    </td>
                    <td class="w-20 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.total')}}
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.yes')}}
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.number')}}
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.no')}}
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.man')}}
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.woman')}}
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.total')}}
                        </span>
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->beneficiariesMen()}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->beneficiariesWomen()}}
                        </span>
                    </td>
                    <td class="w-20 text-center">
                        <span class="color-red">
                            {{$activityPiatReport->poaMatrixReportBeneficiaries->count()}}
                        </span>
                    </td>

                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->benficiiariesDisability()>0?'X':''}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->benficiiariesDisability()}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->benficiiariesDisability()==0?'X':''}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{$activityPiatReport->piat->manResponsibles()}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->piat->womenResponsibles()}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                        <span class="color-red">
                            {{$activityPiatReport->piat->responsibles->count()}}
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
            {{--grupo etario--}}
            <table class="pdf-table w-100">
                <thead>
                   <tr class="d-table w-100" style="height: 25px;">
                    <th scope="col" class="text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2"> {{trans('poa.piat.group_age')}}
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            <6
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            6/12
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            13/17
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            18/29
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            30/39
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            40/49
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            50/59
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            60/69
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            70/79
                        </span>
                    </td>
                    <td class="w-10 text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            >80
                        </span>
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['6']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['6_12']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['13_17']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['13_17']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['18_29']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['30_39']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['50_59']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['60_69']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['70_79']}}
                        </span>
                    </td>
                    <td class="w-10 text-center">
                             <span class="ml-2 mr-2 mt-2 mb-2">
                            {{$activityPiatReport->groupAge()['80']}}
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
            {{--description--}}
            <hr>
            <table class="  pdf-table w-100 ">
                <thead>
                   <tr class="d-table w-100" style="height: 25px;">
                    <th scope="col" class="text-center bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.description_title')}}
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-100">
                        {!! $activityPiatReport->description!!}
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
            {{--ACUERDOS Y COMPROMISOS--}}
            <table class="  pdf-table w-100 ">
                <thead>
                   <tr class="d-table w-100" style="height: 25px;">
                    <th class="text-center bg-piat w-50">
                            <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.agreements')}}
                        </span>
                    </th>
                    <th class="text-center bg-piat w-50">
                            <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.responsible')}}
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($activityPiatReport->poaMatrixReportAgreementCommitment as $agreement)
                       <tr class="d-table w-100" style="height: 25px;">
                        <td class="w-50">
                            <span class="ml-2 mr-2">
                                {{$agreement->description}}
                            </span>
                        </td>
                        <td class="w-50">
                            <span class="ml-2 mr-2">
                                {{$agreement->userResponsable->getFullName()}}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--EVALUACION ACTIVIDAD TALLER--}}
            <hr>
            <table class="  pdf-table w-100 ">
                <thead>
                   <tr class="d-table w-100" style="height: 25px;">
                    <th class="text-center bg-piat w-100">
                            <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.evaluation_tasks')}}
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="text-center bg-piat w-50">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.positive')}}
                        </span>
                    </td>
                    <td class="text-center bg-piat w-50">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.negative')}}
                        </span>
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-50 ">
                        {!! $activityPiatReport->positive_evaluation!!}
                    </td>
                    <td class="w-50">
                        {!! $activityPiatReport->evaluation_for_improvement!!}
                    </td>
                </tr>
                </tbody>
            </table>
            {{--archivos--}}
            <table class="pdf-table w-100">
                <thead>
                   <tr class="d-table w-100" style="height: 25px;">
                    <th scope="col" class="bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.files')}}
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($filesEdit as $file)
                       <tr class="d-table w-100" style="height: 25px;">
                        <td class="w-100">
                            <span class="ml-2 mr-2">
                                {{$file['name']}}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <hr>
            {{--Fecha y firmas--}}
            <table class="pdf-table w-100">
                <tbody>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-50 bg-piat">
                            <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.date_finished')}}

                        </span>
                    </td>
                    <td class="w-50">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{now()}}
                        </span>
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-50 bg-piat">
                            <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.realized_by')}}
                        </span>
                    </td>
                    <td class="w-50 bg-piat">
                            <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.approved_by')}}

                        </span>
                    </td>
                </tr>
                <tr class="d-table w-100" style="height: 100px !important;">
                    <td class="w-50">
                            <span class="color-black fw-700 ml-2 mr-2">
                            Firma:
                        </span>
                        <br>
                        <span class="color-black fw-700 ml-2 mr-2">
                            Nombre:
                        </span>
                    </td>
                    <td class="w-50">
                            <span class="color-black fw-700 ml-2 mr-2">
                            Sello:
                        </span>
                        <br>
                        <span class="color-black fw-700 ml-2 mr-2">
                            Firma:
                        </span>
                        <br>
                        <span class="color-black fw-700 ml-2 mr-2">
                            Nombre:
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
            <div style="page-break-after: always;"></div>
            {{--registro general de asistencia--}}
            <table class="  pdf-table w-100 ">
                <tbody>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.task_lower_8')}}
                        </span>
                    </td>
                    <td class="w-10">

                    </td>
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.meet')}}
                        </span>
                    </td>
                    <td class="w-10">

                    </td>
                    <td class="w-20 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.activity')}}
                        </span>
                    </td>
                    <td class="w-10">

                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-25 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.name_activity')}}
                        </span>
                    </td>
                    <td class="w-25">
                        {{ $activityPiatReport->piat->name}}
                    </td>
                    <td class="w-25 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.place')}}
                        </span>
                    </td>
                    <td class="w-25">
                        {{ $activityPiatReport->piat->place}}
                    </td>
                </tr>
                   <tr class="d-table w-100" style="height: 25px;">
                    <td class="w-10 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.place')}}
                        </span>
                    </td>
                    <td class="w-10">
                        {{$activityPiatReport->piat->location($activityPiatReport->piat->parish)->getPath()}}
                    </td>
                    <td class="w-10 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.date')}}
                        </span>
                    </td>
                    <td class="w-10">
                        {{ $activityPiatReport->piat->date}}

                    </td>
                    <td class="w-10 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.init_time')}}
                        </span>
                    </td>
                    <td class="w-10">
                        {{ $activityPiatReport->piat->initial_time}}

                    </td>
                    <td class="w-10 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.end_time')}}

                        </span>
                    </td>
                    <td class="w-5">
                        {{ $activityPiatReport->piat->end_time}}

                    </td>
                    <td class="w-5 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.total')}}
                        </span>
                    </td>
                    <td class="w-5">
                        {{--                        {{$activityPiatReport->piat->getTimeHours()}}--}}
                    </td>
                    <td class="w-10 bg-piat">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.responsible')}}
                        </span>
                    </td>
                    <td class="w-25">
                        {{ $activityPiatReport->piat->responsableToCreate->getFullName()}}
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
            {{--tabla de voluntarios--}}
            <table class="pdf-table w-100">
                <thead>
                <tr>
                    <th class="w-1 bg-piat text-center">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.number')}}
                        </span>
                    </th>
                    <th class="w-15 bg-piat text-center">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.surnames_names')}}
                        </span>
                    </th>
                    <th class="w-4 bg-piat text-center" scope="col" colspan="2">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.sex')}}
                        </span>
                    </th>
                    <th class="w-10 bg-piat text-center">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.identification')}}
                        </span>
                    </th>
                    <th class="w-10 bg-piat text-center" scope="col" colspan="2">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.disability_person')}}
                        </span>
                    </th>
                    <th class="w-20 bg-piat text-center" scope="col" colspan="10">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.age')}}
                        </span>
                    </th>
                    <th class="w-10 bg-piat text-center">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.observations')}}
                        </span>
                    </th>
                    <th class="w-10 bg-piat text-center">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.company')}}
                        </span>
                    </th>
                    <th class="w-10 bg-piat text-center" scope="col" colspan="2">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.participation')}}
                        </span>
                    </th>
                    <th class="w-10 bg-piat text-center">
                        <span class="color-black fw-700 ml-2 mr-2">
                            {{trans('poa.piat.sign')}}
                        </span>
                    </th>
                </tr>

                <tr>
                    <th class="w-1 bg-piat text-center">
                    </th>
                    <th class="w-15 bg-piat text-center">
                    </th>
                    <th class="w-2 bg-piat text-center">
                        H
                    </th>
                    <th class="w-2 bg-piat text-center">
                        M
                    </th>
                    <th class="w-10 bg-piat text-center">
                    </th>
                    <th class="w-5 bg-piat text-center">
                        Si
                    </th>
                    <th class="w-5 bg-piat text-center">
                        No
                    </th>
                    <th class="w-2 text-center bg-piat">
                        <6
                    </th>
                    <th class="w-2 text-center bg-piat">
                        6/12
                    </th>
                    <th class="w-2 text-center bg-piat">
                        13/17
                    </th>
                    <th class="w-2 text-center bg-piat">
                        18/29
                    </th>
                    <th class="w-2 text-center bg-piat">
                        30/39
                    </th>
                    <th class="w-2 text-center bg-piat">
                        40/49
                    </th>
                    <th class="w-2 text-center bg-piat">
                        50/59
                    </th>
                    <th class="w-2 text-center bg-piat">
                        60/69
                    </th>
                    <th class="w-2 text-center bg-piat">
                        70/79
                    </th>
                    <th class="w-2 text-center bg-piat">
                        >80
                    </th>

                    <th class="w-10 bg-piat text-center">
                    </th>
                    <th class="w-10 bg-piat text-center">
                    </th>
                    <th class="w-5 bg-piat text-center">
                        Hora Inicio
                    </th>
                    <th class="w-5 bg-piat text-center">
                        Hora Fin
                    </th>
                    <th class="w-10 bg-piat text-center">
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($activityPiatReport->poaMatrixReportBeneficiaries as $beneficiary)
                    <tr>
                        <td class="text-center">
                            {{$loop->iteration}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->names.' - '.$beneficiary->surnames}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->gender=='H'?'X':''}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->gender=='M'?'X':''}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->identification}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->disability=='SI'?'X':''}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->disability=='NO'?'X':''}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->age<'6'?'X':''}}
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=6 && $beneficiary->age<=12)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=13 && $beneficiary->age<=17)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=18 && $beneficiary->age<=29)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=30 && $beneficiary->age<=39)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=40 && $beneficiary->age<=49)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=50 && $beneficiary->age<=59)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=60 && $beneficiary->age<=69)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=70 && $beneficiary->age<=79)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            @if($beneficiary->age>=80)
                                X
                            @endif
                        </td>
                        <td class="text-center">
                            {{$beneficiary->pivot->observations}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->pivot->belong_to_board}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->pivot->participation_initial_time}}
                        </td>
                        <td class="text-center">
                            {{$beneficiary->pivot->participation_end_time}}
                        </td>
                        <td class="text-center">

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>