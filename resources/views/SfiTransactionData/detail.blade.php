<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body style="width: 100%;">
        <table>
            <tr>
                <th colspan="17" align="center">SUNPRIDE FOODS INC.</th>
            </tr>
            <tr>
                <td colspan="17" align="center">SAP DETAILS</td>
            </tr>
        </table>
        <table>
            <thead>
                <tr>
                    <th>POSTINGKEY</th>
                    <th>ACCOUNT</th>
                    <th>GL Account</th>
                    <th>SPECIALGLINDICATOR</th>
                    <th>AMOUNT</th>
                    <th>Tax Code</th>
                    <th>COSTCENTER</th>
                    <th>BASELINEDATE</th>
                    <th>PROFIT CENTER</th>
                    <th>TEXT</th>
                    <th>ASSIGNMENT</th>
                    <th>Business Area</th>
                    <th>Contract Number</th>
                    <th>COntract Type</th>
                    <th>VBEWA</th>
                    <th>REF</th>
                    <th>SEND</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $index => $record)
                    <?php 
                        $salesman = $record->sales->salesman->salesman_name;
                        $salesman_split = explode(", ", $salesman);

                        $salesman = $salesman_split[0];
                        if(count($salesman_split) > 1){
                            $salesman .= ', ' . substr($salesman_split[1], 0,1) . '.';
                        }
                    ?>
                    <tr>
                        <td align="left" width="15">01</td>
                        <td align="left" width="15">{{ $record->sales->company_code_after }}</td>

                        @if(substr($record->sales->company_code_after, 0,1) == 1)
                            <td align="left" width="15">110000</td>
                        @endif

                        @if(substr($record->sales->company_code_after, 0,1) == 2)
                            <td align="left" width="15">110010</td>
                        @endif

                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ $record->total_sales }}</td>

                        @if($record->sales->company_code == 1000)
                            <td align="left" width="15">01</td>
                        @endif

                        @if($record->sales->company_code == 2000)
                            <td align="left" width="15">0X</td>
                        @endif

                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ date('mdy',strtotime($record->sales->invoice_date)) }}</td>
                        <td align="left" width="15">{{ !is_null($record->sales->customer->area->profit_center) ? $record->sales->customer->area->profit_center->profit_center : '' }}</td>
                        <td align="left" width="80">{{ strtoupper($record->app_item_master->segment->abbreviation . '-' . $record->sales->customer->customer_name) }}</td>
                        <td align="left" width="20">{{ $salesman }}</td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ $index + 1 }}</td>
                        <td align="left" width="15"></td>
                    </tr>
                    <tr>
                        <td align="left" width="15">50</td>
                        <td align="left" width="15">400000</td>

                        @if(substr($record->sales->company_code_after, 0,1) == 1)
                            <td align="left" width="15">110000</td>
                        @endif

                        @if(substr($record->sales->company_code_after, 0,1) == 2)
                            <td align="left" width="15">110010</td>
                        @endif
                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ $record->total_sales }}</td>

                        @if($record->sales->company_code == 1000)
                            <td align="left" width="15">01</td>
                        @endif

                        @if($record->sales->company_code == 2000)
                            <td align="left" width="15">0X</td>
                        @endif

                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ date('mdy',strtotime($record->sales->invoice_date)) }}</td>
                        <td align="left" width="15">{{ !is_null($record->sales->customer->area->profit_center) ? $record->sales->customer->area->profit_center->profit_center : ''  }}</td>
                        <td align="left" width="80">{{ strtoupper($record->app_item_master->segment->abbreviation . '-' . $record->sales->customer->customer_name) }}</td>
                        <td align="left" width="20">{{ $salesman }}</td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ $index + 1 }}</td>
                        <td align="left" width="15"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table>
            <tr>
                <th colspan="5" align="left">Generated By: {{ auth()->user()->firstname . ' ' .auth()->user()->lastname }}</th>
            </tr>
            <tr>
                <td colspan="5" align="left">Generated On: {{ date('F j,Y g:i:s A') }}</td>
            </tr>
        </table>
    </body>
</html>