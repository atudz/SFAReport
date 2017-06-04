<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ URL::asset('js/components/packages/bootstrap/dist/css/bootstrap.min.css') }}"/>
        <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}"/>
        <style type="text/css">
            *{
                padding: 0;
                margin: 0;
                background-color: #FFF;
            }

            tbody:before,
            tbody:after{ 
                display: none;
            }
        </style>
    </head>
    <body style="width: 100%; background-color: #FFF;">
        <div style="margin: 0 auto; padding: 30px;">
            <h3 style="width: 100%; text-align: center;">SUNPRIDE FOODS INC.</h3>
            <br>

            <h4 style="width: 100%; text-align: center;">Activity Logs</h4>
            <br>

            <table class="table table-striped table-condensed table-bordered" style="border: 1px solid #000;">
                <tr style="border: 1px solid #000;">
                    <th style="border: 1px solid #000; font-size: 12px; font-family: 'Arial';">Date</th>
                    <th style="border: 1px solid #000; font-size: 12px; font-family: 'Arial';">User</th>
                    <th style="border: 1px solid #000; font-size: 12px; font-family: 'Arial';">Location/Branch</th>
                    <th style="border: 1px solid #000; font-size: 12px; font-family: 'Arial';">Module</th>
                    <th style="border: 1px solid #000; font-size: 12px; font-family: 'Arial';">Access/Role</th>
                    <th style="border: 1px solid #000; font-size: 12px; font-family: 'Arial';">Action</th>
                </tr>

                @foreach($records as $record)
                    <tr>
                        <td style="width:100px; border: 1px solid #000; font-size: 12px; font-family: 'Arial';">{{ $record->created_at }}</td>
                        <td style="width:100px; border: 1px solid #000; font-size: 12px; font-family: 'Arial';">{{ $record->user->firstname . ' ' . $record->user->lastname }}</td>
                        <td style="width:100px; border: 1px solid #000; font-size: 12px; font-family: 'Arial';">{{ !is_null($record->user->area) ? $record->user->area->area_name : '' }}</td>
                        <td style="width:100px; border: 1px solid #000; font-size: 12px; font-family: 'Arial';">{{ $record->navigation->name }}</td>
                        <td style="width:100px; border: 1px solid #000; font-size: 12px; font-family: 'Arial';">{{ $record->user->group->name }}</td>
                        <td style="width:100px; border: 1px solid #000; font-size: 12px; font-family: 'Arial';">{{ $record->action }}</td>
                    </tr>
                @endforeach
            </table>

            <br>
            <h4 style="width: 100%;">Date Generated: {{ date('F j,Y g:i:s A') }}</h4>
        </div>
    </body>
</html>