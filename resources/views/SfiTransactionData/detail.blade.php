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
                        $salesman = $record->salesman_name;
                        $salesman_split = explode(", ", $salesman);

                        $salesman = $salesman_split[0];
                        if(count($salesman_split) > 1){
                            $salesman .= ', ' . substr($salesman_split[1], 0,1) . '.';
                        }
                    ?>
                    <tr>
                        <td align="left" width="15">01</td>
                        <td align="left" width="15">{{ str_replace(['1000_','2000_'],'',$record->customer_code) }}</td>
                        <td align="left" width="15">{{ $record->gl_account }}</td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ $record->total_invoice }}</td>
                        <td align="left" width="15">{{ $record->tax_code }}</td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ date('mdy',strtotime($record->invoice_date)) }}</td>
                        <td align="left" width="15">{{ $record->profit_center }}</td>
                        <td align="left" width="80">{{ $record->detail_text}}</td>
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
						<td align="left" width="15">{{ $record->gl_account }}</td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ $record->total_invoice }}</td>
                        <td align="left" width="15">{{ $record->tax_code }}</td>
                        <td align="left" width="15"></td>
                        <td align="left" width="15">{{ date('mdy',strtotime($record->invoice_date)) }}</td>
                        <td align="left" width="15">{{ $record->profit_center }}</td>
                        <td align="left" width="80">{{ $record->detail_text}}</td>
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