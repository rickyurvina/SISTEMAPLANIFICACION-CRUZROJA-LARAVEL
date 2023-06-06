<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">

    <style>

        .logo {
            margin: auto;
            text-align: center;
        }

        .title-project {
            text-transform: uppercase;
            color: #000000;
            text-align: center;
        }

        .bg-red {
            background-color: #D52B1E;
        }

        .color-white {
            color: #FFFFFF;
        }

        .color-black {
            color: #000000;
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

        .content-index a {
            color: #000000;
            text-decoration: none;
            line-height: 3em;
        }
    </style>


    <title></title>
</head>

<body>

<div class="logo">
    <img src="{{ public_path('img/logo_cre.jpg') }}" alt="logo"/>
</div>

@if($activitiesLog)
    <table class="summary-table w-100">

        <tbody>
        <tr>
            <td style="width: 20%">{{ trans('general.user')}}</td>
            <td style="width: 20%">{{ trans('general.action')}}</td>
            <td style="width: 30%">{{ trans('general.activity')}}</td>
            <td style="width: 10%">{{ trans('general.code')}}</td>
            <td style="width: 20%">{{ trans('general.date')}}</td>
        </tr>
        @foreach( $activitiesLog as $item)
            <tr>
                <td>
                    {{ $item->causer->name }}
                </td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->subject ? $item->subject->name : '' }}</td>
                <td>{{ $item->subject ? $item->subject->code : '' }}</td>
                <td>{{ $item->created_at->format('F j, Y, g:i a') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

</body>
</html>