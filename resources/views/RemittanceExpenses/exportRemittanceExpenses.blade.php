<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            @page{
                size: landscape;
            }

            *{
                padding: 0;
                margin: 0;
                background-color: #FFF;
                font-family: 'Helvetica' !important;
            }

            tbody:before,
            tbody:after{ 
                display: none;
            }

            .bordered{
                width:100px;
                border: 1px solid #000 !important;
                font-size: 12px !important;
            }

            p{
                margin-bottom: 10px !important;
                font-size: 15px !important;
            }
        </style>
    </head>
    <body style="width: 100%;">
        <div style="margin: 0 auto; padding: 30px;">
            <h3 style="width: 100%; text-align: center;">SUNPRIDE FOODS INC.</h3>
            <br>

            <h4 style="width: 100%; text-align: center;">STATEMENT OF REMITTANCE</h4>
            <br>

            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td style="width: 20%; font-size: 15px;"><strong>SR. SALESMAN</strong></td>
                    <td style="width: 30%; font-size: 15px;">{{ $record->sr_salesman->salesman_name }}</td>
                    <td style="width: 20%; font-size: 15px;"><strong>DATE</strong></td>
                    <td style="width: 30%; font-size: 15px; text-align: right:">{{ date('m/d/Y',strtotime($record->date_from)) . ' - ' . date('m/d/Y',strtotime($record->date_to)) }}</td>
                </tr>
                <tr>
                    <td style="width: 20%; font-size: 15px;"><strong>JR. SALESMAN</strong></td>
                    <td style="width: 30%; font-size: 15px;">{{ $record->jr_salesman->jr_salesman_name }}</td>
                    <td style="width: 20%;"></td>
                    <td style="width: 30%;"></td>
                </tr>
                <tr>
                    <td style="width: 20%;"></td>
                    <td style="width: 30%; font-size: 15px;">Total Cash</td>
                    <td style="width: 20%;">{{ number_format($record->cash_amount, 2, '.', ',') }}</td>
                    <td style="width: 30%;"></td>
                </tr>
                <tr>
                    <td style="width: 20%;"></td>
                    <td style="width: 30%; font-size: 15px;">Total Check</td>
                    <td style="width: 20%;">{{ number_format($record->check_amount, 2, '.', ',') }}</td>
                    <td style="width: 30%;"></td>
                </tr>
                <tr>
                    <td style="width: 20%;"></td>
                    <td style="width: 30%; font-size: 15px;">Total Collection</td>
                    <td style="width: 20%;"><strong>{{ number_format(($record->cash_amount + $record->check_amount), 2, '.', ',') }}</strong></td>
                    <td style="width: 30%;"></td>
                </tr>
            </table>

            <table style="width: 80%; margin-bottom: 20px;">
                <tr>
                    <th style="width: 25%; font-size: 15px; text-align: left;"><strong>EXPENSES:</strong></th>
                    <th style="width: 30%;"></th>
                    <th style="width: 15%;"></th>
                    <th style="width: 20%;"></th>
                </tr>
                @if(isset($record->expenses))
                    @foreach($record->expenses as $expense)
                        <tr>
                            <td></td>
                            <td>{{ $expense->expense }}</td>
                            <td></td>
                            <td style="text-align: right;">{{ number_format($expense->amount, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td style="font-size:15px;"><strong>TOTAL</strong></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ number_format($record->total_expenses, 2, '.', ',') }}</td>
                </tr>
            </table>

            <table style="width: 80%; margin-bottom: 20px;">
                <tr>
                    <th style="width: 25%; font-size:15px; text-align: left;"><strong>CASH BREAKDOWN:</strong></th>
                    <th style="width: 30%;"></th>
                    <th style="width: 15%;"></th>
                    <th style="width: 20%;"></th>
                </tr>
                @if(isset($record->cash_breakdown))
                    @foreach($record->cash_breakdown as $cash_breakdown)
                        <tr>
                            <td></td>
                            <td style="text-align: right;">{{ $cash_breakdown->denomination }}</td>
                            <td style="text-align: right;">{{ $cash_breakdown->pieces }}</td>
                            <td style="text-align: right;">{{ number_format(($cash_breakdown->denomination * $cash_breakdown->pieces), 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td style="font-size:15px;"><strong>TOTAL</strong></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ number_format($record->total_cash_breakdowns, 2, '.', ',') }}</td>
                </tr>
            </table>

            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <th style="width: 40%;"><h4 style="text-align: left;">Submitted by:</h4></th>
                    <th style="width: 40%;"></th>
                    <th style="width: 20%;"><h4 style="text-align: left;">Recieved by:</h4></th>
                </tr>
                <tr>
                    <td style="margin-top: 20px; height: 30px;"></td>
                    <td style="margin-top: 20px; height: 30px;"></td>
                    <td style="margin-top: 20px; height: 30px;"></td>
                </tr>
                <tr>
                    <td style="margin-top: 20px;"><h4 style="text-align: center;">{{ $record->sr_salesman->salesman_name }}</h4></td>
                    <td style="margin-top: 20px;"><h4 style="text-align: center;">{{ $record->jr_salesman->jr_salesman_name }}</h4></td>
                    <td style="margin-top: 20px;"></td>
                </tr>
                <tr>
                    <td><h4 style="text-align: center;">Senior Salesman</h4></td>
                    <td><h4 style="text-align: center;">Junior Salesman</h4></td>
                    <td><h4>SFI Cashier</h4></td>
                </tr>
            </table>

            <h4 style="width: 100%;">Generated By: {{ auth()->user()->firstname . ' ' .auth()->user()->lastname }}</h4>
            <br>
            <h4 style="width: 100%;">Generated On: {{ date('F j,Y g:i:s A') }}</h4>
        </div>
    </body>
</html>