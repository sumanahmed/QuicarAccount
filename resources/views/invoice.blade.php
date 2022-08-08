<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Invoice</title>
    </head>
    <body>
        <div style="width:100%;font-family:arial;">
            <div style="width:100%; height:260px;">
                <div style="width:40%;padding:0px 5px; float:left;font-size:14px;line-height:10px"> 
                        <img class="img" alt="Invoce Template" src="{{ asset('assets/images/logo.png') }}" />
                        <h3 style="font-size:25px;">Autospire Logistics</h3>
                        <p>150/1, Crescent Homes, Mirpur-1, Dhaka 1216</p>
                        <p>01912278827 / 01611822829</p>
                        <p>autospirebd@gmail.com</p>
                </div>
                <div style="width:40%;padding:0px 5px; float:right; text-align:right; line-height:10px">
                    <h3 style="font-size:20px;">Let us take you away!</h3>
                    <p>Print date: {{ date('d M, Y') }}</p>
                    <p>Invoice-AS-{{ $rent->id }}</p>
                    <p><strong>{{ $rent->name }}, {{ $rent->phone }}</strong></p>
                </div>
            </div> 
            <div style="width:100%; height:280px; text-align: justify;">
                <div class="col-md-12">
                    <p>Dear <strong>{{ $rent->name }}</strong>,</p>
                    <p>Please find below the rental cost with explanation. Please make payment at your earliest
                    convenience, and do not hesitate to contact us with any questions.</p><br/>
                    <p>Many Thanks,</p>
                    <p>Autospire Logistics</p>
                    <p>Travel Date : {{ date('d M, Y h:i:s a', strtotime($rent->pickup_datetime)) }}</p>
                    @if($rent->rent_type != 1)
                        <p>Return Date : {{ date('d M, Y h:i:s a', strtotime($rent->return_datetime)) }} </p>
                    @endif
                </div>
            </div>
            
            <div style="width:100%; min-height:200px;">
                <table style="width:100%;">
                    <thead style="background: #ddd !important;">
                        <tr>
                            <th style="padding: 5px !important;border: 1px solid #000 !important;" colspan="2">Rental Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Pickup</td>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->pickup_location }} @if($rent->pickup_datetime != null) at {{ date('d M, Y h:i:s a', strtotime($rent->pickup_datetime)) }} @endif</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Destination</td>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->drop_location }} @if($rent->drop_datetime != null) at {{ date('d M, Y h:i:s a', strtotime($rent->drop_datetime)) }} @endif </td>
                        </tr>
                        @if($rent->rent_type == 2 && $rent->return_datetime != null)
                            <tr>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">Return Date & Time</td>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ date('d M, Y h:i:s a', strtotime($rent->return_datetime)) }} </td>
                            </tr>
                        @endif
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Car Type</td>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->CarType->name }} </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Total Vehicle</td>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->total_vehicle }} </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Total Person</td>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->total_person }} </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Rent Type</td>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ getRentType($rent->rent_type) }} </td>
                        </tr>
                        @if($rent->rent_type ==3)
                            <tr>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">Body Rent (Per Day)</td>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->body_rent }} Tk</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">Fuel Cost (Per Km)</td>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->fuel }} Tk</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">Driver Accomodation (Per Day)</td>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->driver_accomodation }} Tk</td>
                            </tr>
                        @endif
                        @if($rent->driver_id != null)
                            <tr>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">Driver</td>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->driver->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">Reg. No</td>
                                <td style="padding: 5px !important;border: 1px solid #000 !important;">{{ $rent->reg_number }}) </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot style="font-weight: 700; background: #ddd !important;">
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Price</td>
                            <td  style="padding: 5px !important;border: 1px solid #000 !important; text-align:right">{{ $rent->price }} Tk</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Advanced</td>
                            <td  style="padding: 5px !important;border: 1px solid #000 !important; text-align:right">{{ $rent->advance }} Tk</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px !important;border: 1px solid #000 !important;">Due (Remaining)</td>
                            <td  style="padding: 5px !important;border: 1px solid #000 !important; text-align:right">{{ (float)($rent->price - $rent->advance) }} Tk</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div style="width:100%; min-height:270px; text-align: justify">
                <div class="col-md-12">
                    <p>Many thanks for your Booking! We look forward to doing business with you again in due
                        course.</p>
                    <p>Payment Terms: Pay to our Bank Account / Bkash payment / Cash</p>
                    <p><strong>Brac Bank Limited</strong></p>
                    <p>Account name : Autospire</p>
                    <p>AC/NO: 1538204467297001</p> 
                    <br/>
                    <p><strong>The City Bank Limited</strong></p>
                    <p>Account name : Autospire</p>
                    <p>AC/NO: 1233539402001</p>
                    
                    <p>Bkash Merchant : Autospire</p>
                    <p>Bkash Number : 01912278827</p><br/>
                    <p><strong>(Note: Please do not hire bus from driver to avoid money loss, different bus and commitment issues)</strong></p>
                    @if($rent->note != null)
                        <p><strong>[Extra Note: {{ $rent->note }}]</strong></p><br/>
                    @endif
                </div>
            </div>
            <!--<div  style="width:100%; height:50px; margin-top:40px;">-->
            <!--    <div style="text-align:center">-->
            <!--        <p><b>[No Signature is required. This is an auto generated invoice]</b></p>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
        
        <?php
            function getRentType ($type) {
                if ($type == 1) {
                    echo "Drop Only";
                } else if ($type == 2) {
                    echo "Round Trip";
                } else if ($type == 3) {
                    echo "Body Rent";
                } else if ($type == 4) {
                    echo "Monthly";
                }
            }
        ?>
    </body>
</html>